<?php

namespace App\Http\Controllers;

use App\Models\ProsesProduksi;
use App\Models\DetailProses;
use App\Models\Bahan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProsesProduksiController extends Controller
{
    public function index()
    {
        $produksi = ProsesProduksi::with('detailProses.bahan', 'produk')->get();
        return view('produksi.proses-produksi.index', compact('produksi'));
    }

    public function create()
    {
        $bahan = Bahan::all();
        $produk = Produk::all();
        return view('produksi.proses-produksi.create', compact('bahan', 'produk'));
    }


    public function store(Request $request)
    {
        // Filter detail kosong
        $filteredDetails = collect($request->details)->filter(function ($detail) {
            return !empty($detail['id_bahan']) && !empty($detail['kuantitas']);
        })->values()->all();

        $request->merge(['details' => $filteredDetails]);

        // Validasi
        $request->validate([
            'tanggal' => 'required|date',
            'id_produk' => 'required|exists:produk,id_produk',
            // 'kuantitas' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
            'details.*.kuantitas' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($request) {
            // Simpan data proses
            $proses = ProsesProduksi::create([
                'kode_produksi' => $this->generateKodeProduksi(),
                'tanggal' => $request->tanggal,
                'id_produk' => $request->id_produk,
                'kuantitas' => $request->kuantitas,
                'keterangan' => $request->keterangan,
                'status' => $request->kuantitas > 0 ? 1 : 0,
            ]);

            // Simpan detail proses dan kurangi stok bahan
            foreach ($request->details as $detail) {
                DetailProses::create([
                    'id_proses' => $proses->id_proses,
                    'id_bahan' => $detail['id_bahan'],
                    'kuantitas' => $detail['kuantitas'],
                ]);

                $bahan = Bahan::findOrFail($detail['id_bahan']);
                $bahan->stok -= $detail['kuantitas'];
                $bahan->save();
            }

            // Tambahkan stok ke produk hasil produksi
            $produk = Produk::findOrFail($request->id_produk);
            $produk->stok += $request->kuantitas;
            $produk->save();
        });

        return redirect()->route('proses-produksi.index')->with('success', 'Data proses produksi berhasil disimpan.');
    }




    public function show($id)
    {
        $produksi = ProsesProduksi::with('detailProses.bahan')->findOrFail($id);
        return view('produksi.show', compact('produksi'));
    }

    public function edit($id)
    {
        $produksi = ProsesProduksi::with('detailProses.bahan')->findOrFail($id);
        $bahan = Bahan::all();
        $produk = \App\Models\Produk::all();

        return view('produksi.proses-produksi.edit', compact('produksi', 'bahan', 'produk'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'id_produk' => 'required|exists:produk,id_produk',
            'kuantitas' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
            'details.*.kuantitas' => 'required|numeric|min:1',
            'status' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $id) {
            $proses = ProsesProduksi::with('detailProses')->findOrFail($id);

            // ✅ 1. Kembalikan stok bahan lama
            foreach ($proses->detailProses as $detailLama) {
                $bahan = Bahan::findOrFail($detailLama->id_bahan);
                $bahan->stok += $detailLama->kuantitas;
                $bahan->save();
            }

            // ✅ 2. Kembalikan stok produk hasil lama
            $produkLama = Produk::findOrFail($proses->id_produk);
            $produkLama->stok -= $proses->kuantitas;
            $produkLama->save();

            // ✅ 3. Update proses produksi
            $proses->update([
                'kode_produksi' => $this->generateKodeProduksi(),
                'tanggal' => $request->tanggal,
                'id_produk' => $request->id_produk,
                'kuantitas' => $request->kuantitas,
                'keterangan' => $request->keterangan,
                'status' => $request->kuantitas > 0 ? 1 : 0,
            ]);

            // ✅ 4. Hapus detail proses lama
            $proses->detailProses()->delete();

            // ✅ 5. Simpan detail proses baru dan kurangi stok bahan
            foreach ($request->details as $detail) {
                DetailProses::create([
                    'id_proses' => $proses->id_proses,
                    'id_bahan' => $detail['id_bahan'],
                    'kuantitas' => $detail['kuantitas'],
                ]);

                $bahan = Bahan::findOrFail($detail['id_bahan']);
                $bahan->stok -= $detail['kuantitas'];
                $bahan->save();
            }

            // ✅ 6. Tambahkan stok produk baru
            $produkBaru = Produk::findOrFail($request->id_produk);
            $produkBaru->stok += $request->kuantitas;
            $produkBaru->save();
        });

        return redirect()->route('proses-produksi.index')->with('success', 'Proses produksi berhasil diperbarui dan stok disesuaikan.');
    }


    public function destroy($id)
    {
        $proses = ProsesProduksi::with('detailProses')->findOrFail($id);

        // Kembalikan stok bahan sebelum menghapus
        foreach ($proses->detailProses as $detail) {
            $bahan = Bahan::findOrFail($detail->id_bahan);
            $bahan->stok += $detail->kuantitas;
            $bahan->save();
        }

        $proses->detailProses()->delete();
        $proses->delete();

        return redirect()->route('proses-produksi.index')->with('success', 'Proses produksi berhasil dihapus dan stok dikembalikan.');
    }


    private function generateKodeProduksi()
    {
        $last = \App\Models\ProsesProduksi::latest('id_proses')->first();
        $nextNumber = $last ? $last->id_proses + 1 : 1;
        return 'PRODUKSI-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}

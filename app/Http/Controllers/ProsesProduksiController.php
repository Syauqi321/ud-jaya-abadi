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
        $produksi = ProsesProduksi::with('detailProses.bahan')->get();
        return view('produksi.proses-produksi.index', compact('produksi'));
    }

    public function create()
    {
        $bahan = Bahan::all();
        return view('produksi.proses-produksi.create', compact('bahan'));
    }

    public function store(Request $request)
    {
        $filteredDetails = collect($request->details)->filter(function ($detail) {
            return !empty($detail['id_bahan']) && !empty($detail['kuantitas']);
        })->values()->all(); // reset index array

        $request->merge(['details' => $filteredDetails]);

        $request->validate([
            'tanggal' => 'required|date',
            'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
            'details.*.kuantitas' => 'required|numeric|min:1',
            'status' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request) {
            $proses = ProsesProduksi::create([
                'kode_produksi' => $this->generateKodeProduksi(),
                'tanggal' => $request->tanggal,
            ]);

            foreach ($request->details as $detail) {
                DetailProses::create([
                    'id_proses' => $proses->id_proses,
                    'id_bahan' => $detail['id_bahan'],
                    'kuantitas' => $detail['kuantitas'],
                ]);

                $bahan = Bahan::findOrFail($detail['id_bahan']);
                $bahan->stok -= $detail['kuantitas']; // misal proses mengurangi stok
                $bahan->save();
            }
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
            'kuantitas' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string',
            'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
            'details.*.kuantitas' => 'required|numeric|min:1',
            'status' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request, $id) {
            $proses = ProsesProduksi::with('detailProses')->findOrFail($id);

            // Kembalikan stok bahan dari data lama
            foreach ($proses->detailProses as $detailLama) {
                $bahan = Bahan::findOrFail($detailLama->id_bahan);
                $bahan->stok += $detailLama->kuantitas;
                $bahan->save();
            }

            // Update proses
            $proses->update([
                'kode_produksi' => $this->generateKodeProduksi(),
                'tanggal' => $request->tanggal,
                'id_produk' => $request->id_produk,
                'kuantitas' => $request->kuantitas,
                'keterangan' => $request->keterangan,
            ]);

            $proses->detailProses()->delete();

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

    public function toggleStatus($id)
    {
        $proses = ProsesProduksi::findOrFail($id);
        $proses->status = !$proses->status; // toggle true <-> false
        $proses->save();

        return redirect()->route('proses-produksi.index')->with('success', 'Status berhasil diperbarui.');
    }

    private function generateKodeProduksi()
    {
        $last = \App\Models\ProsesProduksi::latest('id_proses')->first();
        $nextNumber = $last ? $last->id_proses + 1 : 1;
        return 'PRODUKSI-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}

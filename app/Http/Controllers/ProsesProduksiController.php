<?php

namespace App\Http\Controllers;

use App\Models\ProsesProduksi;
use App\Models\DetailProses;
use App\Models\Bahan;
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
        'kode_produksi' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
        'details.*.kuantitas' => 'required|numeric|min:1',
    ]);

    DB::transaction(function () use ($request) {
        $proses = ProsesProduksi::create([
            'kode_produksi' => $request->kode_produksi,
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
    return view('produksi.proses-produksi.edit', compact('produksi', 'bahan'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produksi' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
            'details.*.kuantitas' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {
            $proses = ProsesProduksi::with('detailProses')->findOrFail($id);

            // Rollback stok bahan dari proses sebelumnya
            foreach ($proses->detailProses as $detailLama) {
                $bahan = Bahan::findOrFail($detailLama->id_bahan);
                $bahan->stok += $detailLama->kuantitas;
                $bahan->save();
            }

            // Update proses
            $proses->update([
                'kode_produksi' => $request->kode_produksi,
                'tanggal' => $request->tanggal,
            ]);

            // Hapus detail lama
            $proses->detailProses()->delete();

            // Simpan detail baru dan update stok bahan
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
}

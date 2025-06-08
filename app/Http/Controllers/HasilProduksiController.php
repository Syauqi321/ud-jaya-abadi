<?php

namespace App\Http\Controllers;

use App\Models\DataHasilProduksi;
use App\Models\ProsesProduksi;
use App\Models\Produk;
use Illuminate\Http\Request;

class HasilProduksiController extends Controller
{
    public function index()
    {
        $hasilProduksi = DataHasilProduksi::with(['prosesProduksi', 'produk'])->get();
        return view('produksi.hasil-produksi.index', compact('hasilProduksi'));
    }

    public function create()
    {
        $proses = ProsesProduksi::all();
        $produk = Produk::all();
        return view('produksi.hasil-produksi.create', compact('proses', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_proses' => 'required|exists:proses_produksi,id_proses',
            'id_produk' => 'required|exists:produk,id_produk',
            'kuantitas' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DataHasilProduksi::create($request->all());

        return redirect()->route('hasil-produksi.index')->with('success', 'Data hasil produksi berhasil disimpan.');
    }

    public function show($id)
    {
        $hasil = DataHasilProduksi::with(['prosesProduksi', 'produk'])->findOrFail($id);
        return view('hasil-produksi.show', compact('hasil'));
    }

    public function edit($id)
    {
        $hasil = DataHasilProduksi::findOrFail($id);
        $proses = ProsesProduksi::all();
        $produk = Produk::all();
        return view('produksi.hasil-produksi.edit', compact('hasil', 'proses', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_proses' => 'required|exists:proses_produksi,id_proses',
            'id_produk' => 'required|exists:produk,id_produk',
            'kuantitas' => 'required|numeric|min:1',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $hasil = DataHasilProduksi::findOrFail($id);
        $hasil->update($request->all());

        return redirect()->route('hasil-produksi.index')->with('success', 'Data hasil produksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $hasil = DataHasilProduksi::findOrFail($id);
        $hasil->delete();

        return redirect()->route('hasil-produksi.index')->with('success', 'Data hasil produksi berhasil dihapus.');
    }
}

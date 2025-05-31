<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailPenjualan;
use Illuminate\Http\Request;

class PenjualanController extends Controller
{
    public function index()
    {
        $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.produk'])->latest()->get();
        return view('transaksi.penjualan.index', compact('penjualan'));
    }

    public function create()
{
    $pelanggan = Pelanggan::all();
    $produk = Produk::all();
    return view('transaksi.penjualan.create', compact('pelanggan', 'produk'));
}

public function store(Request $request)
{
    $request->validate([
        'id_pelanggan' => 'required',
        'tanggal' => 'required|date',
        'details.*.id_produk' => 'required|exists:produk,id_produk',
        'details.*.kuantitas' => 'required|numeric|min:1',
        'details.*.harga_jual' => 'required|numeric|min:0',
    ]);

    $penjualan = Penjualan::create([
        'id_pelanggan' => $request->id_pelanggan,
        'tanggal' => $request->tanggal
    ]);

    foreach ($request->details as $detail) {
        $penjualan->detailPenjualan()->create($detail);
    }

    return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil disimpan.');
}

    public function edit($id)
    {
        $penjualan = Penjualan::with('detailPenjualan')->findOrFail($id);
        $pelanggan = Pelanggan::all();
        $produk = Produk::all();
        return view('transaksi.penjualan.edit', compact('penjualan', 'pelanggan', 'produk'));
    }

    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->update([
            'id_pelanggan' => $request->id_pelanggan,
            'tanggal' => $request->tanggal
        ]);

        $penjualan->detailPenjualan()->delete();
        foreach ($request->produk as $detail) {
            $penjualan->detailPenjualan()->create($detail);
        }

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::findOrFail($id);
        $penjualan->detailPenjualan()->delete();
        $penjualan->delete();

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus.');
    }
}



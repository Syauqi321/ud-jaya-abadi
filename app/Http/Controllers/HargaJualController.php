<?php

namespace App\Http\Controllers;

use App\Models\HargaJual;
use App\Models\Produk;
use Illuminate\Http\Request;

class HargaJualController extends Controller
{
    public function index()
    {
        $data = HargaJual::with('produk')->latest()->get();
        return view('data-master.harga_jual.index', compact('data'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('data-master.harga_jual.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'tanggal' => 'required|date',
            'harga' => 'required|numeric',
            'status' => 'nullable|boolean',
        ]);

        HargaJual::create($request->all());
        return redirect()->route('harga-jual.index')->with('success', 'Harga jual berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $hargaJual = HargaJual::findOrFail($id);
        $produks = Produk::all();
        return view('data-master.harga_jual.edit', compact('hargaJual', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id_produk',
            'tanggal' => 'required|date',
            'harga' => 'required|numeric',
            'status' => 'nullable|boolean',
        ]);

        $hargaJual = HargaJual::findOrFail($id);
        $hargaJual->update($request->all());

        return redirect()->route('harga-jual.index')->with('success', 'Harga jual berhasil diperbarui.');
    }

    public function destroy($id)
    {
        HargaJual::destroy($id);
        return redirect()->route('harga-jual.index')->with('success', 'Harga jual berhasil dihapus.');
    }

    public function toggleStatus($id)
{
    $harga = HargaJual::findOrFail($id);
    $harga->status = !$harga->status;
    $harga->save();

    return redirect()->route('harga-jual.index')->with('success', 'Status berhasil diperbarui.');
}

}

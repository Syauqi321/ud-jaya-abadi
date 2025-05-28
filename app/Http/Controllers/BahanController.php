<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    // Tampil semua data bahan
    public function index()
    {
        $bahan = Bahan::all();
        return view('data-master.bahan.index', compact('bahan'));
    }

    // Tampilkan form tambah bahan
    public function create()
    {
        return view('data-master.bahan.create');
    }

    // Simpan data bahan baru
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        Bahan::create($request->only('nama', 'stok'));

        return redirect()->route('bahan.index')->with('success', 'Data bahan berhasil disimpan.');
    }

    // Tampilkan form edit bahan
    public function edit($id)
    {
        $bahan = Bahan::findOrFail($id);
        return view('data-master.bahan.edit', compact('bahan'));
    }

    // Update data bahan
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);

        $bahan = Bahan::findOrFail($id);
        $bahan->update($request->only('nama', 'stok'));

        return redirect()->route('bahan.index')->with('success', 'Data bahan berhasil diupdate.');
    }

    // Hapus data bahan
    public function destroy($id)
    {
        $bahan = Bahan::findOrFail($id);
        $bahan->delete();

        return redirect()->route('bahan.index')->with('success', 'Data bahan berhasil dihapus.');
    }
}

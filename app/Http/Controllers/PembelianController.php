<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Bahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PembelianController extends Controller
{
    public function index()
    {
        $pembelian = Pembelian::with('detailPembelian.bahan')->get();
        return view('transaksi.pembelian.index', compact('pembelian'));
    }

    public function create()
    {
        $bahan = Bahan::all();
        return view('transaksi.pembelian.create', compact('bahan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
            'details.*.kuantitas' => 'required|numeric|min:1',
            'details.*.harga' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            foreach ($request->details as $detail) {
                $total += $detail['kuantitas'] * $detail['harga'];
            }

            $pembelian = Pembelian::create([
                'tanggal' => $request->tanggal,
                'total' => $total,
            ]);

            foreach ($request->details as $detail) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_bahan' => $detail['id_bahan'],
                    'kuantitas' => $detail['kuantitas'],
                    'harga' => $detail['harga'],
                ]);
            }
        });

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil disimpan.');
    }

    public function show($id)
    {
        $pembelian = Pembelian::with('detailPembelian.bahan')->findOrFail($id);
        return view('pembelian.show', compact('pembelian'));
    }

    public function edit($id)
    {
        $pembelian = Pembelian::with('detailPembelian')->findOrFail($id);
        $bahan = Bahan::all();
        return view('transaksi.pembelian.edit', compact('pembelian', 'bahan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'details.*.id_bahan' => 'required|exists:bahan,id_bahan',
            'details.*.kuantitas' => 'required|numeric|min:1',
            'details.*.harga' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $id) {
            $pembelian = Pembelian::findOrFail($id);

            $pembelian->update([
                'tanggal' => $request->tanggal,
                'total' => collect($request->details)->sum(function ($detail) {
                    return $detail['kuantitas'] * $detail['harga'];
                }),
            ]);

            // Hapus semua detail sebelumnya
            $pembelian->detailPembelian()->delete();

            // Tambahkan data detail yang baru
            foreach ($request->details as $detail) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_bahan' => $detail['id_bahan'],
                    'kuantitas' => $detail['kuantitas'],
                    'harga' => $detail['harga'],
                ]);
            }
        });

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->detailPembelian()->delete();
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus.');
    }
}

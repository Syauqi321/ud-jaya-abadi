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

                // Tambah stok bahan
                $bahan = Bahan::findOrFail($detail['id_bahan']);
                $bahan->stok += $detail['kuantitas'];
                $bahan->save();
            }
        });

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil disimpan dan stok diperbarui.');
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
            $pembelian = Pembelian::with('detailPembelian')->findOrFail($id);

            // Rollback stok bahan dari detail pembelian sebelumnya
            foreach ($pembelian->detailPembelian as $detailLama) {
                $bahan = Bahan::findOrFail($detailLama->id_bahan);
                $bahan->stok -= $detailLama->kuantitas;
                $bahan->save();
            }

            // Update data pembelian
            $pembelian->update([
                'tanggal' => $request->tanggal,
                'total' => collect($request->details)->sum(function ($detail) {
                    return $detail['kuantitas'] * $detail['harga'];
                }),
            ]);

            // Hapus detail lama
            $pembelian->detailPembelian()->delete();

            // Tambah detail baru dan update stok bahan
            foreach ($request->details as $detail) {
                DetailPembelian::create([
                    'id_pembelian' => $pembelian->id_pembelian,
                    'id_bahan' => $detail['id_bahan'],
                    'kuantitas' => $detail['kuantitas'],
                    'harga' => $detail['harga'],
                ]);

                $bahan = Bahan::findOrFail($detail['id_bahan']);
                $bahan->stok += $detail['kuantitas'];
                $bahan->save();
            }
        });

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil diperbarui dan stok disesuaikan.');
    }

    public function destroy($id)
    {
        $pembelian = Pembelian::with('detailPembelian')->findOrFail($id);

        // Kurangi stok bahan sebelum menghapus
        foreach ($pembelian->detailPembelian as $detail) {
            $bahan = Bahan::findOrFail($detail->id_bahan);
            $bahan->stok -= $detail->kuantitas;
            $bahan->save();
        }

        // Hapus detail pembelian dan pembeliannya
        $pembelian->detailPembelian()->delete();
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Data pembelian berhasil dihapus dan stok dikurangi.');
    }
}

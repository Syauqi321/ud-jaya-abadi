<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\Pelanggan;
use App\Models\Produk;
use App\Models\DetailPenjualan;
use App\Models\HargaJual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        ]);

        DB::transaction(function () use ($request) {
            $penjualan = Penjualan::create([
                'id_pelanggan' => $request->id_pelanggan,
                'tanggal' => $request->tanggal
            ]);

            foreach ($request->details as $detail) {
                // Ambil harga jual terbaru berdasarkan tanggal
                $hargaJual = HargaJual::where('id_produk', $detail['id_produk'])
                    ->latest('tanggal')
                    ->first();

                if (!$hargaJual) {
                    throw new \Exception("Harga jual untuk produk ID {$detail['id_produk']} belum diatur.");
                }

                // Kurangi stok
                $produk = Produk::findOrFail($detail['id_produk']);
                if ($produk->stok < $detail['kuantitas']) {
                    throw new \Exception("Stok produk '{$produk->nama_produk}' tidak mencukupi.");
                }

                $produk->stok -= $detail['kuantitas'];
                $produk->save();

                // Simpan detail penjualan
                $penjualan->detailPenjualan()->create([
                    'id_produk' => $detail['id_produk'],
                    'kuantitas' => $detail['kuantitas'],
                    'harga_jual' => $hargaJual->harga,
                ]);
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil disimpan dan harga jual otomatis diambil.');
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
        $request->validate([
            'id_pelanggan' => 'required',
            'tanggal' => 'required|date',
            'details.*.id_produk' => 'required|exists:produk,id_produk',
            'details.*.kuantitas' => 'required|numeric|min:1',
        ]);

        DB::transaction(function () use ($request, $id) {
            $penjualan = Penjualan::with('detailPenjualan')->findOrFail($id);

            // Kembalikan stok karena akan diubah
            foreach ($penjualan->detailPenjualan as $detail) {
                $produk = Produk::find($detail->id_produk);
                if ($produk) {
                    $produk->stok += $detail->kuantitas;
                    $produk->save();
                }
            }

            // Hapus detail lama
            $penjualan->detailPenjualan()->delete();

            // Update header
            $penjualan->update([
                'id_pelanggan' => $request->id_pelanggan,
                'tanggal' => $request->tanggal
            ]);

            // Simpan detail baru
            foreach ($request->details as $detail) {
                // Ambil harga jual terbaru berdasarkan tanggal
                $hargaJual = HargaJual::where('id_produk', $detail['id_produk'])
                    ->latest('tanggal')
                    ->first();

                if (!$hargaJual) {
                    throw new \Exception("Harga jual untuk produk ID {$detail['id_produk']} belum diatur.");
                }

                $produk = Produk::findOrFail($detail['id_produk']);
                if ($produk->stok < $detail['kuantitas']) {
                    throw new \Exception("Stok produk '{$produk->nama_produk}' tidak mencukupi.");
                }

                $produk->stok -= $detail['kuantitas'];
                $produk->save();

                $penjualan->detailPenjualan()->create([
                    'id_produk' => $detail['id_produk'],
                    'kuantitas' => $detail['kuantitas'],
                    'harga_jual' => $hargaJual->harga,
                ]);
            }
        });

        return redirect()->route('penjualan.index')->with('success', 'Penjualan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        DB::transaction(function () use ($id) {
            $penjualan = Penjualan::with('detailPenjualan')->findOrFail($id);

            // Kembalikan stok produk
            foreach ($penjualan->detailPenjualan as $detail) {
                $produk = Produk::findOrFail($detail->id_produk);
                $produk->stok += $detail->kuantitas;
                $produk->save();
            }

            $penjualan->detailPenjualan()->delete();
            $penjualan->delete();
        });

        return redirect()->route('penjualan.index')->with('success', 'Data penjualan berhasil dihapus dan stok dikembalikan.');
    }
}

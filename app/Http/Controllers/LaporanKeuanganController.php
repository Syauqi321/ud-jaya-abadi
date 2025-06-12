<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataHasilProduksi;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start ?? now()->startOfMonth()->format('Y-m-d');
        $end = $request->end ?? now()->endOfMonth()->format('Y-m-d');

        $hasilProduksi = Pembelian::whereBetween('created_at', [$start, $end])
            ->get();

        $totalBiayaBahan = $hasilProduksi->sum(function ($item) {
            return $item->total ?? 0;
        });

        $hasilProduksi = Penjualan::whereBetween('created_at', [$start, $end])
            ->get();

        $totalPenjualan = $hasilProduksi->sum(function ($item) {
            return $item->total ?? 0;
        });

        return view('laporan.keuangan', compact(
            'hasilProduksi',
            'start',
            'end',
            'totalBiayaBahan',
            'totalPenjualan'
        ));
    }

    public function downloadPdf(Request $request)
{
    $start = $request->start ?? now()->startOfMonth()->format('Y-m-d');
    $end = $request->end ?? now()->endOfMonth()->format('Y-m-d');

    // Ambil data pembelian (pengeluaran)
    $pembelian = Pembelian::whereBetween('created_at', [$start, $end])->get();
    $totalBiayaBahan = $pembelian->sum('total');

    // Ambil data penjualan (pendapatan)
    $penjualan = Penjualan::whereBetween('created_at', [$start, $end])->get();
    $totalPenjualan = $penjualan->sum('total');

    // Kirim data ke view
    $pdf = Pdf::loadView('laporan.keuangan_pdf', [
        'start' => $start,
        'end' => $end,
        'totalBiayaBahan' => $totalBiayaBahan,
        'totalPenjualan' => $totalPenjualan,
    ])->setPaper('a4', 'portrait');

    return $pdf->stream('laporan_keuangan_' . $start . '_sampai_' . $end . '.pdf');
}
}

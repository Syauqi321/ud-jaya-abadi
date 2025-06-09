<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProsesProduksi;
use App\Models\DataHasilProduksi;
use PDF;

class LaporanProduksiController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal = $request->get('tanggal_awal', now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->get('tanggal_akhir', now()->endOfMonth()->toDateString());

        $produksi = ProsesProduksi::with([
                'detailProses.bahan',       // ambil data bahan dari detail proses
                'dataHasilProduksi.produk'  // ambil data hasil produksi dan produk terkait
            ])
            ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
            ->get();

        return view('laporan.produksi', compact('produksi', 'tanggalAwal', 'tanggalAkhir'));
    }

    public function downloadPdf(Request $request)
{
    $tanggalAwal = $request->get('tanggal_awal', now()->startOfMonth()->toDateString());
    $tanggalAkhir = $request->get('tanggal_akhir', now()->endOfMonth()->toDateString());

    $produksi = ProsesProduksi::with([
            'detailProses.bahan',
            'dataHasilProduksi.produk'
        ])
        ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->get();

    $pdf = PDF::loadView('laporan.produksi_pdf', compact('produksi', 'tanggalAwal', 'tanggalAkhir'))
             ->setPaper('a4', 'landscape');

    return $pdf->stream("laporan-produksi-{$tanggalAwal}_{$tanggalAkhir}.pdf");
}

}

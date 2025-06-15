<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembelian;
use App\Models\Penjualan;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $year = now()->year;

        // Ambil data pembelian grup per bulan
        $pembelianPerBulan = Pembelian::selectRaw('MONTH(created_at) as bulan, SUM(total) as total')
            ->whereYear('created_at', $year)
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total', 'bulan');

        // Ambil data penjualan grup per bulan
        $penjualanPerBulan = Penjualan::with('detailPenjualan')
            ->whereYear('created_at', $year)
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->created_at)->month;
            })
            ->map(function ($items) {
                return $items->sum('total'); // Memakai accessor getTotalAttribute
            });

        // Format data untuk Chart.js
        $bulan = collect(range(1, 12))->map(function ($i) {
            return Carbon::create()->month($i)->translatedFormat('F');
        });

        $dataPembelian = collect(range(1, 12))->map(fn ($i) => $pembelianPerBulan[$i] ?? 0);
        $dataPenjualan = collect(range(1, 12))->map(fn ($i) => $penjualanPerBulan[$i] ?? 0);

        return view('dashboard.index', compact('bulan', 'dataPembelian', 'dataPenjualan'));
    }
}


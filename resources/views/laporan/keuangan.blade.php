@extends('layout.master')
@section('title', 'Laporan Keuangan')

@section('content')
<div class="container">
    <h4 class="mb-3">Laporan Keuangan</h4>

    <form method="GET" action="{{ route('laporan.keuangan.index') }}" class="mb-3 row g-2 align-items-end">
        <div class="col-md-5">
            <label for="start" class="form-label">Tanggal Mulai</label>
            <input type="date" name="start" id="start" value="{{ $start }}" class="form-control" required>
        </div>
        <div class="col-md-5">
            <label for="end" class="form-label">Tanggal Akhir</label>
            <input type="date" name="end" id="end" value="{{ $end }}" class="form-control" required>
        </div>
        <div class="col-md-2 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
            <a href="{{ route('laporan.keuangan.pdf', ['start' => $start, 'end' => $end]) }}"
                class="btn btn-danger" target="_blank">Download PDF</a>
        </div>
    </form>

    @if(request('start') && request('end'))
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>Periode</th>
                    <th>Total Pengeluaran (Bahan)</th>
                    <th>Total Penjualan</th>
                    <th>Laba / Rugi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="text-center">
                    <td>{{ \Carbon\Carbon::parse($start)->format('d M Y') }} - {{ \Carbon\Carbon::parse($end)->format('d M Y') }}</td>
                    <td>Rp{{ number_format($totalBiayaBahan, 0, ',', '.') }}</td>
                    <td>Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                    <td class="{{ ($totalPenjualan - $totalBiayaBahan) >= 0 ? 'text-success' : 'text-danger' }}">
                        Rp{{ number_format($totalPenjualan - $totalBiayaBahan, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection

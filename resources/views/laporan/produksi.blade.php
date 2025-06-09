@extends('layout.master')
@section('title', 'Laporan Produksi')

@section('content')
    <div class="container">
    <h4 class="mb-3">Laporan Produksi</h4>

    <form method="GET" action="{{ route('laporan.produksi.index') }}" class="mb-3 row g-2 align-items-end">
    <div class="col-md-5">
        <label for="tanggal_awal" class="form-label">Tanggal Awal</label>
        <input type="date" name="tanggal_awal" id="tanggal_awal" value="{{ $tanggalAwal }}" class="form-control" required>
    </div>
    <div class="col-md-5">
        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" id="tanggal_akhir" value="{{ $tanggalAkhir }}" class="form-control" required>
    </div>
    <div class="col-md-2 d-flex gap-2">
        <div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </div>
        <div>
            <a href="{{ route('laporan.produksi.pdf', ['tanggal_awal' => $tanggalAwal ?? '', 'tanggal_akhir' => $tanggalAkhir ?? '']) }}"
                class="btn btn-danger" target="_blank">Download PDF</a>
        </div>
    </div>
</form>


    @if(request('tanggal_awal') && request('tanggal_akhir'))
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Kode Produksi</th>
                        <th>Tanggal</th>
                        <th>Produk</th>
                        <th>Kuantitas Bahan</th>
                        <th>Kuantitas Produk</th>
                        <th>Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produksi as $data)
                        @foreach ($data->dataHasilProduksi as $hasil)
                            <tr>
                                <td>{{ $hasil->prosesProduksi->kode_produksi ?? '-' }}</td>
                                <td>{{ $data->tanggal }}</td>
                                <td>{{ $hasil->produk->nama ?? '-' }}</td>
                                <td>{{ $data->detailProses->sum('kuantitas') ?? 0 }} kg</td>
                                <td>{{ $hasil->kuantitas ?? 0 }} kg</td>
                                <td>
                                    @php
                                        $hargaJual = $hasil->produk->hargaJualAktif;
                                    @endphp
                                    {{ $hargaJual ? 'Rp ' . number_format($hargaJual->harga, 0, ',', '.') . '/kg' : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data produksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>

@endsection

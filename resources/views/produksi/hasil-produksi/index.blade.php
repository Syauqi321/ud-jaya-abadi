@extends('layout.master')
@section('title', 'Data Hasil Produksi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">📦 Data Hasil Produksi</h4>
            <small class="text-muted">Manajemen hasil produksi dari proses produksi</small>
        </div>
        <a href="{{ route('hasil-produksi.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Hasil
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Kode Produksi</th>
                        <th>Produk</th>
                        <th>Kuantitas (kg)</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($hasilProduksi as $item)
                    <tr>
                        <td>{{ $item->id_data_hasil_produksi }}</td>
                        <td>{{ $item->prosesProduksi->kode_produksi ?? '-' }}</td>
                        <td>{{ $item->produk->nama ?? '-' }}</td>
                        <td>{{ $item->kuantitas }} kg</td>
                        <td>{{ $item->keterangan ?? '-' }}</td>
                        <td class="text-center">
                            <!-- Modal Detail -->
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_data_hasil_produksi }}">
                                <i class="bx bx-show"></i>
                            </button>

                            <a href="{{ route('hasil-produksi.edit', $item->id_data_hasil_produksi) }}" class="btn btn-sm btn-warning">
                                <i class="bx bx-pencil"></i>
                            </a>

                            <form action="{{ route('hasil-produksi.destroy', $item->id_data_hasil_produksi) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bx bx-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data hasil produksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Gabungan Detail -->
@foreach ($hasilProduksi as $item)
@php
    $proses = $item->prosesProduksi;
@endphp
<div class="modal fade" id="modalDetail{{ $item->id_data_hasil_produksi }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $item->id_data_hasil_produksi }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailLabel{{ $item->id_data_hasil_produksi }}">
                    Detail Hasil Produksi #{{ $item->id_data_hasil_produksi }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <h6 class="fw-bold mb-3">Data Proses Produksi</h6>
                @if ($proses && $proses->detailProses->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Bahan</th>
                                    <th>Kuantitas (kg)</th>
                                    <th>Sisa Stok Bahan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($proses->detailProses as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->bahan->nama ?? '-' }}</td>
                                        <td>{{ $detail->kuantitas }} kg</td>
                                        <td>{{ $detail->bahan->stok ?? '-' }} kg</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted">Tidak ada detail bahan.</p>
                @endif

                <h6 class="fw-bold mb-3">Data Hasil Produksi</h6>
                <div class="table-responsive mb-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Produksi</th>
                                <th>Produk</th>
                                <th>Kuantitas (kg)</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $item->prosesProduksi->kode_produksi ?? '-' }}</td>
                                <td>{{ $item->produk->nama ?? '-' }}</td>
                                <td>{{ $item->kuantitas }} kg</td>
                                <td>{{ $item->keterangan ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach


<!-- Boxicons dan Bootstrap JS -->
<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

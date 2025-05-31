@extends('layout.master')
@section('title', 'Data Penjualan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">💰 Data Penjualan</h4>
            <small class="text-muted">Manajemen data penjualan produk</small>
        </div>
        <a href="{{ route('penjualan.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Penjualan
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
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($penjualan as $item)
                    <tr>
                        <td>{{ $item->id_penjualan }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->pelanggan->nama ?? '-' }}</td>
                        <td>Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $item->id_penjualan }}">
                                <i class="bx bx-show"></i>
                            </button>
                            <a href="{{ route('penjualan.edit', $item->id_penjualan) }}" class="btn btn-sm btn-warning">
                                <i class="bx bx-pencil"></i>
                            </a>
                            <form action="{{ route('penjualan.destroy', $item->id_penjualan) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"><i class="bx bx-trash-alt"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data penjualan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@foreach ($penjualan as $item)
<div class="modal fade" id="modalDetail{{ $item->id_penjualan }}" tabindex="-1" aria-labelledby="modalDetailLabel{{ $item->id_penjualan }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailLabel{{ $item->id_penjualan }}">
                    Detail Penjualan #{{ $item->id_penjualan }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <p><strong>Pelanggan:</strong> {{ $item->pelanggan->nama ?? '-' }}</p>

                @if($item->detailPenjualan->isEmpty())
                    <p class="text-muted">Tidak ada detail penjualan.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Harga Jual</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($item->detailPenjualan as $index => $detail)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $detail->produk->nama ?? '-' }}</td>
                                        <td>{{ $detail->kuantitas }}</td>
                                        <td>Rp {{ number_format($detail->harga_jual, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($detail->harga_jual * $detail->kuantitas, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection

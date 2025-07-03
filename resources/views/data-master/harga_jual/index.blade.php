@extends('layout.master')
@section('title', 'Data Harga Jual')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">💰 Data Harga Jual</h4>
            <small class="text-muted">Manajemen harga jual produk</small>
        </div>
        <a href="{{ route('harga-jual.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Harga
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 10%;">ID</th>
                            <th>Nama Produk</th>
                            <th>Tanggal</th>
                            <th>Harga</th>
                            <th style="width: 15%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $item->id_harga }}</td>
                            <td>{{ $item->produk->nama ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}/kg</td>

                            <td class="text-center">
                                <a href="{{ route('harga-jual.edit', $item->id_harga) }}" class="btn btn-icon btn-sm btn-warning me-1" title="Edit">
                                    <i class="bx bx-pencil"></i>
                                </a>
                                <form action="{{ route('harga-jual.destroy', $item->id_harga) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus data harga ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-icon btn-sm btn-danger" type="submit" title="Hapus">
                                        <i class="bx bx-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Belum ada data harga jual.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

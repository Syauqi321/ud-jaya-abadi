@extends('layout.master')
@section('title', 'Data Produk')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">📦 Data Produk</h4>
            <small class="text-muted">Manajemen informasi produk yang tersedia</small>
        </div>
        <a href="{{ route('produk.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-1"></i> Tambah Produk
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
                            <th style="width: 15%;">Stok</th>
                            <th style="width: 15%;" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($produk as $item)
                        <tr>
                            <td>{{ $item->id_produk }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->stok }} kg</td>
                            <td class="text-center">
                                <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-icon btn-sm btn-warning me-1" title="Edit">
                                    <i class="bx bx-pencil"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
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
                            <td colspan="4" class="text-center text-muted">Belum ada data produk.</td>
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

@extends('layout.master')
@section('title', 'Data Bahan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">📦 Data Bahan</h4>
        <a href="{{ route('bahan.create') }}" class="btn btn-primary">
            <i class="bx bx-plus"></i> Tambah Bahan
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bx bx-check-circle me-1"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>ID Bahan</th>
                        <th>Nama</th>
                        <th>Stok</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahan as $item)
                    <tr>
                        <td>{{ $item->id_bahan }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->stok }}</td>
                        <td class="text-center">
                            <a href="{{ route('bahan.edit', $item->id_bahan) }}" class="btn btn-sm btn-warning me-1">
                                <i class="bx bx-edit"></i> Edit
                            </a>
                            <form action="{{ route('bahan.destroy', $item->id_bahan) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Yakin ingin menghapus bahan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="bx bx-trash"></i> Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Tidak ada data bahan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

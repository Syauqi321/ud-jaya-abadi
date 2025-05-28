

@extends('layout.master')
@section('title', 'Edit Bahan')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">Edit Bahan</h4>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card p-4">
        <form action="{{ route('bahan.update', $bahan->id_bahan) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama" class="form-label">Nama Bahan</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $bahan->nama) }}" required>
            </div>
            <div class="mb-3">
                <label for="stok" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stok" name="stok" value="{{ old('stok', $bahan->stok) }}" min="0" required>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('bahan.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

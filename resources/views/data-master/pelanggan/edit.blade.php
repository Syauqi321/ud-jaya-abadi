@extends('layout.master')
@section('title', 'Edit Pelanggan')

@section('content')
<div class="container-xxl py-4">
    <div class="card">
        <div class="card-header"><h5>Edit Pelanggan</h5></div>
        <div class="card-body">
            <form action="{{ route('pelanggan.update', $pelanggan->id_pelanggan) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pelanggan->nama) }}" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="telp" class="form-label">No. Telepon</label>
                    <input type="text" name="telp" id="telp" class="form-control" value="{{ old('telp', $pelanggan->telp) }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

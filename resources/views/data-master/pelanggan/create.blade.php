@extends('layout.master')
@section('title', 'Tambah Pelanggan')

@section('content')
<div class="container-xxl py-4">
    <div class="card">
        <div class="card-header"><h5>Tambah Pelanggan</h5></div>
        <div class="card-body">
            <form action="{{ route('pelanggan.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="telp" class="form-label">No. Telepon</label>
                    <input type="text" name="telp" id="telp" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('pelanggan.index') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
</div>
@endsection

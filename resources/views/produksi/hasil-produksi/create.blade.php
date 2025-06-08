@extends('layout.master')
@section('title', 'Tambah Hasil Produksi')

@section('content')
<div class="container">
    <h4>Tambah Data Hasil Produksi</h4>
    <form action="{{ route('hasil-produksi.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_proses" class="form-label">Proses Produksi</label>
            <select name="id_proses" class="form-select" required>
                <option value="">-- Pilih Proses --</option>
                @foreach($proses as $p)
                    <option value="{{ $p->id_proses }}">{{ $p->kode_produksi }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_produk" class="form-label">Produk</label>
            <select name="id_produk" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($produk as $pr)
                    <option value="{{ $pr->id_produk }}">{{ $pr->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kuantitas" class="form-label">Kuantitas</label>
            <input type="number" name="kuantitas" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('hasil-produksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@extends('layout.master')
@section('title', 'Edit Hasil Produksi')

@section('content')
<div class="container">
    <h4>Edit Data Hasil Produksi</h4>
    <form action="{{ route('hasil-produksi.update', $hasil->id_data_hasil_produksi) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="id_proses" class="form-label">Proses Produksi</label>
            <select name="id_proses" class="form-select" required>
                <option value="">-- Pilih Proses --</option>
                @foreach($proses as $p)
                    <option value="{{ $p->id_proses }}" {{ $hasil->id_proses == $p->id_proses ? 'selected' : '' }}>
                        {{ $p->kode_produksi }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_produk" class="form-label">Produk</label>
            <select name="id_produk" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($produk as $pr)
                    <option value="{{ $pr->id_produk }}" {{ $hasil->id_produk == $pr->id_produk ? 'selected' : '' }}>
                        {{ $pr->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="kuantitas" class="form-label">Kuantitas</label>
            <input type="number" name="kuantitas" class="form-control" value="{{ $hasil->kuantitas }}" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" class="form-control">{{ $hasil->keterangan }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('hasil-produksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

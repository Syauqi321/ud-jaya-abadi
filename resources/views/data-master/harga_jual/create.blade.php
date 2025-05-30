@extends('layout.master')

@section('content')
<div class="container">
    <h4>Tambah Harga Jual</h4>

    <form action="{{ route('harga-jual.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="id_produk" class="form-label">Produk</label>
            <select name="id_produk" id="id_produk" class="form-select" required>
                <option value="">-- Pilih Produk --</option>
                @foreach($produks as $b)
                <option value="{{ $b->id_produk }}" {{ (isset($hargaJual) && $hargaJual->id_produk == $b->id_produk) ? 'selected' : '' }}>
                    {{ $b->nama }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Harga</label>
            <input type="number" step="0.01" name="harga" class="form-control" required>
        </div>


        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('harga-jual.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection

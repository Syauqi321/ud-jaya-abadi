@extends('layout.master')
@section('title', 'Tambah Penjualan')

@section('content')
<div class="container">
    <h4>Tambah Data Penjualan</h4>

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                <option value="" disabled selected>Pilih Pelanggan</option>
                @foreach($pelanggan as $p)
                    <option value="{{ $p->id_pelanggan }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>

        <hr>
        <h5>Detail Produk</h5>

        <div id="detail-container">
            <div class="row mb-3 detail-item">
                <div class="col-md-5">
                    <label class="form-label">Produk</label>
                    <select name="details[0][id_produk]" class="form-select" required>
                        <option value="" disabled selected>Pilih Produk</option>
                        @foreach($produk as $item)
                            <option value="{{ $item->id_produk }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Kuantitas</label>
                    <input type="number" name="details[0][kuantitas]" class="form-control" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Harga Jual</label>
                    <input type="number" name="details[0][harga_jual]" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-remove">Hapus</button>
                </div>
            </div>
        </div>

        <button type="button" id="add-detail" class="btn btn-secondary mb-3">+ Tambah Produk</button>

        <div>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
    let detailIndex = 1;

    document.getElementById('add-detail').addEventListener('click', function () {
        const container = document.getElementById('detail-container');
        const newItem = document.createElement('div');
        newItem.classList.add('row', 'mb-3', 'detail-item');
        newItem.innerHTML = `
            <div class="col-md-5">
                <select name="details[${detailIndex}][id_produk]" class="form-select" required>
                    <option value="" disabled selected>Pilih Produk</option>
                    @foreach($produk as $item)
                        <option value="{{ $item->id_produk }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="details[${detailIndex}][kuantitas]" class="form-control" required>
            </div>
            <div class="col-md-3">
                <input type="number" name="details[${detailIndex}][harga_jual]" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger btn-remove">Hapus</button>
            </div>
        `;
        container.appendChild(newItem);
        detailIndex++;
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('.detail-item').remove();
        }
    });
</script>
@endsection

@extends('layout.master')
@section('title', 'Tambah Proses Produksi')

@section('content')
<div class="container">
    <h4>Tambah Proses Produksi</h4>

    <form action="{{ route('proses-produksi.store') }}" method="POST">
        @csrf
        <div class="mb-3 col-md-4">
            <label for="kode_produksi" class="form-label">Kode Produksi</label>
            <input type="text" name="kode_produksi" id="kode_produksi" class="form-control" value="{{ old('kode_produksi') }}" required>
            @error('kode_produksi')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            @error('tanggal')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <hr>

        <h4>Detail Bahan yang Digunakan</h4>
        <table class="table" id="detail-table">
            <thead>
                <tr>
                    <th>Bahan</th>
                    <th>Kuantitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- baris pertama default -->
                <tr>
                    <td>
                        <select name="details[0][id_bahan]" class="form-select" required>
                            <option value="">Pilih Bahan</option>
                            @foreach($bahan as $item)
                                <option value="{{ $item->id_bahan }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="details[0][kuantitas]" class="form-control" min="1" required></td>
                    <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
                </tr>
                <button type="button" id="btn-add-detail" class="btn btn-primary mb-3">+</button>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('proses-produksi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    let detailIndex = 1;

    document.getElementById('btn-add-detail').addEventListener('click', function () {
        const tbody = document.querySelector('#detail-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="details[${detailIndex}][id_bahan]" class="form-select" required>
                    <option value="">Pilih Bahan</option>
                    @foreach($bahan as $item)
                        <option value="{{ $item->id_bahan }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[${detailIndex}][kuantitas]" class="form-control" min="1" required></td>
            <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
        `;
        tbody.appendChild(newRow);
        detailIndex++;
    });

    document.querySelector('#detail-table').addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('tr').remove();
        }
    });
</script>
@endsection

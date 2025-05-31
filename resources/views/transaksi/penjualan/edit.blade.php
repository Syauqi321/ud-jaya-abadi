@extends('layout.master')
@section('title', 'Edit Penjualan')

@section('content')
<div class="container">
    <h1>Edit Penjualan #{{ $penjualan->id_penjualan }}</h1>

    <form action="{{ route('penjualan.update', $penjualan->id_penjualan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3 col-md-4">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                <option value="">Pilih Pelanggan</option>
                @foreach($pelanggan as $item)
                    <option value="{{ $item->id_pelanggan }}" {{ old('id_pelanggan', $penjualan->id_pelanggan) == $item->id_pelanggan ? 'selected' : '' }}>
                        {{ $item->nama }}
                    </option>
                @endforeach
            </select>
            @error('id_pelanggan')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3 col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $penjualan->tanggal) }}" required>
            @error('tanggal')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <hr>

        <h4>Detail Penjualan</h4>
        <table class="table" id="detail-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldDetails = old('details', $penjualan->detailPenjualan->toArray());
                    $index = 0;
                @endphp

                @foreach ($oldDetails as $detail)
                <tr>
                    <td>
                        <select name="details[{{ $index }}][id_produk]" class="form-select" required>
                            <option value="">Pilih Produk</option>
                            @foreach($produk as $item)
                                <option value="{{ $item->id_produk }}"
                                    {{ $item->id_produk == $detail['id_produk'] ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="details[{{ $index }}][kuantitas]" class="form-control" min="1" value="{{ $detail['kuantitas'] }}" required></td>
                    <td><input type="number" name="details[{{ $index }}][harga_jual]" class="form-control" min="0" value="{{ $detail['harga_jual'] }}" required></td>
                    <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
                </tr>
                @php $index++; @endphp
                @endforeach
            </tbody>
            <button type="button" id="btn-add-detail" class="btn btn-primary mb-3">+</button>
        </table>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    let detailIndex = {{ $index }};

    document.getElementById('btn-add-detail').addEventListener('click', function () {
        const tbody = document.querySelector('#detail-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="details[\${detailIndex}][id_produk]" class="form-select" required>
                    <option value="">Pilih Produk</option>
                    @foreach($produk as $item)
                        <option value="{{ $item->id_produk }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[\${detailIndex}][kuantitas]" class="form-control" min="1" required></td>
            <td><input type="number" name="details[\${detailIndex}][harga_jual]" class="form-control" min="0" required></td>
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

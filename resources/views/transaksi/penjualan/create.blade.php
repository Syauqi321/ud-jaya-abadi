@extends('layout.master')
@section('title', 'Tambah Penjualan')

@section('content')
<div class="container">
    <h4>Tambah Penjualan</h4>

    <form action="{{ route('penjualan.store') }}" method="POST">
        @csrf

        <div class="mb-3 col-md-4">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select name="id_pelanggan" id="id_pelanggan" class="form-select" required>
                <option value="" disabled selected>Pilih Pelanggan</option>
                @foreach($pelanggan as $p)
                    <option value="{{ $p->id_pelanggan }}">{{ $p->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            @error('tanggal')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <hr>

        <h4>Detail Produk</h4>
        <table class="table" id="detail-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- baris pertama default -->
                <tr>
                    <td>
                        <select name="details[0][id_produk]" class="form-select" required>
                            <option value="">Pilih Produk</option>
                            @foreach($produk as $item)
                                <option value="{{ $item->id_produk }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="details[0][kuantitas]" class="form-control" min="1" required></td>
                    <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
                </tr>
                <tr>
                        <button type="button" id="btn-add-detail" class="btn btn-primary mb-3">+</button>
                </tr>
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    let detailIndex = 1;

    function updateProdukOptions() {
        const selectedValues = Array.from(document.querySelectorAll('select[name^="details"]'))
            .map(select => select.value)
            .filter(val => val !== "");

        document.querySelectorAll('select[name^="details"]').forEach(select => {
            const currentValue = select.value;

            select.querySelectorAll('option').forEach(option => {
                if (option.value === "") return;

                if (selectedValues.includes(option.value) && option.value !== currentValue) {
                    option.disabled = true;
                } else {
                    option.disabled = false;
                }
            });
        });
    }

    document.getElementById('btn-add-detail').addEventListener('click', function () {
        const tbody = document.querySelector('#detail-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="details[${detailIndex}][id_produk]" class="form-select produk-select" required>
                    <option value="">Pilih Produk</option>
                    @foreach($produk as $item)
                        <option value="{{ $item->id_produk }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[${detailIndex}][kuantitas]" class="form-control" min="1" required></td>
            <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
        `;
        tbody.appendChild(newRow);

        const select = newRow.querySelector('.produk-select');
        select.addEventListener('change', updateProdukOptions);
        updateProdukOptions();

        detailIndex++;
    });

    document.querySelector('#detail-table').addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('tr').remove();
            updateProdukOptions();
        }
    });

    // Inisialisasi untuk select produk yang sudah ada (misal saat edit)
    document.querySelectorAll('.produk-select').forEach(select => {
        select.addEventListener('change', updateProdukOptions);
    });

    updateProdukOptions();
</script>

@endsection

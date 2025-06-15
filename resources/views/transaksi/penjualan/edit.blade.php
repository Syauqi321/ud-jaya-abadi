@extends('layout.master')
@section('title', 'Edit Penjualan')

@section('content')
<div class="container">
    <h4>Edit Penjualan #{{ $penjualan->id_penjualan }}</h4>

    <form action="{{ route('penjualan.update', $penjualan->id_penjualan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3 col-md-4">
            <label for="id_pelanggan" class="form-label">Pelanggan</label>
            <select name="id_pelanggan" class="form-select" required>
                @foreach($pelanggan as $p)
                    <option value="{{ $p->id_pelanggan }}" {{ $p->id_pelanggan == $penjualan->id_pelanggan ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3 col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="{{ $penjualan->tanggal }}" required>
        </div>

        <hr>
        <h5>Detail Produk</h5>

        <table class="table" id="detail-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Kuantitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjualan->detailPenjualan as $index => $detail)
                <tr>
                    <td>
                        <select name="details[{{ $index }}][id_produk]" class="form-select" required>
                            <option value="">Pilih Produk</option>
                            @foreach($produk as $item)
                                <option value="{{ $item->id_produk }}" {{ $item->id_produk == $detail->id_produk ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="details[{{ $index }}][kuantitas]" value="{{ $detail->kuantitas }}" class="form-control" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove">-</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <button type="button" id="btn-add-detail" class="btn btn-primary mb-3">+</button>
        </table>


        <div>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('penjualan.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </form>
</div>

<script>
    let detailIndex = {{ count($penjualan->detailPenjualan) }};

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
                <select name="details[\${detailIndex}][id_produk]" class="form-select produk-select" required>
                    <option value="">Pilih Produk</option>
                    @foreach($produk as $item)
                        <option value="{{ $item->id_produk }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="details[\${detailIndex}][kuantitas]" class="form-control" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-remove">-</button>
            </td>
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

    // Inisialisasi dropdown produk yang sudah ada (saat edit)
    document.querySelectorAll('.produk-select').forEach(select => {
        select.addEventListener('change', updateProdukOptions);
    });

    updateProdukOptions();
</script>

@endsection

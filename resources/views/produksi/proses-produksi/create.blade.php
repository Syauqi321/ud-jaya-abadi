@extends('layout.master')
@section('title', 'Tambah Proses Produksi')

@section('content')
    <div class="container">
        <h4>Tambah Proses Produksi</h4>

        <form action="{{ route('proses-produksi.store') }}" method="POST">
            @csrf

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

            <h5>Hasil Produksi</h5>
            <table class="table">
                <tbody>
                    <tr>
                        <td style="width: 30%;">
                            <label for="id_produk">Produk</label>
                            <select name="id_produk" class="form-control">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produk as $item)
                                    <option value="{{ $item->id_produk }}" {{ old('id_produk', $produksi->id_produk ?? '') == $item->id_produk ? 'selected' : '' }}>
                                        {{ $item->nama}}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        {{-- <td style="width: 20%;">
                            <label for="kuantitas">Kuantitas Produk</label>
                            <input type="number" name="kuantitas" class="form-control"
                                value="{{ old('kuantitas', $produksi->kuantitas ?? '') }}">
                        </td>
                        <td>
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan"
                                class="form-control">{{ old('keterangan', $produksi->keterangan ?? '') }}</textarea>
                        </td> --}}
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('proses-produksi.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
    let detailIndex = 1;

    function updateBahanOptions() {
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

        // Gunakan backtick dan interpolasi variabel dengan ${detailIndex}
        newRow.innerHTML = `
            <td>
                <select name="details[${detailIndex}][id_bahan]" class="form-select bahan-select" required>
                    <option value="">Pilih Bahan</option>
                    @foreach($bahan as $item)
                        <option value="{{ $item->id_bahan }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                    @endforeach
                </select>
            </td>
            <td>
                <input type="number" name="details[${detailIndex}][kuantitas]" class="form-control" min="1" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-remove">-</button>
            </td>
        `;
        tbody.appendChild(newRow);

        const select = newRow.querySelector('.bahan-select');
        select.addEventListener('change', updateBahanOptions);
        updateBahanOptions();

        detailIndex++;
    });

    document.querySelector('#detail-table').addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('tr').remove();
            updateBahanOptions();
        }
    });

    // Inisialisasi untuk dropdown awal (baris pertama)
    document.querySelectorAll('.bahan-select').forEach(select => {
        select.addEventListener('change', updateBahanOptions);
    });

    updateBahanOptions();
</script>


@endsection

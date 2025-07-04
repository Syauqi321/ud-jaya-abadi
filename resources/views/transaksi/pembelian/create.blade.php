@extends('layout.master')
@section('title', 'Tambah Pembelian')

@section('content')
<div class="container">
    <h4>Tambah Pembelian</h4>

    <form action="{{ route('pembelian.store') }}" method="POST">
        @csrf
        <div class="mb-3 col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
            @error('tanggal')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <hr>

        <h4>Detail Pembelian</h4>
        <table class="table" id="detail-table">
            <thead>
                <tr>
                    <th>Bahan</th>
                    <th>Kuantitas</th>
                    <th>Harga/kg</th>
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
                                <option value="{{ $item->id_bahan }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="details[0][kuantitas]" class="form-control" min="1" required></td>
                    <td><input type="number" name="details[0][harga]" class="form-control" min="0" required></td>
                    <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
                </tr>
                <button type="button" id="btn-add-detail" class="btn btn-primary mb-3">+</button>
            </tbody>
        </table>


        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    let detailIndex = 1;

    // Fungsi untuk memperbarui semua dropdown bahan
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

    // Tambah baris baru
    document.getElementById('btn-add-detail').addEventListener('click', function () {
        const tbody = document.querySelector('#detail-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="details[${detailIndex}][id_bahan]" class="form-select bahan-select" required>
                    <option value="">Pilih Bahan</option>
                    @foreach($bahan as $item)
                        <option value="{{ $item->id_bahan }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[${detailIndex}][kuantitas]" class="form-control" min="1" required></td>
            <td><input type="number" name="details[${detailIndex}][harga]" class="form-control" min="0" required></td>
            <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
        `;
        tbody.appendChild(newRow);
        detailIndex++;

        updateBahanOptions(); // Perbarui opsi bahan

        // Tambahkan event listener untuk select baru
        newRow.querySelector('.bahan-select').addEventListener('change', updateBahanOptions);
    });

    // Hapus baris
    document.querySelector('#detail-table').addEventListener('click', function (e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('tr').remove();
            updateBahanOptions(); // Perbarui opsi bahan
        }
    });

    // Event listener awal untuk select bahan yang sudah ada
    document.querySelectorAll('.bahan-select').forEach(select => {
        select.addEventListener('change', updateBahanOptions);
    });
</script>

@endsection

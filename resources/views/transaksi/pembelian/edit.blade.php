@extends('layout.master')
@section('title', 'Edit Pembelian')

@section('content')
<div class="container">
    <h4>Edit Pembelian #{{ $pembelian->id_pembelian }}</h4>

    <form action="{{ route('pembelian.update', $pembelian->id_pembelian) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3 col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $pembelian->tanggal) }}" required>
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
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $oldDetails = old('details', $pembelian->detailPembelian->toArray());
                    $index = 0;
                @endphp

                @foreach ($oldDetails as $detail)
                <tr>
                    <td>
                        <select name="details[{{ $index }}][id_bahan]" class="form-select" required>
                            <option value="">Pilih Bahan</option>
                            @foreach($bahan as $item)
                                <option value="{{ $item->id_bahan }}"
                                    {{ $item->id_bahan == $detail['id_bahan'] ? 'selected' : '' }}>
                                    {{ $item->nama }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td><input type="number" name="details[{{ $index }}][kuantitas]" class="form-control" min="1" value="{{ $detail['kuantitas'] }}" required></td>
                    <td><input type="number" name="details[{{ $index }}][harga]" class="form-control" min="0" value="{{ $detail['harga'] }}" required></td>
                    <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
                </tr>
                @php $index++; @endphp
                @endforeach
            </tbody>
            <button type="button" id="btn-add-detail" class="btn btn-primary mb-3">+</button>
        </table>


        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('pembelian.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

<script>
    let detailIndex = {{ $index }};

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

    document.getElementById('btn-add-detail').addEventListener('click', function() {
        const tbody = document.querySelector('#detail-table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <select name="details[\${detailIndex}][id_bahan]" class="form-select bahan-select" required>
                    <option value="">Pilih Bahan</option>
                    @foreach($bahan as $item)
                        <option value="{{ $item->id_bahan }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="details[\${detailIndex}][kuantitas]" class="form-control" min="1" required></td>
            <td><input type="number" name="details[\${detailIndex}][harga]" class="form-control" min="0" required></td>
            <td><button type="button" class="btn btn-danger btn-remove">-</button></td>
        `;
        tbody.appendChild(newRow);

        const select = newRow.querySelector('.bahan-select');
        select.addEventListener('change', updateBahanOptions);
        updateBahanOptions();

        detailIndex++;
    });

    document.querySelector('#detail-table').addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-remove')) {
            e.target.closest('tr').remove();
            updateBahanOptions();
        }
    });

    // Inisialisasi untuk select saat edit
    document.querySelectorAll('.bahan-select').forEach(select => {
        select.addEventListener('change', updateBahanOptions);
    });

    // Jalankan pertama kali untuk menonaktifkan opsi bahan yang sudah dipilih saat edit
    updateBahanOptions();
</script>

@endsection

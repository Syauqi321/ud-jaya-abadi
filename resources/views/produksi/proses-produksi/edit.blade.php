@extends('layout.master')
@section('title', 'Edit Proses Produksi')

@section('content')
<div class="container">
    <h4>Edit Proses Produksi</h4>

    <form action="{{ route('proses-produksi.update', $produksi->id_proses) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3 col-md-4">
            <label for="kode_produksi" class="form-label">Kode Produksi</label>
            <input type="text" name="kode_produksi" id="kode_produksi" class="form-control" value="{{ old('kode_produksi', $produksi->kode_produksi) }}" required>
        </div>

        <div class="mb-3 col-md-4">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $produksi->tanggal) }}" required>
        </div>

        <hr>

        <h5>Detail Proses</h5>
        <table class="table" id="detail-table">
            <thead>
                <tr>
                    <th>Bahan</th>
                    <th>Kuantitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produksi->detailProses as $i => $detail)
                <tr>
                    <td>
                        <select name="details[{{ $i }}][id_bahan]" class="form-select" required>
                            <option value="">Pilih Bahan</option>
                            @foreach($bahan as $item)
                                <option value="{{ $item->id_bahan }}" {{ $item->id_bahan == $detail->id_bahan ? 'selected' : '' }}>
                                    {{ $item->nama }} (Stok: {{ $item->stok }})
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" name="details[{{ $i }}][kuantitas]" class="form-control" min="1" value="{{ $detail->kuantitas }}" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-remove">-</button>
                    </td>
                </tr>
                @endforeach
                <button type="button" id="btn-add-detail" class="btn btn-primary mb-3">+</button>
            </tbody>
        </table>


        <div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('proses-produksi.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<script>
    let detailIndex = {{ count($produksi->detailProses) }};

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
            <td>
                <input type="number" name="details[${detailIndex}][kuantitas]" class="form-control" min="1" required>
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-remove">-</button>
            </td>
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

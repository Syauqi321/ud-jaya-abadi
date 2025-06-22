@extends('layout.master')
@section('title', 'Edit Proses Produksi')

@section('content')
    <div class="container">
        <h4>Edit Proses Produksi</h4>

        <form action="{{ route('proses-produksi.update', $produksi->id_proses) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3 col-md-4">
                <label for="tanggal" class="form-label">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control"
                    value="{{ old('tanggal', $produksi->tanggal) }}" required>
            </div>

            <hr>

            <h5>Detail Proses</h5>
            <table class="table" id="detail-table">
                <thead>
                    <tr>
                        <th>Bahan</th>
                        <th>Kuantitas Bahan</th>
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
                                <input type="number" name="details[{{ $i }}][kuantitas]" class="form-control" min="1"
                                    value="{{ $detail->kuantitas }}" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-remove">-</button>
                            </td>
                        </tr>
                    @endforeach
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
                        <td style="width: 20%;">
                            <label for="kuantitas">Kuantitas Produk</label>
                            <input type="number" name="kuantitas" class="form-control"
                                value="{{ old('kuantitas', $produksi->kuantitas ?? '') }}">
                        </td>
                        <td>
                            <label for="keterangan">Keterangan</label>
                            <textarea name="keterangan"
                                class="form-control">{{ old('keterangan', $produksi->keterangan ?? '') }}</textarea>
                        </td>
                    </tr>
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

            newRow.innerHTML = `
                <td>
                    <select name="details[\${detailIndex}][id_bahan]" class="form-select bahan-select" required>
                        <option value="">Pilih Bahan</option>
                        @foreach($bahan as $item)
                            <option value="{{ $item->id_bahan }}">{{ $item->nama }} (Stok: {{ $item->stok }})</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input type="number" name="details[\${detailIndex}][kuantitas]" class="form-control" min="1" required>
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

        // Inisialisasi dropdown yang sudah ada (saat edit)
        document.querySelectorAll('.bahan-select').forEach(select => {
            select.addEventListener('change', updateBahanOptions);
        });

        updateBahanOptions();
    </script>

@endsection

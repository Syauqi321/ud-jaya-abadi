<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .info {
            font-size: 11px;
            line-height: 1.5;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .periode-box {
            border: 1px solid #000;
            padding: 6px 10px;
            font-size: 11px;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            font-size: 12px;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="info">
            <strong>UD. JAYA ABADI</strong><br>
            Dsn Krajan, Desa Sukojati, Kec. Blimbingsari<br>
            Kab. Banyuwangi, Jawa Timur 68462<br>
            0823 3380 2359
        </div>
        <div class="text-right">
            <div class="periode-box">
                Periode: {{ \Carbon\Carbon::parse($tanggalAwal)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($tanggalAkhir)->translatedFormat('d F Y') }}
            </div>
        </div>
    </div>

    <div class="title">Laporan Produksi</div>

    <h4 style="margin-top: 15px;">Detail Produksi</h4>

    <table>
        <thead>
            <tr>
                <th>Kode Produksi</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Kuantitas Bahan</th>
                <th>Kuantitas Produk</th>
                <th>Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($produksi as $data)
                @foreach ($data->dataHasilProduksi as $hasil)
                    <tr>
                        <td class="text-center">{{ $hasil->prosesProduksi->kode_produksi ?? '-' }}</td>
                        <td class="text-center">{{ $data->tanggal }}</td>
                        <td class="text-center">{{ $hasil->produk->nama ?? '-' }}</td>
                        <td class="text-center">{{ number_format($data->detailProses->sum('kuantitas'), 1, ',', '.') ?? 0 }} kg</td>
                        <td class="text-center">{{ number_format($hasil->kuantitas ?? 0, 1, ',', '.') }} kg</td>
                        <td class="text-center">
                            @php
                                $harga = $hasil->produk->hargaJualAktif ?? null;
                            @endphp
                            {{ $harga ? 'Rp ' . number_format($harga->harga, 0, ',', '.') . '/kg' : '-' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

</body>
</html>

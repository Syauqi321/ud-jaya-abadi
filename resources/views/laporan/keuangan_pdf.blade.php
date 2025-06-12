<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
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
            margin-top: 15px;
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

        .text-success {
            color: green;
        }

        .text-danger {
            color: red;
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
                Periode: {{ \Carbon\Carbon::parse($start)->translatedFormat('d F Y') }} - {{ \Carbon\Carbon::parse($end)->translatedFormat('d F Y') }}
            </div>
        </div>
    </div>

    <div class="title">Laporan Keuangan</div>

    <table>
        <thead>
            <tr>
                <th class="text-center">Total Pengeluaran (Bahan)</th>
                <th class="text-center">Total Penjualan</th>
                <th class="text-center">Laba / Rugi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">Rp{{ number_format($totalBiayaBahan, 0, ',', '.') }}</td>
                <td class="text-center">Rp{{ number_format($totalPenjualan, 0, ',', '.') }}</td>
                <td class="text-center {{ ($totalPenjualan - $totalBiayaBahan) >= 0 ? 'text-success' : 'text-danger' }}">
                    Rp{{ number_format($totalPenjualan - $totalBiayaBahan, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

</body>
</html>

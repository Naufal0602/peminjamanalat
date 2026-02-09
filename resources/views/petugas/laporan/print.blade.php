<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
        }
        th {
            background-color: #f2f2f2;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h2>LAPORAN PEMINJAMAN ALAT</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Tgl Pinjam</th>
            <th>Tgl Kembali</th>
            <th>Total Denda</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($laporan as $item)
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td>{{ $item->peminjam->name }}</td>
            <td class="text-center">{{ $item->tanggal_pinjam }}</td>
            <td class="text-center">
                {{ optional($item->pengembalian)->tanggal_kembali ?? '-' }}
            </td>
            <td class="text-right">
                Rp {{ number_format(optional($item->pengembalian)->total_denda ?? 0) }}
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Total Denda Keseluruhan :
    Rp {{ number_format($totalDenda) }}
</div>

</body>
</html>

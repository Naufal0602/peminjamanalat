
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Peringatan Pengembalian Alat</title>
</head>
<body>
   <h3>Halo {{ $peminjaman->peminjam->name }}</h3>

        <p>
        Kami informasikan bahwa Anda <b>terlambat {{ $hariTelat }} hari</b>
        dalam pengembalian alat.
        </p>

        <p>
        Tanggal kembali seharusnya:
        <b>{{ $peminjaman->tanggal_kembali_rencana }}</b>
        </p>

        <p>
        Mohon segera mengembalikan alat untuk menghindari denda tambahan.
        </p>

        <p>
        Terima kasih,<br>
        <b>Sistem Peminjaman Alat</b>
        </p>
</body>
</html>

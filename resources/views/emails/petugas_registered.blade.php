<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Akun Petugas</title>
</head>
<body>
    <h2>Halo {{ $user->name }}</h2>

    <p>Akun Anda sebagai <b>Petugas</b> telah berhasil dibuat.</p>

    <p><b>Detail Login:</b></p>
    <ul>
        <li>Email: {{ $user->email }}</li>
        <li>Password: {{ $password }}</li>
    </ul>

    <p>Silakan login dan segera ganti password Anda.</p>

    <p>Terima kasih,<br>
    <b>Sistem Peminjaman Alat</b></p>
</body>
</html>

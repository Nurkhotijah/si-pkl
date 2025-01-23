<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Siswa Baru</title>
</head>
<body> 
    <h1>Selamat Siswa Anda Diterima</h1>
    <p>Yth. Admin Sekolah,</p>
    <p>Berikut adalah informasi akun siswa yang baru dibuat:</p>
    <ul>
        <li><strong>Nama Siswa:</strong> {{ $name }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Silakan berikan informasi ini kepada siswa agar mereka bisa login.</p>
    <p><em>Catatan:</em> Jika terdapat siswa lain yang diajukan tetapi informasinya tidak muncul di email ini, mohon untuk memeriksa langsung di website kami.</p>
    <p>Terima kasih.</p>
</body>
</html>

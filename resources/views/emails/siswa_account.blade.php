<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akun Siswa Baru</title>
</head>
<body> 
    <h1>Akun Siswa Baru Telah Dibuat</h1>
    <p>Yth. Admin Sekolah,</p>
    <p>Berikut adalah informasi akun siswa yang baru dibuat:</p>
    <ul>
        <li><strong>Nama Siswa:</strong> {{ $name }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Password:</strong> {{ $password }}</li>
    </ul>
    <p>Silakan berikan informasi ini kepada siswa agar mereka bisa login.</p>
    <p>Terima kasih.</p>
 </body>
</html> 

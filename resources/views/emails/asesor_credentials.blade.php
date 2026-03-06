<!doctype html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <p>Halo {{ $name }},</p>

  <p>Akun asesor telah dibuat untuk Anda. Berikut kredensial sementara untuk login ke sistem:</p>

  <ul>
    <li>Email: <strong>{{ $email }}</strong></li>
    <li>Password sementara: <strong>{{ $password }}</strong></li>
  </ul>

  <p>Silakan login dan segera ganti password Anda. Jika Anda mengalami masalah, hubungi administrator.</p>

  <p>Terima kasih.</p>
</body>
</html>

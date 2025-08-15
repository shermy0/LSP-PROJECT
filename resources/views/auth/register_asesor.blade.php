<!DOCTYPE html>
<html>
<head>
    <title>Register Asesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>
<body>

<div class="register-card">
    <h2 class="text-center">Form Pendaftaran Asesor</h2>

    <form action="{{ route('register.asesor.store') }}" method="POST">
        @csrf
        <h5>Akun Login</h5>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>
        </div>

        <hr>
        <h5>Data Asesor</h5>
        <div class="mb-3">
            <label>NIP</label>
            <input type="text" name="nip" class="form-control" required>
        </div>
                <div class="mb-3">
            <label>No. Registrasi</label>
            <input type="text" name="no_registrasi" class="form-control">
        </div>
        <div class="mb-3">
            <label>Nama Asesor</label>
            <input type="text" name="nama_asesor" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Keahlian</label>
            <input type="text" name="keahlian" class="form-control">
        </div>
        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-3">Daftar</button>
    </form>

        <div class="mt-4 text-center">
        <p class="text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                Login
            </a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
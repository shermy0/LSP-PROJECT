<!DOCTYPE html>
<html>
<head>
    <title>Register Asesi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/register.css') }}">
</head>
<body>

<div class="register-card">
    <h2 class="text-center">Form Pendaftaran Asesi</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('register.asesi.store') }}" method="POST">
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
                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
                <small id="confirmError" class="text-danger"></small> <!-- tempat error -->
            </div>
        </div>


        <hr>
        <h5>Data Asesi</h5>
        <div class="mb-3">
            <label>NIK</label>
        <input type="text" name="nik" class="form-control" pattern="\d{16}" title="NIK harus 16 digit angka" required>
        </div>
        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="form-control" required>
                <option value="">-- Pilih --</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Telepon</label>
            <input type="text" name="telepon" class="form-control" required>
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
<script>
document.querySelector("form").addEventListener("submit", function(event) {
    let password = document.querySelector("input[name='password']").value;
    let confirm = document.querySelector("input[name='password_confirmation']").value;

    if (password !== confirm) {
        event.preventDefault(); // stop form submit
        alert("Password dan Konfirmasi Password tidak sama!");
    }
});
</script>
</body>

</html>
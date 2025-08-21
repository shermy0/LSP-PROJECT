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

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


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
        <h5>Data Asesor</h5>
        <div class="mb-3">
            <label>NIP</label>
        <input type="text" name="nip" class="form-control" pattern="\d{18}" title="NIP harus 18 digit angka" required>
            @error('nip')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
                <div class="mb-3">
            <label>No. Registrasi</label>
            <input type="text" name="no_registrasi" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nama Asesor</label>
            <input type="text" name="nama_asesor" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="keahlian">Keahlian</label>
            <select name="keahlian" class="form-control" required>
                <option value="">-- Pilih Keahlian Anda --</option>
                <option value="Akuntansi dan Keuangan Lembaga">Akuntansi dan Keuangan Lembaga</option>
                <option value="Bisnis Daring dan Pemasaran">Bisnis Daring dan Pemasaran</option>
                <option value="Desain Komunikasi Visual">Desain Komunikasi Visual</option>
                <option value="Manajemen Perkantoran dan Layanan Bisnis">Manajemen Perkantoran dan Layanan Bisnis</option>
                <option value="Pengembangan Perangkat Lunak dan Gim">Pengembangan Perangkat Lunak dan Gim</option>
                <option value="Teknik Komputer dan Jaringan">Teknik Komputer dan Jaringan</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" required>
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
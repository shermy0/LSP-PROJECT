<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>

<div class="login-card text-center">
    <h4>Selamat Datang</h4>
    <p>Masuk ke akun LSP anda</p>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="mb-3 text-start">
            <label>Email</label>
            <input type="email" name="email" class="form-control" placeholder="Masukkan email anda" required>
        </div>
        <div class="mb-3 text-start">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Masukkan password anda" required>
        </div>
        <div class="form-check text-start mb-3">
            <input class="form-check-input" type="checkbox" id="remember">
            <label class="form-check-label" for="remember">
                Remember me
            </label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Sign In</button>
    </form>

    <p class="mt-3">Tidak punya akun? 
        <a href="#" class="register-link" data-bs-toggle="modal" data-bs-target="#roleModal">Buat akun</a>
    </p>
</div>

{{-- pop up pilih role --}}
<div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"> <!-- center di layar -->
    <div class="modal-content text-light p-3 rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title w-100 text-center fw-bold" id="roleModalLabel">Pilih Peran Anda.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <div class="row g-3">
          <div class="col-6">
            <div class="role-option p-4 border rounded-3" data-role="asesi">
              <i class="bi bi-person-badge" style="font-size: 2rem;"></i>
              <h6 class="fw-bold mt-2">Asesi</h6>
              <p class="mb-0 small text-muted">Peserta uji kompetensi</p>
            </div>
          </div>
          <div class="col-6">
            <div class="role-option p-4 border rounded-3" data-role="asesor">
              <i class="bi bi-person-check" style="font-size: 2rem;"></i>
              <h6 class="fw-bold mt-2">Asesor</h6>
              <p class="mb-0 small text-muted">Penguji/penilai</p>
            </div>
          </div>
        </div>


      <div class="modal-footer border-0 d-flex justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
        <button type="button" id="continueRole" class="btn btn-primary">Lanjut</button>
      </div>
    </div>
  </div>
</div>
{{-- end pop up --}}

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/login.js') }}" defer></script>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> e85c83359a797ed6d029e7aa7d91b8b3d3aa010a

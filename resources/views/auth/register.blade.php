<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Register - LSP</title>

    <!-- Bootstrap + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root{
            --blue-deep: #052a66;
            --blue-accent: #12b0ff;
            --card-radius: 16px;
        }

        body {
            background: #f2f6fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        .card-wrap {
            width: 100%;
            max-width: 580px; /* Diperbesar sedikit untuk 2 kolom */
            background: var(--blue-deep);
            color: #ffffff;
            border-radius: var(--card-radius);
            padding: 2rem;
            box-shadow: 0 14px 40px rgba(7,33,79,0.18);
            border: 1px solid rgba(255,255,255,0.03);
        }

        .brand {
            width: 68px;
            height: 68px;
            border-radius: 12px;
            display: inline-grid;
            place-items: center;
            background: rgba(255,255,255,0.06);
            margin: 0 auto 10px;
            color: #bfe9ff;
            font-size: 1.4rem;
        }

        .card-title {
            margin: 6px 0 2px;
            font-weight: 700;
            letter-spacing: 0.2px;
            font-size: 1.25rem;
            text-align: center;
        }

        .subtitle {
            color: #cddff4;
            font-size: .92rem;
            margin-bottom: 1.4rem;
            text-align: center;
        }

        .form-row {
            margin-bottom: 1rem;
        }

        .form-row-double {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-clean, .select-clean {
            width: 100%;
            background: #ffffff;
            color: #0b2140;
            border: none;
            border-radius: 10px;
            padding: 12px 44px;
            height: 46px;
            box-shadow: 0 4px 10px rgba(7,33,79,0.06) inset;
            font-size: .95rem;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        .input-clean:focus, .select-clean:focus {
            outline: none;
            box-shadow: 0 6px 18px rgba(7,33,79,0.06);
        }

        .input-icon-left {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #0b3a70;
            font-size: 1rem;
            pointer-events: none;
        }

        .input-icon-right {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #0b3a70;
            background: transparent;
            border: none;
            padding: 4px;
            cursor: pointer;
            font-size: 1.05rem;
        }

        .select-icon-right {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #0b3a70;
            font-size: 1rem;
            pointer-events: none;
        }

        .help-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            color: #bfdff9;
            font-size: .9rem;
        }

        .help-row a {
            color: #aee0ff;
            text-decoration: none;
            font-weight: 600;
        }
        .help-row a:hover { text-decoration: underline; }

        .form-check-label { color: #d7eafc; font-size: .92rem; }
        .form-check-input { width: 18px; height: 18px; }

        .btn-primary-custom {
            display: inline-block;
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 10px 14px;
            font-weight: 700;
            color: white;
            background: linear-gradient(90deg, var(--blue-accent), #0077d6);
            box-shadow: 0 8px 18px rgba(18,176,255,0.18);
            transition: transform .08s ease, box-shadow .12s ease;
        }
        .btn-primary-custom:active { transform: translateY(1px); }
        .btn-primary-custom:hover { box-shadow: 0 12px 30px rgba(18,176,255,0.22); }

        .register-row { text-align: center; margin-top: 1.25rem; color: #cfe7ff; }
        .register-row a { color: #9fe6ff; font-weight: 600; text-decoration: none; }
        .register-row a:hover { text-decoration: underline; }

        .text-error { color: #ffd6d6; font-size: .88rem; margin-top: .4rem; }

        /* Responsif untuk form double */
        @media (max-width: 768px) {
            .form-row-double {
                grid-template-columns: 1fr; /* Satu kolom di mobile */
                gap: 0.5rem;
            }
        }

        @media (max-width: 520px) {
            .card-wrap { 
                padding: 1.4rem; 
                border-radius: 12px;
                max-width: 95%;
            }
            
            body {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>

<div class="card-wrap" role="main" aria-labelledby="regTitle">
    <div class="card-title" id="regTitle">Daftar Akun Baru</div>
    <div class="subtitle">Buat akun untuk mengakses layanan LSP</div>

    {{-- Global error --}}
    @if ($errors->any())
        <div class="mb-3 text-start">
            <div class="text-error">
                {{-- menampilkan error pertama untuk ringkas --}}
                {{ $errors->first() }}
            </div>
        </div>
    @endif

    <form action="{{ route('register.store') }}" method="POST" novalidate>
        @csrf

        {{-- hidden default role (asesi) --}}
        <input type="hidden" name="role" value="asesi">

        <!-- Nama -->
        <div class="form-row text-start">
            <label for="name" style="color:#cfe7ff;font-size:.95rem;">Nama Lengkap</label>
            <div class="input-wrapper">
                <i class="bi bi-person-fill input-icon-left" aria-hidden="true"></i>
                <input id="name" name="name" type="text" class="input-clean @error('name') is-invalid @enderror"
                       placeholder="Masukkan nama lengkap" required value="{{ old('name') }}" autocomplete="name" />
            </div>
            @error('name') <div class="text-error">{{ $message }}</div> @enderror
        </div>

        <!-- Email -->
        <div class="form-row text-start">
            <label for="email" style="color:#cfe7ff;font-size:.95rem;">Email</label>
            <div class="input-wrapper">
                <i class="bi bi-envelope-fill input-icon-left" aria-hidden="true"></i>
                <input id="email" name="email" type="email" class="input-clean @error('email') is-invalid @enderror"
                       placeholder="Masukkan email" required value="{{ old('email') }}" autocomplete="email" />
            </div>
            @error('email') <div class="text-error">{{ $message }}</div> @enderror
        </div>

        <!-- Password dan Konfirmasi Password (Bersebelahan) -->
        <div class="form-row-double text-start">
            <!-- Password -->
            <div>
                <label for="password" style="color:#cfe7ff;font-size:.95rem;">Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-lock-fill input-icon-left" aria-hidden="true"></i>
                    <input id="password" name="password" type="password" class="input-clean @error('password') is-invalid @enderror"
                           placeholder="Buat password" required autocomplete="new-password" />
                    <button type="button" id="togglePassword" class="input-icon-right" aria-label="Lihat password">
                        <i class="bi bi-eye-slash" id="toggleIcon" aria-hidden="true"></i>
                    </button>
                </div>
                @error('password') <div class="text-error">{{ $message }}</div> @enderror
            </div>

            <!-- Konfirmasi Password -->
            <div>
                <label for="password_confirmation" style="color:#cfe7ff;font-size:.95rem;">Konfirmasi Password</label>
                <div class="input-wrapper">
                    <i class="bi bi-key-fill input-icon-left" aria-hidden="true"></i>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="input-clean" placeholder="Ulangi password" required autocomplete="new-password" />
                    <button type="button" id="togglePasswordConfirm" class="input-icon-right" aria-label="Lihat konfirmasi password">
                        <i class="bi bi-eye-slash" id="toggleIconConfirm" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Jurusan -->
        <div class="form-row text-start">
            <label for="jurusan_id" style="color:#cfe7ff;font-size:.95rem;">Pilih Jurusan</label>
            <div class="input-wrapper">
                <i class="bi bi-book-fill input-icon-left" aria-hidden="true"></i>
                <select id="jurusan_id" name="jurusan_id" class="select-clean @error('jurusan_id') is-invalid @enderror" required>
                    <option value="">-- Pilih Jurusan --</option>
                    @foreach($jurusan as $item)
                        <option value="{{ $item->id_jurusan }}" {{ old('jurusan_id') == $item->id_jurusan ? 'selected' : '' }}>
                            {{ $item->nama_jurusan }} ({{ $item->kode_jurusan }})
                        </option>
                    @endforeach
                </select>
                <i class="bi bi-chevron-down select-icon-right" aria-hidden="true"></i>
            </div>
            @error('jurusan_id') <div class="text-error">{{ $message }}</div> @enderror
        </div>

        <!-- help row: lupa password (fallback bukan aktif disini) -->
        <div class="help-row" style="justify-content:flex-end;">
            <!-- kosong left (no remember) and right link to login/register -->
            <a href="{{ Route::has('login') ? route('login') : '#' }}">Sudah punya akun? Login</a>
        </div>

        <div class="form-row">
            <button type="submit" class="btn-primary-custom">Daftar Sekarang</button>
        </div>
    </form>

    <div class="register-row">
        <div>Dengan mendaftar, Anda setuju dengan syarat & ketentuan kami.</div>
    </div>
</div>

<!-- scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle password visibility for both password fields
    (function () {
        const toggleBtn = document.getElementById('togglePassword');
        const toggleBtnConfirm = document.getElementById('togglePasswordConfirm');
        const passInput = document.getElementById('password');
        const passConfirm = document.getElementById('password_confirmation');
        const icon = document.getElementById('toggleIcon');
        const iconConfirm = document.getElementById('toggleIconConfirm');

        if (toggleBtn && passInput) {
            toggleBtn.addEventListener('click', function () {
                const isPwd = passInput.getAttribute('type') === 'password';
                passInput.setAttribute('type', isPwd ? 'text' : 'password');
                icon.classList.toggle('bi-eye');
                icon.classList.toggle('bi-eye-slash');
                this.setAttribute('aria-label', isPwd ? 'Sembunyikan password' : 'Lihat password');
            });
        }

        if (toggleBtnConfirm && passConfirm) {
            toggleBtnConfirm.addEventListener('click', function () {
                const isPwd = passConfirm.getAttribute('type') === 'password';
                passConfirm.setAttribute('type', isPwd ? 'text' : 'password');
                iconConfirm.classList.toggle('bi-eye');
                iconConfirm.classList.toggle('bi-eye-slash');
                this.setAttribute('aria-label', isPwd ? 'Sembunyikan konfirmasi password' : 'Lihat konfirmasi password');
            });
        }

        // simple client-side check to prevent submitting if password mismatch
        document.querySelector('form').addEventListener('submit', function (e) {
            const p = passInput ? passInput.value : '';
            const c = passConfirm ? passConfirm.value : '';
            const jurusan = document.getElementById('jurusan_id') ? document.getElementById('jurusan_id').value : '';
            
            if (p !== c) {
                e.preventDefault();
                alert('Password dan konfirmasi password tidak sama.');
                if (passConfirm) passConfirm.focus();
                return;
            }
            
            if (!jurusan) {
                e.preventDefault();
                alert('Silakan pilih jurusan terlebih dahulu.');
                if (document.getElementById('jurusan_id')) document.getElementById('jurusan_id').focus();
            }
        });
    })();
</script>
</body>
</html>
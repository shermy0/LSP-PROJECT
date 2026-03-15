<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Login - LSP</title>

    <!-- Bootstrap + Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root{
            --blue-deep: #052a66; /* lebih gelap untuk card */
            --blue-accent: #12b0ff; /* aksen tombol */
            --card-radius: 16px;
        }

        /* Body */
        body {
            background: #f2f6fb;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }

        /* Card */
        .login-card {
            width: 100%;
            max-width: 420px;
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

        .login-card h4 {
            margin: 6px 0 2px;
            font-weight: 700;
            letter-spacing: 0.2px;
            font-size: 1.25rem;
        }

        .login-card .subtitle {
            color: #cddff4;
            font-size: .92rem;
            margin-bottom: 1.4rem;
        }

        /* Input wrapper - white rounded inputs with icons inside */
        .form-row {
            margin-bottom: 1rem;
        }

        .input-wrapper {
            position: relative;
        }

        .input-clean {
            width: 100%;
            background: #ffffff;
            color: #0b2140;
            border: none;
            border-radius: 10px;
            padding: 12px 44px; /* space for left & right icons */
            height: 46px;
            box-shadow: 0 4px 10px rgba(7,33,79,0.06) inset;
            font-size: .95rem;
        }

        .input-clean:focus {
            outline: none;
            box-shadow: 0 6px 18px rgba(7,33,79,0.06);
        }

        .input-icon-left {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #0b3a70; /* ikon biru gelap */
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
            font-size: 1.1rem;
        }

        /* small text links */
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

        /* checkbox */
        .form-check-label { color: #d7eafc; font-size: .92rem; }
        .form-check-input { width: 18px; height: 18px; }

        /* button */
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

        /* footer small link */
        .register-row { text-align: center; margin-top: 1.25rem; color: #cfe7ff; }
        .register-row a { color: #9fe6ff; font-weight: 600; text-decoration: none; }
        .register-row a:hover { text-decoration: underline; }

        /* error messages */
        .text-error { color: #ffd6d6; font-size: .88rem; margin-top: .4rem; }

        @media (max-width: 420px) {
            .login-card { padding: 1.4rem; border-radius: 12px; }
        }
    </style>
</head>
<body>

<div class="login-card text-center" role="main" aria-labelledby="loginTitle">
    <h4 id="loginTitle">Selamat Datang</h4>
    <div class="subtitle">Masuk ke akun LSP anda</div>

    {{-- tampilkan error global (mis. credential) --}}
    @if ($errors->has('login') || $errors->any())
        <div class="mb-3 text-start">
            <div class="text-error">
                @if ($errors->has('login'))
                    {{ $errors->first('login') }}
                @else
                    {{ $errors->first() }}
                @endif
            </div>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" novalidate>
        @csrf

        <!-- EMAIL -->
        <div class="form-row text-start">
            <label class="d-block mb-2" for="email" style="color:#cfe7ff;font-size:.95rem;">Email</label>
            <div class="input-wrapper">
                <i class="bi bi-envelope-fill input-icon-left" aria-hidden="true"></i>
                <input id="email" type="email" name="email"
                       class="input-clean @error('email') is-invalid @enderror"
                       placeholder="Masukkan email anda" required value="{{ old('email') }}" autocomplete="email" />
            </div>
            @error('email') <div class="text-error">{{ $message }}</div> @enderror
        </div>

        <!-- PASSWORD -->
        <div class="form-row text-start">
            <label class="d-block mb-2" for="password" style="color:#cfe7ff;font-size:.95rem;">Password</label>
            <div class="input-wrapper">
                <i class="bi bi-lock-fill input-icon-left" aria-hidden="true"></i>
                <input id="password" type="password" name="password"
                       class="input-clean @error('password') is-invalid @enderror"
                       placeholder="Masukkan password anda" required autocomplete="current-password" />
                <button type="button" id="togglePassword" class="input-icon-right" aria-label="Lihat password">
                    <i class="bi bi-eye-slash" id="toggleIcon" aria-hidden="true"></i>
                </button>
            </div>
            @error('password') <div class="text-error">{{ $message }}</div> @enderror
        </div>

        <!-- help row: remember + lupa password -->
        <div class="help-row">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <div>
                {{-- fallback aman jika route belum ada --}}
                <a href="{{ Route::has('password.request') ? route('password.request') : '#' }}">
                    Lupa password?
                </a>
            </div>
        </div>

        <div class="form-row">
            <button type="submit" class="btn-primary-custom">Sign In</button>
        </div>
    </form>

    <div class="register-row">
        <div>Tidak punya akun? <a href="{{ Route::has('register') ? route('register') : '#' }}">Buat akun</a></div>
    </div>
</div>

<!-- scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle password visibility
    (function () {
        const toggleBtn = document.getElementById('togglePassword');
        const passInput = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');

        if (!toggleBtn || !passInput) return;

        toggleBtn.addEventListener('click', function () {
            const isPwd = passInput.getAttribute('type') === 'password';
            passInput.setAttribute('type', isPwd ? 'text' : 'password');

            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');

            // update aria-label
            this.setAttribute('aria-label', isPwd ? 'Sembunyikan password' : 'Lihat password');
        });
    })();
</script>
</body>
</html>
@extends('master')

@section('title', 'Menunggu Verifikasi Admin')

@section('konten')
<div class="position-relative min-vh-100 d-flex align-items-center justify-content-center overflow-hidden py-5">
    <!-- Background decoration: lingkaran blur -->
    <div class="position-absolute top-0 start-0 w-100 h-100" style="z-index: 0;">
        <div class="position-absolute top-0 start-0 translate-middle-x" style="width: 300px; height: 300px; background: radial-gradient(circle, rgba(11,47,124,0.08) 0%, rgba(11,47,124,0) 70%); border-radius: 50%; left: 10%; top: 10%;"></div>
        <div class="position-absolute bottom-0 end-0 translate-middle-y" style="width: 400px; height: 400px; background: radial-gradient(circle, rgba(11,47,124,0.05) 0%, rgba(11,47,124,0) 70%); border-radius: 50%; right: -5%; bottom: 10%;"></div>
        <div class="position-absolute top-50 start-50 translate-middle" style="width: 500px; height: 500px; background: radial-gradient(circle, rgba(11,47,124,0.03) 0%, rgba(11,47,124,0) 70%); border-radius: 50%;"></div>
    </div>

    <!-- Konten utama -->
    <div class="container position-relative" style="z-index: 10;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8 col-md-10">
                <!-- Ikon dengan animasi dan latar soft -->
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-gradient-soft p-4 rounded-4" style="background: linear-gradient(135deg, rgba(11,47,124,0.1) 0%, rgba(11,47,124,0.05) 100%);">
                        <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="#0b2f7c" class="bi bi-hourglass-split animated-hourglass" viewBox="0 0 16 16">
                            <path d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1h-11zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2h-7zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48V8.35c0-.701.478-1.236 1.011-1.492A3.5 3.5 0 0 0 10.5 5s-.866 1.299-3 1.48v2.17c.701 0 1.236.478 1.492 1.011A3.5 3.5 0 0 0 9.5 13s-.866-1.299-3-1.48V8.35c0-.701-.478-1.236-1.011-1.492A3.5 3.5 0 0 0 4.5 5s.866 1.299 3 1.48v2.17z"/>
                        </svg>
                    </div>
                </div>

                <!-- Judul -->
                <h1 class="display-4 fw-bold mb-3" style="color: #0b2f7c; line-height: 1.2;">Menunggu Verifikasi Admin</h1>

                <!-- Deskripsi -->
                <p class="lead text-secondary mb-4 mx-auto" style="max-width: 550px; font-size: 1.25rem;">
                    Permohonan Anda telah diajukan dan sedang dalam proses verifikasi oleh admin.
                    Mohon tunggu konfirmasi selanjutnya. Kami akan segera memprosesnya.
                </p>

                <!-- Tombol kembali -->
                <a href="{{ route('form_pra_assesmen') }}" class="btn-next d-inline-flex align-items-center justify-content-center gap-2 px-5 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    :root {
        --primary: #0b2f7c;
        --primary-dark: #08205c;
        --font-sans: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    body {
        font-family: var(--font-sans);
        background: linear-gradient(145deg, #f9fafc 0%, #f1f4f9 100%);
        margin: 0;
        min-height: 100vh;
    }

    /* Tombol Next */
    .btn-next {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border-radius: 3rem;
        font-weight: 600;
        font-size: 1.1rem;
        border: none;
        cursor: pointer;
        box-shadow: 0 8px 18px rgba(11, 47, 124, 0.3);
        transition: all 0.3s cubic-bezier(0.2, 0.9, 0.3, 1.1);
        text-decoration: none;
    }

    .btn-next:hover {
        background: linear-gradient(135deg, var(--primary-dark), #051633);
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 15px 25px rgba(11, 47, 124, 0.4);
        color: #fff;
    }

    .btn-next:active {
        transform: translateY(0) scale(0.98);
    }

    /* Animasi ikon */
    .animated-hourglass {
        animation: floatAndPulse 3s ease-in-out infinite;
        transform-origin: center;
    }

    @keyframes floatAndPulse {
        0% { transform: scale(1) translateY(0); }
        50% { transform: scale(1.05) translateY(-5px); opacity: 0.9; }
        100% { transform: scale(1) translateY(0); }
    }

    /* Background decoration blur */
    .bg-gradient-soft {
        background: linear-gradient(135deg, rgba(11,47,124,0.08) 0%, rgba(11,47,124,0.02) 100%);
        backdrop-filter: blur(2px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2.8rem;
        }
        .lead {
            font-size: 1.1rem;
        }
        .btn-next {
            padding: 0.8rem 2rem;
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .display-4 {
            font-size: 2.2rem;
        }
        .lead {
            font-size: 1rem;
        }
        .btn-next {
            width: 100%;
        }
        .bg-white.bg-opacity-70 {
            padding-left: 1rem !important;
            padding-right: 1rem !important;
            font-size: 0.9rem;
        }
    }
</style>
@endsection

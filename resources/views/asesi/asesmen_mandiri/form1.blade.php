@extends('master')

@section('title', 'Asesmen Mandiri')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <!-- Header dengan ikon dan judul (warna #0b2f7c) -->
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                </svg>
            </div>
            <h1 class="display-6 fw-bold text-dark">Asesmen Mandiri</h1>
            <p class="text-secondary">Form Asesmen FR.APL.02 – Penilaian mandiri oleh asesi</p>
        </div>

        <!-- Informasi Skema - Card Modern -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-patch-check text-primary" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M14 8.5V6.127c0-.353-.145-.69-.402-.938l-3.73-3.53A1.5 1.5 0 0 0 8.812 1H4.5A1.5 1.5 0 0 0 3 2.5v11A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-1.959a2.5 2.5 0 0 0 .5-1.488V9.5h-.5v.042a2 2 0 0 1-2 2h-.5V9.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5v2h-.5a2 2 0 0 1-2-2v-.5h.042a2 2 0 0 1 1.488-.5H8.5v-.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5v.5h-.5a2 2 0 0 1-2-2V4.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v.5h2.5a.5.5 0 0 1 .5.5v.5h.5a2 2 0 0 1 2 2v.5h.5a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Informasi Skema</h5>
                        <p class="text-secondary mb-0 small">Detail skema yang akan dinilai</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Judul</label>
                        <input type="text" id="judul" class="form-control" value="{{ $permohonan->judul_skema ?? $permohonan->nama_skema ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor</label>
                        <input type="text" id="nomor" class="form-control" value="{{ $permohonan->kode_skema ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Skema Sertifikasi</label>
                        <input type="text" id="skema" class="form-control" value="{{ $permohonan->skema ?? $permohonan->nama_skema ?? '-' }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panduan Asesmen Mandiri - Card Modern -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list-check text-primary" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Panduan Asesmen Mandiri</h5>
                        <p class="text-secondary mb-0 small">Langkah-langkah yang perlu diperhatikan</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="step mb-3">
                    <div class="step-number">1</div>
                    <div class="step-text">Baca setiap pertanyaan/kriteria yang ditampilkan.</div>
                </div>
                <div class="step mb-3">
                    <div class="step-number">2</div>
                    <div class="step-text">Pilih opsi "Kompeten" atau "Belum Kompeten".</div>
                </div>
                <div class="step mb-3">
                    <div class="step-number">3</div>
                    <div class="step-text">Jika memilih "Kompeten", unggah bukti pendukung.</div>
                </div>
                <div class="step mb-0">
                    <div class="step-number">4</div>
                    <div class="step-text">Pastikan semua pertanyaan sudah diisi sebelum kirim.</div>
                </div>
            </div>
        </div>

        <!-- Tombol navigasi -->
        <div class="button-group mt-4">
            <a href="{{ route('form_pra_assesmen') }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Kembali
            </a>
            <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-next">
                Selanjutnya
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                </svg>
            </a>
        </div>
    </div>

    <style>
        /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
        :root {
            --primary: #0b2f7c;
            --primary-dark: #08205c;
            --primary-light: #1a3e9c;
            --secondary: #6c757d;
            --success: #198754;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
            --font-sans: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            font-family: var(--font-sans);
            background-color: #f1f4f9;
        }

        .container-fluid {
            max-width: 1280px;
            margin: 0 auto;
        }

        /* ===== FORM CARD & INPUT ===== */
        .card {
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .card:hover {
            box-shadow: 0 1rem 2rem rgba(0,0,0,0.08) !important;
        }

        .card-header {
            background: transparent;
            padding-bottom: 0;
        }

        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
            outline: none;
        }

        /* ===== WARNA UTAMA #0b2f7c ===== */
        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-primary.bg-gradient {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark)) !important;
        }

        .bg-primary.bg-opacity-10 {
            background-color: rgba(11,47,124,0.1) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

        /* Tombol Next */
        .btn-next {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            padding: 0.7rem 1.8rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 18px rgba(11,47,124,0.3);
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-next:hover {
            background: linear-gradient(135deg, var(--primary-dark), #061944);
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(11,47,124,0.35);
            color: #fff;
        }

        /* Tombol Back (tetap netral) */
        .btn-back {
            background-color: #fff;
            color: var(--secondary);
            padding: 0.7rem 1.8rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            border: 1.5px solid #dee2e6;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background-color: #f1f3f5;
            color: #495057;
            border-color: #ced4da;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* Step styling */
        .step {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
        }
        .step-number {
            width: 2rem;
            height: 2rem;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
            flex-shrink: 0;
        }
        .step-text {
            font-size: 0.95rem;
            color: #334155;
            padding-top: 0.2rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .button-group {
                justify-content: center;
            }
            .card-body .row > [class*="col-"] {
                margin-bottom: 0.25rem;
            }
        }
    </style>
@endsection

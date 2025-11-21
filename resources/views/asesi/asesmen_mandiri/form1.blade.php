@extends('master')

@section('title', 'Asesmen Mandiri')

@section('konten')
    <div class="container-fluid px-4 py-3">
        <!-- Header (ikuti tampilan FR.APL.02) -->
        <div class="text-center mb-4">
            <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
            <h1 class="h4 fw-bold">Asesmen Mandiri</h1>
            <p class="text-muted">Form Asesmen &gt; FR.APL.02</p>
        </div>

        <!-- NOTE:
             halaman ini read-only: menampilkan informasi permohonan (judul, kode, nama skema)
             lalu menampilkan panduan langkah. Tombol 'Selanjutnya' akan menuju form2.
        -->

        <!-- Informasi Skema (mengikuti style unit-header + question-box) -->
        <div class="unit-header">
            <p class="mb-1 fw-semibold">Informasi Skema</p>
            <p class="mb-0">Detail skema yang akan dinilai</p>
        </div>

        <div class="question-box">
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

        <!-- Panduan / Instruksi (mengikuti style target) -->
        <div class="unit-header">
            <p class="mb-1 fw-semibold">Panduan Asesmen Mandiri</p>
            <p class="mb-0">Langkah-langkah yang perlu diperhatikan</p>
        </div>

        <div class="question-box">
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

        <!-- Tombol navigasi -->
        <div class="button-group mt-4">
            <a href="{{ route('form_pra_assesmen') }}" class="btn-back">Kembali</a>
            <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-next">Selanjutnya</a>
        </div>
    </div>

    <!-- STYLES: salin dari desain FR.APL.02, disesuaikan untuk halaman read-only ini -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9fb;
        }

        .container-fluid {
            width: 100%;
        }

        .unit-header {
            background: #E9F1FF;
            border-left: 6px solid #007BFF;
            border-radius: 8px;
            padding: 18px 20px;
            margin-bottom: 12px;
            font-size: 1.125rem;
            line-height: 1.3;
            font-weight: 700;
            color: #041562;
        }

        .unit-header p.mb-0 {
            font-size: 0.95rem;
            color: #334155;
            margin-top: 4px;
            font-weight: 500;
        }

        .question-box {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            background: #fff;
        }

        label.form-label {
            font-weight: 600;
            font-size: 0.95rem;
            color: #0f172a;
            display:block;
            margin-bottom:6px;
        }

        .form-control {
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            background: #fff;
            color: #111827;
        }

        .step { display: flex; align-items: flex-start; margin-bottom: 12px; }
        .step-number {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #041562;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 12px;
            flex-shrink: 0;
        }
        .step-text { font-size: 14px; color: #334155; margin-top:3px; }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn-back {
            background: #d9534f;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            display:inline-block;
        }

        .btn-next {
            background: #041562;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
            display:inline-block;
        }

        .btn-back:hover {
            background: #c9302c;
            color:#fff;
        }

        .btn-next:hover {
            background: #06208a;
            color:#fff;
        }

        @media (max-width: 576px) {
            .unit-header { font-size: 1rem; padding: 14px 16px; }
            .step-text { font-size: 13px; }
            .btn-next, .btn-back { width: 100%; text-align:center; }
            .button-group { flex-direction: column-reverse; gap:10px; }
        }
    </style>

    {{-- (Opsional) Tambahkan script kecil untuk UX, mis. scroll ke section tertentu ketika klik Selanjutnya
         — tapi karena link adalah route biasa, tidak perlu JS khusus di sini. --}}
@endsection

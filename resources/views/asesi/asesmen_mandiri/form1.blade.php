@extends('master')

@section('title', 'Asesmen Mandiri')

@section('konten')
<div class="container">
    <!-- Header -->
    <div class="text-center mb-4">
        <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
        <h1 class="h5 fw-bold">Asesmen Mandiri</h1>
        <p class="small text-muted">Form Asesmen &gt; FR.APL.02</p>
    </div>

    <!-- Informasi Skema -->
    <div class="unit-header">
        <p class="mb-1 fw-semibold">Informasi Skema</p>
        <p class="mb-0">Detail skema yang akan dinilai</p>
    </div>

    <div class="question-box mb-4">
        <div class="mb-3">
            <label class="form-label">Judul</label>
            <input type="text" id="judul" class="form-control" value="{{ $permohonan->judul_skema ?? '-' }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor</label>
            <input type="text" id="nomor" class="form-control" value="{{ $permohonan->kode_skema ?? '-' }}" readonly>
        </div>

        <div class="mb-0">
            <label class="form-label">Skema Sertifikasi</label>
            <input type="text" id="skema" class="form-control" value="{{ $permohonan->skema ?? '-' }}" readonly>
        </div>
    </div>

    <!-- Panduan / Instruksi -->
    <div class="unit-header">
        <p class="mb-1 fw-semibold">Panduan Asesmen Mandiri</p>
        <p class="mb-0">Langkah-langkah yang perlu diperhatikan</p>
    </div>

    <div class="question-box mb-4">
        <div class="step">
            <div class="step-number">1</div>
            <div class="step-text">Baca setiap pertanyaan/kriteria yang ditampilkan.</div>
        </div>

        <div class="step">
            <div class="step-number">2</div>
            <div class="step-text">Pilih opsi "Kompeten" atau "Belum Kompeten".</div>
        </div>

        <div class="step">
            <div class="step-number">3</div>
            <div class="step-text">Jika memilih "Kompeten", unggah bukti pendukung.</div>
        </div>

        <div class="step mb-0">
            <div class="step-number">4</div>
            <div class="step-text">Pastikan semua pertanyaan sudah diisi sebelum kirim.</div>
        </div>
    </div>

    <!-- Tombol (tambah tombol Kembali) -->
    <div class="button-group mt-4">
        <a href="{{ route('form_pra_assesmen') }}" class="btn-back">Kembali</a>
        <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-next">Selanjutnya</a>
    </div>
</div>
@endsection

{{-- STYLE (mengikuti style kode kedua: unit-header / question-box / tombol) --}}
<style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9fb; }
    .container { max-width: 850px; margin: 20px auto; }

    .text-center h1, .text-center p { margin: 0; }

    .unit-header {
        background: #E9F1FF;
        border-left: 6px solid #007BFF;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 12px;
        font-size: 14px;
    }

    .question-box {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 20px;
        background: #fff;
    }

    .form-label { font-weight: 600; margin-bottom: 6px; display: block; }
    .form-control {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        width: 100%;
        background: #fff;
    }

    /* Steps styling */
    .step { display: flex; align-items: flex-start; margin-bottom: 12px; }
    .step-number {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #041562;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        margin-right: 12px;
        flex-shrink: 0;
    }
    .step-text { font-size: 14px; color: #333; }

    /* Buttons */
    .button-group { display: flex; justify-content: flex-end; gap: 12px; }
    .btn-next {
        background: #041562;
        color: #fff;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        border: none;
        display: inline-block;
    }
    .btn-next:hover { background: #06208a; color: #fff; }

    .btn-back {
        background: #d9534f;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        border: none;
    }
    .btn-back:hover { background: #c9302c; color: #fff; }

    /* validation visuals (if used later) */
    .form-control.is-invalid, .form-select.is-invalid {
        border: 2px solid #d9534f !important;
        background: #fff8f8 !important;
    }
    .invalid-feedback { font-size: 12px; }

    /* small responsive tweaks */
    @media (max-width: 576px) {
        .container { padding: 10px; }
        .step-text { font-size: 13px; }
    }
</style>

{{-- Optional JS: jika nanti ingin menambahkan client-side validation, bisa pakai pola berikut --}}
<script>
    // placeholder — tidak diaktifkan sekarang karena form read-only on this page.
    // Jika Anda ingin menambah validasi sebelum navigasi 'Selanjutnya', tambahkan kode di sini.
</script>

@extends('master')

@section('title', 'Asesmen Mandiri')

@section('konten')
    <div class="container">

        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <span>Form Asesmen &gt; <strong>FR.APL.02</strong></span>
        </div>

        <!-- Logo -->
        <div class="logo-box text-center">
            <div class="logo mb-2"></div>
            <h2>Asesmen Mandiri</h2>
        </div>

        <!-- Form -->
        <div class="form-wrapper">
            <div class="form-box">
                <label for="judul">Judul</label>
                <input type="text" id="judul" class="form-control" value="{{ $permohonan->judul_skema ?? '-' }}" readonly>
            </div>

            <div class="form-box">
                <label for="nomor">Nomor</label>
                <input type="text" id="nomor" class="form-control" value="{{ $permohonan->kode_skema ?? '-' }}" readonly>
            </div>

            <div class="form-box">
                <label for="skema">Skema Sertifikasi</label>
                <input type="text" id="skema" class="form-control" value="{{ $permohonan->skema ?? '-' }}" readonly>
            </div>
        </div>

        <!-- Panduan -->
        <div class="guide-box">
            <div class="guide-header">
                <h3>Panduan Asesmen Mandiri</h3>
            </div>

            <div class="step">
                <div class="step-number">1.</div>
                <div class="step-text">Baca setiap pertanyaan/kriteria yang ditampilkan.</div>
            </div>
            <div class="step">
                <div class="step-number">2.</div>
                <div class="step-text">Pilih opsi "Kompeten" atau "Belum Kompeten".</div>
            </div>
            <div class="step">
                <div class="step-number">3.</div>
                <div class="step-text">Jika memilih "Kompeten", unggah bukti pendukung.</div>
            </div>
            <div class="step">
                <div class="step-number">4.</div>
                <div class="step-text">Pastikan semua pertanyaan sudah diisi sebelum kirim.</div>
            </div>
        </div>

        <!-- Tombol -->
        <div class="button-box">
            <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-next">Selanjutnya</a>
        </div>
    </div>
@endsection

<style>
    .container {
        max-width: 800px;
    }

    /* Breadcrumb */
    .breadcrumb {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px 15px;
        font-size: 14px;
        margin-bottom: 20px;
    }

    /* Logo Box */
    .logo-box {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 30px 20px;
        margin-bottom: 25px;
    }
    .logo-box .logo {
        width: 40px;
        height: 40px;
        background-color: #041562;
        border-radius: 6px;
        margin: 0 auto;
    }
    .logo-box h2 {
        font-size: 20px;
        font-weight: 600;
        margin: 10px 0 0 0;
        color: #000;
    }

    /* Form Wrapper */
    .form-wrapper {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }
    .form-box {
        margin-bottom: 15px;
    }
    .form-box label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }
    .form-control {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        width: 100%;
    }

    /* Guide Box */
    .guide-box {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
    }
    .guide-header {
        background: #e9f0ff;
        border-left: 6px solid #041562;
        padding: 10px 15px;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    .guide-header h3 {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
        color: #041562;
    }

    .step {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
    }
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
        margin-right: 10px;
        flex-shrink: 0;
    }
    .step-text {
        font-size: 14px;
        color: #333;
    }

    /* Button Box */
    .button-box {
        text-align: right;
        margin-top: 15px;
    }
    .btn-next {
        display: inline-block;
        background: #041562;
        color: #fff;
        padding: 10px 25px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }
    .btn-next:hover {
        background: #06208a;
        color: #fff;
    }
</style>

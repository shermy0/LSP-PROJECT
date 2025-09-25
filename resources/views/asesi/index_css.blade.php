@extends('layouts.master')

@section('title', 'FR.APL.02')

@section('content')
<div class="container">

    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <span>Form Asesmen &gt; <strong>FR.APL.02</strong></span>
    </div>

    <!-- Logo -->
    <div class="logo-box">
        <div class="logo"></div>
        <h2>Asesmen Mandiri</h2>
    </div>

    <!-- Form -->
    <div class="form-wrapper">
        <div class="form-box">
            <label for="judul">Judul</label>
            <select id="judul">
                <option>Pilih Judul</option>
                <option>Desain Multimedia</option>
                <option>Pengembangan Web</option>
            </select>
            <div class="error-message"></div>
        </div>

        <div class="form-box">
            <label for="nomor">Nomor</label>
            <input type="text" id="nomor" placeholder="Masukkan Nomor">
        </div>

        <div class="form-box">
            <label for="skema">Skema Sertifikasi</label>
            <select id="skema">
                <option>Pilih Skema</option>
                <option>Multimedia</option>
                <option>Web Development</option>
            </select>
            <div class="error-message"></div>
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
            <div class="step-text">Pilih opsi "Kompeten" atau "Belum Kompeten" sesuai keyakinan Anda.</div>
        </div>

        <div class="step">
            <div class="step-number">3.</div>
            <div class="step-text">Jika Anda memilih "Kompeten", silakan unggah bukti pendukung (file atau deskripsi singkat).</div>
        </div>

        <div class="step">
            <div class="step-number">4.</div>
            <div class="step-text">Pastikan semua pertanyaan sudah diisi sebelum mengirimkan asesmen mandiri.</div>
        </div>
    </div>

    <!-- Tombol -->
    <div class="button-box">
        <a href="{{ route('asesmencss') }}" class="btn-next" id="btnNext">Selanjutnya</a>
    </div>
</div>
@endsection

@section('css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Poppins:wght@400;600;700&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: #fff;
    margin: 0;
    padding: 20px;
    color: #333;
}

/* Container */
.container {
    max-width: 600px;
    margin: auto;
}

/* Breadcrumb */
.breadcrumb {
    font-size: 14px;
    color: #666;
    margin-bottom: 20px;
}

/* Logo */
.logo-box {
    text-align: center;
    margin-bottom: 20px;
}
.logo {
    width: 50px;
    height: 50px;
    background: #1d4ed8;
    border-radius: 8px;
    margin: auto;
}
.logo-box h2 {
    margin-top: 10px;
    font-size: 18px;
    font-weight: 600;
}

/* Form */
.form-wrapper {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 20px;
}
.form-box {
    margin-bottom: 20px;
}
.form-box label {
    display: block;
    margin-bottom: 6px;
    font-weight: 600;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    color: #334155;
}
.form-box input, .form-box select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    box-sizing: border-box;
}

/* Panduan */
.guide-header {
    background: #e6f0ff;
    border-radius: 8px;
    padding: 10px 16px;
    position: relative;
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}
.guide-header::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 6px;
    border-radius: 8px 0 0 8px;
    background: linear-gradient(180deg, #00b4ff, #001f73);
}
.guide-header h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #1e293b;
}
.guide-box {
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    background: #f9f9f9;
    margin-bottom: 20px;
}
.step {
    display: flex;
    align-items: center;
    margin-bottom: 16px;
}
.step-number {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: linear-gradient(180deg, #00b4ff, #004080);
    color: #fff;
    font-family: 'Poppins', sans-serif;
    font-weight: 700;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    flex-shrink: 0;
}
.step-text {
    flex: 1;
    font-size: 14px;
    color: #222;
}

/* Tombol */
.button-box {
    text-align: right;
}
.btn-next {
    background: #0a1f55;
    color: #fff;
    padding: 12px 25px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 500;
}
.btn-next:hover {
    background-color: #163ea3;
}

/* Error */
.input-error {
    border: 2px solid #e74c3c !important;
    background-color: #fdecea;
    animation: shake 0.3s ease-in-out;
}
.input-success {
    border: 2px solid #2ecc71 !important;
    background-color: #e9f9f0;
}
@keyframes shake {
    0% { transform: translateX(0); }
    25% { transform: translateX(-5px); }
    50% { transform: translateX(5px); }
    75% { transform: translateX(-5px); }
    100% { transform: translateX(0); }
}
.error-message {
    font-size: 0.9rem;
    color: #e74c3c;
    margin-top: 5px;
    display: none;
}
.error-message.show {
    display: block;
}
</style>
@endsection

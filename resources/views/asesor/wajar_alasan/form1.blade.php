<!-- resources/views/asesor/wajar_alasan/form1.blade.php -->
@extends('master')

@section('title', 'Form Asesmen - FR.AK.07')

@section('konten')
<style>
    .breadcrumb-custom {
        font-size: 14px;
        color: #aaa;
    }
    .breadcrumb-custom span {
        font-weight: 600;
        color: #000;
    }
    .card-custom {
        border: 1px solid #aaa;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 25px;
        background-color: #fff;
    }
    .btn-info-custom {
        background-color: #e9eefb;
        color: #000;
        border: none;
        border-radius: 12px;
        padding: 8px 20px;
        font-size: 14px;
        cursor: pointer;
    }
    .form-box {
        border: 1px solid #aaa;
        border-radius: 12px;
        padding: 18px;
        margin-bottom: 20px;
    }
    .form-box label {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 6px;
    }
    .form-box input {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 10px;
        width: 100%;
        font-size: 14px;
    }
    .btn-next {
        background-color: #041562;
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 12px;
        font-size: 15px;
        cursor: pointer;
    }
    .btn-next:hover {
        background-color: #07258a;
    }
    .btn-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    .icon-box {
        width: 40px;
        height: 40px;
        background-color: #041562;
        border-radius: 8px;
        margin: 0 auto 15px auto;
    }
</style>

<div class="container mt-4">
    <!-- Breadcrumb -->
    <div class="breadcrumb-custom mb-3">
        Form Asesor > <span>FR.AK.07</span>
    </div>

    <!-- Header -->
    <div class="card-custom text-center">
        <div class="icon-box"></div>
        <h2 class="fw-bold mb-3">Ceklis Penyesuaian Yang Wajar dan Beralasan</h2>
        <button class="btn-info-custom">Rincian Data Asesi</button>
    </div>

    <!-- Form -->
<div class="card-custom">
    <div class="form-box">
        <label for="judul">Judul / Skema</label>
        <input type="text" id="judul" value="Okupasi" readonly>
    </div>
    <div class="form-box">
        <label for="nomor">Nomor</label>
        <input type="text" id="nomor" value="012876345" readonly>
    </div>
    <div class="form-box">
        <label for="tuk">TUK</label>
        <input type="text" id="tuk" value="SMKN 11 BANDUNG" readonly>
    </div>
    <div class="form-box">
        <label for="assessor">Nama Assessor</label>
        <input type="text" id="assessor" value="Reno Suswanto" readonly>
    </div>
    <div class="form-box">
        <label for="asesi">Nama Asesi</label>
        <input type="text" id="asesi" value="Hafiz Fadhillah" readonly>
    </div>
    <div class="form-box">
        <label for="tanggal">Tanggal Asesmen</label>
        <input type="date" id="tanggal" value="2026-08-23">
    </div>
</div>

<!-- Tombol di luar kotak -->
<form action="{{ route('asesor.wajar_alasan.form2') }}" method="GET">
    <div class="btn-wrapper">
        <button type="submit" class="btn-next">Selanjutnya</button>
    </div>
</form>
@endsection

<!-- resources/views/asesi/wajar_alasan/form1.blade.php -->
@extends('master')

@section('title', 'Form Asesmen - FR.AK.07')

@section('konten')
<style>
    /* === Breadcrumb === */
    .breadcrumb-custom {
        font-size: 14px;
        color: #aaa;
    }
    .breadcrumb-custom span {
        font-weight: 600;
        color: #000;
    }

    /* === Card Utama === */
    .card-custom {
        border: 1px solid #aaa;
        border-radius: 12px;
        padding: 30px;
        margin-bottom: 25px;
        background-color: #fff;
    }

    /* === Button Info === */
    .btn-info-custom {
        background-color: #e9eefb;
        color: #000;
        border: none;
        border-radius: 12px;
        padding: 8px 20px;
        font-size: 14px;
        cursor: pointer;
    }

    /* === Box Form === */
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

    /* === Tombol Next === */
    .btn-next {
        background-color: #07258a;
        color: white;
        border: none;
        padding: 12px 28px;
        border-radius: 10px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: 0.3s ease;
    }
    .btn-next:hover {
        background-color: #041a5f;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    }
    .btn-wrapper {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
    }

    /* === Icon Box di Header === */
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
        Form Asesmen > <span>FR.AK.07</span>
    </div>

    <!-- Header Card -->
    <div class="card-custom text-center">
        <div class="icon-box"></div>
        <h2 class="fw-bold mb-3">Ceklis Penyesuaian Yang Wajar dan Beralasan</h2>
        <button class="btn-info-custom">Rincian Data Pemohon Sertifikasi</button>
    </div>

    <!-- Form Data Utama -->
    <div class="card-custom">

        <!-- Judul / Skema -->
        <div class="form-box">
            <label for="judul">Judul / Skema</label>
            <input type="text" id="judul" value="okupasi" readonly>
        </div>

        <!-- Nomor -->
        <div class="form-box">
            <label for="nomor">Nomor</label>
            <input type="text" id="nomor" value="012876345" readonly>
        </div>

        <!-- TUK -->
        <div class="form-box">
            <label for="tuk">TUK</label>
            <input type="text" id="tuk" value="SMKN 11 BANDUNG" readonly>
        </div>

        <!-- Nama Assessor -->
        <div class="form-box">
            <label for="assessor">Nama Assessor</label>
            <input type="text" id="assessor" value="Reno Suswanto" readonly>
        </div>

        <!-- Nama Asesi -->
        <div class="form-box">
            <label for="asesi">Nama Asesi</label>
            <input type="text" id="asesi" value="Hafiz Fadhillah" readonly>
        </div>

        <!-- Tanggal Asesmen -->
        <div class="form-box">
            <label for="tanggal">Tanggal Asesmen</label>
            <input type="date" id="tanggal" value="2026-08-23">
        </div>
    </div>

    <!-- Tombol Selanjutnya -->
    <form action="{{ route('asesi.wajar_alasan.form2') }}" method="GET">
        <div class="btn-wrapper">
            <button type="submit" class="btn-next">Selanjutnya</button>
        </div>
    </form>

</div>
@endsection

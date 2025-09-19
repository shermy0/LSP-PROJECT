@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05aAsesi.css') }}">

<div class="form-asesmen-header">
    <p class="breadcrumb">Form Asesmen ></p>
    <div class="icon-box"></div>
    <h1 class="main-title">FR.IA.07 - Lembar Pertanyaan Pilihan Ganda</h1>
    <p class="sub-title">Skema Sertifikasi Kompetensi</p>
    <div class="skema-box">
        <span class="skema-text">JUNIOR OPERATOR DESAIN GRAFIS</span>
    </div>
    <p class="kode-asesor">085102432440</p>
</div>

{{-- ================= FORM BIODATA ================= --}}
<div class="section-box">
    <div class="form-group">
        <label for="no_form">No.Form</label>
        <input type="text" class="form-control" name="no_form" placeholder="Nomor form">
    </div>

    <div class="form-group">
        <label for="nama_asesor">Nama Asesor</label>
        <input type="text" class="form-control" name="nama_asesor" placeholder="Masukkan nama asesor">
    </div>

    <div class="form-group">
        <label for="nama_asesi">Nama Asesi</label>
        <input type="text" class="form-control" name="nama_asesi" placeholder="Masukkan nama asesi">
    </div>

    <div class="form-group">
        <label for="tanggal_asesmen">Tanggal Asesmen</label>
        <input type="date" class="form-control" name="tanggal_asesmen">
    </div>

    <div class="form-group">
        <label for="tuk">TUK (Tempat Uji Kompetensi)</label>
        <input type="text" class="form-control" name="tuk" value="SMKN 11 Bandung">
    </div>
</div>

{{-- ================= BAGIAN PERTANYAAN ================= --}}
<div class="section-box">
<div class="header">
    <div class="header-strip"></div>
    <h2 class="header-title">Pertanyaan Asesmen</h2>
</div>

    <form action="{{ route('fria05aAsesi.store') }}" method="POST">
        @csrf

        {{-- 1. Pertanyaan --}}
        <div class="pertanyaan-box">
            <p><strong>1. Pertanyaan</strong></p>
            <p class="teks-pertanyaan">Ibu kota negara Indonesia adalah …</p>
            <div class="pilihan-jawaban">
                <label><input type="radio" name="jawaban[1]" value="a"> a. Surabaya</label>
                <label><input type="radio" name="jawaban[1]" value="b"> b. Bandung</label>
                <label><input type="radio" name="jawaban[1]" value="c"> c. Jakarta</label>
                <label><input type="radio" name="jawaban[1]" value="d"> d. Medan</label>
                <label><input type="radio" name="jawaban[1]" value="d"> e. Maleber</label>
            </div>
        </div>

        {{-- 2. Pertanyaan --}}
        <div class="pertanyaan-box">
            <p><strong>2. Pertanyaan</strong></p>
            <p class="teks-pertanyaan">Warna primer yang termasuk di bawah ini adalah …</p>
            <div class="pilihan-jawaban">
                <label><input type="radio" name="jawaban[2]" value="a"> a. Hijau</label>
                <label><input type="radio" name="jawaban[2]" value="b"> b. Ungu</label>
                <label><input type="radio" name="jawaban[2]" value="c"> c. Merah</label>
                <label><input type="radio" name="jawaban[2]" value="d"> d. Pink</label>
                <label><input type="radio" name="jawaban[2]" value="d"> e. Hitam</label>
            </div>
        </div>

        {{-- 3. Pertanyaan --}}
        <div class="pertanyaan-box">
            <p><strong>3. Pertanyaan</strong></p>
            <p class="teks-pertanyaan">Hewan yang termasuk jenis mamalia adalah …</p>
            <div class="pilihan-jawaban">
                <label><input type="radio" name="jawaban[3]" value="a"> a. Ayam</label>
                <label><input type="radio" name="jawaban[3]" value="b"> b. Kucing</label>
                <label><input type="radio" name="jawaban[3]" value="c"> c. Ikan</label>
                <label><input type="radio" name="jawaban[3]" value="d"> d. Katak</label>
                <label><input type="radio" name="jawaban[3]" value="d"> e. Kuda</label>
            </div>
        </div>
    </form>
</div>
    <div class="container">
    <a href="{{ url('fria05c') }}" class="btn-submit">Simpan</a>
    </div>
</div>
@endsection

@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/pgia07.css') }}">

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

<div class="content-card">
<div class="header">
    <div class="header-strip"></div>
    <h2 class="header-title">Panduan Bagi Asesor</h2>
</div>
        <div class="panduan-item">
            <span class="circle">1</span>
            <p>Buatlah pertanyaan esai yang dapat mencakupi penguatan informasi berdasarkan KUK, batasan variabel, pengetahuan dan ketrampilan esensial, sikap dan aspek kritis.</p>
        </div>
        <div class="panduan-item">
            <span class="circle">2</span>
            <p>Perkiraan jawaban dapat di isikan pada baris kunci jawaban.</p>
        </div>
        <div class="panduan-item">
            <span class="circle">3</span>
            <p>Dibutuhkan jastifikasi profesional asesor untuk memutuskan hal ini.</p>
        </div>
</div>

<div class="btn-container">
    <button class="btn-primary" id="openModalBtn">Masukan Pertanyaan</button>
</div>

<!-- Modal -->
<div id="modal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <div class="modal-content" style="background:#fff;padding:20px;border-radius:10px;max-width:400px;width:90%;position:relative;">
        <span class="close" style="position:absolute;top:10px;right:15px;font-size:20px;cursor:pointer;">&times;</span>
        <h3>Ketik Jumlah Pertanyaan:</h3>
        <p class="note" style="color:#888;font-size:14px;">note: maksimal 10 pertanyaan!</p>
        <input type="number" id="jumlahPertanyaan" min="1" max="10" value="1" style="width:100%;padding:8px;margin:10px 0;">
        <button class="btn-primary" id="simpanBtn" style="width:100%;">Simpan</button>
    </div>
</div>

<!-- Modal Jumlah Pertanyaan -->
<div id="modal" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <div class="modal-content" style="background:#fff;padding:20px;border-radius:10px;max-width:400px;width:90%;position:relative;">
        <span class="close" style="position:absolute;top:10px;right:15px;font-size:20px;cursor:pointer;">&times;</span>
        <h3>Ketik Jumlah Pertanyaan:</h3>
        <p class="note" style="color:#888;font-size:14px;">note: maksimal 10 pertanyaan!</p>
        <input type="number" id="jumlahPertanyaan" min="1" max="10" value="1" style="width:100%;padding:8px;margin:10px 0;">
        <button class="btn-primary" id="simpanBtn" style="width:100%;">Simpan</button>
    </div>
</div>

<!-- Container untuk pertanyaan -->
<div id="daftarPertanyaan" style="margin-top: 30px;"></div>

<script>
    const modal = document.getElementById('modal');
    const openModalBtn = document.getElementById('openModalBtn');
    const closeBtn = document.querySelector('.close');

    // Buka modal
    openModalBtn.onclick = () => {
        modal.style.display = 'flex';
    };

    // Tutup modal
    closeBtn.onclick = () => {
        modal.style.display = 'none';
    };

    // Tutup modal jika klik di luar
    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    // Redirect ke halaman kedua dengan jumlah pertanyaan
document.getElementById('simpanBtn').onclick = () => {
    const jumlah = parseInt(document.getElementById('jumlahPertanyaan').value);
    window.location.href = "/fria05a?jumlah=" + jumlah; 
};

</script>

@endsection

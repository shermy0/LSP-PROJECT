@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05bAdmin.css') }}">

<div class="form-asesmen-header">
    <h1 class="main-title">FR.IA.05B - Lembar Kunci Jawaban Pilihan Ganda</h1>
    <p class="sub-title">Kunci Jawaban untuk Tes Tertulis Pilihan Ganda</p>
    <div class="skema-box">
        <span class="skema-text">ANSWER KEY FORM</span>
    </div>
</div>

{{-- ================= FORM BIODATA ================= --}}
<div class="section-box">
    <div class="form-row">
        <div class="form-group">
            <label for="judul_skema">Judul Skema Sertifikasi</label>
            <input type="text" class="form-control" name="judul_skema" placeholder="Masukkan judul">
        </div>

        <div class="form-group">
            <label for="no_form">No.Form</label>
            <input type="text" class="form-control" name="no_form" placeholder="Masukkan nomor form">
        </div>
    </div>

    <div class="form-group">
        <label for="tuk">TUK (Tempat Uji Kompetensi)</label>
        <input type="text" class="form-control" name="tuk" value="SMKN 11 Bandung">
    </div>
</div>

{{-- ================= KUNCI JAWABAN ================= --}}
<div class="section-box">
    <div class="header">
        <div class="header-strip"></div>
        <h2 class="header-title">Kunci Jawaban Pertanyaan Tertulis – Pilihan Ganda</h2>
    </div>

    <table class="table-jawaban">
        <thead>
            <tr>
                <th>No.</th>
                <th>Kunci Jawaban</th>
            </tr>
        </thead>
        <tbody id="jawabanTableBody">
            <!-- isi otomatis JS -->
        </tbody>
    </table>
</div>

{{-- ================= PENYUSUN & VALIDATOR ================= --}}
<div class="section-box">
    <div class="header">
        <div class="header-strip"></div>
        <h2 class="header-title">Penyusun dan Validator</h2>
    </div>

    <table class="table-penyusun">
        <thead>
            <tr>
                <th>STATUS</th>
                <th>No.</th>
                <th>NAMA</th>
                <th>NOMOR MET</th>
                <th>TANDA TANGAN DAN TANGGAL</th>
            </tr>
        </thead>
        <tbody id="penyusunTableBody">
            <!-- nanti isi otomatis JS -->
        </tbody>
    </table>
</div>

{{-- ================= ACTION BUTTON ================= --}}
<div class="button-group">
    <form action="{{ route('unduh.fria05b') }}" method="POST" id="downloadForm">
    @csrf
    <input type="hidden" name="jawaban" id="jawaban-input">
    <input type="hidden" name="penyusun" id="penyusun-input">
    <button type="button" id="btn-download" class="btn-unduh">Unduh</button>
</form>
    <button type="button" class="btn-submit">Simpan Form</button>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    // ambil data jawaban dari localStorage atau default 10 soal
    let jawabanData = JSON.parse(localStorage.getItem("jawaban")) 
        || Array.from({length:10}, (_,i)=>({jawaban:"A/B/C/D"}));

    let tbody = document.getElementById("jawabanTableBody");
    tbody.innerHTML = "";

    jawabanData.forEach((item, i) => {
        let tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${i+1}</td>
            <td>${item.jawaban}</td>
        `;
        tbody.appendChild(tr);
    });

    // ambil data penyusun dari localStorage atau contoh default
    let penyusunData = JSON.parse(localStorage.getItem("penyusun")) || [
        { status:"PENYUSUN", nama:"Mohamad Ismail", nomor:"MET.000.011727 2016", ttd:"-" },
        { status:"PENYUSUN", nama:"Zimzim Al Amin Syahidi", nomor:"MET.000.011730 2016", ttd:"-" },
        { status:"VALIDATOR", nama:"Nama Validator 1", nomor:"-", ttd:"-" },
        { status:"VALIDATOR", nama:"Nama Validator 2", nomor:"-", ttd:"-" }
    ];

    let penyusunTbody = document.getElementById("penyusunTableBody");
    penyusunTbody.innerHTML = "";

    penyusunData.forEach((item, i) => {
        let tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${item.status}</td>
            <td>${i+1}</td>
            <td>${item.nama}</td>
            <td>${item.nomor}</td>
            <td>${item.ttd}</td>
        `;
        penyusunTbody.appendChild(tr);
    });

    // tombol unduh
    document.getElementById('btn-download').addEventListener('click', () => {
        document.getElementById('jawaban-input').value = JSON.stringify(jawabanData);
        document.getElementById('penyusun-input').value = JSON.stringify(penyusunData);
        document.getElementById('downloadForm').submit();
    });

    // tombol simpan
    document.querySelector('.btn-submit').addEventListener('click', () => {
        localStorage.setItem("jawaban", JSON.stringify(jawabanData));
        localStorage.setItem("penyusun", JSON.stringify(penyusunData));
        alert("Form berhasil disimpan (simulasi)!");
    });
});
</script>
@endsection

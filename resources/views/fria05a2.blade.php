@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05a2.css') }}">

<div class="form-asesmen-header">
    <p class="breadcrumb">Form Daftar Pertanyaan ></p>
    <div class="icon-box"></div>
    <h1 class="main-title">FR.IA.05A - Pertanyaan Tertulis Pilihan Ganda</h1>
    <p class="sub-title">Kegiatan Terstruktur Lainnya</p>
</div>

<div class="header">
    <div class="header-strip"></div>
    <h2 class="header-title">Daftar Pertanyaan Pilihan Ganda</h2>
</div>

<!-- ✅ Rekap Soal -->
<div id="rekapSoal" class="rekap-soal"></div>

<div class="header">
    <div class="header-strip"></div>
    <h2 class="header-title">Tanda Tangan & Persetujuan</h2>
</div>

<div class="container">
    <a href="{{ url('tambahasesor') }}" class="btn-tambah-asesor">+ Tambah Asesor</a>
</div>

<!-- ✅ Tabel penyusun -->
<div class="table-wrapper">
    <div class="header">
        <div class="header-strip"></div>
        <h2 class="header-title">Penyusun</h2>
    </div>

    <table class="table-penyusun">
        <thead>
            <tr>
                <th>STATUS</th>
                <th>No.</th>
                <th>NAMA</th>
                <th>NOMOR MET</th>
                <th>TANDA TANGAN</th>
            </tr>
        </thead>
        <tbody id="penyusunTableBody">
            <!-- nanti isi otomatis dari JS -->
        </tbody>
    </table>
</div>

<button class="btn-save">Simpan</button>

<script>
// Ambil soal dari localStorage
const rekapContainer = document.getElementById('rekapSoal');
const soalData = JSON.parse(localStorage.getItem('soalPilihanGanda')) || [];

// ✅ Loop langsung array
soalData.forEach((soal, index) => {
    const kunci = soal.kunci ? soal.kunci : '[Belum diisi]';

    const card = document.createElement('div');
    card.classList.add('card-rekap');

    card.innerHTML = `
        <div class="rekap-nomor">${index+1}</div>
        <div class="rekap-pertanyaan">
            ${soal.pertanyaan || ''}
            ${soal.gambarPertanyaan ? `<br><img src="${soal.gambarPertanyaan}" style="max-height:120px;">` : ""}
        </div>
        <div class="rekap-kunci">
            Kunci Jawaban: <span style="color:blue; font-weight:bold;">
                ${kunci}. ${soal.jawaban?.[kunci] || ""}
                ${soal.gambarJawaban?.[kunci] ? `<br><img src="${soal.gambarJawaban[kunci]}" style="max-height:70px;">` : ""}
            </span>
        </div>
    `;

    rekapContainer.appendChild(card);
});

// ====== Render tabel penyusun ======
document.addEventListener("DOMContentLoaded", () => {
    let penyusunData = JSON.parse(localStorage.getItem("penyusun")) || [];
    let tbody = document.getElementById("penyusunTableBody");
    tbody.innerHTML = "";

    penyusunData.forEach((p, i) => {
        let tr = document.createElement("tr");
        tr.innerHTML = `
            <td>Penyusun</td>   <!-- status selalu otomatis "Penyusun" -->
            <td>${i + 1}</td>
            <td>${p.nama || "-"}</td>
            <td>${p.met || "-"}</td>
            <td>
                ${p.ttd ? `<img src="${p.ttd}" alt="TTD" style="max-height:80px;">` : "-"}
            </td>
        `;
        tbody.appendChild(tr);
    });
});



</script>
@endsection

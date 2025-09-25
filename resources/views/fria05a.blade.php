@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05a.css') }}">

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

<form id="form-pertanyaan" enctype="multipart/form-data">
    <div id="daftarPertanyaan" class="daftar-pertanyaan"></div>

    <div class="btn-container">
        <button type="button" class="btn-primary" id="openModalBtn">Simpan</button>
    </div>
</form>

<!-- Popup Konfirmasi -->
<div id="popup" class="popup-modal" style="display:none;">
    <div class="popup-content">
        <p>Pertanyaan berhasil disimpan!</p>
        <div class="popup-buttons">
            <button type="button" onclick="tambahSoal()" class="btn-tambah-soal">Tambah Soal</button>
            <button type="button" onclick="lanjut()" class="btn-lanjut">Lanjut</button>
        </div>
    </div>
</div>


<!-- Modal Tambah Soal -->
<div id="modalJumlah" class="modal" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;
background:rgba(0,0,0,0.5);justify-content:center;align-items:center;">
    <div class="modal-content" style="background:#fff;padding:20px;border-radius:10px;max-width:400px;width:90%;">
        <span class="closeJumlah">&times;</span>
        <h3>Ketik Jumlah Pertanyaan:</h3>
        <p class="note">note: maksimal 10 pertanyaan!</p>
        <input type="number" id="jumlahPertanyaanBaru" min="1" max="10" value="1">
        <button class="btn-primary" id="simpanJumlah">Simpan</button>
    </div>
</div>

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


<script>
let nomorSekarang = 0;

// ===== Fungsi buat pertanyaan =====
function buatPertanyaan(jumlah) {
    const container = document.getElementById('daftarPertanyaan');
    for (let i = 1; i <= jumlah; i++) {
        nomorSekarang++;
        const card = document.createElement('div');
        card.classList.add('card-pertanyaan');

        card.innerHTML = `
            <div class="nomor">Pertanyaan ${nomorSekarang}</div>
            <input type="text" placeholder="Ketik pertanyaan di sini"
                   name="pertanyaan_${nomorSekarang}" class="input-pertanyaan">

            <div class="upload-gambar">
                <label>Choose File:</label><br>
                <input type="file" name="gambar_${nomorSekarang}" accept="image/*">
            </div>

            <div class="opsi-jawaban">
                ${['A','B','C','D','E'].map(opt=>`
                    <div class="opsi-item">
                        <label>${opt}. </label>
                        <input type="text" placeholder="Ketik jawaban ${opt}"
                               name="jawaban_${nomorSekarang}_${opt}" class="input-jawaban">
                        <input type="file"
                               name="gambar_jawaban_${nomorSekarang}_${opt}"
                               accept="image/*" class="input-gambar-jawaban">
                    </div>
                `).join('')}
            </div>

            <div class="kunci-jawaban">
                Pilih kunci jawaban:
                ${['A','B','C','D','E'].map(opt=>`
                    <label>
                        <input type="radio" name="kunci_${nomorSekarang}" value="${opt}"> ${opt}
                    </label>
                `).join('')}
            </div>
        `;
        container.appendChild(card);
    }
}

// ===== Helper ambil query param =====
function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

// ===== LOGIC =====
const popup = document.getElementById("popup");
const modalJumlah = document.getElementById("modalJumlah");
const simpanBtn = document.getElementById("openModalBtn");

// ✅ Simpan → ambil data → simpan ke localStorage → tampilkan popup
simpanBtn.addEventListener("click", () => {
    const formData = [];

    document.querySelectorAll('.card-pertanyaan').forEach((card, index) => {
        const pertanyaan = card.querySelector('.input-pertanyaan').value;

        const jawaban = {};
        ['A','B','C','D','E'].forEach(opt => {
            const inputJawaban = card.querySelector(`input[name="jawaban_${index+1}_${opt}"]`);
            jawaban[opt] = inputJawaban ? inputJawaban.value : '';
        });

        const kunciInput = card.querySelector(`input[name="kunci_${index+1}"]:checked`);
        const kunci = kunciInput ? kunciInput.value : '';

        formData.push({
            pertanyaan,
            jawaban,
            kunci
        });
    });

    localStorage.setItem('soalPilihanGanda', JSON.stringify(formData));
    popup.style.display = "flex";
});

// Lanjut
function lanjut() {
    window.location.href = "/fria05a1";
}

// Tambah Soal → buka modal jumlah
function tambahSoal() {
    popup.style.display = "none";
    modalJumlah.style.display = "flex";
}

// Simpan jumlah soal baru
document.getElementById("simpanJumlah").onclick = () => {
    const jumlahBaru = parseInt(document.getElementById("jumlahPertanyaanBaru").value);
    if (jumlahBaru > 0 && jumlahBaru <= 10) {
        buatPertanyaan(jumlahBaru);
    } else {
        alert("Jumlah pertanyaan harus 1 - 10");
    }
    modalJumlah.style.display = "none";
};

// Tutup modal jumlah
document.querySelector(".closeJumlah").onclick = () => {
    modalJumlah.style.display = "none";
};
window.onclick = (e) => {
    if (e.target === popup) popup.style.display = "none";
    if (e.target === modalJumlah) modalJumlah.style.display = "none";
};

// Tambah pertanyaan sesuai query "jumlah"
window.onload = () => {
    const jumlahAwal = parseInt(getQueryParam("jumlah")) || 1;
    buatPertanyaan(jumlahAwal);
};

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

@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05a1.css') }}">

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

<!-- Modal Konfirmasi Simpan -->
<div id="popup" class="popup-modal" style="display:none;">
    <div class="popup-content">
        <p>Apakah Anda yakin ingin menyimpan semua pertanyaan?</p>
        <div class="popup-buttons">
            <button type="button" onclick="batalSimpan()" class="btn-kembali">Kembali</button>
            <button type="button" onclick="konfirmasiSimpan()" class="btn-simpan">Simpan</button>
        </div>
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
        <tbody id="penyusunTableBody"></tbody>
    </table>
</div>

<script>
let savedSoal = JSON.parse(localStorage.getItem('soalPilihanGanda')) || []; // ⬅️ GLOBAL

document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById('daftarPertanyaan');
    const soalArray = Array.isArray(savedSoal) ? savedSoal : Object.values(savedSoal);

    // ✅ Render pertanyaan
    container.innerHTML = "";
    soalArray.forEach((item, index) => {
        const card = document.createElement('div');
        card.classList.add('card-pertanyaan');

        card.innerHTML = `
            <div class="nomor">Pertanyaan ${index+1}</div>
            <input type="text" value="${item.pertanyaan || ''}" 
                   name="pertanyaan_${index+1}" class="input-pertanyaan">

            ${item.gambarPertanyaan 
                ? `<div class="preview-gambar"><img src="${item.gambarPertanyaan}" style="max-height:100px;"></div>` 
                : ""}

            <div class="upload-gambar">
                <label>Upload Gambar Pertanyaan:</label><br>
                <input type="file" name="gambar_${index+1}" accept="image/*">
            </div>

            <div class="opsi-jawaban">
                ${['A','B','C','D','E'].map(opt=>`
                    <div class="opsi-item">
                        <label>${opt}. </label>
                        <input type="text" value="${item.jawaban?.[opt] || ''}" 
                               name="jawaban_${index+1}_${opt}" class="input-jawaban">

                        ${item.gambarJawaban?.[opt] 
                            ? `<img src="${item.gambarJawaban[opt]}" style="max-height:80px;">` 
                            : ""}

                        <input type="file" name="gambar_jawaban_${index+1}_${opt}" accept="image/*" class="input-gambar-jawaban">
                    </div>
                `).join('')}
            </div>

            <div class="kunci-jawaban">
                Pilih kunci jawaban:
                ${['A','B','C','D','E'].map(opt=>`
                    <label>
                        <input type="radio" name="kunci_${index+1}" value="${opt}" ${item.kunci === opt ? 'checked' : ''}> ${opt}
                    </label>
                `).join('')}
            </div>

            <div class="action-buttons">
                <button type="button" class="btn-edit" onclick="editSoal(this)">Edit</button>
                <button type="button" class="btn-delete" onclick="hapusSoal(this)">Delete</button>
            </div>
        `;
        container.appendChild(card);
    });

    // ✅ Render penyusun
    let penyusunData = JSON.parse(localStorage.getItem("penyusun")) || [];
    let tbody = document.getElementById("penyusunTableBody");
    tbody.innerHTML = "";
    penyusunData.forEach((p, i) => {
        let tr = document.createElement("tr");
        tr.innerHTML = `
            <td>Penyusun</td>
            <td>${i + 1}</td>
            <td>${p.nama || "-"}</td>
            <td>${p.met || "-"}</td>
            <td>${p.ttd ? `<img src="${p.ttd}" alt="TTD" style="max-height:80px;">` : "-"}</td>
        `;
        tbody.appendChild(tr);
    });
});

// ===== Tombol Simpan =====
document.getElementById('openModalBtn').addEventListener('click', function () {
    document.getElementById('popup').style.display = 'flex';
});

function batalSimpan() {
    document.getElementById('popup').style.display = 'none';
}

// ===== Konfirmasi Simpan =====
function konfirmasiSimpan() {
    const soalCards = document.querySelectorAll('.card-pertanyaan');
    const formData = [];
    const promises = [];

    soalCards.forEach((card, index) => {
        const oldData = savedSoal[index] || {}; // ✅ sekarang bisa diakses

        const soalObj = {
            pertanyaan: card.querySelector('.input-pertanyaan').value,
            gambarPertanyaan: oldData.gambarPertanyaan || "",
            jawaban: oldData.jawaban || {},
            gambarJawaban: oldData.gambarJawaban || {},
            kunci: ""
        };

        // === Pertanyaan Gambar ===
        const gambarPertanyaanInput = card.querySelector(`input[name="gambar_${index+1}"]`);
        if (gambarPertanyaanInput && gambarPertanyaanInput.files.length > 0) {
            promises.push(new Promise(resolve => {
                const reader = new FileReader();
                reader.onload = () => {
                    soalObj.gambarPertanyaan = reader.result; // gambar baru
                    resolve();
                };
                reader.readAsDataURL(gambarPertanyaanInput.files[0]);
            }));
        } else {
            soalObj.gambarPertanyaan = oldData.gambarPertanyaan || ""; // tetap pakai gambar lama
        }

        // === Jawaban & Gambar Jawaban ===
        ['A','B','C','D','E'].forEach(opt => {
            const inputJawaban = card.querySelector(`input[name="jawaban_${index+1}_${opt}"]`);
            soalObj.jawaban[opt] = inputJawaban ? inputJawaban.value : (oldData.jawaban?.[opt] || '');

            const inputGambar = card.querySelector(`input[name="gambar_jawaban_${index+1}_${opt}"]`);
            if (inputGambar && inputGambar.files.length > 0) {
                promises.push(new Promise(resolve => {
                    const reader = new FileReader();
                    reader.onload = () => {
                        soalObj.gambarJawaban[opt] = reader.result; // gambar baru
                        resolve();
                    };
                    reader.readAsDataURL(inputGambar.files[0]);
                }));
            } else {
                soalObj.gambarJawaban[opt] = oldData.gambarJawaban?.[opt] || ""; // tetap pakai gambar lama
            }
        });

        // === Kunci Jawaban ===
        const kunciInput = card.querySelector(`input[name="kunci_${index+1}"]:checked`);
        soalObj.kunci = kunciInput ? kunciInput.value : (oldData.kunci || '');

        formData.push(soalObj);
    });

    Promise.all(promises).then(() => {
        localStorage.setItem('soalPilihanGanda', JSON.stringify(formData));
        document.getElementById('popup').style.display = 'none';
        window.location.href = '/fria05a2';
    });
}

// ===== Edit & Hapus =====
function hapusSoal(button) {
    if(confirm("Apakah Anda yakin ingin menghapus soal ini?")) {
        button.closest('.card-pertanyaan').remove();
    }
}

function editSoal(button) {
    const card = button.closest('.card-pertanyaan');
    const inputs = card.querySelectorAll('input[type="text"]');
    inputs.forEach(input => {
        input.removeAttribute('readonly');
        input.style.border = '2px solid #0284C7';
    });
}
</script>

@endsection

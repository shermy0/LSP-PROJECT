@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/tambahasesor.css') }}">

<div class="header">
    <div class="header-strip"></div>
    <h2 class="header-title">Penyusun</h2>
</div>

<!-- Input jumlah penyusun -->
<div class="jumlah-card">
    <label for="jumlahPenyusun" class="jumlah-label">Ketik Jumlah Asesor :</label>
    <input type="number" id="jumlahPenyusun" min="1" max="10" value="1" class="jumlah-input">
    <button id="generateBtn" class="btn-simpan">
        <i class="fas fa-plus"></i>
    </button>
</div>

<!-- Container untuk form asesor -->
<div id="ttdContainer" class="penyusun-container"></div>

<button class="btn-save"><i class="fas fa-save"></i> Simpan</button>

<!-- ✅ Library tanda tangan -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
    const generateBtn = document.getElementById('generateBtn');
    const ttdContainer = document.getElementById('ttdContainer');
    const globalSaveBtn = document.querySelector('.btn-save');

    let penyusunData = JSON.parse(localStorage.getItem('penyusun')) || [];

    function syncInputsToData() {
        const cards = ttdContainer.querySelectorAll('.penyusun-card');
        cards.forEach((card, i) => {
            if (!penyusunData[i]) return;
            penyusunData[i].nama = card.querySelector('.nama-input').value;
            penyusunData[i].met  = card.querySelector('.met-input').value;
        });
    }

    function renderCards() {
        ttdContainer.innerHTML = '';
        penyusunData.forEach((p, i) => {
            const div = document.createElement('div');
            div.classList.add('penyusun-card');

            let ttdHTML = '';
            if (p.ttd) {
                // kalau sudah ada tanda tangan → tampilkan gambar + tombol refresh
                ttdHTML = `
                    <img src="${p.ttd}" alt="TTD" style="max-width:400px;max-height:200px;display:block;border:1px solid #000;">
                    <div style="margin-top:5px;">
                        <button type="button" onclick="editTTD(${i})"><i class="fas fa-sync"></i></button>
                    </div>
                `;
            } else {
                // kalau belum ada → canvas untuk tanda tangan
                ttdHTML = `
                    <canvas id="signature-pad-${i}" width="400" height="200" style="border:1px solid #000;"></canvas>
                    <div style="margin-top:5px;">
                        <button type="button" onclick="clearTTD(${i})"><i class="fas fa-eraser"></i></button>
                        <button type="button" onclick="saveTTD(${i})"><i class="fas fa-save"></i></button>
                    </div>
                `;
            }

            div.innerHTML = `
                <div class="penyusun-header">Penyusun ${i + 1}</div>
                <div class="penyusun-body">
                    <div class="penyusun-left">
                        <label>Nama Asesor</label>
                        <input type="text" value="${p.nama || ''}" class="form-input nama-input" ${p.editing ? '' : 'readonly'}>

                        <label>Nomor MET</label>
                        <input type="text" value="${p.met || ''}" class="form-input met-input" ${p.editing ? '' : 'readonly'}>
                    </div>
                    <div class="penyusun-right">
                        <label>Tanda Tangan</label>
                        ${ttdHTML}
                    </div>
                </div>
                <div style="text-align:right; padding:10px;">
                    <button class="edit-btn">${p.editing ? 'Batal' : 'Edit'}</button>
                    <button class="delete-btn">Delete</button>
                </div>
            `;

            // tombol Edit (hanya untuk nama & met)
            div.querySelector('.edit-btn').onclick = () => {
                if (p.editing) {
                    penyusunData[i].nama = div.querySelector('.nama-input').value;
                    penyusunData[i].met  = div.querySelector('.met-input').value;
                    delete penyusunData[i].editing;
                } else {
                    penyusunData[i].editing = true;
                }
                renderCards();
            };

            // tombol Delete
            div.querySelector('.delete-btn').onclick = () => {
                penyusunData.splice(i, 1);
                localStorage.setItem('penyusun', JSON.stringify(penyusunData));
                renderCards();
            };

            ttdContainer.appendChild(div);

            // inisialisasi SignaturePad kalau sedang edit TTD (p.ttd kosong)
            if (!p.ttd) {
                const canvas = div.querySelector(`#signature-pad-${i}`);
                if (canvas) {
                    penyusunData[i].sigPad = new SignaturePad(canvas);
                }
            }
        });
    }

    function clearTTD(i) {
        if (penyusunData[i].sigPad) {
            penyusunData[i].sigPad.clear();
        }
    }

    function saveTTD(i) {
        const card = ttdContainer.querySelectorAll('.penyusun-card')[i];
        penyusunData[i].nama = card.querySelector('.nama-input').value;
        penyusunData[i].met  = card.querySelector('.met-input').value;

        if (penyusunData[i].sigPad && !penyusunData[i].sigPad.isEmpty()) {
            penyusunData[i].ttd = penyusunData[i].sigPad.toDataURL();
        }

        delete penyusunData[i].editing;
        localStorage.setItem('penyusun', JSON.stringify(penyusunData));
        renderCards();
    }

    // tombol refresh untuk ubah ttd jadi canvas
    function editTTD(i) {
        penyusunData[i].ttd = null;
        penyusunData[i].editing = true;
        renderCards();
    }

    // tambah asesor
    generateBtn.onclick = () => {
        const jumlah = parseInt(document.getElementById('jumlahPenyusun').value);
        if (isNaN(jumlah) || jumlah < 1) return;

        syncInputsToData();

        while (penyusunData.length < jumlah) {
            penyusunData.push({ nama: '', met: '', editing: true });
        }
        if (penyusunData.length > jumlah) {
            penyusunData = penyusunData.slice(0, jumlah);
        }

        renderCards();
    };

globalSaveBtn.onclick = () => {
    syncInputsToData();
    localStorage.setItem('penyusun', JSON.stringify(penyusunData));
    window.location.href = "{{ url('fria05a2') }}"; // ✅ redirect ke fria05a2
};

    if (penyusunData.length > 0) {
        renderCards();
    }
</script>
@endsection

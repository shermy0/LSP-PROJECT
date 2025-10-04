@extends('master')

@section('konten')
<div class="container mt-4">
    <h1 class="fw-bold mb-4 text-dark">Form Ceklis Observasi</h1>

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Pesan error --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Validasi error --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formObservasi" action="{{ route('ceklisobservasi.store') }}" method="POST" class="card shadow-sm p-4">
        @csrf

        {{-- Hidden input --}}
        <input type="hidden" name="id_skema" value="{{ request('id_skema') }}">
        <input type="hidden" name="id_asesi" value="{{ request('id_asesi') }}">
        <input type="hidden" name="ttd_asesor" id="ttd_asesor">

        {{-- Informasi Asesi --}}
        <div class="mb-4">
            <label class="form-label fw-semibold">Nama Asesi</label>
            <input type="text" class="form-control" 
                value="{{ $asesi->where('id_asesi', request('id_asesi'))->first()->nama_lengkap ?? 'Tidak ditemukan' }}" 
                readonly>
        </div>

        {{-- Nama Skema --}}
        <h3 class="fw-semibold mb-4 text-primary" id="nama-skema">Skema: -</h3>

        {{-- Container dinamis --}}
        <div id="kuk-container" class="text-center text-muted">
            Memuat daftar Kriteria Unjuk Kerja...
        </div>

        {{-- Umpan Balik --}}
        <div class="mb-4 mt-4">
            <label for="umpan_balik" class="form-label fw-semibold">Umpan Balik</label>
            <textarea name="umpan_balik" id="umpan_balik" class="form-control"></textarea>
        </div>

        {{-- Rekomendasi --}}
        <div class="mb-4">
            <label for="rekomendasi" class="form-label fw-semibold">Rekomendasi</label>
            <select name="rekomendasi" id="rekomendasi" class="form-select" required>
                <option value="">-- pilih rekomendasi --</option>
                <option value="Kompeten">Kompeten</option>
                <option value="Belum Kompeten">Belum Kompeten</option>
            </select>
        </div>

        {{-- Rincian rekomendasi --}}
        <div class="mb-4">
            <label for="rekomendasi_rincian" class="form-label fw-semibold">Rincian Rekomendasi (Opsional)</label>
            <textarea name="rekomendasi_rincian" id="rekomendasi_rincian" class="form-control"></textarea>
        </div>

        {{-- Tanda Tangan Asesor --}}
        <div class="mb-4 mt-4">
            <label class="form-label fw-semibold">Tanda Tangan Asesor</label>
            <div class="border p-2 rounded bg-light text-center">
                <canvas id="signature-pad" width="400" height="200" style="border:1px solid #ccc; border-radius:4px; cursor:crosshair;"></canvas>
            </div>
            <button type="button" class="btn btn-sm btn-warning mt-2" id="clear-signature">Hapus Tanda Tangan</button>
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-primary btn-lg mt-4 w-100">Simpan Penilaian</button>
    </form>
</div>

{{-- ========== STYLE ========== --}}
<style>
    .header-group {
        background-color: #4C6EF5;
        color: #fff;
        padding: .75rem 1rem;
        font-weight: 600;
        border-radius: .25rem .25rem 0 0;
    }
    .header-unit {
        background-color: #E6F0FF;
        border-left: 5px solid #4C6EF5;
        padding: .75rem 1rem;
        font-weight: 600;
        margin-bottom: 1rem;
    }
</style>

{{-- ========== SCRIPT ========== --}}
<script>
/* -----------------------------
   1️⃣ LOAD DATA KUK
-------------------------------- */
function loadKuk(skemaId) {
    const container = document.getElementById('kuk-container');
    const namaSkemaEl = document.getElementById('nama-skema');
    container.innerHTML = '';
    namaSkemaEl.innerHTML = '';

    if (!skemaId) {
        container.innerHTML = '<p class="text-muted">Skema tidak ditemukan.</p>';
        return;
    }

    fetch(`/ceklisobservasi/data/${skemaId}`)
        .then(res => res.json())
        .then(data => {
            namaSkemaEl.innerHTML = "Skema: " + (data.skema_nama ?? 'Tidak tersedia');
            if (!data.kelompok || data.kelompok.length === 0) {
                container.innerHTML = '<p class="text-muted">Belum ada kelompok/unit untuk skema ini.</p>';
                return;
            }

            let html = '';
            data.kelompok.forEach((kel, kIndex) => {
                html += `
                <div class="card mb-4 shadow-sm">
                    <div class="header-group">Kelompok Pekerjaan ${kIndex + 1}: ${kel.nama_kelompok ?? '-'}</div>
                    <div class="card-body">`;

                (kel.unit_kompetensi ?? []).forEach(unit => {
                    html += `
                    <div class="header-unit mb-3">
                        ${unit.kode_unit ?? 'Kode Unit'} - ${unit.judul_unit ?? 'Judul Unit'}
                    </div>`;

                    (unit.elemen ?? []).forEach(ele => {
                        html += `
                        <h6 class="fw-bold mb-3">${ele.nomor_elemen ?? '0'}. ${ele.nama_elemen ?? '-'}</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>No.</th>
                                        <th>Kriteria Unjuk Kerja</th>
                                        <th>Standar Industri</th>
                                        <th>K</th>
                                        <th>BK</th>
                                        <th>Penilaian Lanjut</th>
                                    </tr>
                                </thead>
                                <tbody>`;

                        (ele.kuk ?? []).forEach((kuk, kukIndex) => {
                            const kukNo = `${ele.nomor_elemen || kIndex + 1}.${kukIndex + 1}`;
                            const kukId = kuk.id_kuk ?? 0;
                            html += `
                            <tr>
                                <td>${kukNo}</td>
                                <td>${kuk.deskripsi_kuk ?? '-'}</td>
                                <td>
                                    <select class="form-select form-select-sm" 
                                            name="kuk[${kukId}][standar_industri]" 
                                            onchange="toggleLainnya(this, ${kukId})">
                                        <option value="Modul Praktek" selected>Modul Praktek</option>
                                        <option value="SOP">SOP</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <input type="text" class="form-control form-control-sm mt-2 d-none" 
                                           name="kuk[${kukId}][standar_lainnya]" 
                                           placeholder="Tulis standar lainnya">
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="kuk[${kukId}][status]" value="Ya" required>
                                </td>
                                <td class="text-center">
                                    <input class="form-check-input" type="radio" name="kuk[${kukId}][status]" value="Tidak">
                                </td>
                                <td>
                                    <input type="text" name="kuk[${kukId}][catatan]" class="form-control form-control-sm" placeholder="Catatan Penilaian">
                                </td>
                            </tr>`;
                        });

                        html += `</tbody></table></div>`;
                    });
                });

                html += `</div></div>`;
            });

            container.innerHTML = html;
        })
        .catch(() => {
            container.innerHTML = '<p class="text-danger">Gagal memuat data.</p>';
        });
}

/* -----------------------------
   2️⃣ TOGGLE "LAINNYA"
-------------------------------- */
function toggleLainnya(selectEl, kukId) {
    const inputLainnya = selectEl.parentElement.querySelector('input[name="kuk[' + kukId + '][standar_lainnya]"]');
    if (selectEl.value === "Lainnya") {
        inputLainnya.classList.remove("d-none");
    } else {
        inputLainnya.classList.add("d-none");
        inputLainnya.value = "";
    }
}

/* -----------------------------
   3️⃣ SIGNATURE PAD
-------------------------------- */
let canvas = document.getElementById('signature-pad');
let ctx = canvas.getContext('2d');
let drawing = false;

canvas.addEventListener('mousedown', () => drawing = true);
canvas.addEventListener('mouseup', () => { drawing = false; ctx.beginPath(); });
canvas.addEventListener('mousemove', draw);

function draw(e) {
    if (!drawing) return;
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    ctx.lineTo(e.offsetX, e.offsetY);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
}

document.getElementById('clear-signature').addEventListener('click', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
});

/* -----------------------------
   4️⃣ FORM SUBMIT HANDLER
-------------------------------- */
document.getElementById('formObservasi').addEventListener('submit', function(e) {
    const ttdInput = document.getElementById('ttd_asesor');
    const imageData = canvas.toDataURL('image/png');

    // Pastikan tanda tangan tidak kosong (semua pixel putih)
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;
    if (canvas.toDataURL() === blank.toDataURL()) {
        e.preventDefault();
        alert('Silakan tanda tangani terlebih dahulu sebelum menyimpan.');
        return false;
    }

    ttdInput.value = imageData;
    this.querySelector('button[type="submit"]').disabled = true; // cegah double submit
});

/* -----------------------------
   5️⃣ LOAD KUK OTOMATIS
-------------------------------- */
document.addEventListener('DOMContentLoaded', () => {
    const params = new URLSearchParams(window.location.search);
    const skemaId = params.get('id_skema');
    if (skemaId) loadKuk(skemaId);
});
</script>
@endsection

@extends('master')

@section('konten')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #041562;
        --primary-light: #0a2a9e;
        --primary-glow: rgba(4, 21, 98, 0.10);
        --accent-gold: #e8b84b;
        --text-main: #0d1b4b;
        --text-muted: #6b7fb5;
    }

    body, .container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .observasi-wrapper {
        min-height: 100vh;
        background: linear-gradient(160deg, #eef2ff 0%, #f8faff 50%, #e8eeff 100%);
        padding: 3.5rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .observasi-wrapper::before {
        content: '';
        position: absolute;
        top: -140px; right: -140px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(4,21,98,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Page Header */
    .page-header { margin-bottom: 2rem; }

    .header-badge {
        display: inline-block;
        background: var(--primary-glow);
        color: var(--primary);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(4,21,98,0.18);
    }

    .page-header h2 {
        font-size: 1.6rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.2rem;
        line-height: 1.25;
    }

    .page-header p {
        color: var(--text-muted);
        font-size: 0.88rem;
        font-weight: 500;
        margin: 0;
    }

    .header-divider {
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent-gold));
        border-radius: 4px;
        margin-top: 1rem;
    }

    /* Alert */
    .alert-custom {
        border-radius: 12px;
        font-size: 0.88rem;
        font-weight: 600;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.25rem;
    }

    .alert-success-custom {
        background: rgba(22,163,74,0.08);
        border: 1.5px solid rgba(22,163,74,0.25);
        color: #15803d;
    }

    .alert-danger-custom {
        background: rgba(220,38,38,0.07);
        border: 1.5px solid rgba(220,38,38,0.2);
        color: #b91c1c;
    }

    .alert-close {
        margin-left: auto;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 1rem;
        line-height: 1;
        opacity: 0.6;
        color: inherit;
    }

    /* Section Card */
    .section-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 24px rgba(4,21,98,0.07);
        overflow: hidden;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.45s ease both;
    }

    .section-card-header {
        background: var(--primary);
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-card-header .hicon {
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,0.15);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
        flex-shrink: 0;
    }

    .section-card-header h6 {
        color: #fff;
        font-weight: 700;
        font-size: 0.92rem;
        margin: 0;
    }

    .section-card-body { padding: 1.5rem; }

    /* Identitas fields */
    .field-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 6px;
        display: block;
    }

    .field-input {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1.5px solid rgba(4,21,98,0.12);
        background: #f5f7ff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 600;
        color: var(--text-main);
        transition: border-color 0.2s;
    }

    .field-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(4,21,98,0.08);
    }

    /* Panduan */
    .panduan-box {
        background: #f0f4ff;
        border: 1.5px solid rgba(4,21,98,0.12);
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
    }

    .panduan-box ul {
        margin: 0;
        padding-left: 1.2rem;
    }

    .panduan-box li {
        font-size: 0.85rem;
        color: var(--text-muted);
        margin-bottom: 6px;
        line-height: 1.5;
    }

    .panduan-box li:last-child { margin-bottom: 0; }

    /* Dynamic Table */
    .table-observasi {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.82rem;
        border: 1px solid rgba(4,21,98,0.1);
        border-radius: 12px;
        overflow: hidden;
    }

    .table-observasi th,
    .table-observasi td {
        border: 1px solid rgba(4,21,98,0.1);
        padding: 0.6rem 0.75rem;
        vertical-align: middle;
        text-align: left;
    }

    .table-observasi thead th {
        background: var(--primary);
        color: #fff;
        font-weight: 700;
        font-size: 0.78rem;
        letter-spacing: 0.3px;
        text-align: center;
    }

    .table-observasi thead tr:nth-child(2) th {
        background: #0a2a9e;
        font-size: 0.75rem;
    }

    .table-observasi tbody tr:nth-child(even) { background: #f8faff; }
    .table-observasi tbody tr:hover { background: #eef2ff; }

    .kelompok-label {
        background: #eef2ff !important;
        font-weight: 700;
        color: var(--primary);
    }

    .unit-header {
        font-weight: 700;
        color: var(--primary);
        font-size: 0.9rem;
        margin: 1.5rem 0 0.5rem;
        padding-bottom: 6px;
        border-bottom: 2px solid rgba(4,21,98,0.1);
    }

    .section-divider {
        border: none;
        border-top: 2px dashed rgba(4,21,98,0.15);
        margin: 2rem 0;
    }

    /* Form controls inside table */
    .form-select-sm-custom {
        padding: 5px 10px;
        border-radius: 7px;
        border: 1.5px solid rgba(4,21,98,0.12);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.78rem;
        font-weight: 500;
        color: var(--text-main);
        background: #f8faff;
        width: 100%;
    }

    .form-control-sm-custom {
        padding: 5px 10px;
        border-radius: 7px;
        border: 1.5px solid rgba(4,21,98,0.12);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.78rem;
        color: var(--text-main);
        background: #fff;
        width: 100%;
    }

    .form-control-sm-custom:focus,
    .form-select-sm-custom:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(4,21,98,0.08);
    }

    /* Radio custom */
    .radio-custom {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
        cursor: pointer;
    }

    /* Textarea */
    .textarea-custom {
        width: 100%;
        padding: 12px 14px;
        border-radius: 10px;
        border: 1.5px solid rgba(4,21,98,0.12);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.88rem;
        color: var(--text-main);
        background: #f8faff;
        resize: vertical;
        transition: border-color 0.2s;
    }

    .textarea-custom:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(4,21,98,0.08);
        background: #fff;
    }

    /* Select custom */
    .select-custom {
        width: 100%;
        padding: 11px 14px;
        border-radius: 10px;
        border: 1.5px solid rgba(4,21,98,0.12);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--text-main);
        background: #f8faff;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7fb5' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 14px center;
        padding-right: 40px;
        transition: border-color 0.2s;
    }

    .select-custom:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(4,21,98,0.08);
        background-color: #fff;
    }

    /* Signature */
    #signature-pad {
        border: 2px dashed rgba(4,21,98,0.2);
        border-radius: 12px;
        background: #fff;
        cursor: crosshair;
        display: block;
        max-width: 100%;
    }

    .btn-clear-sig {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 8px;
        border: 1.5px solid rgba(217,119,6,0.4);
        background: rgba(217,119,6,0.07);
        color: #b45309;
        font-size: 0.8rem;
        font-weight: 700;
        font-family: 'Plus Jakarta Sans', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 10px;
    }

    .btn-clear-sig:hover {
        background: rgba(217,119,6,0.15);
        border-color: rgba(217,119,6,0.6);
    }

    /* Submit */
    .btn-submit {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 14px 28px;
        border-radius: 12px;
        background: var(--primary);
        color: #fff;
        font-weight: 700;
        font-size: 0.95rem;
        font-family: 'Plus Jakarta Sans', sans-serif;
        border: none;
        box-shadow: 0 4px 18px rgba(4,21,98,0.25);
        cursor: pointer;
        transition: all 0.25s ease;
        margin-top: 1.5rem;
    }

    .btn-submit:hover {
        background: var(--primary-light);
        box-shadow: 0 6px 24px rgba(4,21,98,0.35);
        transform: translateY(-2px);
    }

    .btn-submit i { transition: transform 0.2s ease; }
    .btn-submit:hover i { transform: translateX(3px); }

    /* Loading state */
    #kelompok-container .loading-text {
        color: var(--text-muted);
        font-size: 0.88rem;
        font-style: italic;
        text-align: center;
        padding: 2rem 0;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
</style>

    <div class="container">
        <center>
        <div class="page-header">
            <span class="header-badge">FR.IA.01</span>
            <h2>Form Ceklis Observasi Aktivitas Praktik</h2>
            <p>Isi form penilaian observasi untuk asesi yang dipilih.</p>
            <div class="header-divider"></div>
        </div>
        </center>

        @if(session('success'))
            <div class="alert-custom alert-success-custom">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
                <button class="alert-close" onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom alert-danger-custom">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ session('error') }}
                <button class="alert-close" onclick="this.parentElement.remove()"><i class="bi bi-x-lg"></i></button>
            </div>
        @endif

        <form id="formObservasi" action="{{ route('ceklisobservasi.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_skema" value="{{ request('id_skema') }}">
            <input type="hidden" name="id_asesi" value="{{ request('id_asesi') }}">
            <input type="hidden" name="ttd_asesor" id="ttd_asesor">

            {{-- IDENTITAS --}}
            <div class="section-card" style="animation-delay:0.05s">
                <div class="section-card-header">
                    <div class="hicon"><i class="bi bi-person-badge-fill"></i></div>
                    <h6>Identitas</h6>
                </div>
                <div class="section-card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="field-label">Judul Skema</label>
                            <input type="text" id="judul-skema" class="field-input" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="field-label">Nama Asesi</label>
                            <input type="text" class="field-input" value="{{ $asesi->nama_lengkap }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="field-label">Nama Asesor</label>
                            <input type="text" class="field-input" value="{{ auth()->user()->name ?? '-' }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            {{-- PANDUAN --}}
            <div class="section-card" style="animation-delay:0.1s">
                <div class="section-card-header">
                    <div class="hicon"><i class="bi bi-info-circle-fill"></i></div>
                    <h6>Panduan Bagi Asesor</h6>
                </div>
                <div class="section-card-body">
                    <div class="panduan-box">
                        <ul>
                            <li>Lengkapi nama unit kompetensi, elemen, dan kriteria unjuk kerja sesuai kolom dalam tabel.</li>
                            <li>Isilah standar industri atau tempat kerja.</li>
                            <li>Beri tanda centang (√) pada kolom "Ya" jika asesi dapat melakukan tugas sesuai KUK, atau "Tidak" jika sebaliknya.</li>
                            <li>Penilaian Lanjut diisi bila hasil belum dapat disimpulkan.</li>
                            <li>Isilah kolom KUK sesuai dengan Unit Kompetensi/SKKNI.</li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- TABEL DINAMIS --}}
            <div class="section-card" style="animation-delay:0.15s">
                <div class="section-card-header">
                    <div class="hicon"><i class="bi bi-table"></i></div>
                    <h6>Data Kelompok Pekerjaan & KUK</h6>
                </div>
                <div class="section-card-body">
                    <div id="kelompok-container">
                        <p class="loading-text"><i class="bi bi-hourglass-split"></i> Memuat data kelompok pekerjaan...</p>
                    </div>
                </div>
            </div>

            {{-- UMPAN BALIK --}}
            <div class="section-card" style="animation-delay:0.2s">
                <div class="section-card-header">
                    <div class="hicon"><i class="bi bi-chat-left-text-fill"></i></div>
                    <h6>Umpan Balik & Rekomendasi</h6>
                </div>
                <div class="section-card-body">
                    <div class="mb-4">
                        <label class="field-label">Umpan Balik</label>
                        <textarea name="umpan_balik" class="textarea-custom" rows="3"
                                  placeholder="Tuliskan umpan balik untuk asesi..."></textarea>
                    </div>
                    <div>
                        <label class="field-label">Rekomendasi</label>
                        <select name="rekomendasi" class="select-custom" required>
                            <option value="">— Pilih Rekomendasi —</option>
                            <option value="Kompeten">Kompeten</option>
                            <option value="Belum Kompeten">Belum Kompeten</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- TANDA TANGAN --}}
            <div class="section-card" style="animation-delay:0.25s">
                <div class="section-card-header">
                    <div class="hicon"><i class="bi bi-pen-fill"></i></div>
                    <h6>Tanda Tangan Asesor</h6>
                </div>
                <center>
                <div class="section-card-body">
                    <canvas id="signature-pad" width="500" height="180"></canvas>
                    <br>
                    <button type="button" class="btn-clear-sig" id="clear-signature">
                        <i class="bi bi-eraser-fill"></i> Hapus Tanda Tangan
                    </button>
                </div>
                </center>
            </div>

            <button type="submit" class="btn-submit">
                Simpan Penilaian <i class="bi bi-arrow-right"></i>
            </button>
        </form>

    </div>
</div>

<script>
function loadData(skemaId) {
    const container = document.getElementById('kelompok-container');
    const judulSkema = document.getElementById('judul-skema');

    fetch(`/ceklisobservasi/data/${skemaId}`)
        .then(res => res.json())
        .then(data => {
            judulSkema.value = data.skema_nama ?? 'Tidak tersedia';
            let html = '';

            (data.kelompok ?? []).forEach((kel, kIndex) => {
                html += `
                <div class="table-responsive mb-4">
                <table class="table-observasi">
                    <thead>
                        <tr>
                            <th style="width:25%">Kelompok Pekerjaan ${kIndex + 1}<br><small style="font-weight:400;">${kel.nama_kelompok ?? '-'}</small></th>
                            <th style="width:5%">No.</th>
                            <th style="width:25%">Kode Unit</th>
                            <th>Judul Unit</th>
                        </tr>
                    </thead>
                    <tbody>`;

                (kel.unit_kompetensi ?? []).forEach((unit, uIdx) => {
                    html += `
                    <tr>
                        <td class="kelompok-label"></td>
                        <td style="text-align:center;">${uIdx + 1}.</td>
                        <td>${unit.kode_unit ?? '-'}</td>
                        <td>${unit.judul_unit ?? '-'}</td>
                    </tr>`;
                });

                html += `</tbody></table></div>`;

                (kel.unit_kompetensi ?? []).forEach((unit, uIdx) => {
                    html += `
                    <div class="unit-header">
                        Unit Kompetensi ${uIdx + 1}
                        <span style="font-weight:500; color:var(--text-muted); font-size:0.78rem; margin-left:8px;">
                            ${unit.kode_unit ?? '-'} — ${unit.judul_unit ?? '-'}
                        </span>
                    </div>

                    <div class="table-responsive mb-3">
                    <table class="table-observasi">
                        <thead>
                            <tr>
                                <th style="width:4%">No.</th>
                                <th style="width:18%">Elemen</th>
                                <th style="width:30%">Kriteria Unjuk Kerja</th>
                                <th style="width:18%">Standar Industri / Tempat Kerja</th>
                                <th colspan="2" style="width:12%">Pencapaian</th>
                                <th style="width:18%">Penilaian Lanjut</th>
                            </tr>
                            <tr>
                                <th></th><th></th><th></th><th></th>
                                <th style="text-align:center;">Ya</th>
                                <th style="text-align:center;">Tidak</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>`;

                    (unit.elemen ?? []).forEach(ele => {
                        (ele.kuk ?? []).forEach((kuk, idx) => {
                            const no = `${ele.nomor_elemen || uIdx + 1}.${idx + 1}`;
                            const kukId = kuk.id_kuk ?? 0;
                            html += `
                            <tr>
                                <td style="text-align:center;">${no}</td>
                                <td>${ele.nama_elemen ?? '-'}</td>
                                <td>${kuk.deskripsi_kuk ?? '-'}</td>
                                <td>
                                    <select class="form-select-sm-custom"
                                            name="kuk[${kukId}][standar_industri]"
                                            onchange="toggleLainnya(this, ${kukId})">
                                        <option value="Modul Praktek" selected>Modul Praktek</option>
                                        <option value="SOP">SOP</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    <input type="text" class="form-control-sm-custom mt-1 d-none"
                                           name="kuk[${kukId}][standar_lainnya]"
                                           placeholder="Tulis standar lainnya">
                                </td>
                                <td style="text-align:center;">
                                    <input class="radio-custom" type="radio" name="kuk[${kukId}][status]" value="Ya" required>
                                </td>
                                <td style="text-align:center;">
                                    <input class="radio-custom" type="radio" name="kuk[${kukId}][status]" value="Tidak">
                                </td>
                                <td>
                                    <input type="text" name="kuk[${kukId}][catatan]" class="form-control-sm-custom" placeholder="Catatan...">
                                </td>
                            </tr>`;
                        });
                    });

                    html += `</tbody></table></div>`;
                });

                html += `<hr class="section-divider">`;
            });

            container.innerHTML = html || '<p style="color:var(--text-muted);font-style:italic;">Tidak ada data kelompok pekerjaan.</p>';
        })
        .catch(() => {
            container.innerHTML = '<p style="color:#b91c1c;font-style:italic;"><i class="bi bi-exclamation-circle"></i> Gagal memuat data.</p>';
        });
}

function toggleLainnya(selectEl, kukId) {
    const input = selectEl.parentElement.querySelector(`input[name="kuk[${kukId}][standar_lainnya]"]`);
    if (selectEl.value === "Lainnya") input.classList.remove("d-none");
    else { input.classList.add("d-none"); input.value = ""; }
}

/* Signature Pad */
const canvas = document.getElementById('signature-pad');
const ctx = canvas.getContext('2d');
let drawing = false;

canvas.addEventListener('mousedown', () => drawing = true);
canvas.addEventListener('mouseup', () => { drawing = false; ctx.beginPath(); });
canvas.addEventListener('mouseleave', () => { drawing = false; ctx.beginPath(); });
canvas.addEventListener('mousemove', e => {
    if (!drawing) return;
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    ctx.lineTo(e.offsetX, e.offsetY);
    ctx.stroke();
    ctx.beginPath();
    ctx.moveTo(e.offsetX, e.offsetY);
});

document.getElementById('clear-signature').addEventListener('click', () => {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
});

document.getElementById('formObservasi')?.addEventListener('submit', e => {
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;
    if (canvas.toDataURL() === blank.toDataURL()) {
        e.preventDefault();
        alert('Silakan tanda tangani terlebih dahulu.');
        return false;
    }
    document.getElementById('ttd_asesor').value = canvas.toDataURL('image/png');
});

document.addEventListener('DOMContentLoaded', () => {
    const skemaId = new URLSearchParams(window.location.search).get('id_skema');
    if (skemaId) loadData(skemaId);
});
</script>
@endsection
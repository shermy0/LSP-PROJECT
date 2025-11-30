@extends('master')

@section('konten')
<div class="container mt-4">
    <h1 class="fw-bold mb-4 text-primary">Form Ceklis Observasi Aktivitas Praktik</h1>
    <h1 class="fw-bold mb-4 text-primary">(FR.IA.01)</h1>

    {{-- Pesan --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FORM --}}
    <form id="formObservasi" action="{{ route('ceklisobservasi.store') }}" method="POST" class="card border-0 shadow-sm p-4 rounded-4">
        @csrf
        <input type="hidden" name="id_skema" value="{{ request('id_skema') }}">
        <input type="hidden" name="id_asesi" value="{{ request('id_asesi') }}">
        <input type="hidden" name="ttd_asesor" id="ttd_asesor">

        {{-- IDENTITAS --}}
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold text-secondary">Judul Skema</label>
                <input type="text" id="judul-skema" class="form-control border-primary-subtle" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold text-secondary">Nama Asesi</label>
                <input type="text" class="form-control border-primary-subtle"
                    value="{{ $asesi->where('id_asesi', request('id_asesi'))->first()->nama_lengkap ?? 'Tidak ditemukan' }}" readonly>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label fw-semibold text-secondary">Nama Asesor</label>
                <input type="text" class="form-control border-primary-subtle" value="{{ auth()->user()->name ?? '-' }}" readonly>
            </div>
        </div>

        {{-- PANDUAN BAGI ASESOR --}}
        <div class="border rounded-4 p-3 mb-4 bg-light-subtle border-primary-subtle shadow-sm">
            <h5 class="fw-bold text-primary mb-2">Panduan Bagi Asesor</h5>
            <ul class="mb-0 text-secondary small">
                <li>Lengkapi nama unit kompetensi, elemen, dan kriteria unjuk kerja sesuai kolom dalam tabel.</li>
                <li>Isilah standar industri atau tempat kerja.</li>
                <li>Beri tanda centang (√) pada kolom “Ya” jika asesi dapat melakukan tugas sesuai KUK, atau “Tidak” jika sebaliknya.</li>
                <li>Penilaian Lanjut diisi bila hasil belum dapat disimpulkan.</li>
                <li>Isilah kolom KUK sesuai dengan Unit Kompetensi/SKKNI.</li>
            </ul>
        </div>

        {{-- CONTAINER DINAMIS --}}
        <div id="kelompok-container">
            <p class="text-muted">Memuat data kelompok pekerjaan...</p>
        </div>

        {{-- UMPAN BALIK --}}
        <div class="mt-4">
            <label class="form-label fw-semibold text-secondary">Umpan Balik</label>
            <textarea name="umpan_balik" class="form-control border-primary-subtle" rows="3"></textarea>
        </div>

        {{-- REKOMENDASI --}}
        <div class="mt-4">
            <label class="form-label fw-semibold text-secondary">Rekomendasi</label>
            <select name="rekomendasi" class="form-select border-primary-subtle" required>
                <option value="">-- pilih rekomendasi --</option>
                <option value="Kompeten">Kompeten</option>
                <option value="Belum Kompeten">Belum Kompeten</option>
            </select>
        </div>

        {{-- TTD --}}
        <div class="mt-4">
            <label class="form-label fw-semibold text-secondary">Tanda Tangan Asesor</label>
            <div class="border border-primary-subtle p-2 rounded-3 bg-white text-center">
                <canvas id="signature-pad" width="400" height="200"></canvas>
            </div>
            <button type="button" class="btn btn-sm btn-outline-warning mt-2" id="clear-signature">Hapus Tanda Tangan</button>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-4 rounded-3 shadow-sm">Simpan Penilaian</button>
    </form>
</div>

{{-- STYLE --}}
<style>
body { background-color: #f8f9fc; font-family: 'Segoe UI', Tahoma, sans-serif; }
.table { width: 100%; border-collapse: collapse; font-size: 0.9rem; border: 1px solid #dee2e6; }
.table th, .table td { border: 1px solid #dee2e6; padding: 0.6rem; vertical-align: top; text-align: left; }
.table thead th { background-color: #004AAD; color: white; text-align: center; }
.table-striped tbody tr:nth-child(even) { background-color: #f8faff; }
.kelompok-label { background-color: #EAF1FF; font-weight: 600; color: #004AAD; vertical-align: middle; }
.unit-header { font-weight: 600; color: #004AAD; margin-top: 1rem; }
.section-divider { border-top: 2px dashed #004AAD; margin: 2rem 0; }
#signature-pad { border: 1px dashed #004AAD; border-radius: 8px; background: #fefefe; cursor: crosshair; }
</style>

{{-- SCRIPT --}}
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
                // === KELOMPOK PEKERJAAN ===
                html += `
                <table class="table mb-4 table-striped rounded-3 overflow-hidden shadow-sm">
                    <thead>
                        <tr>
                            <th style="width:25%">Kelompok Pekerjaan ${kIndex + 1}<br><small>${kel.nama_kelompok ?? '-'}</small></th>
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
                        <td>${uIdx + 1}.</td>
                        <td>${unit.kode_unit ?? '-'}</td>
                        <td>${unit.judul_unit ?? '-'}</td>
                    </tr>`;
                });

                html += `</tbody></table>`;

                // === UNIT KOMPETENSI ===
                (kel.unit_kompetensi ?? []).forEach((unit, uIdx) => {
                    html += `
                    <div class="unit-header mt-4 mb-2">
                        <strong>Unit Kompetensi ${uIdx + 1}</strong><br>
                        <span class="text-muted small">Kode Unit: ${unit.kode_unit ?? '-'} | Judul Unit: ${unit.judul_unit ?? '-'}</span>
                    </div>

                    <table class="table table-bordered table-striped align-middle rounded-3 overflow-hidden shadow-sm">
                        <thead>
                            <tr>
                                <th style="width:5%">No.</th>
                                <th style="width:20%">Elemen</th>
                                <th style="width:35%">Kriteria Unjuk Kerja</th>
                                <th style="width:15%">Standar Industri / Tempat Kerja</th>
                                <th colspan="2" style="width:10%">Pencapaian</th>
                                <th style="width:15%">Penilaian Lanjut</th>
                            </tr>
                            <tr style="background-color:#eaf1ff;">
                                <th></th><th></th><th></th><th></th>
                                <th class="text-center">Ya</th>
                                <th class="text-center">Tidak</th>
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
                                <td>${no}</td>
                                <td>${ele.nama_elemen ?? '-'}</td>
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
                                           name="kuk[${kukId}][standar_lainnya]" placeholder="Tulis standar lainnya">
                                </td>
                                <td class="text-center"><input type="radio" name="kuk[${kukId}][status]" value="Ya" required></td>
                                <td class="text-center"><input type="radio" name="kuk[${kukId}][status]" value="Tidak"></td>
                                <td><input type="text" name="kuk[${kukId}][catatan]" class="form-control form-control-sm"></td>
                            </tr>`;
                        });
                    });

                    html += `</tbody></table>`;
                });

                html += `<div class="section-divider"></div>`;
            });

            container.innerHTML = html || '<p class="text-muted">Tidak ada data kelompok pekerjaan.</p>';
        })
        .catch(() => container.innerHTML = '<p class="text-danger">Gagal memuat data.</p>');
}

function toggleLainnya(selectEl, kukId) {
    const input = selectEl.parentElement.querySelector('input[name="kuk[' + kukId + '][standar_lainnya]"]');
    if (selectEl.value === "Lainnya") input.classList.remove("d-none");
    else { input.classList.add("d-none"); input.value = ""; }
}

/* Signature pad */
let canvas = document.getElementById('signature-pad');
let ctx = canvas.getContext('2d');
let drawing = false;
canvas.addEventListener('mousedown', () => drawing = true);
canvas.addEventListener('mouseup', () => { drawing = false; ctx.beginPath(); });
canvas.addEventListener('mousemove', e => {
    if (!drawing) return;
    ctx.lineWidth = 2; ctx.lineCap = 'round'; ctx.strokeStyle = '#004AAD';
    ctx.lineTo(e.offsetX, e.offsetY); ctx.stroke(); ctx.beginPath(); ctx.moveTo(e.offsetX, e.offsetY);
});
document.getElementById('clear-signature').addEventListener('click', () => ctx.clearRect(0, 0, canvas.width, canvas.height));

document.getElementById('formObservasi').addEventListener('submit', e => {
    const ttdInput = document.getElementById('ttd_asesor');
    const imageData = canvas.toDataURL('image/png');
    const blank = document.createElement('canvas');
    blank.width = canvas.width; blank.height = canvas.height;
    if (canvas.toDataURL() === blank.toDataURL()) {
        e.preventDefault();
        alert('Silakan tanda tangani terlebih dahulu.');
        return false;
    }
    ttdInput.value = imageData;
});

document.addEventListener('DOMContentLoaded', () => {
    const skemaId = new URLSearchParams(window.location.search).get('id_skema');
    if (skemaId) loadData(skemaId);
});
</script>
@endsection

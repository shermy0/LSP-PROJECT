@extends('master')

@section('title', 'FR.APL.02 - Permohonan Sertifikasi Kompetensi')

@section('konten')
<div class="container mt-2 my-5">
    <div class="bg-white border rounded-3 shadow-sm p-4">

        <!-- Header -->
        <div class="mb-4">
            <p class="small text-muted mb-1">Form Asesmen &gt; <span class="fw-semibold">FR.APL.02</span></p>
            <div class="d-flex flex-column align-items-center text-center">
                <div class="rounded mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                <h1 class="h5 fw-bold">Permohonan Sertifikasi Kompetensi</h1>
                <span class="badge bg-light text-dark mt-2 px-3 py-2 rounded-pill">Rincian Data Pemohon Sertifikasi</span>
            </div>
        </div>

        <!-- Form -->
        <form id="permohonanForm" action="{{ route('asesi.permohonan.storeDokumen') }}" method="POST"
              enctype="multipart/form-data" novalidate>
            @csrf

            <!-- Data Sertifikasi -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Sertifikasi
                </div>

                <div class="mb-3">
                    <label class="form-label">Skema Sertifikasi <span class="text-danger">*</span></label>
                    <select id="skemaSelect" name="id_skema" class="form-select rounded-3" required>
                        <option value="" disabled selected>Pilih Skema Sertifikasi</option>
                        @foreach($skema as $s)
                            <option value="{{ $s->id_skema }}">{{ $s->nama_skema }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Silakan pilih skema sertifikasi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Sertifikasi</label>
                    <input type="text" id="judulSertifikasi" class="form-control rounded-3" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Skema</label>
                    <input type="text" id="nomorSkema" class="form-control rounded-3" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Tujuan Asesmen <span class="text-danger">*</span></label>
                    <select id="tujuanAsesmen" name="tujuan_asesmen" class="form-select rounded-3" required>
                        <option value="" disabled selected>Pilih Tujuan Asesmen</option>
                        <option value="Sertifikasi">Sertifikasi</option>
                        <option value="PKT">PKT</option>
                        <option value="RPL">RPL</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                    <div class="invalid-feedback">Silakan pilih tujuan asesmen.</div>
                </div>
            </div>

            <!-- Daftar Unit Kompetensi -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Daftar Unit Kompetensi
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Unit</th>
                                <th>Judul Unit</th>
                                <th>Standar Kompetensi Kerja</th>
                            </tr>
                        </thead>
                        <tbody id="unitTable">
                            <tr>
                                <td colspan="4" class="text-center text-muted">Pilih skema sertifikasi terlebih dahulu</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bukti Kelengkapan -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Bagian 3 : Bukti Kelengkapan Pemohon
                </div>
                @foreach($jenisDokumen as $jd)
                    <div class="mb-3">
                        <label class="form-label">{{ $loop->iteration }}. {{ $jd->nama_jenis }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" 
                                   name="dokumen[{{ $jd->id_jenis_dokumen }}]" 
                                   class="form-control dokumen-input" 
                                   accept=".jpg,.jpeg,.png,.pdf" required
                                   onchange="showFileActions(this)">
                            <button type="button" class="btn btn-outline-danger" onclick="removeFile(this)">Hapus</button>
                        </div>
                        <div class="invalid-feedback">Silakan unggah dokumen ini.</div>
                        <!-- Tempat tombol lihat -->
                        <div class="file-preview mt-2"></div>
                    </div>
                @endforeach
            </div>

            <!-- Tanda Tangan Asesi -->
            <div class="border rounded-3 p-3 mb-4 bg-white shadow-sm">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Tanda Tangan Asesi
                </div>

                <div class="card">
                    <div class="card-title">Asesi</div>
                    <div class="mb-2">
                        <label for="nama-asesi">Nama Lengkap</label>
                        <input type="text" id="nama-asesi" class="form-control"
                               value="{{ $asesi->nama_lengkap ?? '' }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal-asesi">Tanggal</label>
                        <input type="date" id="tanggal-asesi" name="tanggal" class="form-control"
                               value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="ttd-asesi">Tanda Tangan</label>
                        <canvas id="ttd-asesi" width="400" height="150"></canvas>
                        <input type="hidden" name="ttd_asesi" id="ttd_asesi_data">
                    </div>
                    <div class="btns">
                        <button type="button" class="btn clear" onclick="clearCanvas()">Hapus</button>
                        <button type="button" class="btn download" onclick="downloadTTD()">Unduh</button>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('asesi.permohonan.form1') }}" class="btn btn-danger">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan dan Kirim</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Preview Dokumen -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="previewModalLabel">Preview Dokumen</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body text-center" id="previewContent">
        <!-- konten preview file -->
      </div>
    </div>
  </div>
</div>

<!-- Script Preview File & Hapus -->
<script>
function showFileActions(input) {
    const file = input.files[0];
    const previewContainer = input.closest('.mb-3').querySelector('.file-preview');
    previewContainer.innerHTML = '';

    if (file) {
        const fileURL = URL.createObjectURL(file);
        previewContainer.innerHTML = `
            <button type="button" class="btn btn-sm btn-info" onclick="openPreview('${fileURL}', '${file.type}')">
                Lihat Dokumen
            </button>
        `;
    }
}

function openPreview(url, type) {
    let content = '';
    if (type.startsWith("image/")) {
        content = `<img src="${url}" class="img-fluid" style="max-height:70vh;">`;
    } else if (type === "application/pdf") {
        content = `<embed src="${url}" type="application/pdf" width="100%" height="600px">`;
    } else {
        content = `<a href="${url}" target="_blank">Download File</a>`;
    }
    document.getElementById('previewContent').innerHTML = content;
    let modal = new bootstrap.Modal(document.getElementById('previewModal'));
    modal.show();
}

function removeFile(btn) {
    const input = btn.closest('.input-group').querySelector('input[type="file"]');
    input.value = ''; // reset file
    const previewContainer = btn.closest('.mb-3').querySelector('.file-preview');
    previewContainer.innerHTML = ''; // hapus tombol lihat
}
</script>

<!-- Script Skema + Validasi -->
<script>
document.getElementById('skemaSelect').addEventListener('change', function () {
    let skemaId = this.value;
    fetch(`/get-skema/${skemaId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('judulSertifikasi').value = data.skema?.judul_skema ?? '';
            document.getElementById('nomorSkema').value = data.skema?.kode_skema ?? '';
            let tbody = document.getElementById('unitTable');
            tbody.innerHTML = '';
            if (data.units && data.units.length > 0) {
                data.units.forEach((u, i) => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${i + 1}</td>
                            <td>${u.kode_unit}</td>
                            <td>${u.judul_unit}</td>
                            <td>${u.standar_kompetensi}</td>
                        </tr>`;
                });
            } else {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Unit kompetensi belum tersedia</td></tr>`;
            }
        });
});

document.getElementById('permohonanForm').addEventListener('submit', function (e) {
    let valid = true;
    let firstInvalid = null;

    const requiredFields = this.querySelectorAll('[required]');
    requiredFields.forEach(field => {
        if (!field.value || (field.type === "file" && !field.files.length)) {
            field.classList.add('is-invalid');
            valid = false;
            if (!firstInvalid) firstInvalid = field;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    if (!valid) {
        e.preventDefault();
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
            firstInvalid.focus();
        }
    }
});
</script>

<!-- Script Tanda Tangan -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    let isDrawing = false, lastX = 0, lastY = 0;

    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.lineJoin = 'round';
    ctx.strokeStyle = '#000';

    function startDrawing(e) { isDrawing = true; [lastX, lastY] = [e.offsetX, e.offsetY]; }
    function draw(e) {
        if (!isDrawing) return;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }
    function stopDrawing() { isDrawing = false; }

    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    document.getElementById('permohonanForm').addEventListener('submit', function () {
        document.getElementById('ttd_asesi_data').value = canvas.toDataURL();
    });
});

function clearCanvas() {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}
function downloadTTD() {
    const canvas = document.getElementById('ttd-asesi');
    const nama = document.getElementById('nama-asesi').value || 'User';
    const tanggal = document.getElementById('tanggal-asesi').value || new Date().toISOString().split('T')[0];
    const link = document.createElement('a');
    link.download = `${nama}_${tanggal}_tanda_tangan.png`;
    link.href = canvas.toDataURL();
    link.click();
}
</script>

<!-- Style -->
<style>
.card { 
    background: #fff; 
    border: 1px solid #ddd; 
    border-radius: 12px; 
    box-shadow: 0 4px 10px rgba(0,0,0,0.08); 
    padding: 25px; 
    max-width: 500px; 
    margin: 20px auto; 
}
.card-title {
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 1.1rem;
    color: #333;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}
.card canvas { 
    border: 1px solid #999; 
    border-radius: 6px; 
    width: 100%; 
    height: 150px; 
    background-color: #ffffff; 
    cursor: crosshair; 
}
.btns { display: flex; justify-content: space-between; gap: 10px; }
.btns .clear { background: #dc3545; color: white; }
.btns .download { background: #0d6efd; color: white; }
.btns button:hover { opacity: 0.9; transform: translateY(-2px); transition: all 0.2s; }
</style>
@endsection

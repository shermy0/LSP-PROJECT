@extends('master')

@section('title', 'Detail Permohonan Sertifikasi Asesi')

@section('konten')
<div class="container-fluid px-4 py-3">
    <div class="bg-transparent">
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
            <h1 class="h4 fw-bold">Detail Permohonan Sertifikasi (FR.APL.02)</h1>
            <p class="text-muted">Rincian Data Pemohon</p>
        </div>

        <form id="permohonanForm" action="{{ route('admin.permohonan.update', $permohonan->id_permohonan) }}" method="POST" class="needs-validation" novalidate>
            @csrf

            {{-- Data Pribadi --}}
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Data Pribadi</p>
                <p class="mb-0">Rincian identitas pemohon</p>
            </div>
            <div class="question-box mb-4">
                <div class="ps-2">
                    <p><strong>Nama Lengkap:</strong> {{ $asesi->nama_lengkap }}</p>
                    <p><strong>NIK:</strong> {{ $asesi->nik }}</p>
                    <p><strong>Tempat/Tgl Lahir:</strong> {{ $asesi->tempat_lahir }}, {{ $asesi->tgl_lahir }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $asesi->jenis_kelamin }}</p>
                    <p><strong>Alamat:</strong> {{ $asesi->alamat_rumah }}</p>
                    <p><strong>Telepon/Email:</strong> {{ $asesi->telepon_hp }} / {{ $asesi->email }}</p>
                    <p><strong>Pendidikan Terakhir:</strong> {{ $asesi->kualifikasi_pendidikan }}</p>
                </div>
            </div>

            {{-- Data Pekerjaan --}}
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Data Pekerjaan</p>
                <p class="mb-0">Informasi TUK / instansi</p>
            </div>
            <div class="question-box mb-4">
                <div class="ps-2">
                    <p><strong>Nama Institusi:</strong> {{ $tuk->nama_tuk ?? '-' }}</p>
                    <p><strong>Alamat Instansi:</strong> {{ $tuk->alamat_tuk ?? '-' }}</p>
                    <p><strong>Telepon Instansi:</strong> {{ $tuk->telepon ?? '-' }}</p>
                    <p><strong>Email Instansi:</strong> {{ $tuk->email ?? '-' }}</p>
                </div>
            </div>

            {{-- Data Sertifikasi --}}
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Data Sertifikasi</p>
                <p class="mb-0">Skema & status permohonan</p>
            </div>
            <div class="question-box mb-4">
                <div class="ps-2">
                    <p><strong>Skema Sertifikasi:</strong> {{ $skema->nama_skema ?? '-' }}</p>
                    <p><strong>Judul Sertifikasi:</strong> {{ $skema->judul_skema ?? '-' }}</p>
                    <p><strong>Nomor Skema:</strong> {{ $skema->kode_skema ?? '-' }}</p>
                    <p><strong>Tujuan Asesmen:</strong> {{ $permohonan->tujuan_asesmen ?? '-' }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $permohonan->status=='Diajukan' ? 'warning text-dark' : ($permohonan->status=='Diterima' ? 'success' : 'danger') }}">
                            {{ $permohonan->status }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Daftar Unit Kompetensi --}}
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Daftar Unit Kompetensi</p>
                <p class="mb-0">Unit kompetensi pemohon</p>
            </div>
            <div class="question-box mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Unit</th>
                                <th>Judul Unit</th>
                                <th>Standar Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($units as $i => $unit)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>{{ $unit->kode_unit }}</td>
                                    <td>{{ $unit->judul_unit }}</td>
                                    <td>{{ $unit->standar_kompetensi }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">Belum ada unit kompetensi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Bukti Kelengkapan --}}
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Bukti Kelengkapan</p>
                <p class="mb-0">Lampiran dokumen pemohon</p>
            </div>
            <div class="question-box mb-4">
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Jenis Dokumen</th>
                                <th>Lampiran</th>
                                <th>Memenuhi Syarat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dokumen as $i => $d)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td>{{ $d->jenis }}</td>
                                    <td class="text-center">
                                        @if(!empty($d->path_file))
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                onclick="openPreview('{{ asset('storage/' . $d->path_file) }}', '{{ pathinfo($d->path_file, PATHINFO_EXTENSION) }}')">
                                                Lihat
                                            </button>
                                        @else
                                            <span class="text-muted">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="syarat[{{ $d->id_dokumen }}]" value="Ya" id="ya{{ $i }}" required>
                                            <label class="form-check-label" for="ya{{ $i }}">Memenuhi</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio"
                                                name="syarat[{{ $d->id_dokumen }}]" value="Tidak" id="tidak{{ $i }}">
                                            <label class="form-check-label" for="tidak{{ $i }}">Tidak Memenuhi</label>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted">Belum ada dokumen persyaratan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tanda Tangan Persetujuan --}}
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Tanda Tangan Persetujuan</p>
                <p class="mb-0">TTD Asesi & Admin</p>
            </div>
            <div class="question-box mb-4">
                <div class="row g-3">
                    <!-- Asesi (read-only image) -->
                    <div class="col-md-6">
                        <div>
                            <p class="mb-2 fw-semibold">Asesi</p>
                            <p><strong>Tanggal:</strong> {{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
                            @if(!empty($persetujuan->ttd_asesi))
                                <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="TTD Asesi"
                                     class="border rounded" style="max-width:100%; height:150px; object-fit:contain;">
                            @else
                                <p class="text-muted">Belum ada tanda tangan asesi</p>
                            @endif
                        </div>
                    </div>

                    <!-- Admin (interactive canvas) -->
                    <div class="col-md-6">
                        <div>
                            <p class="mb-2 fw-semibold">Admin</p>
                            <div class="mb-2">
                                <label for="tanggal-admin" class="form-label">Tanggal</label>
                                <input type="date" id="tanggal-admin" name="tanggal_admin" class="form-control"
                                       value="{{ date('Y-m-d') }}" readonly required>
                                <div class="invalid-feedback">Tanggal admin wajib diisi.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanda Tangan Admin <span class="text-danger">*</span></label>
                                <div class="canvas-wrapper">
                                    <canvas id="ttd-admin"></canvas>
                                    <span class="canvas-placeholder">Tanda tangan admin di sini</span>
                                </div>
                                <input type="hidden" name="ttd_admin" id="ttd_admin_data">
                                <div class="invalid-feedback">Tanda tangan admin wajib diisi.</div>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn-back" onclick="clearCanvasAdmin()">Hapus</button>
                                <button type="button" class="btn-next" onclick="downloadTTDAdmin()">Unduh</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Keputusan Permohonan --}}
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Keputusan Permohonan</p>
                <p class="mb-0">Pilih status dan catatan</p>
            </div>
            <div class="question-box mb-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status Keputusan</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               name="status_permohonan" id="statusDiterima" value="Diterima"
                               {{ old('status_permohonan', $permohonan->status ?? '') == 'Diterima' ? 'checked' : '' }} required>
                        <label class="form-check-label text-success fw-semibold" for="statusDiterima">Diterima</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                               name="status_permohonan" id="statusDitolak" value="Ditolak"
                               {{ old('status_permohonan', $permohonan->status ?? '') == 'Ditolak' ? 'checked' : '' }}>
                        <label class="form-check-label text-danger fw-semibold" for="statusDitolak">Ditolak</label>
                    </div>
                    <div class="invalid-feedback">Silakan pilih status keputusan.</div>
                </div>

                {{-- catatan box: initial display dikontrol server-side (jika sebelumnya sudah 'Ditolak' tampil) --}}
                <div class="mb-3" id="catatanBox" style="display: {{ old('status_permohonan', $permohonan->status ?? '') == 'Ditolak' ? 'block' : 'none' }};">
                    <label for="catatan" class="form-label fw-semibold">Alasan / Keterangan</label>
                    <textarea id="catatan" name="catatan" class="form-control" rows="3"
                        {{ old('status_permohonan', $permohonan->status ?? '') == 'Ditolak' ? 'required' : '' }}
                    >{{ old('catatan', $permohonan->catatan ?? '') }}</textarea>
                    <div class="invalid-feedback">Harap isi alasan penolakan.</div>
                </div>
            </div>

            {{-- Tombol --}}
            <div class="button-group mt-3 mb-5">
                <a href="{{ route('admin.permohonan.index') }}" class="btn-back">Kembali</a>
                <button type="submit" class="btn-next">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Preview --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center" id="previewContent">
                <p class="text-muted">Memuat...</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal Alert untuk TTD Admin --}}
<div class="modal fade" id="ttdAlertModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-center">
      <div class="modal-header">
        <h5 class="modal-title text-danger">Tanda Tangan Diperlukan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <p>Silakan isi tanda tangan admin terlebih dahulu sebelum menyimpan keputusan.</p>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>

{{-- STYLE --}}
<style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9fb; }

    .unit-header {
        background: #E9F1FF;
        border-left: 6px solid #007BFF;
        border-radius: 8px;
        padding: 18px 20px;
        margin-bottom: 12px;
        font-size: 1.125rem;
        line-height: 1.3;
        font-weight: 700;
        color: #041562;
    }
    .unit-header p.mb-0 { font-size: 0.95rem; color: #334155; margin-top: 4px; font-weight: 500; }

    .question-box {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        background: #fff;
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border: 2px solid #d9534f !important;
        background: #fff8f8 !important;
    }
    .invalid-feedback { font-size: 12px; display:block; }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-back {
        background: #d9534f;
        color: #fff;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        border: none;
    }

    .btn-next {
        background: #041562;
        color: #fff;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
        border: none;
    }

    .btn-back:hover { background: #c9302c; }
    .btn-next:hover { background: #06208a; }

    .canvas-wrapper { position: relative; width: 100%; max-width: 700px; margin: 0 auto; }
    #ttd-admin { display:block; width:100%; height:150px; border:2px dashed #ccc; border-radius:6px; background:#fff; cursor:crosshair; }
    .canvas-placeholder { position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); color:#aaa; font-size:14px; pointer-events:none; }

    .table-light th { vertical-align: middle; }
</style>

{{-- SCRIPTS --}}
<script>
    // Preview dokumen (image/pdf/other)
    function openPreview(url, ext) {
        let content = '';
        ext = (ext || '').toLowerCase();
        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
            content = `<img src="${url}" class="img-fluid" alt="preview">`;
        } else if (ext === 'pdf') {
            content = `<embed src="${url}" type="application/pdf" width="100%" height="600px">`;
        } else {
            content = `<a href="${url}" target="_blank">Download File</a>`;
        }
        document.getElementById('previewContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }

    // === TTD Admin: responsive hi-dpi, blank-detection, touch support ===
    (function () {
        const canvas = document.getElementById('ttd-admin');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const placeholder = document.querySelector('.canvas-placeholder');
        const VISIBLE_HEIGHT = 150;
        let drawing = false;
        let blankDataURL = null;

        function resizeCanvasAndPrepareBlankAdmin() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.strokeStyle = '#000';

            blankDataURL = canvas.toDataURL();
        }

        function getPointerPosAdmin(evt) {
            const rect = canvas.getBoundingClientRect();
            let clientX, clientY;
            if (evt.touches && evt.touches.length > 0) {
                clientX = evt.touches[0].clientX;
                clientY = evt.touches[0].clientY;
            } else {
                clientX = evt.clientX;
                clientY = evt.clientY;
            }
            return { x: clientX - rect.left, y: clientY - rect.top };
        }

        function startDrawingAdmin(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPosAdmin(evt);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            placeholder.style.display = 'none';
        }
        function drawMoveAdmin(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPosAdmin(evt);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
        function stopDrawingAdmin(evt) {
            if (!drawing) return;
            evt.preventDefault();
            drawing = false;
            ctx.beginPath();
        }

        function clearCanvasAdmin() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            blankDataURL = canvas.toDataURL();
            document.getElementById('ttd_admin_data').value = '';
            placeholder.style.display = 'block';
        }

        function isCanvasBlankAdmin() {
            return canvas.toDataURL() === blankDataURL;
        }

        // use modal instead of alert; DO NOT auto-scroll when showing modal
        function saveAdminTTD(required = true) {
            if (isCanvasBlankAdmin()) {
                if (required) {
                    // show bootstrap modal instead of alert
                    new bootstrap.Modal(document.getElementById('ttdAlertModal')).show();
                    return false;
                } else {
                    document.getElementById('ttd_admin_data').value = '';
                    return true;
                }
            }
            document.getElementById('ttd_admin_data').value = canvas.toDataURL('image/png');
            return true;
        }

        function downloadTTDAdmin() {
            if (isCanvasBlankAdmin()) {
                // use modal as well
                new bootstrap.Modal(document.getElementById('ttdAlertModal')).show();
                return;
            }
            const link = document.createElement('a');
            const tanggal = document.getElementById('tanggal-admin').value || new Date().toISOString().split('T')[0];
            link.download = `Admin_${tanggal}_tanda_tangan.png`;
            link.href = canvas.toDataURL('image/png');
            link.click();
        }

        // attach events
        canvas.addEventListener('mousedown', startDrawingAdmin);
        canvas.addEventListener('mousemove', drawMoveAdmin);
        window.addEventListener('mouseup', stopDrawingAdmin);

        canvas.addEventListener('touchstart', function(e){ startDrawingAdmin(e); }, { passive: false });
        canvas.addEventListener('touchmove', function(e){ drawMoveAdmin(e); }, { passive: false });
        window.addEventListener('touchend', stopDrawingAdmin);

        window.addEventListener('resize', function () {
            const prev = canvas.toDataURL();
            resizeCanvasAndPrepareBlankAdmin();
            if (prev && prev !== blankDataURL) {
                const img = new Image();
                img.onload = function () {
                    ctx.drawImage(img, 0, 0, canvas.clientWidth, VISIBLE_HEIGHT);
                };
                img.src = prev;
            }
        });

        // init
        resizeCanvasAndPrepareBlankAdmin();

        // expose to window
        window.clearCanvasAdmin = clearCanvasAdmin;
        window.downloadTTDAdmin = downloadTTDAdmin;
        window.saveAdminTTD = saveAdminTTD;
        window.isCanvasBlankAdmin = isCanvasBlankAdmin;
    })();

    // === Toggle catatan (hanya tampil ketika "Ditolak") ===
    (function () {
        const diterima = document.getElementById('statusDiterima');
        const ditolak = document.getElementById('statusDitolak');
        const catatanBox = document.getElementById('catatanBox');
        const catatan = document.getElementById('catatan');

        function toggleCatatan() {
            if (ditolak.checked) {
                catatanBox.style.display = 'block';
                catatan.setAttribute('required', 'required');
            } else {
                catatanBox.style.display = 'none';
                catatan.removeAttribute('required');
                catatan.classList.remove('is-invalid');
            }
        }

        if (diterima && ditolak && catatanBox) {
            diterima.addEventListener('change', toggleCatatan);
            ditolak.addEventListener('change', toggleCatatan);
            // initial
            toggleCatatan();
        }
    })();

    // === FORM VALIDATION (Bootstrap style) + extra checks ===
    (function () {
        'use strict';
        const form = document.getElementById('permohonanForm');

        form.addEventListener('submit', function (event) {
            // 1) Save admin TTD; if missing -> show modal and prevent submit
            if (typeof saveAdminTTD === 'function') {
                const ok = saveAdminTTD(true);
                if (!ok) {
                    event.preventDefault();
                    event.stopPropagation();
                    // do not auto-scroll to top — modal gives feedback
                    return false;
                }
            }

            // 2) Let browser check validity (required fields, patterns)
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                // mark invalid fields (Bootstrap)
                form.classList.add('was-validated');

                // focus first invalid element (optional)
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    try { firstInvalid.focus({ preventScroll: true }); } catch(e){ firstInvalid.focus(); }
                    // scroll slightly to make it visible but avoid jumping to top; prefer smooth centered only when necessary
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return false;
            }

            // 3) If "Ditolak", ensure catatan not empty (extra check to ensure browser didn't miss it)
            const ditolak = document.getElementById('statusDitolak');
            const catatan = document.getElementById('catatan');
            if (ditolak && ditolak.checked) {
                const val = (catatan.value || '').trim();
                if (!val) {
                    event.preventDefault();
                    event.stopPropagation();
                    catatan.classList.add('is-invalid');
                    catatan.focus();
                    catatan.scrollIntoView({ behavior:'smooth', block: 'center' });
                    return false;
                }
            }

            // all good: allow submit; add visual validation class
            form.classList.add('was-validated');
        }, false);
    })();
</script>
@endsection
@extends('master')

@section('title', 'FR.APL.02 - Permohonan Sertifikasi Kompetensi')

@section('konten')
    <div class="container-fluid px-4 py-3">
        <form id="permohonanForm" action="{{ route('asesi.permohonan.storeDokumen') }}" method="POST"
            enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            <!-- Header -->
            <div class="text-center mb-4">
                <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                <h1 class="h4 fw-bold">Permohonan Sertifikasi Kompetensi</h1>
                <p class="text-muted">Form Asesmen &gt; FR.APL.02</p>
            </div>

            <!-- Data Sertifikasi -->
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Data Sertifikasi</p>
                <p class="mb-0">Pilih skema sertifikasi dan tujuan asesmen</p>
            </div>

            <div class="question-box">
                <div class="mb-3">
                    <label class="form-label">Skema Sertifikasi <span class="text-danger">*</span></label>
                    <select id="skemaSelect" name="skema_id" class="form-select" required>
                        <option value="" disabled {{ old('skema_id') ? '' : 'selected' }}>Pilih Skema Sertifikasi</option>
                        @foreach($skema as $s)
                            <option value="{{ $s->id_skema }}" {{ old('skema_id') == $s->id_skema ? 'selected' : '' }}>
                                {{ $s->nama_skema }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Silakan pilih skema sertifikasi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Sertifikasi</label>
                    <input type="text" id="judulSertifikasi" class="form-control" readonly required>
                    <div class="invalid-feedback">Judul sertifikasi wajib terisi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor Skema</label>
                    <input type="text" id="nomorSkema" class="form-control" readonly required>
                    <div class="invalid-feedback">Nomor skema wajib terisi.</div>
                </div>

                <div class="mb-0">
                    <label class="form-label">Tujuan Asesmen <span class="text-danger">*</span></label>
                    <select id="tujuanAsesmen" name="tujuan_id" class="form-select" required>
                        <option value="" disabled {{ old('tujuan_id') ? '' : 'selected' }}>Pilih Tujuan Asesmen</option>
                        @foreach($tujuanAsesmen as $t)
                            <option value="{{ $t->id_tujuan }}" {{ old('tujuan_id') == $t->id_tujuan ? 'selected' : '' }}>
                                {{ $t->nama_tujuan }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Silakan pilih tujuan asesmen.</div>
                </div>
            </div>

            <!-- Daftar Unit Kompetensi -->
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Daftar Unit Kompetensi</p>
                <p class="mb-0">Unit kompetensi yang diujikan sesuai skema</p>
            </div>
            <div class="question-box">
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
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Bukti Kelengkapan Pemohon</p>
                <p class="mb-0">Unggah dokumen yang diperlukan sesuai kategori</p>
            </div>

            {{-- === Bukti Persyaratan Dasar Pemohon === --}}
            <div class="question-box">
                <h6 class="fw-bold text-primary mb-3">A. Bukti Persyaratan Dasar Pemohon</h6>
                @foreach($jenisDokumen->where('kategori', 'dasar') as $jd)
                    <div class="mb-3">
                        <label class="form-label">{{ $loop->iteration }}. {{ $jd->nama_dokumen }} <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" name="dokumen[{{ $jd->id_jenis_dokumen }}]" class="form-control dokumen-input"
                                accept=".jpg,.jpeg,.png,.pdf" onchange="previewFile(this)" required>
                            <button type="button" class="btn btn-outline-primary" onclick="lihatFile(this)"
                                disabled>Lihat</button>
                            <button type="button" class="btn btn-outline-danger" onclick="hapusFile(this)">Hapus</button>
                            <div class="invalid-feedback">Silakan unggah dokumen ini.</div>
                        </div>
                        <div class="file-preview mt-2 text-muted small">Belum ada file dipilih</div>
                    </div>
                @endforeach
            </div>

            {{-- === Bukti Administratif === --}}
            <div class="question-box">
                <h6 class="fw-bold text-primary mb-3">B. Bukti Administratif</h6>
                @foreach($jenisDokumen->where('kategori', 'administratif') as $jd)
                    <div class="mb-3">
                        <label class="form-label">{{ $loop->iteration }}. {{ $jd->nama_dokumen }} <span
                                class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="file" name="dokumen[{{ $jd->id_jenis_dokumen }}]" class="form-control dokumen-input"
                                accept=".jpg,.jpeg,.png,.pdf" onchange="previewFile(this)" required>
                            <button type="button" class="btn btn-outline-primary" onclick="lihatFile(this)"
                                disabled>Lihat</button>
                            <button type="button" class="btn btn-outline-danger" onclick="hapusFile(this)">Hapus</button>
                            <div class="invalid-feedback">Silakan unggah dokumen ini.</div>
                        </div>
                        <div class="file-preview mt-2 text-muted small">Belum ada file dipilih</div>
                    </div>
                @endforeach
            </div>

            <!-- Tanda Tangan Asesi -->
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Tanda Tangan Asesi</p>
                <p class="mb-0">Isi nama, tanggal, dan tanda tangan digital</p>
            </div>
            <div class="question-box">
                <div class="mb-3">
                    <label for="nama-asesi" class="form-label">Nama Lengkap</label>
                    <input type="text" id="nama-asesi" class="form-control"
                        value="{{ $asesi->nama_lengkap ?? Auth::user()->name }}" readonly required>
                    <div class="invalid-feedback">Nama wajib terisi.</div>
                </div>
                <div class="mb-3">
                    <label for="tanggal-asesi" class="form-label">Tanggal</label>
                    <input type="date" id="tanggal-asesi" name="tanggal" class="form-control"
                        value="{{ old('tanggal', date('Y-m-d')) }}" required>
                    <div class="invalid-feedback">Tanggal wajib diisi.</div>
                </div>
                <div class="mb-3">
                    <label for="ttd-asesi" class="form-label">Tanda Tangan <span class="text-danger">*</span></label>
                    <div class="canvas-wrapper">
                        <canvas id="ttd-asesi"></canvas>
                        <span class="canvas-placeholder">Tanda tangan di sini</span>
                    </div>
                    <input type="hidden" name="ttd_asesi" id="ttd_asesi_data" required>
                    <div class="invalid-feedback">Tanda tangan wajib diisi.</div>
                </div>
                <div class="button-group">
                    <button type="button" class="btn-back" onclick="clearCanvas()">Hapus</button>
                </div>
            </div>

            <!-- Modal Preview -->
            <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Preview Dokumen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body text-center" id="previewContent"></div>
                    </div>
                </div>
            </div>

            <!-- Modal: TTD Required -->
            <div class="modal fade" id="ttdRequiredModal" tabindex="-1" aria-labelledby="ttdRequiredModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-danger">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title" id="ttdRequiredModalLabel">Tanda Tangan Diperlukan</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-0">Silakan tanda tangan pada area tanda tangan sebelum melanjutkan.</p>
                            <p class="small text-muted mt-2">Tekan <strong>Hapus</strong> jika ingin mulai ulang, lalu tanda tangan ulang.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="button-group mt-4">
                <a href="{{ route('asesi.permohonan.form1') }}" class="btn-back">Kembali</a>
                <button type="submit" class="btn-next">Simpan dan Kirim</button>
            </div>
        </form>
    </div>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9fb;
        }

        .container-fluid {
            width: 100%;
        }

        .unit-header {
            background: #E9F1FF;
            border-left: 6px solid #007BFF;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .question-box {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            background: #fff;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border: 2px solid #d9534f !important;
            background: #fff8f8 !important;
        }

        .invalid-feedback {
            font-size: 12px;
        }

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

        .btn-back:hover {
            background: #c9302c;
        }

        .btn-next:hover {
            background: #06208a;
        }

        .canvas-wrapper {
            position: relative;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        #ttd-asesi {
            display: block;
            width: 100%;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 6px;
            background-color: #fff;
            cursor: crosshair;
        }

        .canvas-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #aaa;
            font-size: 14px;
            pointer-events: none;
        }

        .file-preview {
            font-size: 13px;
        }

        .modal-body img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .modal-body iframe {
            width: 100%;
            height: 600px;
            border: none;
        }

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

        .unit-header p.mb-0 {
            font-size: 0.95rem;
            color: #334155;
            margin-top: 4px;
            font-weight: 500;
        }

        label.form-label {
            font-weight: 600;
            font-size: 0.95rem;
            color: #0f172a;
        }

        .question-box .mb-3 {
            margin-bottom: 14px;
        }

        @media (max-width: 576px) {
            .unit-header {
                font-size: 1rem;
            }

            label.form-label {
                font-size: 0.9rem;
            }
        }
    </style>

    {{-- === SCRIPT Bukti Kelengkapan === --}}
    <script>
        function previewFile(input) {
            const file = input.files[0];
            const previewDiv = input.closest('.mb-3').querySelector('.file-preview');
            const lihatBtn = input.closest('.input-group').querySelector('button.btn-outline-primary');
            if (file) {
                previewDiv.textContent = `File dipilih: ${file.name}`;
                lihatBtn.disabled = false;
            } else {
                previewDiv.textContent = "Belum ada file dipilih";
                lihatBtn.disabled = true;
            }
        }
        function lihatFile(btn) {
            const input = btn.closest('.input-group').querySelector('input[type="file"]');
            const file = input.files[0]; if (!file) return;
            const reader = new FileReader();
            reader.onload = function (e) {
                const modalBody = document.getElementById('previewContent');
                modalBody.innerHTML = "";
                if (file.type === "application/pdf") {
                    modalBody.innerHTML = `<iframe src="${e.target.result}"></iframe>`;
                } else if (file.type.startsWith("image/")) {
                    modalBody.innerHTML = `<img src="${e.target.result}" alt="Preview Gambar">`;
                } else {
                    modalBody.innerHTML = `<p>Tipe file tidak didukung untuk preview</p>`;
                }
                new bootstrap.Modal(document.getElementById('previewModal')).show();
            };
            reader.readAsDataURL(file);
        }
        function hapusFile(btn) {
            const input = btn.closest('.input-group').querySelector('input[type="file"]');
            const lihatBtn = btn.closest('.input-group').querySelector('button.btn-outline-primary');
            const previewDiv = btn.closest('.mb-3').querySelector('.file-preview');
            input.value = "";
            previewDiv.textContent = "Belum ada file dipilih";
            lihatBtn.disabled = true;
        }
    </script>

    <script>
        (function () {
            'use strict'
            const form = document.getElementById('permohonanForm')
            form.addEventListener('submit', function (event) {
                if (!saveTTD()) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    const firstInvalid = form.querySelector(':invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                }
                form.classList.add('was-validated')
            }, false)
        })()

        // === SKEMA AJAX LOADER ===
        document.getElementById('skemaSelect').addEventListener('change', function () {
            let id = this.value;
            if (!id) return;
            let url = "{{ route('get.skema', ':id') }}".replace(':id', id);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('judulSertifikasi').value = data.skema.judul_skema ?? data.skema.nama_skema;
                    document.getElementById('nomorSkema').value = data.skema.kode_skema ?? '';
                    let tbody = document.getElementById('unitTable');
                    tbody.innerHTML = '';
                    if (data.units && data.units.length > 0) {
                        data.units.forEach((u, i) => {
                            tbody.innerHTML += `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>${u.kode_unit ?? '-'}</td>
                                    <td>${u.judul_unit ?? '-'}</td>
                                    <td>${u.standar_kompetensi ?? '-'}</td>
                                </tr>`;
                        });
                    } else {
                        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Tidak ada unit kompetensi</td></tr>`;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data skema');
                });
        });

        // === TTD Canvas (responsive, high-DPI aware, blank-detection using white background) ===
        const canvas = document.getElementById("ttd-asesi");
        const ctx = canvas.getContext("2d");
        const placeholder = document.querySelector(".canvas-placeholder");
        let drawing = false;
        let blankDataURL = null;   // akan berisi dataURL canvas saat hanya background putih
        const VISIBLE_HEIGHT = 200; // px, sesuai CSS height

        function resizeCanvasAndPrepareBlank() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            blankDataURL = canvas.toDataURL();
        }

        function getPointerPos(evt) {
            const rect = canvas.getBoundingClientRect();
            let clientX, clientY;
            if (evt.touches && evt.touches.length > 0) {
                clientX = evt.touches[0].clientX;
                clientY = evt.touches[0].clientY;
            } else {
                clientX = evt.clientX;
                clientY = evt.clientY;
            }
            const x = clientX - rect.left;
            const y = clientY - rect.top;
            return { x, y };
        }

        function startDrawing(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPos(evt);
            ctx.beginPath();
            ctx.lineWidth = 2;
            ctx.lineCap = "round";
            ctx.strokeStyle = "#000";
            ctx.moveTo(pos.x, pos.y);
            placeholder.style.display = "none";
        }
        function drawMove(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPos(evt);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
        function stopDrawing(evt) {
            if (!drawing) return;
            evt.preventDefault();
            drawing = false;
            ctx.beginPath();
        }

        function clearCanvas() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            blankDataURL = canvas.toDataURL();
            document.getElementById("ttd_asesi_data").value = "";
            placeholder.style.display = "block";
        }

        function isCanvasBlank() {
            return canvas.toDataURL() === blankDataURL;
        }

        function saveTTD() {
            if (isCanvasBlank()) {
                // Show modal (instead of alert)
                const modalEl = document.getElementById('ttdRequiredModal');
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                } else {
                    // fallback
                    alert("Silakan tanda tangan terlebih dahulu sebelum lanjut.");
                }
                return false;
            }
            document.getElementById("ttd_asesi_data").value = canvas.toDataURL("image/png");
            return true;
        }

        function attachCanvasEvents() {
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', drawMove);
            window.addEventListener('mouseup', stopDrawing);

            canvas.addEventListener('touchstart', startDrawing, { passive: false });
            canvas.addEventListener('touchmove', drawMove, { passive: false });
            window.addEventListener('touchend', stopDrawing);
        }

        window.addEventListener('resize', function () {
            const prevData = canvas.toDataURL();
            resizeCanvasAndPrepareBlank();

            if (prevData && prevData !== blankDataURL) {
                const img = new Image();
                img.onload = function () {
                    ctx.drawImage(img, 0, 0, canvas.clientWidth, VISIBLE_HEIGHT);
                };
                img.src = prevData;
            }
        });

        resizeCanvasAndPrepareBlank();
        attachCanvasEvents();

    </script>
@endsection
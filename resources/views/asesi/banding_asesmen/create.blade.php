@extends('master')

@section('title', 'FR.AK.04 - Ajukan Banding Asesmen')

@section('konten')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
            </svg>
        </div>
        <h1 class="display-6 fw-bold text-dark">Ajukan Banding Asesmen</h1>
        <p class="text-secondary">FR.AK.04 – Isi form banding dan tanda tangan</p>
    </div>

    <!-- Informasi Skema dan Asesor (Read-only) -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle text-primary" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Informasi Sertifikasi</h5>
                    <p class="text-secondary mb-0 small">Data skema dan asesor terkait banding</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted">Skema Sertifikasi</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $permohonan->skema->nama_skema ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Nomor Skema</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $permohonan->skema->kode_skema ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Nama Asesor</label>
                    <p class="fw-semibold border p-2 rounded bg-light">
                        {{ $permohonan->asesi->asesor->user->name ?? $permohonan->asesi->asesor->nama_asesor ?? '-' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Banding -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square text-primary" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Form Banding</h5>
                    <p class="text-secondary mb-0 small">Jawab pertanyaan dan tanda tangan</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <form method="POST" action="{{ route('asesi.banding_asesmen.store') }}" id="bandingForm">
                @csrf
                <input type="hidden" name="id_permohonan" value="{{ $permohonan->id_permohonan }}">

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Asesmen <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_asesmen" class="form-control @error('tgl_asesmen') is-invalid @enderror" value="{{ old('tgl_asesmen') }}" required>
                        @error('tgl_asesmen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">1. Apakah Proses Banding telah dijelaskan kepada Anda? <span class="text-danger">*</span></label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="banding_dijelaskan" id="dijelaskanYa" value="Ya" {{ old('banding_dijelaskan') == 'Ya' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="dijelaskanYa">Ya</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="banding_dijelaskan" id="dijelaskanTidak" value="Tidak" {{ old('banding_dijelaskan') == 'Tidak' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="dijelaskanTidak">Tidak</label>
                        </div>
                    </div>
                    @error('banding_dijelaskan') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">2. Apakah Anda telah mendiskusikan Banding dengan Asesor? <span class="text-danger">*</span></label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diskusi_dengan_asesor" id="diskusiYa" value="Ya" {{ old('diskusi_dengan_asesor') == 'Ya' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="diskusiYa">Ya</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="diskusi_dengan_asesor" id="diskusiTidak" value="Tidak" {{ old('diskusi_dengan_asesor') == 'Tidak' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="diskusiTidak">Tidak</label>
                        </div>
                    </div>
                    @error('diskusi_dengan_asesor') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">3. Apakah Anda mau melibatkan "orang lain" membantu Anda dalam Proses Banding? <span class="text-danger">*</span></label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="libatkan_orang_lain" id="libatkanYa" value="Ya" {{ old('libatkan_orang_lain') == 'Ya' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="libatkanYa">Ya</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="libatkan_orang_lain" id="libatkanTidak" value="Tidak" {{ old('libatkan_orang_lain') == 'Tidak' ? 'checked' : '' }} required>
                            <label class="form-check-label" for="libatkanTidak">Tidak</label>
                        </div>
                    </div>
                    @error('libatkan_orang_lain') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Alasan Banding <span class="text-danger">*</span></label>
                    <textarea name="alasan_banding" rows="4" class="form-control @error('alasan_banding') is-invalid @enderror" placeholder="Jelaskan alasan Anda mengajukan banding secara lengkap..." required>{{ old('alasan_banding') }}</textarea>
                    @error('alasan_banding') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <!-- Bagian Tanda Tangan -->
                <div class="card border-0 shadow-sm mb-4 mt-4">
                    <div class="card-header bg-white border-0 pt-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pen text-primary" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                                </svg>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0">Tanda Tangan Asesi</h5>
                                <p class="text-secondary mb-0 small">Setujui dan tanda tangan di bawah ini</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="setuju" value="1" id="setujuCheckbox" required>
                                    <label class="form-check-label fw-semibold" for="setujuCheckbox">
                                        Saya menyetujui bahwa informasi yang saya berikan adalah benar dan saya mengajukan banding ini dengan kesadaran sendiri.
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Tanda Tangan</label>
                                <input type="date" name="tgl_ttd_asesi" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="canvas-wrapper mb-2">
                                    <canvas id="ttd-asesi" class="ttd-canvas" width="400" height="160"></canvas>
                                    <span class="canvas-placeholder">Tanda tangan di sini</span>
                                </div>
                                <input type="hidden" name="ttd_asesi" id="ttd-asesi-input" required>
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-3">
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCanvas()">Hapus</button>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info bg-light border-0 rounded-4">
                    <div class="d-flex">
                        <div class="me-3">
                            <i class="bi bi-info-circle-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <p class="mb-0">Anda mempunyai hak mengajukan banding jika Anda menilai Proses Asesmen tidak sesuai SOP dan tidak memenuhi Prinsip Asesmen.</p>
                        </div>
                    </div>
                </div>

                <div class="button-group mt-4">
                    <a href="{{ route('form_pra_assesmen') }}" class="btn-back">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="btn-next" id="submitBtn" disabled>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send me-2" viewBox="0 0 16 16">
                            <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                        </svg>
                        Ajukan Banding
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
    :root {
        --primary: #0b2f7c;
        --primary-dark: #08205c;
        --primary-light: #1a3e9c;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #212529;
        --font-sans: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    body {
        font-family: var(--font-sans);
        background-color: #f1f4f9;
    }

    .container-fluid {
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ===== FORM CARD & INPUT ===== */
    .card {
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .card:hover {
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.08) !important;
    }

    .card-header {
        background: transparent;
        padding-bottom: 0;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 0.3rem;
    }

    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
        outline: none;
    }

    .form-control:read-only {
        background-color: #f8f9fa;
    }

    /* ===== WARNA UTAMA #0b2f7c ===== */
    .bg-primary {
        background-color: var(--primary) !important;
    }

    .bg-primary.bg-gradient {
        background: linear-gradient(145deg, var(--primary), var(--primary-dark)) !important;
    }

    .bg-primary.bg-opacity-10 {
        background-color: rgba(11,47,124,0.1) !important;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    .border-primary {
        border-color: var(--primary) !important;
    }

    /* Tombol Next & Back */
    .btn-next {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(11,47,124,0.3);
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-next:hover {
        background: linear-gradient(135deg, var(--primary-dark), #061944);
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(11,47,124,0.35);
        color: #fff;
    }

    .btn-back {
        background-color: #fff;
        color: var(--secondary);
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border: 1.5px solid #dee2e6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background-color: #f1f3f5;
        color: #495057;
        border-color: #ced4da;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
    }

    /* Canvas wrapper */
    .canvas-wrapper {
        position: relative;
        width: 100%;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        border: 2px dashed #d0d9e8;
    }

    .ttd-canvas {
        display: block;
        width: 100%;
        height: 160px;
        background: #ffffff;
        cursor: crosshair;
        touch-action: none;
    }

    .canvas-placeholder {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        color: #9aa9b9;
        font-size: 0.9rem;
        background: rgba(255,255,255,0.7);
        padding: 4px 12px;
        border-radius: 40px;
        pointer-events: none;
        backdrop-filter: blur(2px);
    }

    .btn-outline-danger {
        border-width: 1.5px;
        border-radius: 2rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-outline-danger:hover {
        background-color: var(--danger);
        color: white;
    }

    @media (max-width: 768px) {
        .button-group {
            justify-content: center;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('ttd-asesi');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let drawing = false;
        const VISIBLE_HEIGHT = 160;

        function resizeCanvas() {
            const container = canvas.parentElement;
            const cssWidth = container.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';
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
            return {
                x: (clientX - rect.left) * (canvas.width / rect.width),
                y: (clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDrawing(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPos(evt);
            ctx.beginPath();
            ctx.moveTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
        }

        function drawMove(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPos(evt);
            ctx.lineTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
            ctx.stroke();
        }

        function stopDrawing() {
            drawing = false;
            ctx.beginPath();
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', drawMove);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', drawMove, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        const setujuCheckbox = document.getElementById('setujuCheckbox');
        const submitBtn = document.getElementById('submitBtn');
        const ttdInput = document.getElementById('ttd-asesi-input');

        function isCanvasBlank() {
            const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            for (let i = 0; i < pixelData.length; i += 4) {
                if (pixelData[i] !== 255 || pixelData[i+1] !== 255 || pixelData[i+2] !== 255) {
                    return false;
                }
            }
            return true;
        }

        function toggleSubmit() {
            if (setujuCheckbox && submitBtn) {
                submitBtn.disabled = !(setujuCheckbox.checked && !isCanvasBlank());
            }
        }

        setujuCheckbox.addEventListener('change', toggleSubmit);
        canvas.addEventListener('mouseup', toggleSubmit);
        canvas.addEventListener('touchend', toggleSubmit);

        window.clearCanvas = function() {
            const container = canvas.parentElement;
            const cssWidth = container.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);
            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(ratio, ratio);
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);
            ttdInput.value = '';
            toggleSubmit();
        };

        const form = document.getElementById('bandingForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                if (!setujuCheckbox.checked) {
                    e.preventDefault();
                    alert('Anda harus menyetujui pernyataan.');
                    return;
                }
                if (isCanvasBlank()) {
                    e.preventDefault();
                    alert('Tanda tangan harus diisi.');
                    return;
                }
                ttdInput.value = canvas.toDataURL('image/png');
            });
        }
    });
</script>
@endsection
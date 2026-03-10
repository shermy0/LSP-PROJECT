@extends('master')

@section('title', 'Tanda Tangan Asesi')

@section('konten')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header dengan ikon dan judul (warna #0b2f7c) -->
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                    </svg>
                </div>
                <h1 class="display-6 fw-bold text-dark">Tanda Tangan Asesi</h1>
                <p class="text-secondary">Form Asesmen FR.APL.02 – Konfirmasi akhir asesmen mandiri</p>
            </div>

            <!-- Card Tanda Tangan Asesi -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-check text-primary" viewBox="0 0 16 16">
                                <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514zM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                                <path d="M8.256 14a4.474 4.474 0 0 1-.229-1.004H3c.001-.246.154-.986.832-1.664C4.484 10.68 5.711 10 8 10c.26 0 .507.009.74.025.226-.341.496-.65.804-.918C9.077 9.038 8.564 9 8 9c-5 0-6 3-6 4s1 1 1 1h5.256z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Tanda Tangan Asesi</h5>
                            <p class="text-secondary mb-0 small">Konfirmasi akhir asesmen mandiri dengan tanda tangan digital</p>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-3">
                    <form id="ttd-form" method="POST" action="{{ route('asesi.asesmen_mandiri.ttd.store') }}">
                        @csrf

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_asesi" id="nama-asesi" class="form-control"
                                       value="{{ Auth::user()->name }}" readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="tgl_ttd_asesi" id="tanggal-asesi" class="form-control"
                                       value="{{ date('Y-m-d') }}" readonly>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Tanda Tangan <span class="text-danger">*</span></label>
                                <div class="canvas-wrapper">
                                    <canvas id="ttd-asesi" class="ttd-canvas"
                                            width="400" height="200"></canvas>
                                    <span class="canvas-placeholder">Tanda tangan di sini</span>
                                </div>
                                <input type="hidden" name="ttd_asesi" id="ttd-asesi-input" required>
                                <div class="invalid-feedback">Tanda tangan wajib diisi.</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="clearCanvas('ttd-asesi')">
                                <i class="bi bi-eraser me-1"></i>Hapus
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tombol navigasi -->
            <div class="button-group mt-4">
                <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali
                </a>
                <button type="submit" class="btn-next" form="ttd-form" onclick="saveTTD()">
                    Simpan dan Kirim
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send ms-2" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                    </svg>
                </button>
            </div>
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

    /* ===== CARD STYLE ===== */
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

    /* ===== FORM ELEMENTS ===== */
    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 0.3rem;
    }

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background-color: #fff;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
        outline: none;
    }

    .form-control:read-only {
        background-color: #f8f9fa;
    }

    /* ===== CANVAS ===== */
    .canvas-wrapper {
        position: relative;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        border: 2px dashed #d0d9e8;
    }

    .ttd-canvas {
        display: block;
        width: 100%;
        height: 200px;
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

    /* ===== BUTTONS ===== */
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

    .btn-outline-danger {
        border: 1.5px solid var(--danger);
        color: var(--danger);
        background: transparent;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-outline-danger:hover {
        background-color: var(--danger);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220,53,69,0.3);
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .button-group {
            justify-content: center;
        }
        .canvas-placeholder {
            font-size: 0.8rem;
            padding: 2px 8px;
        }
    }
</style>

<script>
// Inisialisasi canvas tanda tangan
function initSignature(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    let drawing = false;

    // Set canvas ukuran sebenarnya (CSS sudah mengatur width, tapi untuk koordinat mouse)
    function resizeCanvas() {
        const container = canvas.parentElement;
        const cssWidth = container.clientWidth;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = cssWidth * ratio;
        canvas.height = 200 * ratio;
        ctx.setTransform(1,0,0,1,0,0);
        ctx.scale(ratio, ratio);
        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';
    }

    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    // Event listeners
    canvas.addEventListener('mousedown', (e) => {
        e.preventDefault();
        drawing = true;
        const rect = canvas.getBoundingClientRect();
        const x = (e.clientX - rect.left) * (canvas.width / rect.width);
        const y = (e.clientY - rect.top) * (canvas.height / rect.height);
        ctx.beginPath();
        ctx.moveTo(x / (canvas.width / rect.width), y / (canvas.height / rect.height));
    });

    canvas.addEventListener('mousemove', (e) => {
        if (!drawing) return;
        e.preventDefault();
        const rect = canvas.getBoundingClientRect();
        const x = (e.clientX - rect.left) * (canvas.width / rect.width);
        const y = (e.clientY - rect.top) * (canvas.height / rect.height);
        ctx.lineTo(x / (canvas.width / rect.width), y / (canvas.height / rect.height));
        ctx.stroke();
    });

    canvas.addEventListener('mouseup', () => drawing = false);
    canvas.addEventListener('mouseleave', () => drawing = false);

    // Touch events
    canvas.addEventListener('touchstart', (e) => {
        e.preventDefault();
        drawing = true;
        const rect = canvas.getBoundingClientRect();
        const touch = e.touches[0];
        const x = (touch.clientX - rect.left) * (canvas.width / rect.width);
        const y = (touch.clientY - rect.top) * (canvas.height / rect.height);
        ctx.beginPath();
        ctx.moveTo(x / (canvas.width / rect.width), y / (canvas.height / rect.height));
    }, { passive: false });

    canvas.addEventListener('touchmove', (e) => {
        if (!drawing) return;
        e.preventDefault();
        const rect = canvas.getBoundingClientRect();
        const touch = e.touches[0];
        const x = (touch.clientX - rect.left) * (canvas.width / rect.width);
        const y = (touch.clientY - rect.top) * (canvas.height / rect.height);
        ctx.lineTo(x / (canvas.width / rect.width), y / (canvas.height / rect.height));
        ctx.stroke();
    }, { passive: false });

    canvas.addEventListener('touchend', () => drawing = false);
}

// Clear canvas
function clearCanvas(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    // Hapus hidden input value juga
    document.getElementById('ttd-asesi-input').value = '';
}

// Simpan base64 ke input hidden sebelum submit
function saveTTD() {
    const canvas = document.getElementById("ttd-asesi");
    const dataURL = canvas.toDataURL("image/png");
    document.getElementById("ttd-asesi-input").value = dataURL;
}

// Inisialisasi saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    initSignature("ttd-asesi");
});

// Validasi form sebelum submit (wajib tanda tangan)
document.getElementById('ttd-form').addEventListener('submit', function(e) {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    // Cek apakah canvas kosong (misal dengan mengambil pixel data)
    const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
    let isBlank = true;
    for (let i = 0; i < pixelData.length; i += 4) {
        // Jika ada pixel bukan putih (nilai < 255) berarti ada coretan
        if (pixelData[i] < 255 || pixelData[i+1] < 255 || pixelData[i+2] < 255) {
            isBlank = false;
            break;
        }
    }
    if (isBlank) {
        e.preventDefault();
        alert('Silakan isi tanda tangan terlebih dahulu.');
        return false;
    }
    saveTTD();
});
</script>
@endsection

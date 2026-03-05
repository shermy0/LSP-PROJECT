@extends('master')

@section('konten')
<div class="container mt-4">
    <div class="card shadow border-0 rounded-4">
        <div class=" text-white rounded-top-4">
        </div>
        <div class="card-body p-4">
            {{-- ===== Form Tanda Tangan Asesmen Lisan ===== --}}
            <div class="mb-4">
                <h5 class="fw-bold text-primary mb-3">Form Tanda Tangan Asesmen Lisan</h5>
                <table class="table table-bordered">
                    <tr><th>Nama Lengkap</th><td>{{ $asesi->nama_lengkap }}</td></tr>
                    <tr><th>Skema Sertifikasi</th><td>{{ $skema->nama_skema }}</td></tr>
                    <tr><th>Jenis Asesmen</th><td>Lisan</td></tr>
                </table>
            </div>

            {{-- ===== FORM TANDA TANGAN ===== --}}
            <form method="POST" action="{{ route('jawaban.store') }}" id="formTtd" onsubmit="return validateAndSaveSignature()">
                @csrf
                <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
                <input type="hidden" name="jenis" value="lisan">
                <input type="hidden" name="tgl_ttd_asesi" id="tgl_ttd_asesi" value="{{ now()->toDateString() }}">
                <input type="hidden" name="ttd_asesi" id="ttd_asesi">

                <div id="signature-section" class="mt-5 border rounded p-4 bg-light">
                    <h5 class="fw-bold text-primary mb-3">Tanda Tangan Asesi</h5>

                    <div class="card">
                        <div class="card-title">Asesi</div>

                        <div class="mb-2">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{ $asesi->nama_lengkap }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label>Tanggal</label>
                            <input type="date" id="tanggal-asesi" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label>Tanda Tangan</label>
                            <canvas id="ttd-asesi" width="400" height="150"></canvas>
                        </div>

                        <div class="btns">
                            <button type="button" class="btn btn-danger clear" onclick="clearCanvas()">
                                <i class="bi bi-eraser me-1"></i> Hapus
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Kirim Tanda Tangan
                        </button>
                        <button type="button" class="btn btn-secondary ms-2" id="backToQuestionsBtn" onclick="window.history.back()">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===== SCRIPTS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Inisialisasi canvas (sama seperti format pada kode kedua)
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');

    // Pastikan background putih supaya pengecekan blank konsisten
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);

    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';

    let isDrawing = false;
    let lastX = 0;
    let lastY = 0;

    function getPosFromEvent(e, canvasEl) {
        const rect = canvasEl.getBoundingClientRect();
        if (e.touches && e.touches.length > 0) {
            return {
                x: e.touches[0].clientX - rect.left,
                y: e.touches[0].clientY - rect.top
            };
        } else {
            return {
                x: e.clientX - rect.left,
                y: e.clientY - rect.top
            };
        }
    }

    function startDrawing(e) {
        e.preventDefault();
        const pos = getPosFromEvent(e, canvas);
        isDrawing = true;
        lastX = pos.x;
        lastY = pos.y;
    }

    function draw(e) {
        if (!isDrawing) return;
        e.preventDefault();
        const pos = getPosFromEvent(e, canvas);
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(pos.x, pos.y);
        ctx.stroke();
        lastX = pos.x;
        lastY = pos.y;
    }

    function stopDrawing(e) {
        if (!isDrawing) return;
        e && e.preventDefault();
        isDrawing = false;
    }

    // Desktop events
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Mobile events (touch)
    canvas.addEventListener('touchstart', startDrawing, { passive: false });
    canvas.addEventListener('touchmove', draw, { passive: false });
    canvas.addEventListener('touchend', stopDrawing, { passive: false });

    // Clear canvas
    window.clearCanvas = function() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = '#ffffff';
        ctx.fillRect(0, 0, canvas.width, canvas.height);
    };

    // Cek canvas kosong (bandingkan pixel)
    function isCanvasBlank(canvasEl) {
        const blank = document.createElement('canvas');
        blank.width = canvasEl.width;
        blank.height = canvasEl.height;
        const bctx = blank.getContext('2d');
        bctx.fillStyle = '#ffffff';
        bctx.fillRect(0, 0, blank.width, blank.height);
        return canvasEl.toDataURL() === blank.toDataURL();
    }

    // Simpan tanda tangan ke input hidden sebelum submit
    window.saveSignature = function() {
        const hidden = document.getElementById('ttd_asesi');
        if (!isCanvasBlank(canvas)) {
            hidden.value = canvas.toDataURL('image/png');
            // tanggal juga
            document.getElementById('tgl_ttd_asesi').value = document.getElementById('tanggal-asesi').value;
        } else {
            hidden.value = ''; // jangan kirim data kosong
        }
    };

    // Validasi saat submit (cek ttd terisi)
    window.validateAndSaveSignature = function() {
        if (isCanvasBlank(canvas)) {
            Swal.fire({
                icon: 'warning',
                title: 'Tanda Tangan Belum Diisi!',
                text: 'Silakan isi tanda tangan sebelum mengirim.',
                confirmButtonColor: '#0d6efd'
            });
            return false;
        }

        // jika sudah ada goyangkan simpan data
        saveSignature();
        return true;
    };
});
</script>

{{-- Style (menyamakan style dengan kode kedua) --}}
<style>
.card{background:#fff;border:1px solid #ddd;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.08);padding:25px;max-width:700px;margin:20px auto;}
.card-title{font-weight:bold;margin-bottom:15px;font-size:1.1rem;color:#333;border-bottom:1px solid #eee;padding-bottom:10px;}
.card canvas{border:1px solid #999;border-radius:6px;width:100%;height:150px;background-color:#fff;cursor:crosshair;}
.btns{display:flex;justify-content:flex-end;gap:10px;}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.querySelector(".toggle-btn");

    // Sembunyikan sidebar dan tombolnya di halaman lembar jawaban
    if (sidebar) {
        sidebar.style.display = "none";
    }
    if (toggleBtn) {
        toggleBtn.style.display = "none";
    }

    // Biar area konten penuh layar
    const mainContent = document.getElementById("main-content");
    if (mainContent) {
        mainContent.style.marginLeft = "0";
        mainContent.style.width = "100%";
    }
});
</script>
@endpush
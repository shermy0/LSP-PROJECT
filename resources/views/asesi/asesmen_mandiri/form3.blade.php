@extends('master')

@section('title', 'Tanda Tangan Asesi')

@section('konten')
<div class="container my-5">
    <div class="ttd-container">
        <div class="ttd-header">Tanda Tangan Asesi</div>
        <div class="ttd-card">
            <div class="ttd-card-title">Asesi</div>

            <form id="ttd-form" method="POST" action="{{ route('asesi.asesmen_mandiri.ttd.store') }}">
                @csrf

                <label for="nama-asesi" class="ttd-label">Nama Lengkap</label>
                <input type="text" name="nama_asesi" id="nama-asesi" class="ttd-input"
                       value="{{ Auth::user()->name }}" readonly>

                <label for="tanggal-asesi" class="ttd-label">Tanggal</label>
                <!-- tanggal dibuat readonly -->
                <input type="date" name="tgl_ttd_asesi" id="tanggal-asesi" class="ttd-input"
                       value="{{ date('Y-m-d') }}" readonly>

                <label for="ttd-asesi" class="ttd-label">Tanda Tangan</label>
                <canvas id="ttd-asesi" class="ttd-canvas"
                        width="400" height="200"></canvas>

                <!-- Hidden input untuk simpan base64 -->
                <input type="hidden" name="ttd_asesi" id="ttd-asesi-input">

                <div class="ttd-btns mt-3">
                    <button type="button" class="btn-clear"
                            onclick="clearCanvas('ttd-asesi')">Hapus</button>
                    <button type="button" class="btn-download"
                            onclick="downloadTTD()">Unduh</button>
                </div>
            </form>
        </div>
    </div>

    <div class="action-buttons mt-4">
        <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-back">Kembali</a>
        <button type="submit" class="btn-submit" form="ttd-form" onclick="saveTTD()">Simpan & Kirim</button>
    </div>
</div>

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f9f9fb;
    }
    .container {
        max-width: 850px;
    }

    .ttd-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        padding: 25px;
    }
    .ttd-header {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        color: #041562;
    }
    .ttd-card-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 15px;
        color: #333;
    }

    /* Label & Input */
    .ttd-label {
        font-weight: 500;
        font-size: 14px;
        margin-top: 10px;
        display: block;
        color: #333;
    }
    .ttd-input {
        width: 100%;
        padding: 10px 12px;
        margin-top: 5px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        background: #f9f9f9;
    }
    .ttd-input:focus {
        outline: none;
        border-color: #041562;
        background: #fff;
    }

    /* Canvas */
    .ttd-canvas {
        border: 2px dashed #ccc;
        border-radius: 8px;
        background: #fff;
        cursor: crosshair;
        display: block;
        margin-top: 8px;
    }

    /* Buttons */
    .ttd-btns {
        display: flex;
        gap: 10px;
    }
    .btn-clear, .btn-download, .btn-back, .btn-submit {
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        border: none;
        cursor: pointer;
        color: #fff;
    }
    .btn-clear { background: #d9534f; }
    .btn-clear:hover { background: #c9302c; }
    .btn-download { background: #17a2b8; }
    .btn-download:hover { background: #117a8b; }
    .btn-back { background: #6c757d; text-decoration: none; line-height: 36px; }
    .btn-back:hover { background: #5a6268; }
    .btn-submit { background: #041562; }
    .btn-submit:hover { background: #06208a; }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
    }
</style>

<script>
function initSignature(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    let drawing = false;

    canvas.addEventListener("mousedown", (e) => {
        drawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener("mousemove", (e) => {
        if (drawing) {
            ctx.lineTo(e.offsetX, e.offsetY);
            ctx.strokeStyle = "#000000"; // warna hitam
            ctx.lineWidth = 2;
            ctx.stroke();
        }
    });

    canvas.addEventListener("mouseup", () => drawing = false);
    canvas.addEventListener("mouseleave", () => drawing = false);
}

// clear canvas
function clearCanvas(canvasId) {
    const canvas = document.getElementById(canvasId);
    const ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, canvas.width, canvas.height);
}

// simpan base64 ke input hidden sebelum submit
function saveTTD() {
    const canvas = document.getElementById("ttd-asesi");
    const dataURL = canvas.toDataURL("image/png");
    document.getElementById("ttd-asesi-input").value = dataURL;
}

// unduh tanda tangan
function downloadTTD() {
    const canvas = document.getElementById("ttd-asesi");
    const link = document.createElement("a");
    link.download = "tanda_tangan_asesi.png";
    link.href = canvas.toDataURL("image/png");
    link.click();
}

window.onload = function () {
    initSignature("ttd-asesi");
};
</script>
@endsection

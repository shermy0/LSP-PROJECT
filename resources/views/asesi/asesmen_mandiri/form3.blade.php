@extends('layouts.master')

@section('title', 'Tanda Tangan Asesi')

@section('content')
<div class="container my-5">
    <div class="ttd-container">
        <div class="ttd-header">Tanda Tangan Asesi</div>
        <div class="ttd-card">
            <div class="ttd-card-title">Asesi</div>

            <!-- Tambahkan id untuk form -->
            <form id="ttd-form" method="POST" action="{{ route('asesi.asesmen_mandiri.ttd.store') }}">
                @csrf

                <label for="nama-asesi" class="ttd-label">Nama Lengkap</label>
                <input type="text" name="nama_asesi" id="nama-asesi" class="ttd-input"
                       value="{{ Auth::user()->name }}" readonly>

                <label for="tanggal-asesi" class="ttd-label">Tanggal</label>
                <input type="date" name="tgl_ttd_asesi" id="tanggal-asesi" class="ttd-input"
                       value="{{ date('Y-m-d') }}">

                <label for="ttd-asesi" class="ttd-label">Tanda Tangan</label>
                <canvas id="ttd-asesi" class="ttd-canvas"
                        width="400" height="200" style="border:1px solid #ccc;"></canvas>

                <!-- Hidden input untuk simpan base64 -->
                <input type="hidden" name="ttd_asesi" id="ttd-asesi-input">

                <div class="ttd-btns mt-3">
                    <button type="button" class="ttd-btn ttd-clear"
                            onclick="clearCanvas('ttd-asesi')">Hapus</button>

                    <!-- Tombol unduh di dalam form -->
                    <button type="button" class="ttd-btn ttd-download"
                            onclick="downloadTTD()">Unduh</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tombol Aksi di bawah form -->
    <div class="action-buttons mt-4 text-end">
        <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-back">Kembali</a>
        <!-- Submit ke form dengan id ttd-form -->
        <button type="submit" class="btn-submit" form="ttd-form" onclick="saveTTD()">Simpan & Kirim</button>
    </div>
</div>

<style>
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}
.btn-back, .ttd-btn, .btn-submit {
    padding: 10px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    color: #fff;
    border: none;
    cursor: pointer;
}
.btn-back { background-color: #6c757d; }
.ttd-clear { background-color: #dc3545; }
.ttd-download { background-color: #17a2b8; } /* biru muda */
.btn-submit { background-color: #007bff; }   /* biru utama */
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

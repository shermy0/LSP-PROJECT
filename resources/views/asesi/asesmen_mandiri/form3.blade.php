@extends('master')

@section('title', 'Tanda Tangan Asesi')

@section('konten')
<div class="container my-5">
    <div class="ttd-container">
        <div class="ttd-header">Tanda Tangan Asesi</div>
        <div class="ttd-card">
            <div class="ttd-card-title">Asesi</div>
            <form>
                <label for="nama-asesi" class="ttd-label">Nama Lengkap</label>
                <input type="text" id="nama-asesi" class="ttd-input" placeholder="Masukkan nama lengkap asesi">

                <label for="tanggal-asesi" class="ttd-label">Tanggal</label>
                <input type="date" id="tanggal-asesi" class="ttd-input">

                <label for="ttd-asesi" class="ttd-label">Tanda Tangan</label>
                <canvas id="ttd-asesi" class="ttd-canvas" width="400" height="200" style="border:1px solid #ccc;"></canvas>

                <div class="ttd-btns mt-3">
                    <button type="button" class="ttd-btn ttd-clear" onclick="clearCanvas('ttd-asesi')">Hapus</button>
                    <button type="button" class="ttd-btn ttd-download" onclick="downloadTTD('ttd-asesi','nama-asesi','tanggal-asesi')">Unduh</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tombol Aksi di bawah form -->
    <div class="action-buttons mt-4 text-end">
        <a href="{{ route('asesi.asesmen_mandiri.form2') }}" class="btn-back">Kembali</a>
        <button type="submit" class="btn-submit">Simpan & Kirim</button>
    </div>
</div>

<style>
.action-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-back, .btn-submit {
    padding: 10px 18px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    color: #fff;
    border: none;
    cursor: pointer;
}

.btn-back {
    background-color: #6c757d; /* abu-abu */
}

.btn-submit {
    background-color: #007bff; /* biru */
}
</style>

<script>
    // Fungsi gambar di canvas
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

        canvas.addEventListener("mouseup", () => {
            drawing = false;
        });

        canvas.addEventListener("mouseleave", () => {
            drawing = false;
        });
    }

    // Hapus tanda tangan
    function clearCanvas(canvasId) {
        const canvas = document.getElementById(canvasId);
        const ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, canvas.width, canvas.height);
    }

    // Unduh tanda tangan
    function downloadTTD(canvasId, nameId, dateId) {
        const canvas = document.getElementById(canvasId);
        const nama = document.getElementById(nameId).value || "Asesi";
        const tanggal = document.getElementById(dateId).value || new Date().toISOString().split('T')[0];
        const link = document.createElement("a");
        link.download = `TTD_${nama}_${tanggal}.png`;
        link.href = canvas.toDataURL("image/png");
        link.click();
    }

    // Jalankan saat halaman load
    window.onload = function () {
        initSignature("ttd-asesi");
    };
</script>
@endsection

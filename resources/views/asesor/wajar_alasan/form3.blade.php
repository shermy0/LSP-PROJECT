@extends('master')

@section('title', 'Form Asesmen - FR.AK.07')

@section('konten')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f9f9f9;
    }

    .card-custom {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 25px;
    }

    .section-header {
        background: #f0f6ff;
        padding: 12px 15px;
        font-weight: 500;
        font-size: 15px;
        color: #111;
        border-radius: 10px;
        margin-bottom: 20px;
        position: relative;
    }

    .section-header::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: #0a2c82;
        border-radius: 10px 0 0 10px;
    }

    .step-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        background: #041562;
        color: #fff;
        border-radius: 6px;
        padding: 8px 12px;
        margin-bottom: 8px;
    }

    .step-label span {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 22px;
        height: 22px;
        background: #007a6e;
        border-radius: 50%;
        font-size: 12px;
        font-weight: 700;
        margin-right: 8px;
    }

    textarea, input {
        border-radius: 6px !important;
        border: 1px solid #ccc !important;
        font-size: 14px;
    }

    /* Container dalam agar ukurannya konsisten dengan form */
    .inner-form {
        max-width: 600px; /* sesuaikan dengan ukuran form atas */
        margin: auto;
    }

    .signature-wrapper {
        width: 100%;
        height: 150px; /* tinggi canvas */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .signature-pad {
        border: 1px solid #ccc;
        border-radius: 6px;
        width: 100% !important;
        height: 100% !important;
        background: #fff;
        display: block;
    }

    .btn-clean {
        background: #e74c3c;
        color: #fff;
        font-size: 13px;
        padding: 6px 16px;
        border-radius: 6px;
        border: none;
    }

    .btn-download {
        background: #041562;
        color: #fff;
        font-size: 13px;
        padding: 6px 16px;
        border-radius: 6px;
        border: none;
    }

    /* Tombol utama bawah */
.btn-main {
    font-size: 15px;
    font-weight: 500;
    padding: 10px 28px;
    border-radius: 8px;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
}

/* Tombol Simpan */
.btn-simpan {
    background: #041562;
    color: #fff;
}
.btn-simpan:hover {
    background: #06268f;
}

/* Tombol Unduh */
.btn-unduh {
    background: #007a6e;
    color: #fff;
}
.btn-unduh:hover {
    background: #005f54;
}

</style>

<div class="container mt-4">

    {{-- Bagian Input --}}
    <div class="card-custom">
        <div class="section-header">
            Hasil Penyesuaian yang wajar dan beralasan disepakati menggunakan :
        </div>

        <div class="mb-3">
            <div class="step-label"><span>1</span> Acuan Pembanding Asesmen:</div>
            <textarea class="form-control" rows="2" placeholder="Masukkan teks"></textarea>
        </div>

        <div class="mb-3">
            <div class="step-label"><span>2</span> Metode Asesmen:</div>
            <textarea class="form-control" rows="2" placeholder="Masukkan teks"></textarea>
        </div>

        <div class="mb-3">
            <div class="step-label"><span>3</span> Instrumen Asesmen:</div>
            <textarea class="form-control" rows="2" placeholder="Masukkan teks"></textarea>
        </div>
    </div>

{{-- Bagian Tanda Tangan Asesor --}}
<div class="card-custom mt-4">
    <div class="section-header">
        Tanda Tangan & Persetujuan
    </div>
    <div class="p-3" style="max-width:600px; margin:auto;">
        <h6 class="fw-bold mb-3">Asesor</h6>

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" value="Reno Suswanto">
        </div>

        <div class="mb-3">
            <label class="form-label">No. Registrasi</label>
            <input type="text" class="form-control" value="081237654">
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input type="date" class="form-control" value="2026-08-23">
        </div>

        <div class="mb-2">
            <label class="form-label">Tanda Tangan</label>
            <div class="signature-wrapper">
                <canvas id="signatureAsesor" class="signature-pad"></canvas>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button class="btn-clean" onclick="clearSignatureAsesor()">Bersihkan</button>
            <button class="btn-download" onclick="downloadSignatureAsesor()">Unduh</button>
        </div>
    </div>
</div>

    {{-- Tombol Simpan & Unduh --}}
    <div class="text-end mb-5">
        <button class="btn-main btn-simpan">Simpan</button>
        <button class="btn-main btn-unduh">Unduh</button>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    let signatureAsesor;

    function resizeCanvas(canvas) {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }

    window.addEventListener("load", () => {
        const canvas = document.getElementById("signatureAsesor");
        resizeCanvas(canvas);
        signatureAsesor = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,1)',
            penColor: 'black'
        });
    });

    window.addEventListener("resize", () => {
        const canvas = document.getElementById("signatureAsesor");
        resizeCanvas(canvas);
        signatureAsesor.clear();
    });

    function clearSignatureAsesor() {
        signatureAsesor.clear();
    }

    function downloadSignatureAsesor() {
        if (signatureAsesor.isEmpty()) {
            alert("Tanda tangan masih kosong!");
            return;
        }
        const dataURL = signatureAsesor.toDataURL();
        const link = document.createElement("a");
        link.href = dataURL;
        link.download = "signatureAsesor.png";
        link.click();
    }
</script>


@endsection

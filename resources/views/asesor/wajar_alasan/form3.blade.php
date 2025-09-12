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

    .signature-pad {
        border: 1px solid #ccc;
        border-radius: 6px;
        width: 100%;
        height: 100px; /* sesuai gambar */
        background: #fff;
    }

    .btn-clean {
        background: #e74c3c;
        color: #fff;
        font-size: 12px;
        padding: 5px 15px;
        border-radius: 6px;
        border: none;
        margin-right: 4px;
    }

    .btn-download {
        background: #041562;
        color: #fff;
        font-size: 12px;
        padding: 5px 15px;
        border-radius: 6px;
        border: none;
    }

    .btn-main {
        font-size: 15px;
        font-weight: 500;
        padding: 8px 28px;
        border-radius: 8px;
        border: none;
        margin-right: 10px;
    }

    .btn-simpan {
        background: #041562;
        color: white;
    }

    .btn-unduh {
        background: #007a6e;
        color: white;
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

    {{-- Bagian Tanda Tangan --}}
    <div class="card-custom">
        <div class="section-header">
            Tanda Tangan & Persetujuan
        </div>
        <div class="col-md-12 mb-3">
            <h6 class="fw-bold">Asesor</h6>
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
                <canvas id="signatureAsesor" class="signature-pad"></canvas>
            </div>
            <div>
                <button class="btn-clean" onclick="clearSignature()">Bersihkan</button>
                <button class="btn-download" onclick="downloadSignature()">Unduh</button>
            </div>
        </div>
    </div>

    {{-- Tombol Simpan & Unduh --}}
    <div class="text-end mb-5">
        <button class="btn-main btn-simpan">Simpan</button>
        <button class="btn-main btn-unduh">Unduh</button>
    </div>
</div>

{{-- Script SignaturePad --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    let signatureAsesor;

    window.onload = function() {
        const canvas = document.getElementById("signatureAsesor");
        signatureAsesor = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,1)',
            penColor: 'black'
        });
    };

    function clearSignature() {
        signatureAsesor.clear();
    }

    function downloadSignature() {
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

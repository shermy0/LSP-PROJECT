@extends('master')

@section('title', 'Form Asesmen - FR.AK.07')

@section('konten')
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f8f9fc;
    }

    /* Card Container */
    .card-custom {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 25px;
        margin-bottom: 35px;
    }

    /* Section Header (Judul Box Atas) */
    .section-header {
        background: #eef5ff;
        padding: 12px 18px;
        font-weight: 600;
        font-size: 16px;
        color: #1a1a1a;
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
        width: 5px;
        background: linear-gradient(to bottom, #0a2c82, #0066cc);
        border-radius: 10px 0 0 10px;
    }

    /* Judul Setiap Kolom Form */
    .section-title {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #041562;
        color: #fff;
        padding: 10px 14px;
        border-radius: 8px;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .section-title span {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        background: #00c2ff;
        color: #041562;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        font-size: 14px;
        font-weight: 600;
    }

    /* Input & Textarea */
    textarea, input[type="text"], input[type="date"] {
        border-radius: 8px !important;
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
    }

    textarea:focus, input:focus {
        border-color: #041562;
        box-shadow: 0 0 0 2px rgba(4, 21, 98, 0.1);
        outline: none;
    }

    /* Tanda Tangan Box */
    .signature-pad {
        border: 2px dashed #041562;
        border-radius: 10px;
        width: 100%;
        height: 150px;
        background: #fff;
    }

    /* Tombol Bersih & Unduh Tanda Tangan */
    .btn-clean, .btn-download {
        font-size: 12px;
        padding: 6px 10px;
        border-radius: 6px;
        border: none;
        margin-right: 5px;
    }

    .btn-clean {
        background: #e74c3c;
        color: white;
    }

    .btn-download {
        background: #041562;
        color: white;
    }

    /* Tombol Simpan & Unduh Bawah */
    .btn-main {
        padding: 10px 24px;
        border-radius: 10px;
        border: none;
        font-weight: 600;
        margin-left: 8px;
        font-size: 14px;
    }

    .btn-simpan {
        background: #041562;
        color: white;
    }

    .btn-unduh {
        background: #008060;
        color: white;
    }

    /* Judul Subsection */
    h6.fw-bold {
        margin-bottom: 15px;
        color: #041562;
    }
</style>

<div class="container mt-4">

    {{-- Bagian 1 --}}
    <div class="card-custom">
        <div class="section-header">
            Hasil Penyesuaian yang wajar dan beralasan disepakati menggunakan :
        </div>
        <div class="mb-3">
            <div class="section-title"><span>1</span> Acuan Pembanding Asesmen:</div>
            <textarea class="form-control" rows="3" placeholder="Masukkan teks"></textarea>
        </div>
        <div class="mb-3">
            <div class="section-title"><span>2</span> Metode Asesmen:</div>
            <textarea class="form-control" rows="3" placeholder="Masukkan teks"></textarea>
        </div>
        <div class="mb-3">
            <div class="section-title"><span>3</span> Instrumen Asesmen:</div>
            <textarea class="form-control" rows="3" placeholder="Masukkan teks"></textarea>
        </div>
    </div>

    {{-- Bagian 2 --}}
    <div class="card-custom">
        <div class="section-header">
            Tanda Tangan & Persetujuan
        </div>
        <div class="row">
            {{-- Asesi --}}
            <div class="col-md-6 mb-3">
                <h6 class="fw-bold">Asesi</h6>
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control" value="Reno Suswanto">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control" value="2026-08-23">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanda Tangan</label>
                    <canvas id="signatureAsesi" class="signature-pad"></canvas>
                </div>
                <button class="btn-clean" onclick="clearSignature('signatureAsesi')">Bersih</button>
                <button class="btn-download" onclick="downloadSignature('signatureAsesi')">Unduh</button>
            </div>

            {{-- Asesor --}}
            <div class="col-md-6 mb-3">
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
                <div class="mb-3">
                    <label class="form-label">Tanda Tangan</label>
                    <canvas id="signatureAsesor" class="signature-pad"></canvas>
                </div>
                <button class="btn-clean" onclick="clearSignature('signatureAsesor')">Bersih</button>
                <button class="btn-download" onclick="downloadSignature('signatureAsesor')">Unduh</button>
            </div>
        </div>
    </div>

    {{-- Tombol Simpan & Unduh --}}
    <div class="text-end">
        <button class="btn-main btn-simpan">Simpan</button>
        <button class="btn-main btn-unduh">Unduh</button>
    </div>
</div>

{{-- Script SignaturePad --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const signaturePads = {};

    function initSignaturePad(id) {
        const canvas = document.getElementById(id);
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,1)',
            penColor: 'black'
        });
        signaturePads[id] = signaturePad;
    }

    window.onload = function() {
        initSignaturePad("signatureAsesi");
        initSignaturePad("signatureAsesor");
    };

    function clearSignature(id) {
        signaturePads[id].clear();
    }

    function downloadSignature(id) {
        if (signaturePads[id].isEmpty()) {
            alert("Tanda tangan masih kosong!");
            return;
        }
        const dataURL = signaturePads[id].toDataURL();
        const link = document.createElement("a");
        link.href = dataURL;
        link.download = id + ".png";
        link.click();
    }
</script>
@endsection

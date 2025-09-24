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

    /* Style khusus tanda tangan */
    .card { 
        background: #fff; 
        border: 1px solid #ddd; 
        border-radius: 12px; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.08); 
        padding: 25px; 
        max-width: 600px; 
        margin: 20px auto; 
    }
    .card-title {
        font-weight: bold;
        margin-bottom: 15px;
        font-size: 1.1rem;
        color: #333;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }
.card canvas { 
    border: 1px solid #999; 
    border-radius: 6px; 
    background-color: #ffffff; 
    cursor: crosshair; 
    display: block;
    max-width: 100%;
}

    .btns { display: flex; justify-content: flex-start; gap: 10px; margin-top: 10px; }
    .btns .clear { background: #dc3545; color: white; }
    .btns .download { background: #0d6efd; color: white; }
    .btns button:hover { opacity: 0.9; transform: translateY(-2px); transition: all 0.2s; }

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
    .btn-simpan { background: #041562; color: #fff; }
    .btn-simpan:hover { background: #06268f; }
    .btn-unduh { background: #007a6e; color: #fff; }
    .btn-unduh:hover { background: #005f54; }
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
    <div class="border rounded-3 p-3 mb-4 bg-white shadow-sm">
        <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
            <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
            &nbsp;&nbsp;Tanda Tangan Asesor
        </div>

        <div class="card">
            <div class="card-title">Asesor</div>
            <div class="mb-2">
                <label for="nama-asesor">Nama Lengkap</label>
                <input type="text" id="nama-asesor" class="form-control" value="Reno Suswanto">
            </div>
            <div class="mb-2">
                <label for="no-asesor">No. Registrasi</label>
                <input type="text" id="no-asesor" class="form-control" value="081237654">
            </div>
            <div class="mb-3">
                <label for="tanggal-asesor">Tanggal</label>
                <input type="date" id="tanggal-asesor" class="form-control" value="{{ date('Y-m-d') }}">
            </div>
            <div class="mb-3">
                <label for="ttd-asesor">Tanda Tangan</label>
                <canvas id="ttd-asesor" width="600" height="200"></canvas>
                <input type="hidden" name="ttd_asesor" id="ttd_asesor_data">
            </div>
            <div class="btns">
                <button type="button" class="btn clear" onclick="clearCanvas('ttd-asesor')">Hapus</button>
                <button type="button" class="btn download" onclick="downloadTTD('ttd-asesor','nama-asesor','tanggal-asesor','tanda_tangan_asesor')">Unduh</button>
            </div>
        </div>
    </div>

    {{-- Tombol Simpan & Unduh --}}
    <div class="text-end mb-5">
        <button class="btn-main btn-simpan">Simpan</button>
        <button class="btn-main btn-unduh">Unduh</button>
    </div>
</div>

{{-- Script tanda tangan umum --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const signaturePads = {};

    function resizeCanvas(canvas) {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
    }

    function initSignaturePad(id) {
        const canvas = document.getElementById(id);
        resizeCanvas(canvas); // Atur ukuran agar gambar muncul dengan benar
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,1)',
            penColor: 'black',
        });
        signaturePads[id] = signaturePad;
    }

    window.onload = function() {
        initSignaturePad("signatureAsesi");
        initSignaturePad("signatureAsesor");
    };

    window.onresize = function() {
        // Supaya tanda tangan nggak hilang kalau resize window
        for (const id in signaturePads) {
            const canvas = document.getElementById(id);
            resizeCanvas(canvas);
        }
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

ddocument.addEventListener('DOMContentLoaded', function () {
    initCanvas('ttd-asesor', 'ttd_asesor_data');
});

</script>
@endsection

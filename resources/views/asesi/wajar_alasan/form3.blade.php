@extends('master')

@section('title', 'Form Asesmen - FR.AK.07')

@section('konten')
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }
    .card-custom {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 30px;
    }
    .section-header {
    background-color: #eaf2ff; /* biru muda */
    padding: 10px 15px;
    font-weight: 500;
    font-size: 16px;
    color: #1a1a1a;
    border-radius: 8px;
    margin-bottom: 15px;
    position: relative;
}

/* Garis di sisi kiri */
.section-header::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 6px; /* ketebalan garis */
    background: linear-gradient(to bottom, #0a2c82, #0066cc); /* gradasi biru */
    border-radius: 8px 0 0 8px;
}

    .section-title {
        background: #041562;
        color: #fff;
        padding: 8px 15px;
        border-radius: 8px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .section-title span {
        display: inline-block;
        background: #00c2ff;
        color: #041562;
        border-radius: 50%;
        padding: 4px 10px;
        margin-right: 8px;
    }
    textarea, input {
        border-radius: 8px !important;
    }
    .signature-pad {
        border: 2px dashed #041562;
        border-radius: 8px;
        width: 100%;
        height: 150px;
        background: #fff;
    }
    .btn-clean {
        background: #e74c3c;
        color: white;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 6px;
        border: none;
    }
    .btn-download {
        background: #041562;
        color: white;
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 6px;
        border: none;
    }
    .btn-main {
        padding: 10px 25px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        margin-left: 10px;
    }
    .btn-simpan {
        background: #041562;
        color: white;
    }
    .btn-unduh {
        background: #008060;
        color: white;
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

{{-- Tambahkan Script SignaturePad --}}
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    // Inisialisasi SignaturePad
    const signaturePads = {};

    function initSignaturePad(id) {
        const canvas = document.getElementById(id);
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,1)',
            penColor: 'black'
        });
        signaturePads[id] = signaturePad;
    }

    // Inisialisasi semua canvas
    window.onload = function() {
        initSignaturePad("signatureAsesi");
        initSignaturePad("signatureAsesor");
    };

    // Bersihkan tanda tangan
    function clearSignature(id) {
        signaturePads[id].clear();
    }

    // Download tanda tangan
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

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

.section-title span {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    width: 26px;
    height: 26px;
    font-size: 14px;
    font-weight: 600;

    /* Background bulatan gradasi */
    background: linear-gradient(135deg, #0a2c82, #00c2ff, #000000);
    color: #fff; /* Warna angka tetap putih */
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


    /* Container Luar */
    .card-outer {
        background: #fff;
        border-radius: 10px;
        border: 1px solid #ddd;
        padding: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    /* Header */
.card-header {
    background: #eaf1ff;
    padding: 10px 15px 10px 20px;
    font-weight: 600;
    font-size: 16px;
    color: #041562;
    border-radius: 6px;
    margin-bottom: 15px;
    position: relative;
    overflow: hidden;
}

/* Garis biru di samping kiri */
.card-header::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    bottom: 0;
    width: 6px;
    background: linear-gradient(to bottom, #0a2c82, #0066cc);
    border-radius: 6px 0 0 6px;
}


    /* Card Dalam */
    .card-inner {
        border: 1px solid #ccc;
        border-radius: 8px;
        padding: 15px;
        background: #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        margin-bottom: 15px;
    }

    .card-inner h6 {
        font-weight: 600;
        margin-bottom: 15px;
        color: #041562;
    }

    /* Input */
    .form-control {
        border-radius: 6px;
        border: 1px solid #ccc;
        padding: 8px 10px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #041562;
        box-shadow: 0 0 0 2px rgba(4, 21, 98, 0.1);
    }

    /* Canvas Tanda Tangan */
    .signature-pad {
        border: 1px solid #999;
        border-radius: 6px;
        width: 100%;
        height: 120px;
        background: #fff;
        cursor: crosshair;
    }

    /* Tombol */
    .btn-clean, .btn-download, .btn-main {
        font-size: 12px;
        padding: 6px 14px;
        border-radius: 5px;
        border: none;
        margin-top: 8px;
        margin-right: 5px;
    }

    .btn-clean {
        background: #ff6b6b;
        color: white;
    }

    .btn-download {
        background: #041562;
        color: white;
    }

.btn-main {
    background: #008060;
    color: white;
    font-size: 15px;     /* ukuran teks pas */
    padding: 10px 22px;  /* tinggi & lebar seimbang */
    border-radius: 6px;
    margin-left: 5px;
    font-weight: 600;
    transition: background 0.3s ease;
}

.btn-main:hover {
    background: #00694d; /* efek hover lebih gelap */
}

.btn-back {
    background: #e63946;   /* merah */
    color: white;
    font-size: 15px;       /* sama dengan btn-main */
    padding: 10px 22px;    /* ukuran seimbang */
    border-radius: 6px;
    margin-right: 8px;
    font-weight: 600;
    transition: background 0.3s ease;
    text-decoration: none; /* hilangkan underline pada <a> */
    display: inline-block; /* biar mirip tombol */
}

.btn-back:hover {
    background: #c92c3c;   /* merah lebih gelap saat hover */
}

/* Efek tombol aktif ditekan */
.btn-main:active,
.btn-back:active {
    transform: translateY(2px);   /* tombol sedikit turun */
    box-shadow: none;            /* bayangan hilang */
}


</style>

<div class="container mt-4">

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


    <!-- Tanda Tangan -->
    <div class="card-outer">
        <div class="card-header">Tanda Tangan Asesi & Asesor</div>
        <div class="row g-3">
            <!-- Asesi -->
            <div class="col-md-6">
                <div class="card-inner">
                    <h6>Asesi</h6>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama lengkap asesi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanda Tangan</label>
                        <canvas id="signatureAsesi" class="signature-pad"></canvas>
                    </div>
                    <button class="btn-clean" onclick="clearSignature('signatureAsesi')">Bersih</button>
                    <button class="btn-download" onclick="downloadSignature('signatureAsesi')">Unduh</button>
                </div>
            </div>

            <!-- Asesor -->
            <div class="col-md-6">
                <div class="card-inner">
                    <h6>Asesor</h6>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" placeholder="Masukkan nama lengkap asesor">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Registrasi</label>
                        <input type="text" class="form-control" placeholder="Masukkan no. registrasi">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control">
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
    </div>

<!-- Tombol Simpan & Kirim -->
<div class="text-end">
    <a href="{{ url('asesi/wajar-alasan/form2') }}" class="btn-back">Kembali</a>
    <button class="btn-main">Simpan & Kirim</button>
</div>



<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const signaturePads = {};

    function initSignaturePad(id) {
        const canvas = document.getElementById(id);
        const signaturePad = new SignaturePad(canvas, {
            backgroundColor: 'rgba(255,255,255,1)',
            penColor: 'black'
        });

        function resizeCanvas() {
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            canvas.width = canvas.offsetWidth * ratio;
            canvas.height = canvas.offsetHeight * ratio;
            canvas.getContext("2d").scale(ratio, ratio);
            signaturePad.clear();
        }

        window.addEventListener("resize", resizeCanvas);
        resizeCanvas();

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

@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/fria05c.css') }}">

<div class="form-asesmen-header">
    <p class="breadcrumb">Form Asesmen ></p>
    <div class="icon-box"></div>
    <h1 class="main-title">FR.IA.07 - Lembar Pertanyaan Pilihan Ganda</h1>
    <p class="sub-title">Skema Sertifikasi Kompetensi</p>
    <div class="skema-box">
        <span class="skema-text">JUNIOR OPERATOR DESAIN GRAFIS</span>
    </div>
    <p class="kode-asesor">085102432440</p>
</div>

{{-- ================= FORM BIODATA ================= --}}
<div class="section-box">
    <div class="form-group">
        <label for="no_form">No.Form</label>
        <input type="text" class="form-control" name="no_form" placeholder="Nomor form">
    </div>

    <div class="form-group">
        <label for="nama_asesor">Nama Asesor</label>
        <input type="text" class="form-control" name="nama_asesor" placeholder="Masukkan nama asesor">
    </div>

    <div class="form-group">
        <label for="nama_asesi">Nama Asesi</label>
        <input type="text" class="form-control" name="nama_asesi" placeholder="Masukkan nama asesi">
    </div>

    <div class="form-group">
        <label for="tanggal_asesmen">Tanggal Asesmen</label>
        <input type="date" class="form-control" name="tanggal_asesmen">
    </div>

    <div class="form-group">
        <label for="tuk">TUK (Tempat Uji Kompetensi)</label>
        <input type="text" class="form-control" name="tuk" value="SMKN 11 Bandung">
    </div>
</div>

<div class="section-box">
    <div class="header">
        <div class="header-strip"></div>
        <h2 class="header-title">Tanda Tangan dan Persetujuan</h2>
    </div>

    <div class="kotak-asesi">
        <h2 class="kotak-title">Asesi</h2>

        <div class="form-group">
            <label for="nama_asesi">Nama Lengkap</label>
            <input type="text" class="form-control" name="nama_asesi"
                value="{{ Auth::user()->name ?? 'Nama Asesi' }}" readonly>
        </div>

        <div class="form-group">
            <label for="tanggal">Tanggal</label>
            <input type="text" class="form-control" name="tanggal"
                value="{{ now()->format('d/m/Y') }}" readonly>
        </div>

        <div class="form-group">
            <label for="tanda_tangan">Tanda Tangan</label>
            <canvas id="signature-pad" class="signature-pad"></canvas>
            <button type="button" id="clear-signature" class="btn-clear">Bersihkan</button>
            <input type="hidden" name="tanda_tangan" id="signature-data">
        </div>
    </div>
</div>
    <a href="{{ url('fria05c') }}" class="btn-submit">Simpan</a>
</div>

<!-- ✅ Library tanda tangan -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

<script>
    // ambil canvas
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);

    // tombol clear
    document.getElementById('clear-signature').addEventListener('click', function () {
        signaturePad.clear();
    });

    // kalau mau simpan → isi ke input hidden
    document.querySelector('.btn-submit').addEventListener('click', function (e) {
        if (!signaturePad.isEmpty()) {
            const dataURL = signaturePad.toDataURL();
            document.getElementById('signature-data').value = dataURL;
        } else {
            alert("Silakan tanda tangan dulu.");
            e.preventDefault();
        }
    });
</script>
@endsection

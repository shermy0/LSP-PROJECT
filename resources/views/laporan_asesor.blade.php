@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('laporan') }}">FR.AK.05</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Catatan Asesor & Tanda Tangan
            </li>
        </ol>
    </nav>
</div>

<!-- Komentar dan TTD -->
<div class="card-box">
    <div class="judul-box">
        <div class="judul-header">Catatan Asesor & Tanda Tangan</div>

        <h5 class="mb-3">Asesor</h5>

        <!-- Catatan -->
        <div class="form-group mb-3">
            <label for="catatan" class="form-label fw-semibold">Catatan</label>
            <textarea id="catatan" class="form-control mt-2" rows="3" placeholder="Masukkan Catatan Anda"></textarea>
        </div>

        @if(isset($asesor))
            <!-- Nama Asesor -->
            <div class="form-group mb-3">
                <label class="form-label fw-semibold">Nama Asesor</label>
                <input type="text" class="form-control" value="{{ $asesor->nama_asesor }}" readonly>
            </div>

            <!-- Nomor Registrasi -->
            <div class="form-group mb-3">
                <label class="form-label fw-semibold">Nomor Registrasi</label>
                <input type="text" class="form-control" value="{{ $no_registrasi }}" readonly>
            </div>
        @else
            <div class="alert alert-info">
                Data asesor belum dipilih. Kembali ke halaman 
                <a href="{{ route('laporan') }}">Pilih Asesor</a>.
            </div>
        @endif

        <!-- Tanggal Asesmen -->
        <div class="form-group mb-3">
            <label for="tanggalAsesmen" class="form-label fw-semibold">Tanggal Asesmen</label>
            <input type="date" class="form-control" id="tanggalAsesmen">
        </div>

        <!-- Tanda Tangan -->
        <div class="col-md-6">
            <div class="card-field">
                <label class="form-label fw-semibold">Tanda Tangan</label>
                <div class="signature-container">
                    <canvas id="signature-pad" class="signature-pad"></canvas>
                </div>

                <div class="mt-2 d-flex gap-2">
                    <button type="button" id="clear" class="btn btn-sm btn-outline-danger">Hapus</button>
                </div>

                <!-- Hidden input untuk simpan tanda tangan -->
                <input type="hidden" name="tanda_tangan" id="tanda_tangan">
            </div>
        </div>
    </div>
</div>

<!-- Tombol Simpan -->
<form id="simpan-form" action="{{ route('formperencanaan') }}" method="POST" class="simpan-form mt-3">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan</span>
    </button>
</form>

<!-- Signature Pad -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById("signature-pad");
    const signaturePad = new SignaturePad(canvas);

    // Resize biar canvas sesuai container
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    window.onresize = resizeCanvas;
    resizeCanvas();

    // Tombol clear
    document.getElementById("clear").addEventListener("click", function () {
        signaturePad.clear();
    });

    // Saat submit form simpan ke input hidden
    document.getElementById("simpan-form").addEventListener("submit", function () {
        if (!signaturePad.isEmpty()) {
            document.getElementById("tanda_tangan").value = signaturePad.toDataURL();
        }
    });
</script>
@endsection

@extends('master')

@section('konten')
<div class="container my-4">
    <h4 class="text-center mb-4">Banding Asesmen</h4>

    <form action="{{ route('banding.store') }}" method="POST">
        @csrf

        <!-- Rincian Data Pemohon Sertifikasi -->
        <div class="card mb-4 p-3">
            <h6 class="mb-3">Rincian Data Pemohon Sertifikasi</h6>

            <div class="mb-3">
                <label class="form-label">Nama Asesi</label>
                <input type="text" name="nama_asesi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Asesor</label>
                <input type="text" name="nama_asesor" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Asesmen</label>
                <input type="date" name="tanggal_asesmen" class="form-control" required>
            </div>
        </div>

        <!-- Pertanyaan Ya/Tidak -->
        <div class="card mb-4 p-3">
            <h6 class="mb-3">Jawablah dengan Ya atau Tidak:</h6>

            <div class="mb-3">
                <label class="form-label">Apakah Proses Banding telah dijelaskan kepada Anda?</label><br>
                <input type="radio" name="proses_dijelaskan" value="Ya" required> Ya
                <input type="radio" name="proses_dijelaskan" value="Tidak"> Tidak
            </div>

            <div class="mb-3">
                <label class="form-label">Apakah Anda telah mendiskusikan Banding dengan Asesor?</label><br>
                <input type="radio" name="diskusi_asesor" value="Ya" required> Ya
                <input type="radio" name="diskusi_asesor" value="Tidak"> Tidak
            </div>

            <div class="mb-3">
                <label class="form-label">Apakah Anda mau melibatkan "orang lain" membantu Anda dalam Proses Banding?</label><br>
                <input type="radio" name="melibatkan_orang" value="Ya" required> Ya
                <input type="radio" name="melibatkan_orang" value="Tidak"> Tidak
            </div>
        </div>

        <!-- Skema Sertifikasi -->
        <div class="card mb-4 p-3">
            <h6 class="mb-3">Skema Sertifikasi</h6>
            <div class="mb-3">
                <label class="form-label">Skema Sertifikasi</label>
                <input type="text" name="skema" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">No. Skema Sertifikasi</label>
                <input type="text" name="no_skema" class="form-control" required>
            </div>
        </div>

        <!-- Alasan Banding -->
        <div class="card mb-4 p-3">
            <h6 class="mb-3">Alasan Banding</h6>
            <textarea name="alasan" class="form-control" rows="4" placeholder="Tuliskan alasan anda di sini..." required></textarea>
        </div>

        <!-- Persetujuan Asesi -->
        <div class="card mb-4 p-3">
            <h6 class="mb-3">Persetujuan Asesi</h6>
            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

           <!-- Komentar dan TTD -->
<div class="card-box">
    <div class="komen_ttd-box">
        <div class="komen_ttd-header">Komentar Asesor & Tanda Tangan</div>
    </div>
    <h5 style="text-align: left;">Asesor</h5>
    <div class="col-md-12">
        <label for="namaAsesor" class="form-label fw-semibold">Nama Asesor</label>
        <input type="text" class="form-control" id="namaAsesor" placeholder="Nama Asesor">
    </div>
    <div class="col-md-12">
        <label for="nomorregistrasi" class="form-label fw-semibold">Nomor Registrasi</label>
        <input type="text" class="form-control" id="nomorregistrasi" placeholder="Nomor Registrasi">
    </div>
    <div class="col-md-12">
        <label for="tanggalAsesmen" class="form-label fw-semibold">Tanggal Asesmen</label>
        <input type="date" class="form-control" id="tanggalAsesmen">
    </div>
    <div class="col-md-6">
        <div class="card-field">
            <label class="form-label">Tanda Tangan</label>
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

<form id="simpan-form" action="{{ route('formperencanaan') }}" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan</span>
    </button>
</form>

        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan dan Kirim Form</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById("signature-pad");
    const signaturePad = new SignaturePad(canvas);

    // Resize biar canvas sesuai container
    function resizeCanvas() {
        const ratio =  Math.max(window.devicePixelRatio || 1, 1);
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
    document.querySelector("form").addEventListener("submit", function (e) {
        if (!signaturePad.isEmpty()) {
            document.getElementById("tanda_tangan").value = signaturePad.toDataURL();
        }
    });
</script>
@endsection

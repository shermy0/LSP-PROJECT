@extends('master')
@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.01</li>
        </ol>
    </nav>
</div>

<!-- Komentar dan TTD -->
<div class="card-box">
    <div class="komen_ttd-box">
        <div class="komen_ttd-header">Catatan Asesor & Tanda Tangan</div>
    </div>
    <h5 style="text-align: left;">Asesor</h5>
    <div class="col-md-12">
        <label for="catatan" class="form-label fw-semibold">Catatan</label>
        <textarea id="rekomendasi" class="form-control mt-2" rows="3" placeholder="Masukkan Catatan Anda"></textarea>
    </div>
    <div class="col-md-12">
        <label for="namaasesor" class="form-label fw-semibold">Nama Asesor</label>
        <input type="text" class="form-control" id="namaasesor" placeholder="Nama Asesor">
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

    <button type="submit" class="simpan-btn">
        <span>Simpan</span>
    </button>
</form>
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
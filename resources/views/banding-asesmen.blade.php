@extends('master')

@section('konten')
<div class="container my-4">
    <div class="avatar-img">
                <img src="{{ asset('assets/poto/potta.png') }}" alt="Potta" class="img-fluid">
</div>
    <h4 class="text-center mb-4">Banding Asesmen</h4>

    <form action="{{ route('banding.store') }}" method="POST">
        @csrf

        <!-- Rincian Data Pemohon Sertifikasi -->
        <div class="card mb-4 p-3">
            <!-- Pertanyaan Ya/Tidak -->
                <div class="card mb-4 p-3">
                    <!-- Pesan Informasi -->
            <div class="alert d-flex align-items-center" 
                style="background-color:#eaf2ff; border-left:6px solid #1e88e5; border-radius:8px;">
                <p class="mb-0 text-dark">
                Rincian Data Pemohon Sertifikasi</div>

            <form action="{{ route('banding.store') }}" method="POST">
                @csrf
                <!-- isi form seperti sebelumnya -->
            </form>
            <div class="mb-3">
                <label class="form-label">Nama Asesi</label>
                <input type="text" name="nama_asesi" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Asesor</label>
                <select name="nama_asesor" class="form-control" required>
                    <option value="">-- Pilih Asesor --</option>
                    @foreach($asesors as $asesor)
                        <option value="{{ $asesor->id }}">{{ $asesor->nama_asesor }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal Asesmen</label>
                <input type="date" name="tanggal_asesmen" class="form-control" required>
            </div>
        </div>

        <!-- Pertanyaan Ya/Tidak -->
        <div class="card mb-4 p-3">
            <!-- Pesan Informasi -->
    <div class="alert d-flex align-items-center" 
         style="background-color:#eaf2ff; border-left:6px solid #1e88e5; border-radius:8px;">
        <p class="mb-0 text-dark">
        Jawablah dengan Ya atau Tidak pertanyaan-pertanyaan berikutini :</div>

    <form action="{{ route('banding.store') }}" method="POST">
        @csrf
        <!-- isi form seperti sebelumnya -->
    </form>

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
                          <!-- Pesan Informasi -->
    <div class="alert d-flex align-items-center" 
         style="background-color:#eaf2ff; border-left:6px solid #1e88e5; border-radius:8px;">
        <p class="mb-0 text-dark">
            Banding ini diajukan atas Keputusan Asesmen yang dibuat terhadap Skema Sertifikasi (Kualifikasi/Klaster/Okupasi) berikut:    </div>

    <form action="{{ route('banding.store') }}" method="POST">
        @csrf
        <!-- isi form seperti sebelumnya -->
    </form>
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
                <!-- Pesan Informasi -->
    <div class="alert d-flex align-items-center" 
         style="background-color:#eaf2ff; border-left:6px solid #1e88e5; border-radius:8px;">
        <p class="mb-0 text-dark">
            Banding ini diajukan atas alasan sebagai berikut :
        </p>
    </div>

    <form action="{{ route('banding.store') }}" method="POST">
        @csrf
        <!-- isi form seperti sebelumnya -->
    </form>
            <textarea name="alasan" class="form-control" rows="4" placeholder="Tuliskan alasan anda di sini..." required></textarea>
        </div>

       <!-- Bagian Asesi -->
        <div class="card mb-4 p-3">
            
    <!-- Pesan Informasi -->
    <div class="alert d-flex align-items-center" 
         style="background-color:#eaf2ff; border-left:6px solid #1e88e5; border-radius:8px;">
        <p class="mb-0 text-dark">
            Anda mempunyai hak mengajukan banding jika Anda menilai Proses Asesmen tidak sesuai 
            SOP dan tidak memenuhi Prinsip Asesmen.
        </p>
    </div>

    <form action="{{ route('banding.store') }}" method="POST">
        @csrf
        <!-- isi form seperti sebelumnya -->
    </form>
            
            <div class="mb-3">
                <label class="form-label">Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanggal:</label>
                <input type="date" name="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Tanda Tangan:</label>
                <div class="border rounded p-2 bg-light">
                    <canvas id="signature-pad" style="width: 100%; height: 150px; border:1px solid #ccc;"></canvas>
                </div>
                <div class="mt-2 d-flex gap-2">
                    <button type="button" id="clear" class="btn btn-sm btn-outline-danger">Bersihkan</button>
                    <button type="button" id="download" class="btn btn-sm btn-outline-primary">Unduh</button>
                </div>
                <input type="hidden" name="tanda_tangan" id="tanda_tangan">
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan dan Kirim Form</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
<script>
    const canvas = document.getElementById("signature-pad");
    const signaturePad = new SignaturePad(canvas);

    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }
    window.onresize = resizeCanvas;
    resizeCanvas();

    document.getElementById("clear").addEventListener("click", function () {
        signaturePad.clear();
    });

    document.getElementById("download").addEventListener("click", function () {
        if (!signaturePad.isEmpty()) {
            const dataURL = signaturePad.toDataURL("image/png");
            const a = document.createElement("a");
            a.href = dataURL;
            a.download = "tanda_tangan.png";
            a.click();
        }
    });

    document.querySelector("form").addEventListener("submit", function () {
        if (!signaturePad.isEmpty()) {
            document.getElementById("tanda_tangan").value = signaturePad.toDataURL();
        }
    });
</script>
@endsection
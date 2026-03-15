@extends('master')

@section('title', 'FR.APL.02 - Verifikasi Asesmen Mandiri')

@section('konten')
    <div class="container my-4">
        <form action="{{ route('asesor.asesmen_mandiri.verifikasi.store', $asesi->id_asesi) }}" method="POST"
            id="verifikasiForm" novalidate>
            @csrf

            <!-- Header -->
            <div class="form-header text-center mb-4">
                <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                <h1 class="h5 fw-bold">Verifikasi Asesmen Mandiri</h1>
                <p class="small text-muted">Form Asesmen &gt; FR.APL.02</p>
            </div>

            <!-- Data Asesi -->
            <div class="question-box mb-4">
                <div class="question-title">
                    <span class="number">1</span>
                    <span class="text">Data Pribadi Asesi</span>
                </div>
                <table class="table-custom">
                    <tr>
                        <td style="width:30%">Nama Lengkap Peserta</td>
                        <td>{{ $asesi->nama_lengkap ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Peserta</td>
                        <td>{{ $asesi->no_peserta ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Skema Sertifikasi</td>
                        <td>{{ $permohonan->skema ?? '-' }}</td>
                    </tr>
                </table>
            </div>

            <!-- Unit Kompetensi -->
            @foreach($units as $unit)
                <div class="unit-header">
                    <p class="mb-1 fw-semibold">Unit Kompetensi {{ $loop->iteration }}</p>
                    <p class="mb-0">Kode Unit : {{ $unit->kode_unit }}</p>
                    <p class="mb-0">Judul Unit : {{ $unit->judul_unit }}</p>
                </div>

                @php $elemenUnit = $elemen->where('id_unit', $unit->id_unit); @endphp
                @foreach($elemenUnit as $e)
                    <div class="question-box">
                        <div class="question-title">
                            <span class="number">{{ $loop->iteration }}</span>
                            <span class="text">{{ $e->nama_elemen ?? '-' }}</span>
                        </div>
                        <table class="table-custom">
                            <thead>
                                <tr>
                                    <th style="width:5%">NO</th>
                                    <th style="width:55%">Elemen</th>
                                    <th style="width:10%">K</th>
                                    <th style="width:10%">BK</th>
                                    <th style="width:20%">Bukti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $kukElemen = $kuk->where('id_elemen', $e->id_elemen); @endphp
                                @foreach($kukElemen as $k)
                                    @php $j = $jawaban[$k->id_kuk] ?? null; @endphp
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $k->deskripsi_kuk }}</td>
                                        <td class="text-center">@if($j && $j->status === 'K')<span class="badge bg-success">✔</span>@endif</td>
                                        <td class="text-center">@if($j && $j->status === 'BK')<span class="badge bg-danger">✘</span>@endif</td>
                                        <td class="text-center">
                                            @if($j && $j->dokumen)
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#dokumenModal"
                                                    data-src="{{ asset('storage/' . $j->dokumen->file_path) }}">
                                                    Lihat
                                                </button>
                                            @else
                                                <span class="text-muted">Tidak ada bukti</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            @endforeach

            <!-- Rekomendasi Asesor -->
            <div class="question-box" id="rekomendasiSection">
                <p class="fw-semibold mb-2">Rekomendasi Asesor <span class="text-danger">*</span></p>
                <div>
                    <label>
                        <input type="radio" name="rekomendasi" value="Dapat Dilanjutkan" required>
                        Asesi dapat melanjutkan ke asesmen berikutnya
                    </label><br>
                    <label class="mt-2">
                        <input type="radio" name="rekomendasi" value="Tidak Dapat Dilanjutkan" required>
                        Asesi tidak dapat melanjutkan ke asesmen berikutnya
                    </label>
                </div>
                <div class="invalid-feedback d-block text-danger" id="rekomendasiError" style="display:none;">
                    Harap pilih salah satu rekomendasi.
                </div>
            </div>

            <!-- Catatan -->
            <div class="question-box">
                <p class="fw-semibold mb-2">Catatan Asesor (Opsional)</p>
                <textarea name="catatan" class="form-control" rows="3"></textarea>
            </div>

            <!-- Tanda Tangan -->
            <div class="question-box" id="ttdSection">
                <div class="question-title"><span class="number">TTD</span><span class="text">Tanda Tangan</span></div>
                <div class="row g-4">
                    <!-- Asesi -->
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light fw-semibold text-center">Asesi</div>
                            <div class="card-body text-center">
                                <p><strong>Nama:</strong> {{ $asesi->nama_lengkap ?? '-' }}</p>
                                <p><strong>Tanggal:</strong> {{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
                                @if(!empty($persetujuan->ttd_asesi))
                                    <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="TTD Asesi"
                                        class="ttd-img">
                                @else
                                    <div class="ttd-box d-flex align-items-center justify-content-center">
                                        <span class="text-muted">Belum ada TTD</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Asesor -->
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-light fw-semibold text-center">Asesor <span
                                    class="text-danger">*</span></div>
                            <div class="card-body text-center">
                                <p><strong>Nama:</strong> {{ Auth::user()?->name ?? "" ?? '-' }}</p>
                                <p><strong>Tanggal:</strong> {{ date('Y-m-d') }}</p>
                                <canvas id="ttd-asesor" class="ttd-box"></canvas>
                                <input type="hidden" name="ttd_asesor" id="ttd-asesor-input" required>
                                <div class="invalid-feedback d-block text-danger" id="ttdError" style="display:none;">
                                    Harap tanda tangani terlebih dahulu.
                                </div>
                                <div class="mt-3 d-flex justify-content-center gap-2">
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="clearCanvas('ttd-asesor')">🗑 Hapus</button>
                                    <button type="button" class="btn btn-sm btn-info" onclick="downloadTTD()">⬇
                                        Unduh</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="button-group mt-4">
                <a href="{{ route('asesor.asesmen_mandiri.index') }}" class="btn-back">Kembali</a>
                <button type="submit" class="btn-next">Simpan dan Kirim</button>
            </div>
        </form>
    </div>

    <!-- Modal Preview Dokumen -->
    <div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content shadow-lg rounded">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="dokumenModalLabel">Preview Dokumen</h5>
                    <div class="d-flex gap-2">
                        <a id="downloadLink" href="#" target="_blank" class="btn btn-sm btn-success">⬇ Unduh</a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                </div>
                <div class="modal-body text-center">
                    <div id="dokumenPreview"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Preview dokumen
        var modal = document.getElementById('dokumenModal');
        var preview = document.getElementById('dokumenPreview');
        var downloadLink = document.getElementById('downloadLink');

        modal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var src = button.getAttribute('data-src');
            var ext = src.split('.').pop().toLowerCase();
            downloadLink.href = src;
            preview.innerHTML = "";

            if (["jpg", "jpeg", "png", "gif", "bmp", "webp"].includes(ext)) {
                preview.innerHTML = `<img src="${src}" class="img-fluid rounded shadow" style="max-height:80vh;">`;
            } else if (ext === "pdf") {
                preview.innerHTML = `<iframe src="${src}" frameborder="0" style="width:100%; height:80vh;"></iframe>`;
            } else {
                preview.innerHTML = `<p class="text-muted">Preview tidak tersedia. Silakan unduh dokumen.</p>`;
            }
        });

        modal.addEventListener('hidden.bs.modal', function () {
            preview.innerHTML = "";
            downloadLink.href = "#";
        });

        // Signature Pad
        function initSignature(canvasId) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext("2d");
            let drawing = false;

            canvas.addEventListener("mousedown", (e) => {
                drawing = true; ctx.beginPath(); ctx.moveTo(e.offsetX, e.offsetY);
            });
            canvas.addEventListener("mousemove", (e) => {
                if (drawing) { ctx.lineTo(e.offsetX, e.offsetY); ctx.strokeStyle = "#000"; ctx.lineWidth = 2; ctx.stroke(); }
            });
            canvas.addEventListener("mouseup", () => drawing = false);
            canvas.addEventListener("mouseleave", () => drawing = false);
        }
        initSignature("ttd-asesor");

        function saveTTD() {
            const canvas = document.getElementById("ttd-asesor");
            const dataURL = canvas.toDataURL("image/png");
            document.getElementById("ttd-asesor-input").value = dataURL;
        }
        window.saveTTD = saveTTD;

        window.clearCanvas = function (canvasId) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext("2d");
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            document.getElementById("ttd-asesor-input").value = "";
        };

        window.downloadTTD = function () {
            const canvas = document.getElementById("ttd-asesor");
            const link = document.createElement("a");
            link.download = "tanda_tangan_asesor.png";
            link.href = canvas.toDataURL("image/png");
            link.click();
        };

        // Helper cek apakah canvas kosong (cek pixel langsung)
        function isCanvasBlank(canvas) {
            const ctx = canvas.getContext("2d");
            const pixelBuffer = new Uint32Array(
                ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
            );
            return !pixelBuffer.some(color => color !== 0);
        }

        // Validasi form
        document.getElementById("verifikasiForm").addEventListener("submit", function (e) {
            saveTTD();
            let valid = true;
            let firstInvalid = null;

            // Cek rekomendasi
            let rekomendasi = document.querySelector('input[name="rekomendasi"]:checked');
            if (!rekomendasi) {
                document.getElementById("rekomendasiError").style.display = "block";
                if (!firstInvalid) firstInvalid = document.getElementById("rekomendasiSection");
                valid = false;
            } else {
                document.getElementById("rekomendasiError").style.display = "none";
            }

            // Cek tanda tangan (cek pixel canvas)
            const canvas = document.getElementById("ttd-asesor");
            if (isCanvasBlank(canvas)) {
                document.getElementById("ttdError").style.display = "block";
                if (!firstInvalid) firstInvalid = document.getElementById("ttdSection");
                valid = false;
            } else {
                document.getElementById("ttdError").style.display = "none";
            }

            if (!valid) {
                e.preventDefault();
                firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        });
    });
</script>

<style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9fb; }
    .container { max-width: 900px; }
    .unit-header { background: #E9F1FF; border-left: 6px solid #007BFF; border-radius: 8px; padding: 15px 20px; margin: 20px 0; font-size: 14px; }
    .question-box { border: 1px solid #ddd; border-radius: 12px; padding: 20px; margin-bottom: 20px; background: #fff; }
    .question-title { display: flex; align-items: center; font-weight: 600; margin-bottom: 15px; font-size: 15px; }
    .question-title .number { min-width: 26px; height: 26px; border-radius: 50%; background: #041562; color: #fff; display: flex; align-items: center; justify-content: center; font-size: 13px; margin-right: 10px; }
    .table-custom { width: 100%; border-collapse: collapse; font-size: 14px; background: #fff; }
    .table-custom th, .table-custom td { border: 1px solid #ddd; padding: 10px 12px; vertical-align: middle; }
    .table-custom th { background: #f5f5f5; text-align: center; font-weight: 600; }
    .ttd-box { border: 2px dashed #aaa; border-radius: 10px; width: 100%; height: 160px; background: #fafafa; cursor: crosshair; }
    .ttd-img { max-width: 100%; height: 160px; object-fit: contain; border: 1px solid #ddd; border-radius: 10px; background: #fff; padding: 6px; }
    .card-header { font-size: 14px; background: #f0f4ff !important; border-bottom: 1px solid #ddd; }
    .button-group { display: flex; justify-content: flex-end; gap: 12px; }
    .btn-back { background: #d9534f; color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; }
    .btn-next { background: #041562; color: #fff; padding: 10px 24px; border-radius: 8px; font-weight: 600; border: none; }
    .btn-back:hover { background: #c9302c; }
    .btn-next:hover { background: #06208a; }
</style>

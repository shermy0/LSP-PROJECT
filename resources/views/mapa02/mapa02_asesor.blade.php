@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mapa02') }}">FR.MAPA.02</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Penyusun & Validator</li>
        </ol>
    </nav>
</div>

<div class="container mt-4">
    <!-- Penyusun -->
    <div class="card-box">
        <div class="judul-header">Penyusun</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="penyusun-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center align-middle">Nama</th>
                        <th class="text-center align-middle">No Met</th>
                        <th class="text-center align-middle">Tanggal</th>
                        <th class="text-center align-middle">Tanda Tangan</th>
                        <th class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Penyusun"></td>
                        <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
                        <td><input type="date" name="tanggal[]" class="form-control"></td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="add-row" class="btn btn-success mt-2">+ Tambah Data Penyusun</button>
        </div>
    </div>
</div>

<!-- Modal tanda tangan -->
<div class="modal fade" id="signatureModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tanda Tangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <canvas id="signature-pad" style="border:1px solid #ccc; width:100%; height:300px;"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" id="clear-signature" class="btn btn-danger">Hapus</button>
        <button type="button" id="save-signature" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="container mt-4">
    <!-- Penyusun -->
    <div class="card-box">
        <div class="judul-header">Validator</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="penyusun-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center align-middle">Nama</th>
                        <th class="text-center align-middle">No Met</th>
                        <th class="text-center align-middle">Tanggal</th>
                        <th class="text-center align-middle">Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Validator"></td>
                        <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
                        <td><input type="date" name="tanggal[]" class="form-control"></td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal tanda tangan -->
<div class="modal fade" id="signatureModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tanda Tangan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <canvas id="signature-pad" style="border:1px solid #ccc; width:100%; height:300px;"></canvas>
      </div>
      <div class="modal-footer">
        <button type="button" id="clear-signature" class="btn btn-danger">Hapus</button>
        <button type="button" id="save-signature" class="btn btn-primary" data-bs-dismiss="modal">Simpan</button>
      </div>
    </div>
  </div>
</div>

<!-- Simpan dan Lanjut -->
<form id="simpan-form" action="{{ route('formperencanaan') }}" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan</span>
    </button>
</form>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("#penyusun-table tbody");
    const addRowBtn = document.getElementById("add-row");
    const canvasModal = document.getElementById("signature-pad");
    let signaturePad = new SignaturePad(canvasModal);
    let activePreview;

    // Tambah baris baru
    addRowBtn.addEventListener("click", function () {
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Penyusun"></td>
            <td><input type="text" name="nomet[]" class="form-control" placeholder="No Met"></td>
            <td><input type="date" name="tanggal[]" class="form-control"></td>
            <td class="text-center">
                <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i></button>
            </td>
        `;
        tableBody.appendChild(newRow);
    });

    // Hapus baris
    document.addEventListener("click", function(e) {
        if (e.target.closest(".delete-row")) {
            e.target.closest("tr").remove();
        }
    });

    // Resize canvas modal (fix biar gak blank)
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasModal.width = canvasModal.offsetWidth * ratio;
        canvasModal.height = canvasModal.offsetHeight * ratio;
        canvasModal.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    // Klik canvas kecil -> buka modal
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("signature-preview")) {
            activePreview = e.target;
            const modalEl = document.getElementById('signatureModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            // resize saat modal ditampilkan
            modalEl.addEventListener('shown.bs.modal', resizeCanvas, { once: true });
        }
    });

    // Tombol hapus tanda tangan
    document.getElementById("clear-signature").addEventListener("click", function () {
        signaturePad.clear();
    });

    // Tombol simpan tanda tangan
    document.getElementById("save-signature").addEventListener("click", function () {
        if (!signaturePad.isEmpty() && activePreview) {
            const dataURL = signaturePad.toDataURL();
            const ctx = activePreview.getContext("2d");
            const img = new Image();
            img.onload = function() {
                ctx.clearRect(0, 0, activePreview.width, activePreview.height);
                ctx.drawImage(img, 0, 0, activePreview.width, activePreview.height);
            }
            img.src = dataURL;
            activePreview.nextElementSibling.value = dataURL;
        }
    });
});
</script>
@endsection

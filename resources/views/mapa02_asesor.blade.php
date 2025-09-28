@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('mapa02.show') }}">FR.MAPA.02</a></li>
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
                        <th class="text-center align-middle">Nama Asesor</th>
                        <th class="text-center align-middle">No Met</th>
                        <th class="text-center align-middle">Tanggal</th>
                        <th class="text-center align-middle">Tanda Tangan</th>
                        <th class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="asesor_id[]" class="form-control asesor-select">
                                <option value="">-- Pilih Asesor --</option>
                            </select>
                        </td>
                        <td>
                            <input type="text" name="no_met[]" class="form-control noMet" readonly>
                        </td>
                        <td><input type="date" name="tanggal[]" class="form-control"></td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-danger btn-sm delete-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" id="add-row" class="btn btn-success mt-2">+ Tambah Data Penyusun</button>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="card-box">
        <div class="judul-header">Validator</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="validator-table">
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
                        <td><input type="text" name="nama_validator[]" class="form-control validator-field" placeholder="Nama Validator" readonly></td>
                        <td><input type="text" name="nomet_validator[]" class="form-control validator-field" placeholder="No Met" readonly></td>
                        <td><input type="date" name="tanggal_validator[]" class="form-control validator-field" readonly></td>
                        <td class="text-center">
                            <canvas class="signature-preview-validator validator-field" width="120" height="50" style="border:1px solid #ccc; background:#f1f1f1;"></canvas>
                            <input type="hidden" name="tanda_tangan_validator[]" class="tanda_tangan">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".validator-field").forEach(field => {
        field.addEventListener("focus", showValidatorAlert);
        field.addEventListener("click", showValidatorAlert);
    });

    function showValidatorAlert(e) {
        e.preventDefault();
        Swal.fire({
            icon: 'warning',
            title: 'Akses Ditolak',
            text: 'Validator diisi pada bagian FR.VA Memberikan Kontribusi dalam Validasi Asesmen',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Mengerti'
        });
        e.target.blur(); // keluar dari field
    }
});
</script>


<!-- Simpan dan Lanjut -->
<form id="simpan-form" action="{{ route('formperencanaan') }}" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan</span>
    </button>
</form>

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

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tableBody = document.querySelector("#penyusun-table tbody");
    const addRowBtn = document.getElementById("add-row");
    const canvasModal = document.getElementById("signature-pad");
    let signaturePad = new SignaturePad(canvasModal);
    let activePreview;

    // ✅ Tambah baris baru
    addRowBtn.addEventListener("click", function () {
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>
                <select name="asesor_id[]" class="form-control asesor-select">
                    <option value="">-- Pilih Asesor --</option>
                </select>
            </td>
            <td>
                <input type="text" name="no_met[]" class="form-control noMet" readonly>
            </td>
            <td><input type="date" name="tanggal[]" class="form-control"></td>
            <td class="text-center">
                <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm delete-row">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        `;
        tableBody.appendChild(newRow);
        loadAsesorOptions(skemaId); // isi dropdown asesor utk row baru
    });

    // ✅ Hapus baris
    document.addEventListener("click", function(e) {
        if (e.target.closest(".delete-row")) {
            e.target.closest("tr").remove();
        }
    });

    // ✅ Resize canvas modal
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvasModal.width = canvasModal.offsetWidth * ratio;
        canvasModal.height = canvasModal.offsetHeight * ratio;
        canvasModal.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    // ✅ Klik canvas kecil -> buka modal
    document.addEventListener("click", function(e) {
        if (e.target.classList.contains("signature-preview")) {
            activePreview = e.target;
            const modalEl = document.getElementById('signatureModal');
            const modal = new bootstrap.Modal(modalEl);
            modal.show();

            modalEl.addEventListener('shown.bs.modal', resizeCanvas, { once: true });
        }
    });

    // ✅ Tombol hapus tanda tangan
    document.getElementById("clear-signature").addEventListener("click", function () {
        signaturePad.clear();
    });

    // ✅ Tombol simpan tanda tangan
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

    // ✅ Load asesor
    const skemaId = localStorage.getItem('selectedSkemaId');
    if (skemaId) {
        loadAsesorOptions(skemaId);
    }
});

function loadAsesorOptions(skemaId) {
    fetch(`/mapa02/skema/${skemaId}/asesor`)
        .then(res => res.json())
        .then(data => {
            document.querySelectorAll('.asesor-select').forEach(select => {
                select.innerHTML = '<option value="">-- Pilih Asesor --</option>';
                data.forEach(asesor => {
                    let opt = document.createElement('option');
                    opt.value = asesor.id_asesor;
                    opt.textContent = `${asesor.nama_asesor}`;
                    opt.dataset.noMet = asesor.no_registrasi;
                    select.appendChild(opt);
                });
            });
        });
}

document.addEventListener('change', function(e) {
    if (e.target.classList.contains('asesor-select')) {
        let noMetInput = e.target.closest('tr').querySelector('.noMet');
        noMetInput.value = e.target.selectedOptions[0].dataset.noMet || '';
    }
});
</script>
@endsection
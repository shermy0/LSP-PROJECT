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
                <a href="{{ route('fr_va', ['periode' => $periode]) }}">FR.VA {{ $periode }}</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Memberikan Kontribusi dan Rencana Perbaikan
            </li>
        </ol>
    </nav>
</div>

<div class="container mt-4"><br>
    <!-- Memberikan Kontribusi untuk Hasil Asesmen -->
    <div class="card-box">
        <div class="judul-header">3. Memberikan Kontribusi untuk Hasil Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="kontribusi-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center align-middle">No</th>
                        <th class="text-center align-middle">Temuan Validasi</th>
                        <th class="text-center align-middle">Rekomendasi untuk meningkatkan Praktek Asesmen</th>
                        <th class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center no">1</td>
                        <td>
                            <input type="text" name="temuan[]" class="form-control" placeholder="Isi Temuan Validasi">
                        </td>
                        <td>
                            <input type="text" name="rekomendasi[]" class="form-control" placeholder="Isi Rekomendasi">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit text-white"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success mt-2 add-row" data-table="kontribusi-table">
                + Tambah Data
            </button>
        </div>
    </div>

    <!-- Rencana Implementasi Perbaikan -->
    <div class="card-box mt-4">
        <div class="judul-header">Rencana Implementasi Perubahan / Perbaikan Pelaksanaan Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="perbaikan-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center align-middle">No</th>
                        <th class="text-center align-middle">Kegiatan perbaikan sesuai rekomendasi</th>
                        <th class="text-center align-middle">Waktu Penyelesaian</th>
                        <th class="text-center align-middle">Penanggung Jawab</th>
                        <th class="text-center align-middle">Tanda Tangan</th>
                        <th class="text-center align-middle">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center no">1</td>
                        <td><input type="text" name="perbaikan[]" class="form-control" placeholder="Isi perbaikan"></td>
                        <td><input type="date" name="waktu[]" class="form-control"></td>
                        <td><input type="text" name="penanggung[]" class="form-control" placeholder="Masukkan Nama"></td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan[]" class="tanda_tangan">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit text-white"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success mt-2 add-row" data-table="perbaikan-table">
                + Tambah Data
            </button>
        </div>
    </div>

    <!-- Validator -->
    <div class="card-box mt-4">
        <div class="judul-header">Validator</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table" id="validator-table">
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
                        <td><input type="text" name="nama_validator[]" class="form-control" placeholder="Nama Validator"></td>
                        <td><input type="text" name="nomet_validator[]" class="form-control" placeholder="No Met"></td>
                        <td><input type="date" name="tanggal_validator[]" class="form-control"></td>
                        <td class="text-center">
                            <canvas class="signature-preview" width="120" height="50" style="border:1px solid #ccc; cursor:pointer;"></canvas>
                            <input type="hidden" name="tanda_tangan_validator[]" class="tanda_tangan">
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-warning btn-sm">
                                <i class="fa fa-edit text-white"></i>
                            </button>
                            <button type="button" class="btn btn-danger btn-sm delete-row">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success mt-2" id="add-validator-row">
                + Tambah Data
            </button>
        </div>
    </div>
</div>

<!-- Simpan dan Lanjut -->
<form id="simpan-form" action="{{ route('formperencanaan') }}" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn"><span>Simpan</span></button>
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.5/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const signatureModal = new bootstrap.Modal(document.getElementById('signatureModal'));
    const canvas = document.getElementById('signature-pad');
    const signaturePad = new SignaturePad(canvas);
    let activePreview;

    // Tambah baris untuk semua tabel
    document.querySelectorAll('.add-row').forEach(button => {
        button.addEventListener('click', function() {
            const table = document.getElementById(this.dataset.table).querySelector('tbody');
            const newRow = table.rows[0].cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            table.appendChild(newRow);
            Array.from(table.rows).forEach((row, index) => {
                const noCell = row.querySelector('.no');
                if(noCell) noCell.textContent = index + 1;
            });
        });
    });

    // Hapus baris
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-row')) {
            const row = e.target.closest('tr');
            const table = row.closest('tbody');
            row.remove();
            Array.from(table.rows).forEach((r, index) => {
                const noCell = r.querySelector('.no');
                if(noCell) noCell.textContent = index + 1;
            });
        }

        // Klik canvas -> modal tanda tangan
        if (e.target.classList.contains('signature-preview')) {
            activePreview = e.target;
            signaturePad.clear();
            signatureModal.show();
        }
    });

    // Clear tanda tangan
    document.getElementById('clear-signature').addEventListener('click', () => signaturePad.clear());

    // Simpan tanda tangan
    document.getElementById('save-signature').addEventListener('click', () => {
        if (activePreview && !signaturePad.isEmpty()) {
            const dataURL = signaturePad.toDataURL();
            const ctx = activePreview.getContext('2d');
            const img = new Image();
            img.onload = () => {
                ctx.clearRect(0,0,activePreview.width, activePreview.height);
                ctx.drawImage(img, 0,0, activePreview.width, activePreview.height);
            };
            img.src = dataURL;
            activePreview.nextElementSibling.value = dataURL;
        }
    });

    // Validator table add-row
    const validatorTableBody = document.querySelector("#validator-table tbody");
    document.getElementById("add-validator-row").addEventListener("click", function() {
        const newRow = validatorTableBody.rows[0].cloneNode(true);
        newRow.querySelectorAll('input').forEach(input => input.value = '');
        validatorTableBody.appendChild(newRow);
    });
});
</script>
@endsection

@extends('master')

@section('konten')
<div class="container mt-4">

    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#" class="text-primary">Form Asesmen</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.IA.07</li>
        </ol>
    </nav>

    <!-- Header Judul -->
    <div class="text-center mb-4">
        <h4 class="fw-bold text-dark">FR.IA.07 – Lembar Pertanyaan Esai</h4>
        <p class="text-muted mb-1">Skema Sertifikasi Kompetensi</p>

        <!-- Dropdown Skema -->
        <div class="d-inline-block mb-2">
            <button class="btn" style="background-color:#003366; color:#fff;" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                JUNIOR OPERATOR DESAIN GRAFIS
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Junior Technical Support</a></li>
                <li><a class="dropdown-item" href="#">Pemrograman Junior</a></li>
                <li><a class="dropdown-item" href="#">Office Administrative</a></li>
            </ul>
        </div>

        <!-- Nomor Identifikasi -->
        <p class="text-muted">085102432440</p>
    </div>

    <!-- Panduan Bagi Asesor -->
    <div class="card shadow-sm mb-5 border-0">
        <div class="card-header" style="background-color:#f0f6ff; color:#333; font-weight:bold;">
            Panduan Bagi Asesor
        </div>
        <div class="card-body">
            <ol class="list-group list-group-numbered">
                <li class="list-group-item border-0 ps-0">
                    Buatlah pertanyaan esai yang dapat mengekplorasi penguasaan informasi pelaksanaan KUK, batasan variabel, pengetahuan dan keterampilan esensial, aspek penting kritis.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Perkirakan jawaban dapat diisikan pada baris kosong jawaban.
                </li>
                <li class="list-group-item border-0 ps-0">
                    Dibutuhkan justifikasi profesional asesor untuk memutuskan hal ini.
                </li>
            </ol>
        </div>
    </div>

    <!-- Tombol Masukkan Pertanyaan -->
    <div class="text-end">
        <button class="btn text-white px-4 py-2" style="background-color:#003366;" data-bs-toggle="modal" data-bs-target="#modalPertanyaan">
            Masukkan Pertanyaan
        </button>
    </div>
</div>

<!-- Modal Tambah Pertanyaan -->
<div class="modal fade" id="modalPertanyaan" tabindex="-1" aria-labelledby="modalPertanyaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 350px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPertanyaanLabel">Ketik Jumlah Pertanyaan :</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-2">
                <input type="number" class="form-control mb-2" min="1" max="15" value="5">
                <small class="text-danger">note: maksimal 15 pertanyaan</small>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn w-100 text-white" style="background-color:#003366; font-weight:bold;">
                    Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
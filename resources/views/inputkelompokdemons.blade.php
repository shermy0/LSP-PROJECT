
@extends('master')

@section('konten')
<div class="container mt-4" style="max-width: 900px;">

    <!-- Judul Halaman -->
    <h5 class="text-muted">Form Asesmen > <b>FR.IA.02</b></h5>
    <div class="text-center mt-3">
        <div style="width:50px;height:50px;background:#001a66;margin:auto;border-radius:8px;"></div>
        <h4 class="mt-3">FR.IA.02 - Lembar Pertanyaan Demonstrasi</h4>
        <p class="text-muted">Skema Sertifikasi Kompetensi</p>
        <span style="background:#eaf2ff;color:#1e3a8a;font-weight:600;padding:6px 14px;border-radius:8px;">
            JUNIOR OPERATOR DESAIN GRAFIS
        </span>
    </div>

    <!-- Petunjuk -->
    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h5 class="mb-3">Petunjuk</h5>
            <ul class="instructions">
                <li><span>1</span> Baca dan pelajari setiap instruksi kerja di bawah ini dengan cermat sebelum melaksanakan praktik.</li>
                <li><span>2</span> Identifikasi kepada asesor jika ada hal yang belum jelas.</li>
                <li><span>3</span> Laksanakan pekerjaan sesuai urutan proses yang ditetapkan.</li>
                <li><span>4</span> Gunakan SOP/IK yang dipersyaratkan (jika ada).</li>
            </ul>
        </div>
    </div>

    <!-- Pilih Kelompok Pekerjaan -->
<div class="card mt-4 shadow-sm">
    <div class="card-header" style="background:#eaf2ff;font-weight:600;">
        Pilih Kelompok Pekerjaan
    </div>
    <div class="card-body p-0">
        <table class="table table-bordered kelompok-table mb-0">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kelompok Pekerjaan</th>
                    <th>Pilih</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>J.59MTM00.027.1 - Kelompok Pekerjaan 1</td>
                    <td class="text-center">
                        <input type="checkbox" name="kelompok[]" value="1">
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>J.59MTM00.028.1 - Kelompok Pekerjaan 2</td>
                    <td class="text-center">
                        <input type="checkbox" name="kelompok[]" value="2">
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>J.59MTM00.029.1 - Kelompok Pekerjaan 3</td>
                    <td class="text-center">
                        <input type="checkbox" name="kelompok[]" value="3">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>


    <!-- Tombol Selanjutnya -->
    <div class="text-end mt-4">
        <button class="btn btn-primary px-4">Selanjutnya</button>
    </div>

</div>

{{-- Tambahan styling kecil --}}
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f5f7fa;
    }
    .card {
        border-radius: 12px;
        border: none;
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    .btn-primary {
        background: #001a66;
        border: none;
        border-radius: 8px;
    }
    .instructions {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .instructions li {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        font-size: 14px;
    }
    .instructions li span {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        width: 24px;
        height: 24px;
        margin-right: 10px;
        background: #2962ff;
        color: #fff;
        border-radius: 50%;
        font-size: 13px;
        font-weight: bold;
    }

    /* Styling khusus tabel kelompok pekerjaan */
    .kelompok-table {
        border: 2px solid #001a66 !important;
    }
    .kelompok-table th {
        background: #001a66 !important;
        color: #fff !important;
        border: 1px solid #001a66 !important;
        text-align: center;
    }
    .kelompok-table td {
        border: 1px solid #001a66 !important;
    }
    .kelompok-table tbody tr:hover {
        background: #eaf2ff !important;
    }

    /* Styling checkbox sesuai warna biru */
input[type="checkbox"] {
    accent-color: #001a66;
    transform: scale(1.2);
    cursor: pointer;
    outline: none !important;  /* hapus outline default */
    box-shadow: none !important; /* hapus glow biru */
}
</style>
@endsection
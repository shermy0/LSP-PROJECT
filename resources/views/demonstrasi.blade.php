
@extends('master')

@section('konten')
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <title>FR.IA.02 - Tugas Praktik Demonstrasi</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f7fa;
      margin: 0;
      padding: 20px;
      color: #333;
    }

    .container {
      max-width: 950px;
      margin: auto;
    }

    h2 {
      text-align: center;
      margin-bottom: 5px;
    }

    .subtitle {
      text-align: center;
      color: #666;
      margin: 0;
    }

    .badge {
      display: block;
      width: fit-content;
      margin: 12px auto 20px;
      padding: 6px 14px;
      background: #2962ff;
      color: #fff;
      border-radius: 20px;
      font-size: 13px;
      font-weight: bold;
    }

    .card {
      background: #fff;
      padding: 20px;
      margin-bottom: 25px;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    .card h3 {
  background: #eaf2ff;
  padding: 10px 15px;
  margin: -20px -20px 15px -20px;
  border-radius: 10px 10px 0 0;
  font-size: 16px;
  border-left: 6px solid #2962ff; /* aksen biru di kiri */
}

    label {
      display: block;
      margin: 10px 0 5px;
      font-weight: bold;
      font-size: 14px;
    }

    input[type="text"],
    input[type="date"],
    textarea {
      width: 100%;
      padding: 8px;
      border: 1px solid #ddd;
      border-radius: 6px;
      margin-bottom: 10px;
      font-size: 14px;
    }

    textarea {
      min-height: 80px;
    }

    .radio-group {
      display: flex;
      gap: 20px;
      margin: 10px 0;
    }

    /* Petunjuk dengan nomor bulat */
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

    /* Tabel */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      font-size: 14px;
    }

    table thead {
      background: #1e3a8a;
      color: #fff;
    }

    table th, table td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    table tbody tr:nth-child(even) {
      background: #f9f9f9;
    }

    /* Tombol */
    .btn {
      display: inline-block;
      padding: 8px 15px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 14px;
    }

    .btn-green {
      background: #2ecc71;
      color: #fff;
    }

    .btn-primary {
      background: #2962ff;
      color: #fff;
    }

    .btn-danger {
      background: #e74c3c;
      color: #fff;
    }

    .action-btns {
      display: flex;
      gap: 10px;
      margin-top: 10px;
    }
  </style>
</head>
<body>
  <div class="container">

    <h2>FR.IA.02 – Tugas Praktik Demonstrasi</h2>
    <p class="subtitle">Skema Sertifikasi Kompetensi</p>
      <!-- ✅ Ambil nama skema dari database -->
    <span class="badge">{{ strtoupper($skema->nama_skema) }}</span>
    <!-- Petunjuk -->
      <p class="text-muted">{{ $skema->kode_skema ?? 'N/A' }}</p>
    <div class="card">
      <h3>Petunjuk</h3>
      <ul class="instructions">
        <li><span>1</span> Baca dan pelajari setiap instruksi kerja di bawah ini dengan cermat sebelum melaksanakan praktik.</li>
        <li><span>2</span> Identifikasi kepada asesor jika ada hal yang belum jelas.</li>
        <li><span>3</span> Laksanakan pekerjaan sesuai urutan proses yang ditetapkan.</li>
        <li><span>4</span> Gunakan SOP/IK yang dipersyaratkan (jika ada).</li>
      </ul>
    </div>

    
    <!-- Skenario Tugas -->
    <div class="card">
      <h3>Skenario Tugas Praktik Demonstrasi</h3>
      <p><b>Situation:</b> Anda seorang asesi mengajukan permohonan uji kompetensi untuk jabatan Junior Desain Grafis. Produk yang harus dibuat adalah Logo Perusahaan dan Poster Produk.</p>
      <p><b>Task:</b> Untuk itu Anda diminta pada kelompok kerja 1 membuat Sketsa Logo dan Poster.</p>
      <p><b>Perlengkapan dan Peralatan:</b> PC/Laptop, Printer, Software pengolah vektor & bitmap (Corel/AI/PS), Cutter, Penggaris, Alas.</p>
      <p><b>Action:</b></p>
      <ul>
        <li>Mengumpulkan Aset Multimedia</li>
        <li>Membuat Data Based Multimedia</li>
        <li>Mendistribusikan Aset Multimedia</li>
      </ul>
      <p><b>Result:</b> Poster Produk</p>
    </div>   
        <div class="action-btns">
    <!-- Tombol buka modal -->
<div class="action-btns">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPertanyaan">
        Buat Pertanyaan
    </button>
</div>

<!-- Modal Buat Pertanyaan -->
<div class="modal fade" id="modalPertanyaan" tabindex="-1" aria-labelledby="modalPertanyaanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content" style="border-radius: 10px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h6 class="modal-title fw-bold" id="modalPertanyaanLabel">Atur Pertanyaan Demonstrasi</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- 🔹 Ubah ke POST langsung ke demonstrasi.store -->
            <form method="POST" action="{{ route('demonstrasi.store') }}">
                @csrf
                <div class="modal-body pt-2">
                    <!-- Hidden id_skema & asesor -->
<input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
<input type="hidden" name="id_asesor" value="1">



                    <!-- Instruksi default -->
                    <input type="hidden" name="instruksi" value="Tugas demonstrasi untuk skema {{ $skema->nama_skema }}">

                    <!-- Timer -->
                    <label for="timer" class="fw-bold small mt-3">Timer (menit)</label>
                    <input type="number" name="timer" id="timer" class="form-control" min="1" value="30" required>
                </div>

                <div class="modal-footer border-0">
                    <button type="submit" class="btn w-100 text-white" style="background-color:#041562; font-weight:bold;">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>

@endsection
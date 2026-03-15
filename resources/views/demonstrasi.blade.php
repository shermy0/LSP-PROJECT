@extends('master')
@section('konten')

<div class="container mt-4">

  {{-- Breadcrumb --}}
  <nav class="mb-3" style="font-size: 14px;">
    <a href="#" class="text-primary text-decoration-none">Form Asesmen</a>
    <span class="text-muted mx-1">/</span>
    <span class="text-muted">FR.IA.02</span>
  </nav>

  {{-- Judul Center --}}
  <div class="text-center mb-4">
    <h4 class="fw-bold text-dark mb-1">FR.IA.02 – Tugas Praktik Demonstrasi</h4>
    <p class="text-muted mb-2" style="font-size: 14px;">Skema Sertifikasi Kompetensi</p>
    <span class="badge text-white px-3 py-2" style="background-color: #041562; font-size: 13px; border-radius: 6px;">
      {{ strtoupper($skema->nama_skema) }}
    </span>
    <p class="text-muted mt-2 mb-0" style="font-size: 13px;">{{ $skema->kode_skema ?? 'N/A' }}</p>
  </div>

  {{-- Card: Petunjuk --}}
  <div class="mb-3">
    <label class="form-label fw-bold">Petunjuk</label>
    <div class="border rounded p-3 bg-white" style="font-size: 14px;">
      <p class="mb-2">1. Baca dan pelajari setiap instruksi kerja di bawah ini dengan cermat sebelum melaksanakan praktik.</p>
      <p class="mb-2">2. Identifikasi kepada asesor jika ada hal yang belum jelas.</p>
      <p class="mb-2">3. Laksanakan pekerjaan sesuai urutan proses yang ditetapkan.</p>
      <p class="mb-0">4. Gunakan SOP/IK yang dipersyaratkan (jika ada).</p>
    </div>
  </div>

  {{-- Card: Skenario Tugas --}}
  <div class="mb-3">
    <label class="form-label fw-bold">Skenario Tugas Praktik Demonstrasi</label>
    <div class="border rounded p-3 bg-white" style="font-size: 14px;">
      <p class="mb-2"><strong>Situation:</strong> Anda seorang asesi mengajukan permohonan uji kompetensi untuk jabatan Junior Desain Grafis. Produk yang harus dibuat adalah Logo Perusahaan dan Poster Produk.</p>
      <p class="mb-2"><strong>Task:</strong> Untuk itu Anda diminta pada kelompok kerja 1 membuat Sketsa Logo dan Poster.</p>
      <p class="mb-2"><strong>Perlengkapan dan Peralatan:</strong> PC/Laptop, Printer, Software pengolah vektor & bitmap (Corel/AI/PS), Cutter, Penggaris, Alas.</p>
      <p class="mb-1"><strong>Action:</strong></p>
      <ul class="mb-2 ps-3">
        <li>Mengumpulkan Aset Multimedia</li>
        <li>Membuat Data Based Multimedia</li>
        <li>Mendistribusikan Aset Multimedia</li>
      </ul>
      <p class="mb-0"><strong>Result:</strong> Poster Produk</p>
    </div>
  </div>

  {{-- Tombol Buat Pertanyaan --}}
  <div class="text-end mt-4">
    <button type="button" class="btn text-white px-4 py-2" style="background-color: #041562;"
      data-bs-toggle="modal" data-bs-target="#modalPertanyaan">
      Buat Pertanyaan
    </button>
  </div>

</div>

{{-- Modal Buat Pertanyaan (fungsi tidak diubah) --}}
<div class="modal fade" id="modalPertanyaan" tabindex="-1" aria-labelledby="modalPertanyaanLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
    <div class="modal-content" style="border-radius: 10px; border: none;">
      <div class="modal-header border-0 pb-0">
        <h6 class="modal-title fw-bold" id="modalPertanyaanLabel">Atur Pertanyaan Demonstrasi</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="{{ route('demonstrasi.store') }}">
        @csrf
        <div class="modal-body pt-2">
          <input type="hidden" name="id_skema" value="{{ $skema->id_skema }}">
          <input type="hidden" name="id_asesor" value="1">
          <input type="hidden" name="instruksi" value="Tugas demonstrasi untuk skema {{ $skema->nama_skema }}">
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

@endsection
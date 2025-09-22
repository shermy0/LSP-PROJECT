@extends('master')

@section('title', 'Dashboard Asesor')

@section('konten')
<div class="container py-4">

    {{-- Header --}}
<div class="mb-4">
  <h2 class="fw-bold">
    Selamat Datang {{ $asesi->nama_lengkap ?? $user->name }}
  </h2>
  <p class="text-muted mb-1">
    {{ $asesi->jurusan ?? 'Rekayasa Perangkat Lunak' }}
  </p>
  <span class="phone">
    {{ $asesi->telepon ?? 'Nomor HP belum diisi' }}
  </span>
</div>


  {{-- Status Sertifikasi --}}
  <h5 class="fw-bold mb-3">Status Sertifikasi</h5>
  <div class="row g-3 mb-5">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <p class="text-muted mb-1">Status Asesmen</p>
        <h6 class="fw-bold text-primary">Proses Verifikasi</h6>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <p class="text-muted mb-1">Status Sertifikasi</p>
        <h6 class="fw-bold text-primary">Kompeten</h6>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <p class="text-muted mb-1">Status Ujian</p>
        <h6 class="fw-bold text-primary">Sedang Ujian</h6>
      </div>
    </div>
  </div>

  {{-- Progress --}}
  <h5 class="fw-bold mb-3">Progress</h5>
  <div class="row g-4 align-items-center">
    <div class="col-md-4 text-center">
      <div class="position-relative d-inline-block">
        <!-- Chart lingkaran -->
        <canvas id="progressChart" width="160" height="160"></canvas>
        <!-- Angka di tengah chart -->
        <div class="position-absolute top-50 start-50 translate-middle fw-bold fs-3 text-primary" id="progressValue">
          8
        </div>
      </div>
      <p class="mt-2 text-muted">unit yang diselesaikan</p>
    </div>
    <div class="col-md-8">
      <div class="d-flex flex-column gap-3">
        <div class="card shadow-sm border-0 p-3 rounded-3 active-step">
          Permohonan Sertifikasi Kompetensi
        </div>
        <div class="card shadow-sm border-0 p-3 rounded-3 text-muted d-flex justify-content-between align-items-center">
          Asesmen Mandiri <span>🔒</span>
        </div>
        <div class="card shadow-sm border-0 p-3 rounded-3 text-muted d-flex justify-content-between align-items-center">
          Persetujuan Asesmen dan Kerahasiaan <span>🔒</span>
        </div>
        <div class="card shadow-sm border-0 p-3 rounded-3 text-muted d-flex justify-content-between align-items-center">
          Ceklis Penyesuaian Yang Wajar Dan Beralasan <span>🔒</span>
        </div>
      </div>
    </div>
  </div>

</div>
@endsection

@push('styles')
<style>
.active-step {
  border-left: 6px solid #1E3A8A;
  font-weight: bold;
  color: #1E3A8A;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const total = 10;      // total unit
  const selesai = 8;     // unit selesai
  const sisa = total - selesai;

  // update angka di tengah
  document.getElementById("progressValue").textContent = selesai;

  // render chart lingkaran
  const ctx = document.getElementById('progressChart').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [selesai, sisa], // 8 terisi, 2 kosong
        backgroundColor: ['#1E3A8A', '#e5e7eb'],
        borderWidth: 0
      }]
    },
    options: {
      cutout: '75%',          // lubang di tengah
      responsive: false,      // biar sesuai ukuran canvas
      plugins: {
        legend: { display: false },
        tooltip: { enabled: false }
      },
      animation: {
        duration: 1200,       // animasi isi dari 0 → 8
      }
    }
  });
});
</script>
@endpush

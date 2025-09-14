@extends('master')

@section('title', 'Dashboard Asesor')

@section('konten')
<div class="container py-4">

  {{-- Header --}}
  <div class="mb-4">
    <h2 class="fw-bold">Selamat Datang {{ $user->name }}</h2>
    <p class="text-muted mb-1">{{ $user->jurusan }}</p>
    <span class="text-secondary">{{ $user->no_hp }}</span>
  </div>

  {{-- Status Sertifikasi --}}
  <h5 class="fw-bold mb-3">Status Sertifikasi</h5>
  <div class="row g-3 mb-5">
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <p class="text-muted mb-1">Status Asesmen</p>
        <h6 class="fw-bold text-primary">{{ $statusAsesmen }}</h6>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <p class="text-muted mb-1">Status Sertifikasi</p>
        <h6 class="fw-bold text-primary">{{ $statusSertifikasi }}</h6>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
        <p class="text-muted mb-1">Status Ujian</p>
        <h6 class="fw-bold text-primary">{{ $statusUjian }}</h6>
      </div>
    </div>
  </div>

  {{-- Progress --}}
  <h5 class="fw-bold mb-3">Progress</h5>
  <div class="row g-4 align-items-center">
    <div class="col-md-4 text-center">
      <div class="position-relative d-inline-block">
        <canvas id="progressChart" width="160" height="160"></canvas>
        <div class="position-absolute top-50 start-50 translate-middle fw-bold fs-3 text-primary" id="progressValue">
          {{ $selesaiUnit }}
        </div>
      </div>
      <p class="mt-2 text-muted">unit yang diselesaikan</p>
    </div>
    <div class="col-md-8">
      {{-- Step list bisa juga ambil dari DB --}}
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
        <div class="mt-4 text-center">
  <a href="{{ route('banding.asesmen') }}" class="btn btn-primary px-4 rounded-3">
    <i class="fas fa-exchange-alt me-2"></i> Ajukan Banding Asesmen
  </a>
</div>

      </div>
    </div>
  </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const total = {{ $totalUnit }};
  const selesai = {{ $selesaiUnit }};
  const sisa = total - selesai;

  document.getElementById("progressValue").textContent = selesai;

  const ctx = document.getElementById('progressChart').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      datasets: [{
        data: [selesai, sisa],
        backgroundColor: ['#1E3A8A', '#e5e7eb'],
        borderWidth: 0
      }]
    },
    options: {
      cutout: '75%',
      responsive: false,
      plugins: {
        legend: { display: false },
        tooltip: { enabled: false }
      },
      animation: {
        duration: 1200,
      }
    }
  });
});
</script>
@endpush

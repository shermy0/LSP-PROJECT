@extends('master')

@section('title', 'Dashboard Asesor')

@section('konten')
<div class="container py-4">

  {{-- Judul --}}
  <div class="mb-4">
    <h2 class="fw-bold">Dashboard Admin</h2>
    <p class="text-muted">Kelola asesmen dengan standar profesional terdepan</p>
  </div>

  {{-- 4 Card Statistik --}}
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <div class="icon-box bg-primary text-white rounded-3 me-2">
            <i class="bi bi-bar-chart"></i>
          </div>
        </div>
        <div class="text-center">
          <div class="fw-bold fs-3 text-primary">284</div>
          <p class="mb-1 text-muted">Total Peserta</p>
          <small class="text-primary">12.5 % Growth This Month</small>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <div class="icon-box bg-success text-white rounded-3 me-2">
            <i class="bi bi-file-earmark-text"></i>
          </div>
        </div>
        <div class="text-center">
          <div class="fw-bold fs-3 text-success">284</div>
          <p class="mb-1 text-muted">Sertifikat</p>
          <small class="text-success">12.5 % Growth This Month</small>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <div class="icon-box bg-warning text-white rounded-3 me-2">
            <i class="bi bi-graph-up"></i>
          </div>
        </div>
        <div class="text-center">
          <div class="fw-bold fs-3 text-warning">284</div>
          <p class="mb-1 text-muted">Dalam Progres</p>
          <small class="text-warning">12.5 % Growth This Month</small>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm border-0 rounded-4 p-3">
        <div class="d-flex align-items-center justify-content-center mb-2">
          <div class="icon-box bg-teal text-white rounded-3 me-2">
            <i class="bi bi-award"></i>
          </div>
        </div>
        <div class="text-center">
          <div class="fw-bold fs-3 text-teal">284</div>
          <p class="mb-1 text-muted">Penghargaan</p>
          <small class="text-info">12.5 % Growth This Month</small>
        </div>
      </div>
    </div>
  </div>

  {{-- Grafik Sertifikasi --}}
  <div class="card border-0 shadow-sm rounded-4 p-4">
    <h5 class="fw-bold mb-3">Grafik Sertifikasi</h5>
    <canvas id="barChart" height="100"></canvas>

    <div class="d-flex justify-content-between mt-3 small">
      <span><b class="text-primary">300</b> Total Tersertifikasi</span>
      <span><b class="text-success">18%</b> Rata-rata Pertumbuhan</span>
      <span><b class="text-warning">MPLB</b> Jurusan Terbanyak Sertifikasi</span>
    </div>
  </div>

</div>
@endsection

@push('styles')
<style>
.card {
  border-radius: 1rem !important;
}
.text-teal {
  color: #0d9488;
}
.bg-teal {
  background-color: #0d9488;
}
.icon-box {
  width: 40px;
  height: 40px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
}
</style>
{{-- bootstrap icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const ctx = document.getElementById('barChart').getContext('2d');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['akl','mplb','pemasaran','m-log','dkv','rpl','tjkt'],
      datasets: [{
        data: [45, 65, 30, 15, 40, 50, 10],
        backgroundColor: [
          '#facc15', // akl
          '#3b82f6', // mplb
          '#ef4444', // pemasaran
          '#f97316', // m-log
          '#a855f7', // dkv
          '#22c55e', // rpl
          '#6b7280'  // tjkt
        ],
        borderRadius: 12
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          beginAtZero: true,
          grid: { color: '#f1f1f1' },
          ticks: {
            stepSize: 20,
            callback: function(value) { return value + ' peserta'; }
          }
        },
        x: {
          grid: { display: false }
        }
      }
    }
  });
});
</script>
@endpush

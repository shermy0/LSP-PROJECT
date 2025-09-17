@extends('master')

@section('content')
<div class="container mt-4">

    <!-- Judul -->
    <h2 class="fw-bold">Dashboard Asesi</h2>
    <p class="text-muted">Kelola asesmen dengan standar profesional terdepan</p>

    <!-- Kartu Statistik -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0 rounded-4">
                <h5 class="fw-bold">284</h5>
                <p class="mb-1">Total Peserta</p>
                <span class="badge bg-info text-dark">12.5 % Growth</span>
                <small class="d-block text-muted">This Month</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0 rounded-4">
                <h5 class="fw-bold">284</h5>
                <p class="mb-1">Sertifikat</p>
                <span class="badge bg-success">12.5 % Growth</span>
                <small class="d-block text-muted">This Month</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0 rounded-4">
                <h5 class="fw-bold">284</h5>
                <p class="mb-1">Dalam Progres</p>
                <span class="badge bg-warning text-dark">12.5 % Growth</span>
                <small class="d-block text-muted">This Month</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-3 border-0 rounded-4">
                <h5 class="fw-bold">284</h5>
                <p class="mb-1">Penghargaan</p>
                <span class="badge bg-primary">12.5 % Growth</span>
                <small class="d-block text-muted">This Month</small>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <h5 class="fw-bold mb-3">Grafik Sertifikasi</h5>
        <canvas id="chartSertifikasi" height="120"></canvas>

        <div class="d-flex justify-content-between mt-3">
            <div><span class="fw-bold text-primary">300</span><br><small>Total Tersertifikasi</small></div>
            <div><span class="fw-bold text-success">18%</span><br><small>Rata-rata Pertumbuhan</small></div>
            <div><span class="fw-bold text-warning">MPLB</span><br><small>Jurusan Terbanyak Sertifikasi</small></div>
        </div>
    </div>

</div>


@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('chartSertifikasi').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['akl', 'mplb', 'pemasaran', 'm-log', 'dkv', 'rpl', 'tjkt'],
            datasets: [{
                label: 'Jumlah Peserta',
                data: [40, 70, 35, 20, 45, 50, 25],
                backgroundColor: [
                    '#FFD54F', '#4FC3F7', '#E57373',
                    '#FFB74D', '#BA68C8', '#81C784', '#90A4AE'
                ],
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 20 } }
            }
        }
    });
</script>
@endpush


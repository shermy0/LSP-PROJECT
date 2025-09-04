@extends('master')

@section('konten')
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 flex">
<div class="container mx-auto mt-12 px-8">
    <!-- Main Content -->
    <main class="flex-1">
        <h2 class="text-3xl font-bold mb-2">Dashboard Asesor</h2>
        <p class="text-gray-500 mb-8 text-lg">Kelola asesmen dengan standar profesional terdepan</p>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-10">
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <p class="text-gray-400 text-lg">Total Peserta</p>
                <h3 class="text-3xl font-bold">284</h3>
                <p class="text-green-500 text-sm mt-2">12.5% Growth • This Month</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <p class="text-gray-400 text-lg">Sertifikat</p>
                <h3 class="text-3xl font-bold">284</h3>
                <p class="text-green-500 text-sm mt-2">12.5% Growth • This Month</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <p class="text-gray-400 text-lg">Dalam Progres</p>
                <h3 class="text-3xl font-bold">284</h3>
                <p class="text-yellow-500 text-sm mt-2">12.5% Growth • This Month</p>
            </div>
            <div class="bg-white p-8 rounded-2xl shadow-lg">
                <p class="text-gray-400 text-lg">Penghargaan</p>
                <h3 class="text-3xl font-bold">284</h3>
                <p class="text-green-500 text-sm mt-2">12.5% Growth • This Month</p>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white p-8 rounded-2xl shadow-lg">
            <h3 class="text-xl font-semibold mb-6">Grafik Sertifikasi</h3>
            <canvas id="sertifikasiChart" height="140"></canvas>
            <div class="flex justify-between text-base text-gray-600 mt-6">
                <span><strong>300</strong> Total Tersertifikasi</span>
                <span><strong>18%</strong> Rata-rata Pertumbuhan</span>
                <span><strong>MPLB</strong> Jurusan Terbanyak Sertifikasi</span>
            </div>
        </div>
    </main>
</div>

<script>
    const ctx = document.getElementById('sertifikasiChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['akl', 'mplb', 'pemasaran', 'mm-log', 'dkv', 'rpl', 'tjk'],
            datasets: [{
                label: 'Jumlah Peserta',
                data: [40, 60, 30, 20, 50, 55, 15],
                backgroundColor: ['#fbbf24','#3b82f6','#ef4444','#8b5cf6','#10b981','#6366f1','#9ca3af'],
                borderRadius: 10
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false }},
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 20 }}
            }
        }
    });
</script>

@endsection

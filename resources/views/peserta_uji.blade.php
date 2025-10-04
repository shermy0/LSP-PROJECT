@extends('master')

@section('konten')
<div class="container mt-4">
    <!-- Header Section -->
    <div class="mb-4">
        <h2 class="fw-bold mb-2">
            <span class="text-primary">📈</span> Hasil Asesmen
        </h2>
        <p class="text-muted">Ringkasan pencapaian asesmen Anda</p>
    </div>

    @forelse($rekap as $r)
        <!-- Card per Asesmen -->
        <div class="card shadow-sm mb-3 border-0 hover-card">
            <div class="card-body p-4">
                <div class="row align-items-center">
                    <!-- Info Utama -->
                    <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                        <h5 class="fw-bold mb-2 text-navy">{{ $r['skema'] }}</h5>
                        <span class="badge badge-custom px-3 py-2">
                            {{ ucwords(str_replace('_', ' ', $r['jenis'])) }}
                        </span>
                    </div>

                    <!-- Statistik -->
                    <div class="col-lg-5 col-md-6 mb-3 mb-lg-0">
                        <div class="row g-3">
                            <div class="col-4 text-center">
                                <div class="stat-box">
                                    <div class="stat-number stat-primary fw-bold fs-4">{{ $r['total'] }}</div>
                                    <small class="text-muted">Total Soal</small>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="stat-box">
                                    <div class="stat-number text-success fw-bold fs-4">{{ $r['benar'] ?? '-' }}</div>
                                    <small class="text-muted">Benar</small>
                                </div>
                            </div>
                            <div class="col-4 text-center">
                                <div class="stat-box">
                                    <div class="stat-number text-danger fw-bold fs-4">{{ $r['salah'] ?? '-' }}</div>
                                    <small class="text-muted">Salah</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Persentase & Aksi -->
                    <div class="col-lg-3 text-lg-end text-center">
                        @if(!is_null($r['persentase']))
                            <div class="mb-3">
                                <div class="progress progress-custom" style="height: 8px;">
                                    <div class="progress-bar 
                                        @if($r['persentase'] >= 80) bg-success
                                        @elseif($r['persentase'] >= 60) bg-warning
                                        @else bg-danger
                                        @endif" 
                                        role="progressbar" 
                                        style="width: {{ $r['persentase'] }}%"
                                        aria-valuenow="{{ $r['persentase'] }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <span class="fw-bold fs-5 
                                    @if($r['persentase'] >= 80) text-success
                                    @elseif($r['persentase'] >= 60) text-warning
                                    @else text-danger
                                    @endif">
                                    {{ $r['persentase'] }}%
                                </span>
                            </div>
                        @else
                            <div class="mb-3">
                                <span class="text-muted">-</span>
                            </div>
                        @endif
                        
                        <a href="{{ route('detail.jawaban', ['skema' => $r['skema'], 'jenis' => $r['jenis']]) }}" 
                        class="btn btn-navy btn-sm px-4 text-white">
                            🔎 Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <!-- Empty State -->
        <div class="text-center py-5">
            <div class="empty-state">
                <div class="mb-3 empty-icon">📋</div>
                <h5 class="text-navy fw-normal">Belum ada data asesmen</h5>
                <p class="text-muted small">Data hasil ujian Anda akan muncul di sini</p>
            </div>
        </div>
    @endforelse
</div>
@endsection
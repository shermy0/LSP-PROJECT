@extends('master')
@section('konten')
<div class="container mt-5 mb-5">
    <!-- Header Section -->
    <div class="text-center mb-5">
        <div class="d-inline-block p-3 bg-gradient-primary rounded-circle mb-3">
            <i class="bi bi-clipboard-check text-white" style="font-size: 2.5rem;"></i>
        </div>
        <h2 class="fw-bold mb-2" style="color: #1a1a2e;">Pilih Asesmen</h2>
        <p class="text-muted fs-5">
            Halo, <span class="fw-semibold text-dark">{{ $asesi->nama_lengkap ?? 'Asesi' }}</span>!  
        </p>
        <p class="text-muted">
            Silakan pilih jenis asesmen yang ingin kamu kerjakan berdasarkan skema sertifikasi yang kamu miliki.
        </p>
    </div>

    @forelse($skemaList as $skema)
        <div class="card modern-card mb-4">
            <!-- Card Header -->
            <div class="card-header-modern">
                <div class="d-flex align-items-center">
                    <div class="icon-wrapper me-3">
                        <i class="bi bi-award-fill"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $skema->nama_skema }}</h5>
                        <small class="text-muted">Kode: <span class="badge bg-light text-dark">{{ $skema->kode_skema }}</span></small>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                @php
                    $isPilihanGandaSelesai = $statusAsesmen[$skema->id_skema]['pilihan_ganda'] ?? false;
                    $isEsaiSelesai = $statusAsesmen[$skema->id_skema]['esai'] ?? false;
                    $isLisanSelesai = $statusAsesmen[$skema->id_skema]['lisan'] ?? false;
                    $isTtdLisanSelesai = $statusAsesmen[$skema->id_skema]['ttd_lisan_selesai'] ?? false;
                @endphp
                
                <!-- Pilihan Ganda -->
                <div class="assessment-card mb-3">
                    <div class="assessment-content {{ $isPilihanGandaSelesai ? 'completed' : '' }}">
                        <div class="assessment-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <div class="assessment-info flex-grow-1">
                            <h6 class="fw-semibold mb-1">Asesmen Pilihan Ganda</h6>
                            @if($isPilihanGandaSelesai)
                                <span class="status-badge completed">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Sudah Dikerjakan
                                </span>
                            @else
                                <small class="text-muted">Klik tombol untuk memulai asesmen</small>
                            @endif
                        </div>
                        <button onclick="konfirmasiMulai('{{ $skema->nama_skema }}', '{{ url('/jawaban/' . $skema->id_skema . '/pilihan_ganda') }}', 'Pilihan Ganda')" 
                           class="btn-assessment {{ $isPilihanGandaSelesai ? 'disabled' : '' }}"
                           {{ $isPilihanGandaSelesai ? 'disabled' : '' }}>
                            <i class="bi {{ $isPilihanGandaSelesai ? 'bi-lock-fill' : 'bi-play-circle-fill' }} me-2"></i> 
                            {{ $isPilihanGandaSelesai ? 'Terkunci' : 'Mulai' }}
                        </button>
                    </div>
                </div>

                <!-- Esai -->
                <div class="assessment-card mb-3">
                    <div class="assessment-content {{ $isEsaiSelesai ? 'completed' : '' }}">
                        <div class="assessment-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <div class="assessment-info flex-grow-1">
                            <h6 class="fw-semibold mb-1">Asesmen Esai</h6>
                            @if($isEsaiSelesai)
                                <span class="status-badge completed">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Sudah Dikerjakan
                                </span>
                            @else
                                <small class="text-muted">Klik tombol untuk memulai asesmen</small>
                            @endif
                        </div>
                        <button onclick="konfirmasiMulai('{{ $skema->nama_skema }}', '{{ url('/jawaban/' . $skema->id_skema . '/esai') }}', 'Esai')" 
                           class="btn-assessment {{ $isEsaiSelesai ? 'disabled' : '' }}"
                           {{ $isEsaiSelesai ? 'disabled' : '' }}>
                            <i class="bi {{ $isEsaiSelesai ? 'bi-lock-fill' : 'bi-play-circle-fill' }} me-2"></i> 
                            {{ $isEsaiSelesai ? 'Terkunci' : 'Mulai' }}
                        </button>
                    </div>
                </div>

                <!-- Lisan/Demonstrasi -->
                <div class="assessment-card">
                    <div class="assessment-content {{ $isTtdLisanSelesai ? 'completed' : ($isLisanSelesai ? 'pending' : 'locked') }}">
                        <div class="assessment-icon">
                            <i class="bi bi-person-video3"></i>
                        </div>
                        <div class="assessment-info flex-grow-1">
                            <h6 class="fw-semibold mb-1">Tanda Tangan Asesmen Lisan</h6>
                            @if($isTtdLisanSelesai)
                                <span class="status-badge completed">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    Sudah Tanda Tangan — Terkunci
                                </span>
                            @elseif($isLisanSelesai)
                                <span class="status-badge pending">
                                    <i class="bi bi-unlock-fill me-1"></i>
                                    Sudah Dikerjakan — Silakan Tanda Tangan
                                </span>
                            @else
                                <span class="status-badge locked">
                                    <i class="bi bi-lock-fill me-1"></i>
                                    Belum Dikerjakan
                                </span>
                            @endif
                        </div>
                        <button onclick="konfirmasiMulaiTtd('{{ $skema->nama_skema }}', '{{ url('/jawaban/lisan/ttd/' . $skema->id_skema) }}')"
                            class="btn-assessment {{ $isTtdLisanSelesai || !$isLisanSelesai ? 'disabled' : ($isLisanSelesai ? 'active' : '') }}"
                            {{ $isTtdLisanSelesai || !$isLisanSelesai ? 'disabled' : '' }}>
                            <i class="bi {{ $isTtdLisanSelesai ? 'bi-lock-fill' : ($isLisanSelesai ? 'bi-pen-fill' : 'bi-lock-fill') }} me-2"></i>
                            {{ $isTtdLisanSelesai ? 'Terkunci' : ($isLisanSelesai ? 'Tanda Tangan' : 'Terkunci') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-warning text-center modern-alert">
            <i class="bi bi-exclamation-triangle me-2" style="font-size: 1.5rem;"></i>
            <div>
                <strong>Tidak Ada Skema</strong>
                <p class="mb-0 mt-2">Kamu belum memiliki skema sertifikasi yang terhubung dengan asesor.</p>
            </div>
        </div>
    @endforelse
</div>

<script>
function konfirmasiMulai(namaSkema, url, jenisAsesmen) {
    Swal.fire({
        title: '⚠️ Yakin Mulai Asesmen?',
        html: `
            <div style="text-align: left; padding: 10px 20px;">
                <p class="mb-2"><strong>Skema:</strong> ${namaSkema}</p>
                <p class="mb-3"><strong>Jenis Asesmen:</strong> ${jenisAsesmen}</p>
                <div class="alert alert-info mb-0" style="font-size: 0.9rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Perhatian:</strong>
                    <ul class="mb-0 mt-2" style="padding-left: 20px;">
                        <li>Waktu akan dimulai setelah Anda klik "Ya, Mulai"</li>
                        <li>Pastikan koneksi internet stabil</li>
                        <li>Jangan refresh atau tutup halaman selama asesmen</li>
                        <li>Jawaban akan otomatis tersimpan saat waktu habis</li>
                    </ul>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-play-fill me-1"></i> Ya, Mulai Sekarang!',
        cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        width: '600px',
        allowOutsideClick: false,
        allowEscapeKey: false,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memuat Asesmen...',
                html: 'Mohon tunggu sebentar...',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                Swal.close();
                window.location.href = url;
            }, 800);
        }

        window.addEventListener('beforeunload', () => {
            Swal.close();
        });
    });
}

function konfirmasiMulaiTtd(namaSkema, url, jenisAsesmen) {
    Swal.fire({
        title: '⚠️ Yakin Tanda Tangan Asesmen Lisan?',
        html: `
            <div style="text-align: left; padding: 10px 20px;">
                <p class="mb-2"><strong>Skema:</strong> ${namaSkema}</p>
                <p class="mb-3"><strong>Tanda Tangan Asesmen Lisan</strong> </p>
                <div class="alert alert-info mb-0" style="font-size: 0.9rem;">
                    <i class="bi bi-info-circle me-1"></i>
                    <strong>Perhatian:</strong>
                    <ul class="mb-0 mt-2" style="padding-left: 20px;">
                        <li>Sekarang anda hanya perlu tanda tangan saja</li>
                    </ul>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-play-fill me-1"></i> Ya, Tanda Tangan Sekarang!',
        cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        reverseButtons: true,
        width: '600px',
        allowOutsideClick: false,
        allowEscapeKey: false,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memuat Form Tanda Tangan...',
                html: 'Mohon tunggu sebentar...',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            setTimeout(() => {
                Swal.close();
                window.location.href = url;
            }, 1000);
        }

        window.addEventListener('beforeunload', () => {
            Swal.close();
        });
    });
}
</script>

<style>
:root {
    --primary-color: #4f46e5;
    --primary-hover: #4338ca;
    --success-color: #10b981;
    --warning-color: #f59e0b;
    --danger-color: #ef4444;
    --text-dark: #1a1a2e;
    --text-muted: #6b7280;
    --border-color: #e5e7eb;
    --bg-light: #f9fafb;
}

.bg-gradient-primary {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
}

/* Modern Card Styles */
.modern-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.modern-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.card-header-modern {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 1.5rem;
    border: none;
    color: white;
}

.icon-wrapper {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.icon-wrapper i {
    font-size: 1.5rem;
    color: white;
}

/* Assessment Card Styles */
.assessment-card {
    margin-bottom: 1rem;
}

.assessment-content {
    display: flex;
    align-items: center;
    padding: 1.5rem;
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    transition: all 0.3s ease;
}

.assessment-content:hover:not(.completed):not(.locked) {
    border-color: var(--primary-color);
    box-shadow: 0 4px 12px rgba(79, 70, 229, 0.15);
    transform: translateX(4px);
}

.assessment-content.completed {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border-color: var(--success-color);
}

.assessment-content.pending {
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    border-color: var(--warning-color);
}

.assessment-content.locked {
    background: var(--bg-light);
    border-color: var(--border-color);
    opacity: 0.7;
}

.assessment-icon {
    width: 48px;
    height: 48px;
    min-width: 48px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
}

.assessment-content.completed .assessment-icon {
    background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
}

.assessment-content.pending .assessment-icon {
    background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
}

.assessment-content.locked .assessment-icon {
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
}

.assessment-icon i {
    font-size: 1.5rem;
    color: white;
}

.assessment-info {
    flex-grow: 1;
}

.assessment-info h6 {
    color: var(--text-dark);
    margin-bottom: 0.25rem;
    font-size: 1rem;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    font-size: 0.813rem;
    font-weight: 500;
}

.status-badge.completed {
    background: var(--success-color);
    color: white;
}

.status-badge.pending {
    background: var(--warning-color);
    color: white;
}

.status-badge.locked {
    background: #9ca3af;
    color: white;
}

/* Button Styles */
.btn-assessment {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-hover) 100%);
    color: white;
    font-weight: 600;
    font-size: 0.938rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    white-space: nowrap;
    box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.3);
}

.btn-assessment:hover:not(.disabled) {
    transform: translateY(-2px);
    box-shadow: 0 8px 12px -1px rgba(79, 70, 229, 0.4);
}

.btn-assessment:active:not(.disabled) {
    transform: translateY(0);
}

.btn-assessment.active {
    background: linear-gradient(135deg, var(--warning-color) 0%, #d97706 100%);
    box-shadow: 0 4px 6px -1px rgba(245, 158, 11, 0.3);
}

.btn-assessment.active:hover {
    box-shadow: 0 8px 12px -1px rgba(245, 158, 11, 0.4);
}

.btn-assessment.disabled {
    background: linear-gradient(135deg, #9ca3af 0%, #6b7280 100%);
    cursor: not-allowed;
    opacity: 0.6;
    box-shadow: none;
}

.btn-assessment.disabled:hover {
    transform: none;
}

/* Modern Alert */
.modern-alert {
    border: none;
    border-radius: 12px;
    padding: 2rem;
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-left: 4px solid var(--warning-color);
}

/* Responsive */
@media (max-width: 768px) {
    .assessment-content {
        flex-direction: column;
        text-align: center;
    }

    .assessment-icon {
        margin-right: 0;
        margin-bottom: 1rem;
    }

    .assessment-info {
        margin-bottom: 1rem;
    }

    .btn-assessment {
        width: 100%;
        justify-content: center;
    }

    .card-header-modern {
        text-align: center;
    }

    .card-header-modern .d-flex {
        flex-direction: column;
    }

    .icon-wrapper {
        margin: 0 auto 1rem;
    }
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.modern-card {
    animation: fadeInUp 0.5s ease-out;
}

.modern-card:nth-child(2) {
    animation-delay: 0.1s;
}

.modern-card:nth-child(3) {
    animation-delay: 0.2s;
}
</style>
@endsection 
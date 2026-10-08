@extends('master')

@section('title', 'Daftar Banding Asesmen')

@section('konten')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4 header-card">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="bi bi-exclamation-triangle fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold" style="color: #041562;">Banding Asesmen</h4>
                        <p class="mb-0 text-muted">Daftar pengajuan banding dari asesi</p>
                    </div>
                </div>
                
                <form class="d-flex search-wrapper" method="GET" action="{{ route('admin.banding-asesmen.index') }}">
                    <input name="q" value="{{ request('q') }}" type="search" class="form-control search-input" 
                           placeholder="Cari nama asesi / skema...">
                    <i class="bi bi-search search-icon"></i>
                </form>
            </div>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-check-circle-fill me-3 fs-5 flex-shrink-0"></i>
                <div class="flex-grow-1">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-5 flex-shrink-0"></i>
                <div class="flex-grow-1">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Card Daftar Banding --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h6 class="mb-1 fw-semibold" style="color: #041562;">
                        <i class="bi bi-list-ul me-2"></i>Daftar Pengajuan Banding
                    </h6>
                    <small class="text-muted">Berikut adalah semua pengajuan banding dari asesi</small>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>Nama Asesi</th>
                            <th>Skema Sertifikasi</th>
                            <th>Tanggal Banding</th>
                            <th>Status Tanda Tangan</th>
                            <th class="text-center" width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bandings as $index => $banding)
                            <tr>
                                <td class="text-center">
                                    <span class="badge-id">
                                        {{ $loop->iteration }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <span class="fw-semibold text-dark">
                                            {{ $banding->asesi->user->name ?? $banding->asesi->nama_asesi ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    @if($banding->permohonan && $banding->permohonan->skema)
                                        <span class="badge bg-info">{{ $banding->permohonan->skema->nama_skema }}</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-dark">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($banding->tgl_banding)->format('d M Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($banding->created_at)->format('H:i') }}
                                        </small>
                                    </div>
                                </td>

                                <td>
                                    @if($banding->persetujuan && $banding->persetujuan->ttd_asesi)
                                        <span class="badge bg-success">Sudah Ditandatangani</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Belum Ditandatangani</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.banding-asesmen.show', $banding->id_banding) }}" 
                                       class="btn btn-sm btn-primary-custom">
                                        <i class="bi bi-eye me-1"></i> Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p class="mb-1 mt-3 fw-semibold">Belum Ada Pengajuan Banding</p>
                                        <small class="text-muted">Tidak ada data banding yang ditemukan</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($bandings, 'links') && $bandings->total() > 0)
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="text-muted small">
                        <i class="bi bi-list-ul me-2"></i>
                        Menampilkan <strong>{{ $bandings->firstItem() }}</strong> - <strong>{{ $bandings->lastItem() }}</strong>
                        dari <strong>{{ $bandings->total() }}</strong> data
                    </div>
                    <nav aria-label="Pagination">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous --}}
                            @if ($bandings->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bandings->previousPageUrl() }}" aria-label="Previous">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @php
                                $start = max($bandings->currentPage() - 2, 1);
                                $end = min($start + 4, $bandings->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bandings->url(1) }}">1</a>
                                </li>
                                @if($start > 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            @for($i = $start; $i <= $end; $i++)
                                @if ($i == $bandings->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $bandings->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if($end < $bandings->lastPage())
                                @if($end < $bandings->lastPage() - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $bandings->url($bandings->lastPage()) }}">{{ $bandings->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next --}}
                            @if ($bandings->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $bandings->nextPageUrl() }}" aria-label="Next">
                                        <i class="bi bi-chevron-right"></i>
                                    </a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ================== CUSTOM CSS ================== --}}
<style>
    /* Primary Color Variables */
    :root {
        --primary-dark: #041562;
        --primary-light: #E9F1FF;
    }

    /* Header Card */
    .header-card {
        border-left: 4px solid var(--primary-dark);
    }

    /* Icon Box */
    .icon-box {
        width: 60px;
        height: 60px;
        background: var(--primary-light);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-dark);
    }

    /* Custom Primary Button */
    .btn-primary-custom {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
        font-weight: 500;
        padding: 8px 16px;
        border-radius: 8px;
        transition: all 0.3s ease;
        font-size: 14px;
    }

    .btn-primary-custom:hover {
        background-color: #030f45;
        border-color: #030f45;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(4, 21, 98, 0.3);
    }

    .btn-primary-custom:active {
        background-color: #020a30 !important;
        border-color: #020a30 !important;
    }

    /* Search Wrapper */
    .search-wrapper {
        position: relative;
        min-width: 300px;
    }

    .search-input {
        padding-left: 40px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
        height: 44px;
    }

    .search-input:focus {
        border-color: var(--primary-dark);
        box-shadow: 0 0 0 3px rgba(4, 21, 98, 0.1);
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        pointer-events: none;
    }

    /* Avatar Circle */
    .avatar-circle {
        width: 40px;
        height: 40px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-dark);
        font-size: 18px;
        flex-shrink: 0;
    }

    .avatar-circle-sm {
        width: 32px;
        height: 32px;
        background: var(--primary-light);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-dark);
        font-size: 14px;
        flex-shrink: 0;
    }

    /* Badge ID */
    .badge-id {
        display: inline-block;
        padding: 6px 12px;
        background: var(--primary-light);
        color: var(--primary-dark);
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }

    /* Badge Keahlian */
    .badge-keahlian {
        display: inline-block;
        padding: 5px 12px;
        background: #e8f4f8;
        color: #0c5460;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Table Styling */
    table thead {
        background-color: var(--primary-light);
        color: var(--primary-dark);
    }

    table thead th {
        font-weight: 600;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 14px 16px;
        border: none;
    }

    table tbody td {
        padding: 14px 16px;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9ff;
    }

    /* Empty State */
    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
    }

    /* Pagination Custom */
    .pagination .page-link {
        border-radius: 6px;
        margin: 0 3px;
        border: 1px solid #dee2e6;
        color: var(--primary-dark);
        font-weight: 500;
        min-width: 36px;
        text-align: center;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background-color: var(--primary-light);
        border-color: var(--primary-dark);
        color: var(--primary-dark);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
        font-weight: 600;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
    }

    /* Modal Styling */
    .modal-icon {
        width: 48px;
        height: 48px;
        background: var(--primary-light);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary-dark);
        font-size: 24px;
    }

    /* Alerts */
    .alert {
        border-radius: 8px;
    }

    /* Badge styling */
    .badge.bg-secondary {
        background-color: #6c757d !important;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge.bg-success {
        background-color: #28a745 !important;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge.bg-warning {
        background-color: #ffc107 !important;
        color: #212529;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge.bg-info {
        background-color: #17a2b8 !important;
        color: white;
        padding: 5px 10px;
        font-size: 12px;
        font-weight: 500;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .icon-box {
            width: 48px;
            height: 48px;
        }

        .icon-box i {
            font-size: 1.3rem !important;
        }

        table thead th {
            font-size: 11px;
            padding: 10px 8px;
        }

        table tbody td {
            font-size: 13px;
            padding: 10px 8px;
        }

        .badge-id,
        .badge-keahlian {
            font-size: 11px;
            padding: 4px 8px;
        }
        
        .search-wrapper {
            min-width: 100%;
            margin-top: 10px;
        }
    }
</style>

{{-- ================== SCRIPT ================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endsection
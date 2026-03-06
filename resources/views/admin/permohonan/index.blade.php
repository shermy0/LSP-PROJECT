@extends('master')

@section('title', 'Daftar Form Pra Asesmen')

@section('konten')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4 header-card">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="bi bi-journal-check fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold" style="color: #041562;">Daftar Permohonan Asesi</h4>
                        <p class="mb-0 text-muted">Berikut daftar pengajuan FR.APL.01 oleh Asesi</p>
                    </div>
                </div>
                <div class="search-wrapper">
                    <input type="text" id="searchInput" class="form-control search-input" 
                           placeholder="Cari asesi berdasarkan nama, email, atau NIK...">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Search & Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h6 class="mb-1 fw-semibold" style="color: #041562;">
                        <i class="bi bi-list-ul me-2"></i>Daftar Pengajuan
                    </h6>
                    <small class="text-muted">Formulir FR.APL.01 - Permohonan Sertifikasi Kompetensi</small>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="asesiTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>Nama Asesi</th>
                            <th width="140">NIK</th>
                            <th>Email</th>
                            <th width="120">Telepon</th>
                            <th width="160">Update Terakhir</th>
                            <th class="text-center" width="140">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($asesi as $a)
                            <tr>
                                {{-- NOMOR URUT --}}
                                <td class="text-center">
                                    <span class="badge-id">
                                        {{ $asesi->firstItem() + $loop->index }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <span class="fw-semibold text-dark">
                                            {{ $a->nama_lengkap }}
                                        </span>
                                    </div>
                                </td>

                                <td><span class="text-muted small">{{ $a->nik }}</span></td>
                                <td><small class="text-muted">{{ $a->email }}</small></td>
                                <td><span class="text-muted small">{{ $a->telepon ?? '-' }}</span></td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-dark">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ \Carbon\Carbon::parse($a->updated_at)->format('d M Y') }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ \Carbon\Carbon::parse($a->updated_at)->format('H:i') }}
                                        </small>
                                    </div>
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('admin.permohonan.show', $a->id_asesi) }}" 
                                       class="btn btn-sm btn-outline-custom">
                                        <i class="bi bi-eye me-1"></i>Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p class="mb-1 mt-3 fw-semibold">Belum Ada Data Pengajuan</p>
                                        <small class="text-muted">Belum ada formulir permohonan yang diajukan oleh asesi</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($asesi, 'links') && $asesi->total() > 0)
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="text-muted small">
                        <i class="bi bi-list-ul me-2"></i>
                        Menampilkan <strong>{{ $asesi->firstItem() }}</strong> - <strong>{{ $asesi->lastItem() }}</strong>
                        dari <strong>{{ $asesi->total() }}</strong> data
                    </div>
                    <nav aria-label="Pagination">
                        <ul class="pagination pagination-sm mb-0">
                            {{-- Previous --}}
                            @if ($asesi->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $asesi->previousPageUrl() }}" aria-label="Previous">
                                        <i class="bi bi-chevron-left"></i>
                                    </a>
                                </li>
                            @endif

                            {{-- Page Numbers --}}
                            @php
                                $start = max($asesi->currentPage() - 2, 1);
                                $end = min($start + 4, $asesi->lastPage());
                                $start = max($end - 4, 1);
                            @endphp

                            @if($start > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ $asesi->url(1) }}">1</a>
                                </li>
                                @if($start > 2)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                            @endif

                            @for($i = $start; $i <= $end; $i++)
                                @if ($i == $asesi->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $i }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $asesi->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor

                            @if($end < $asesi->lastPage())
                                @if($end < $asesi->lastPage() - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                @endif
                                <li class="page-item">
                                    <a class="page-link"
                                        href="{{ $asesi->url($asesi->lastPage()) }}">{{ $asesi->lastPage() }}</a>
                                </li>
                            @endif

                            {{-- Next --}}
                            @if ($asesi->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $asesi->nextPageUrl() }}" aria-label="Next">
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

    /* Custom Outline Button */
    .btn-outline-custom {
        border-color: var(--primary-dark);
        color: var(--primary-dark);
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 6px 12px;
        font-size: 14px;
    }

    .btn-outline-custom:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(4, 21, 98, 0.2);
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

    /* Alerts */
    .alert {
        border-radius: 8px;
    }

    /* Hover Effects */
    .btn {
        transition: all 0.3s ease;
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

        .badge-id {
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
        // Search functionality with debounce
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('asesiTable');
        const rows = table ? table.querySelectorAll('tbody tr') : [];

        if (searchInput && rows.length > 0) {
            let debounceTimer;
            searchInput.addEventListener('keyup', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const keyword = this.value.toLowerCase().trim();
                    let visibleCount = 0;

                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        const shouldShow = text.includes(keyword);
                        row.style.display = shouldShow ? '' : 'none';
                        if (shouldShow) visibleCount++;
                    });

                    // Optional: Show message if no results
                    const noResultsRow = table.querySelector('.no-results-row');
                    if (visibleCount === 0 && !row.classList.contains('no-results-row')) {
                        console.log('Tidak ada hasil yang cocok');
                    }
                }, 300);
            });
        }

        // Auto-dismiss alerts after 5 seconds (if any)
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                try {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                } catch (e) {
                    // If Bootstrap alert is not available, just hide it
                    alert.style.display = 'none';
                }
            }, 5000);
        });
    });
</script>
@endsection
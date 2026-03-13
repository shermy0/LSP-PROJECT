@extends('master')

@section('title', 'Daftar Persetujuan Asesmen')

@section('konten')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4 header-card">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="bi bi-file-earmark-check fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold" style="color: #0b2f7c;">Daftar Persetujuan Asesmen</h4>
                        <p class="mb-0 text-muted">Kelola persetujuan asesmen (FR.AK.01) untuk asesi yang ditugaskan</p>
                    </div>
                </div>
                <div class="search-wrapper">
                    <input type="text" id="searchInput" class="form-control search-input"
                           placeholder="Cari asesi...">
                    <i class="bi bi-search search-icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h6 class="mb-1 fw-semibold" style="color: #0b2f7c;">
                        <i class="bi bi-list-ul me-2"></i>Daftar Permohonan
                    </h6>
                    <small class="text-muted">Asesi yang ditugaskan kepada Anda</small>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="permohonanTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>Nama Asesi</th>
                            <th>NIK</th>
                            <th>Skema</th>
                            <th>Status Persetujuan</th>
                            <th>Update Terakhir</th>
                            <th class="text-center" width="200">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($permohonan as $p)
                            @php
                                $persetujuan = $p->persetujuan;
                                $status = $persetujuan->status ?? null;
                                $statusBadge = '';
                                $statusText = '';
                                if (!$persetujuan) {
                                    $statusBadge = 'bg-secondary';
                                    $statusText = 'Belum dibuat';
                                } elseif ($status == 'draf') {
                                    $statusBadge = 'bg-warning text-dark';
                                    $statusText = 'Draf (menunggu TTD asesi)';
                                } elseif ($status == 'menunggu_asesor') {
                                    $statusBadge = 'bg-info';
                                    $statusText = 'Menunggu TTD Asesor';
                                } elseif ($status == 'selesai') {
                                    $statusBadge = 'bg-success';
                                    $statusText = 'Selesai';
                                }
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <span class="badge-id">
                                        {{ $permohonan->firstItem() + $loop->index }}
                                    </span>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="avatar-circle">
                                            <i class="bi bi-person-fill"></i>
                                        </div>
                                        <span class="fw-semibold text-dark">
                                            {{ $p->asesi->nama_lengkap ?? '-' }}
                                        </span>
                                    </div>
                                </td>

                                <td><span class="text-muted small">{{ $p->asesi->nik ?? '-' }}</span></td>

                                <td><span class="text-muted small">{{ $p->skema->nama_skema ?? '-' }}</span></td>

                                <td>
                                    <span class="badge {{ $statusBadge }}">{{ $statusText }}</span>
                                </td>

                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-dark">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $p->updated_at ? \Carbon\Carbon::parse($p->updated_at)->format('d M Y') : '-' }}
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i>
                                            {{ $p->updated_at ? \Carbon\Carbon::parse($p->updated_at)->format('H:i') : '-' }}
                                        </small>
                                    </div>
                                </td>

                                <td class="text-center">
                                    @if (!$persetujuan)
                                        <a href="{{ route('asesor.persetujuan_asesmen.create', $p->id_permohonan) }}"
                                           class="btn btn-sm btn-primary-custom">
                                            <i class="bi bi-plus-circle me-1"></i>Buat
                                        </a>
                                    @elseif ($status == 'draf')
                                        <a href="{{ route('asesor.persetujuan_asesmen.show', $persetujuan->id_persetujuan) }}"
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil me-1"></i>Lihat
                                        </a>
                                    @elseif ($status == 'menunggu_asesor')
                                        <a href="{{ route('asesor.persetujuan_asesmen.show', $persetujuan->id_persetujuan) }}"
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-pen me-1"></i>Tanda Tangan
                                        </a>
                                    @elseif ($status == 'selesai')
                                        <a href="{{ route('asesor.persetujuan_asesmen.show', $persetujuan->id_persetujuan) }}"
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-eye me-1"></i>Lihat
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="bi bi-inbox"></i>
                                        <p class="mb-1 mt-3 fw-semibold">Belum Ada Permohonan</p>
                                        <small class="text-muted">Tidak ada asesi yang ditugaskan kepada Anda</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($permohonan, 'links') && $permohonan->total() > 0)
            <div class="card-footer bg-white border-top py-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div class="text-muted small">
                        <i class="bi bi-list-ul me-2"></i>
                        Menampilkan <strong>{{ $permohonan->firstItem() }}</strong> - <strong>{{ $permohonan->lastItem() }}</strong>
                        dari <strong>{{ $permohonan->total() }}</strong> data
                    </div>
                    <nav aria-label="Pagination">
                        {{ $permohonan->links() }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ================== CUSTOM CSS ================== --}}
<style>
    /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
    :root {
        --primary: #0b2f7c;
        --primary-dark: #08205c;
        --primary-light: #e9effa;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --font-sans: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    body {
        font-family: var(--font-sans);
        background-color: #f1f4f9;
    }

    .container-fluid {
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ===== CARD STYLE ===== */
    .card {
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .card:hover {
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.08) !important;
    }

    .card-header {
        background: transparent;
        padding-bottom: 0;
    }

    /* ===== WARNA UTAMA #0b2f7c ===== */
    .bg-primary {
        background-color: var(--primary) !important;
    }

    .bg-primary.bg-gradient {
        background: linear-gradient(145deg, var(--primary), var(--primary-dark)) !important;
    }

    .bg-primary.bg-opacity-10 {
        background-color: rgba(11,47,124,0.1) !important;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    /* Header Card */
    .header-card {
        border-left: 4px solid var(--primary);
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
        color: var(--primary);
    }

    /* Custom Primary Button */
    .btn-primary-custom {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        font-weight: 500;
        transition: all 0.3s ease;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 2rem;
    }

    .btn-primary-custom:hover {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(11,47,124,0.2);
    }

    /* Custom Outline Buttons */
    .btn-outline-warning,
    .btn-outline-info,
    .btn-outline-success {
        border-width: 1.5px;
        font-weight: 500;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 2rem;
        transition: all 0.3s ease;
    }

    .btn-outline-warning:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #212529;
    }

    .btn-outline-info:hover {
        background-color: #0dcaf0;
        border-color: #0dcaf0;
        color: #000;
    }

    .btn-outline-success:hover {
        background-color: #198754;
        border-color: #198754;
        color: white;
    }

    /* Search Wrapper */
    .search-wrapper {
        position: relative;
        min-width: 300px;
    }

    .search-input {
        padding-left: 40px;
        border: 1.5px solid #e2e8f0;
        border-radius: 2rem;
        transition: all 0.3s ease;
        height: 44px;
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(11,47,124,0.15);
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
        color: var(--primary);
        font-size: 18px;
        flex-shrink: 0;
    }

    /* Badge ID */
    .badge-id {
        display: inline-block;
        padding: 6px 12px;
        background: var(--primary-light);
        color: var(--primary);
        border-radius: 2rem;
        font-weight: 600;
        font-size: 13px;
    }

    /* Table Styling */
    table thead {
        background-color: var(--primary-light);
        color: var(--primary);
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
        background-color: #f8fbff;
    }

    /* Empty State */
    .empty-state i {
        font-size: 4rem;
        color: #dee2e6;
    }

    /* Pagination Custom */
    .pagination .page-link {
        border-radius: 2rem;
        margin: 0 3px;
        border: 1.5px solid #e2e8f0;
        color: var(--primary);
        font-weight: 500;
        min-width: 36px;
        text-align: center;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background-color: var(--primary-light);
        border-color: var(--primary);
        color: var(--primary);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
        font-weight: 600;
    }

    .pagination .page-item.disabled .page-link {
        background-color: #f8f9fa;
        border-color: #dee2e6;
        color: #6c757d;
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
        const table = document.getElementById('permohonanTable');
        const rows = table ? table.querySelectorAll('tbody tr') : [];

        if (searchInput && rows.length > 0) {
            let debounceTimer;
            searchInput.addEventListener('keyup', function () {
                clearTimeout(debounceTimer);
                debounceTimer = setTimeout(() => {
                    const keyword = this.value.toLowerCase().trim();
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        const shouldShow = text.includes(keyword);
                        row.style.display = shouldShow ? '' : 'none';
                    });
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
                    alert.style.display = 'none';
                }
            }, 5000);
        });
    });
</script>
@endsection
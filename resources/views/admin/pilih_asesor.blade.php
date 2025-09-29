@extends('master')

@section('title', 'Pilih Asesor')

@section('konten')
<div class="container py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center mb-3">
                <div class="bg-primary rounded-circle p-3 me-3">
                    <i class="fas fa-user-tie text-white fs-4"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-1">Penugasan Asesor</h2>
                    <p class="text-muted mb-0">Kelola penugasan asesor untuk setiap asesi</p>
                </div>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Assignment Form Card -->
    <div class="card shadow-sm border-0 mb-5">
        <div class="card-header bg-gradient-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Penugasan Baru</h5>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.pilih_asesor.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-lg-5">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user me-1 text-primary"></i>Pilih Asesi
                        </label>
                        <select name="asesi_id" class="form-select form-select-lg" required>
                            <option value="">-- Pilih Asesi --</option>
                            @foreach($asesis as $a)
                                <option value="{{ $a->id_asesi }}">
                                    {{ $a->nama_lengkap }}
                                    @if($a->asesor)
                                        <small>(Sudah memiliki asesor)</small>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-5">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-user-graduate me-1 text-success"></i>Pilih Asesor
                        </label>
                        <select name="asesor_id" class="form-select form-select-lg" required>
                            <option value="">-- Pilih Asesor --</option>
                            @foreach($asesors as $b)
                                <option value="{{ $b->id_asesor }}">
                                    {{ $b->nama_asesor }}
                                    <br><small class="text-muted">{{ $b->bidang_keahlian }}</small>
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-users fs-1 opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase mb-1">Total Asesi</h6>
                            <h3 class="mb-0">{{ count($asesis) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-check fs-1 opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase mb-1">Sudah Ditugaskan</h6>
                            <h3 class="mb-0">{{ $asesis->whereNotNull('asesor_id')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-clock fs-1 opacity-75"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-uppercase mb-1">Menunggu Asesor</h6>
                            <h3 class="mb-0">{{ $asesis->whereNull('asesor_id')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-light border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>Daftar Penugasan Asesor
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-secondary btn-sm" onclick="filterData('all')">
                        <i class="fas fa-list me-1"></i>Semua
                    </button>
                    <button class="btn btn-outline-success btn-sm" onclick="filterData('assigned')">
                        <i class="fas fa-check me-1"></i>Ditugaskan
                    </button>
                    <button class="btn btn-outline-warning btn-sm" onclick="filterData('unassigned')">
                        <i class="fas fa-clock me-1"></i>Belum Ditugaskan
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">
                                <i class="fas fa-user me-2"></i>Nama Asesi
                            </th>
                            <th>
                                <i class="fas fa-user-graduate me-2"></i>Asesor yang Ditugaskan
                            </th>
                            <th class="text-center">Status</th>
                            <th class="pe-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="asesiTable">
                        @foreach($asesis as $index => $a)
                            <tr class="asesi-row" data-status="{{ $a->asesor ? 'assigned' : 'unassigned' }}">
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-3">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $a->nama_lengkap }}</h6>
                                            <small class="text-muted">#{{ $a->id_asesi }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($a->asesor)
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-user-graduate text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-success">{{ $a->asesor->nama_asesor }}</h6>
                                                <small class="text-muted">{{ $a->asesor->bidang_keahlian }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                                <i class="fas fa-clock text-warning"></i>
                                            </div>
                                            <span class="text-muted">Belum ada asesor</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($a->asesor)
                                        <span class="badge bg-success px-3 py-2">
                                            <i class="fas fa-check-circle me-1"></i>Ditugaskan
                                        </span>
                                    @else
                                        <span class="badge bg-warning px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>Menunggu
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-center">
                                    @if($a->asesor)
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-sm" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline-danger btn-sm" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @else
                                        <button type="button" class="btn btn-outline-primary btn-sm" title="Tugaskan Asesor">
                                            <i class="fas fa-user-plus"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.bg-gradient-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
}
.bg-gradient-info {
    background: linear-gradient(45deg, #17a2b8, #0c7489);
}
.bg-gradient-success {
    background: linear-gradient(45deg, #28a745, #1e7e34);
}
.bg-gradient-warning {
    background: linear-gradient(45deg, #ffc107, #e0a800);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

.btn {
    transition: all 0.3s ease;
}

.form-select:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.25);
}

.alert {
    border: none;
    border-radius: 10px;
}

@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
    }
    
    .col-lg-2 {
        margin-top: 1rem;
    }
}
</style>

<!-- JavaScript for filtering -->
<script>
function filterData(status) {
    const rows = document.querySelectorAll('.asesi-row');
    const buttons = document.querySelectorAll('[onclick^="filterData"]');
    
    // Reset button styles
    buttons.forEach(btn => {
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-outline-secondary');
    });
    
    // Highlight active button
    event.target.classList.remove('btn-outline-secondary', 'btn-outline-success', 'btn-outline-warning');
    event.target.classList.add('btn-primary');
    
    rows.forEach(row => {
        if (status === 'all') {
            row.style.display = '';
        } else {
            const rowStatus = row.getAttribute('data-status');
            row.style.display = rowStatus === status ? '' : 'none';
        }
    });
}

// Initialize tooltips if using Bootstrap 5
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

@endsection
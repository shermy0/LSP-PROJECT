@extends('master')

@section('title', 'Daftar Asesor')

@section('konten')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4 header-card">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="bi bi-people-fill fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold" style="color: #041562;">Daftar Asesor</h4>
                        <p class="mb-0 text-muted">Kelola dan pantau seluruh data asesor terdaftar</p>
                    </div>
                </div>
                <button class="btn btn-primary-custom px-4" data-bs-toggle="modal" data-bs-target="#addAsesorModal">
                    <i class="bi bi-plus-circle me-2"></i>Tambah Asesor
                </button>
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

    @if(session('asesor_password'))
    <div class="alert alert-warning alert-dismissible fade show shadow-sm border-0" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-shield-lock-fill me-3 fs-5 flex-shrink-0 mt-1"></i>
            <div class="flex-grow-1">
                <h6 class="alert-heading fw-bold mb-3">Akun Berhasil Dibuat</h6>
                <div class="credential-box p-3 rounded mb-2">
                    <div class="row g-2">
                        <div class="col-12">
                            <small class="d-block mb-2">
                                <strong>Email:</strong>
                                <code class="ms-2 bg-white px-2 py-1 rounded">{{ session('asesor_email') }}</code>
                            </small>
                        </div>
                        <div class="col-12">
                            <small class="d-block">
                                <strong>Password:</strong>
                                <code class="ms-2 bg-white px-2 py-1 rounded">{{ session('asesor_password') }}</code>
                            </small>
                        </div>
                    </div>
                </div>
                <small class="text-muted">
                    <i class="bi bi-info-circle me-1"></i>
                    Password hanya ditampilkan sekali. Harap disimpan dengan aman.
                </small>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($errors->any() && !old())
    <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
        <div class="d-flex align-items-start">
            <i class="bi bi-exclamation-octagon-fill me-3 fs-5 flex-shrink-0 mt-1"></i>
            <div class="flex-grow-1">
                <strong class="d-block mb-2">Terdapat Kesalahan Input:</strong>
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $err)
                    <li><small>{{ $err }}</small></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    {{-- Search & Table Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white border-bottom-0 py-3">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h6 class="mb-1 fw-semibold" style="color: #041562;">
                        <i class="bi bi-search me-2"></i>Pencarian Data
                    </h6>
                    <small class="text-muted">Cari berdasarkan nama, NIP, email, bidang keahlian, atau skema</small>
                </div>
                <div class="col-md-6">
                    <div class="search-wrapper">
                        <input type="text" id="searchInput" class="form-control search-input"
                            placeholder="Ketik untuk mencari asesor...">
                        <i class="bi bi-search search-icon"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="asesorTable">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">No.</th>
                            <th>Nama Asesor</th>
                            <th width="140">NIP</th>
                            <th>Email</th>
                            <th>Bidang Keahlian</th>
                            <th>Skema Diampu</th>
                            <th width="140">No. Registrasi</th>
                            <th width="160">Update Terakhir</th>
                            <th class="text-center" width="140">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($asesor as $a)
                        <tr>
                            <td class="text-center">
                                <span class="badge-id">
                                    {{ $asesor->firstItem() + $loop->index }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar-circle">
                                        <i class="bi bi-person-fill"></i>
                                    </div>
                                    <span class="fw-semibold text-dark">
                                        {{ $a->nama_asesor ?? ($a->user->name ?? '-') }}
                                    </span>
                                </div>
                            </td>

                            <td><span class="text-muted small">{{ $a->nip ?? '-' }}</span></td>
                            <td><small class="text-muted">{{ $a->email ?? ($a->user->email ?? '-') }}</small></td>

                            <td>
                                @if($a->jurusan)
                                <span class="badge-keahlian">{{ $a->jurusan->nama_jurusan }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                @if($a->skemas && $a->skemas->count() > 0)
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($a->skemas->take(3) as $skema)
                                    <span class="badge bg-info text-dark">{{ $skema->kode_skema }}</span>
                                    @endforeach
                                    @if($a->skemas->count() > 3)
                                    <span class="badge bg-secondary">+{{ $a->skemas->count() - 3 }}</span>
                                    @endif
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td><span class="text-muted small">{{ $a->no_registrasi ?? '-' }}</span></td>

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
                                <a href="{{ route('admin.asesor.show', $a->id_asesor) }}"
                                    class="btn btn-sm btn-outline-custom">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="bi bi-inbox"></i>
                                    <p class="mb-1 mt-3 fw-semibold">Belum Ada Data Asesor</p>
                                    <small class="text-muted">Klik tombol "Tambah Asesor" untuk memulai menambahkan
                                        data</small>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if(method_exists($asesor, 'links') && $asesor->total() > 0)
        <div class="card-footer bg-white border-top py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="text-muted small">
                    <i class="bi bi-list-ul me-2"></i>
                    Menampilkan <strong>{{ $asesor->firstItem() }}</strong> - <strong>{{ $asesor->lastItem() }}</strong>
                    dari <strong>{{ $asesor->total() }}</strong> data
                </div>
                <nav aria-label="Pagination">
                    <ul class="pagination pagination-sm mb-0">
                        {{-- Previous --}}
                        @if ($asesor->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                        </li>
                        @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $asesor->previousPageUrl() }}" aria-label="Previous">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        @endif

                        {{-- Page Numbers --}}
                        @php
                        $start = max($asesor->currentPage() - 2, 1);
                        $end = min($start + 4, $asesor->lastPage());
                        $start = max($end - 4, 1);
                        @endphp

                        @if($start > 1)
                        <li class="page-item">
                            <a class="page-link" href="{{ $asesor->url(1) }}">1</a>
                        </li>
                        @if($start > 2)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                        @endif
                        @endif

                        @for($i = $start; $i <= $end; $i++)
                            @if ($i==$asesor->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $i }}</span>
                            </li>
                            @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $asesor->url($i) }}">{{ $i }}</a>
                            </li>
                            @endif
                            @endfor

                            @if($end < $asesor->lastPage())
                                @if($end < $asesor->lastPage() - 1)
                                    <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $asesor->url($asesor->lastPage()) }}">{{ $asesor->lastPage() }}</a>
                                    </li>
                                    @endif

                                    {{-- Next --}}
                                    @if ($asesor->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $asesor->nextPageUrl() }}" aria-label="Next">
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

{{-- ================== MODAL TAMBAH ASESOR ================== --}}
<div class="modal fade" id="addAsesorModal" tabindex="-1" aria-labelledby="addAsesorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow">
            <form action="{{ route('admin.asesor.store') }}" method="POST" novalidate>
                @csrf
                <div class="modal-header border-bottom-0 pb-0">
                    <div class="w-100">
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <div class="modal-icon">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold mb-1" style="color: #041562;" id="addAsesorModalLabel">
                                    Tambah Asesor Baru
                                </h5>
                                <small class="text-muted">Lengkapi formulir berikut untuk menambahkan asesor</small>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body pt-3">

                    {{-- Error dalam modal --}}
                    @if($errors->any() && old())
                    <div class="alert alert-danger border-0 shadow-sm mb-3">
                        <div class="d-flex align-items-start">
                            <i class="bi bi-exclamation-triangle-fill me-3 fs-5 flex-shrink-0 mt-1"></i>
                            <div class="flex-grow-1">
                                <strong class="d-block mb-2">Terdapat Kesalahan:</strong>
                                <ul class="mb-0 ps-3">
                                    @foreach($errors->all() as $err)
                                    <li><small>{{ $err }}</small></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">
                                Nama Asesor <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_asesor"
                                class="form-control @error('nama_asesor') is-invalid @enderror"
                                value="{{ old('nama_asesor') }}" placeholder="Masukkan nama lengkap" required>
                            @error('nama_asesor')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">NIP</label>
                            <input type="text" name="nip" class="form-control @error('nip') is-invalid @enderror"
                                value="{{ old('nip') }}" placeholder="Nomor Induk Pegawai">
                            @error('nip')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Email</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') }}" placeholder="email@example.com">
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Telepon</label>
                            <input type="text" name="telepon"
                                class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}"
                                placeholder="08xx xxxx xxxx">
                            @error('telepon')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Bidang Keahlian</label>
                            <select name="id_jurusan" class="form-select @error('id_jurusan') is-invalid @enderror">
                                <option value="">-- Pilih Bidang Keahlian --</option>
                                @foreach(\App\Models\Jurusan::all() as $jurusan)
                                <option value="{{ $jurusan->id_jurusan }}" {{ old('id_jurusan') == $jurusan->id_jurusan ? 'selected' : '' }}>
                                    {{ $jurusan->nama_jurusan }}
                                </option>
                                @endforeach
                            </select>
                            @error('id_jurusan')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">No. Registrasi</label>
                            <input type="text" name="no_registrasi"
                                class="form-control @error('no_registrasi') is-invalid @enderror"
                                value="{{ old('no_registrasi') }}" placeholder="Nomor registrasi asesor">
                            @error('no_registrasi')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- SKEMA YANG DIAMPU --}}
                        <div class="col-12">
                            <label class="form-label fw-semibold small">Skema yang Diampu</label>
                            <div class="row g-2">
                                @if(isset($daftarSkema) && $daftarSkema instanceof \Illuminate\Support\Collection && $daftarSkema->count() > 0)
                                @foreach($daftarSkema as $s)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="skema_ids[]" value="{{ $s->id_skema }}" id="skema_{{ $s->id_skema }}"
                                            {{ in_array($s->id_skema, old('skema_ids', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="skema_{{ $s->id_skema }}">
                                            {{ $s->nama_skema }}
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="col-12">
                                    <p class="text-muted">Belum ada skema tersedia.</p>
                                </div>
                                @endif
                            </div>
                            @error('skema_ids')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <div class="account-option-card">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="createAccount"
                                        name="create_account" {{ old('create_account') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="createAccount">
                                        Buat akun login untuk asesor ini
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-2 ms-4">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Sistem akan membuat akun user dan mengirim kredensial login melalui email
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary-custom px-4">
                        <i class="bi bi-check-circle me-2"></i>Simpan Asesor
                    </button>
                </div>
            </form>
        </div>
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
        padding: 10px 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
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

    /* Custom Outline Button */
    .btn-outline-custom {
        border-color: var(--primary-dark);
        color: var(--primary-dark);
        font-weight: 500;
        transition: all 0.3s ease;
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
    }

    .search-input {
        padding-left: 40px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        transition: all 0.3s ease;
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

    /* Badge Skema */
    .badge-skema {
        background-color: #e2e8ff;
        color: var(--primary-dark);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
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

    .modal-body {
        max-height: 70vh; /* Batasi tinggi modal agar bisa discroll */
        overflow-y: auto;
    }

    .account-option-card {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 16px;
        transition: all 0.3s ease;
    }

    .account-option-card:has(.form-check-input:checked) {
        background: var(--primary-light);
        border-color: var(--primary-dark);
    }

    .form-check-input:checked {
        background-color: var(--primary-dark);
        border-color: var(--primary-dark);
    }

    .form-check-input:focus {
        border-color: var(--primary-dark);
        box-shadow: 0 0 0 0.2rem rgba(4, 21, 98, 0.15);
    }

    /* Credential Box */
    .credential-box {
        background-color: rgba(255, 255, 255, 0.6);
        border: 1px dashed #856404;
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

        .badge-id,
        .badge-keahlian {
            font-size: 11px;
            padding: 4px 8px;
        }

        .modal-body {
            max-height: 60vh; /* Lebih kecil di mobile */
        }
    }
</style>

{{-- ================== SCRIPT ================== --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality with debounce
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('asesorTable');
        const rows = table ? table.querySelectorAll('tbody tr') : [];

        if (searchInput && rows.length > 0) {
            let debounceTimer;
            searchInput.addEventListener('keyup', function() {
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

        // Auto-open modal if validation fails
        @if($errors->any() && old())
        const modalEl = document.getElementById('addAsesorModal');
        if (modalEl) {
            const modal = new bootstrap.Modal(modalEl);
            modal.show();
        }
        @endif

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
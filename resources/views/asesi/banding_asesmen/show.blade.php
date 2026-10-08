@extends('master')

@section('title', 'FR.AK.04 - Detail Banding Asesmen')

@section('konten')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-exclamation-triangle" viewBox="0 0 16 16">
                <path d="M7.938 2.016A.13.13 0 0 1 8.002 2a.13.13 0 0 1 .063.016.146.146 0 0 1 .054.057l6.857 11.667c.036.06.035.124.002.183a.163.163 0 0 1-.054.06.116.116 0 0 1-.066.017H1.146a.115.115 0 0 1-.066-.017.163.163 0 0 1-.054-.06.176.176 0 0 1 .002-.183L7.884 2.073a.147.147 0 0 1 .054-.057zm1.044-.45a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566z"/>
                <path d="M7.002 12a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 5.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995z"/>
            </svg>
        </div>
        <h1 class="display-6 fw-bold text-dark">Detail Banding Asesmen</h1>
        <p class="text-secondary">FR.AK.04 – Informasi pengajuan banding Anda</p>
        <span class="badge bg-{{ $banding->persetujuan ? 'success' : 'warning' }} px-3 py-2 rounded-pill">
            {{ $banding->persetujuan ? 'Sudah Ditandatangani' : 'Menunggu Tanda Tangan' }}
        </span>
    </div>

    <!-- Informasi Skema -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle text-primary" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Informasi Sertifikasi</h5>
                    <p class="text-secondary mb-0 small">Data skema dan asesor terkait banding</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted">Skema Sertifikasi</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $banding->permohonan->skema->nama_skema ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Nomor Skema</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $banding->permohonan->skema->kode_skema ?? '-' }}</p>
                </div>
                <div class="col-md-3">
                    <label class="form-label text-muted">Nama Asesor</label>
                    <p class="fw-semibold border p-2 rounded bg-light">
                        {{ $banding->permohonan->asesi->asesor->user->name ?? $banding->permohonan->asesi->asesor->nama_asesor ?? '-' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted">Tanggal Asesmen</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $banding->tgl_asesmen ? \Carbon\Carbon::parse($banding->tgl_asesmen)->format('d-m-Y') : '-' }}</p>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted">Tanggal Banding</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $banding->tgl_banding ? \Carbon\Carbon::parse($banding->tgl_banding)->format('d-m-Y') : '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Jawaban Pertanyaan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-question-circle text-primary" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Pertanyaan Banding</h5>
                    <p class="text-secondary mb-0 small">Jawaban yang Anda berikan</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted">1. Apakah Proses Banding telah dijelaskan kepada Anda?</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $banding->banding_dijelaskan ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted">2. Apakah Anda telah mendiskusikan Banding dengan Asesor?</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $banding->diskusi_dengan_asesor ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted">3. Apakah Anda mau melibatkan "orang lain" membantu Anda dalam Proses Banding?</label>
                    <p class="fw-semibold border p-2 rounded bg-light">{{ $banding->libatkan_orang_lain ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alasan Banding -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-text text-primary" viewBox="0 0 16 16">
                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Alasan Banding</h5>
                    <p class="text-secondary mb-0 small">Penjelasan lengkap</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <p class="border p-3 rounded bg-light">{{ $banding->alasan_banding ?? '-' }}</p>
        </div>
    </div>

    <!-- Tanda Tangan Asesi -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pen text-primary" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Tanda Tangan Persetujuan</h5>
                    <p class="text-secondary mb-0 small">Konfirmasi pengajuan banding</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            @php $persetujuan = $banding->persetujuan; @endphp
            @if($persetujuan && $persetujuan->ttd_asesi)
                <div class="row">
                    <div class="col-md-6 text-center mx-auto">
                        <div class="border rounded p-3 bg-light">
                            <h6 class="fw-bold mb-3">Tanda Tangan Asesi</h6>
                            <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="Tanda Tangan Asesi" class="img-fluid mb-2" style="max-height: 150px;">
                            <p class="mb-0">Tanggal: {{ $persetujuan->tgl_ttd_asesi ? \Carbon\Carbon::parse($persetujuan->tgl_ttd_asesi)->format('d-m-Y') : '-' }}</p>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-muted fst-italic">Belum ada tanda tangan.</p>
            @endif
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="button-group mt-4">
        <a href="{{ route('form_pra_assesmen') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Kembali
        </a>
    </div>
</div>

<style>
    /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
    :root {
        --primary: #0b2f7c;
        --primary-dark: #08205c;
        --primary-light: #1a3e9c;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #212529;
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

    /* ===== FORM CARD & INPUT ===== */
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

    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 0.3rem;
    }

    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
        outline: none;
    }

    .form-control:read-only {
        background-color: #f8f9fa;
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

    .border-primary {
        border-color: var(--primary) !important;
    }

    /* Tombol Next & Back */
    .btn-next {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(11,47,124,0.3);
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-next:hover {
        background: linear-gradient(135deg, var(--primary-dark), #061944);
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(11,47,124,0.35);
        color: #fff;
    }

    .btn-back {
        background-color: #fff;
        color: var(--secondary);
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border: 1.5px solid #dee2e6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background-color: #f1f3f5;
        color: #495057;
        border-color: #ced4da;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
    }

    @media (max-width: 768px) {
        .button-group {
            justify-content: center;
        }
    }
</style>
@endsection
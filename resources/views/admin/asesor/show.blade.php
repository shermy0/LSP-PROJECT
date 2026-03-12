@extends('master')

@section('title', 'Detail Asesor')

@section('konten')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4 header-card">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-box">
                        <i class="bi bi-person-badge fs-3"></i>
                    </div>
                    <div>
                        <h4 class="mb-1 fw-bold" style="color: #041562;">
                            Detail Asesor
                        </h4>
                        <p class="mb-0 text-muted">Informasi lengkap mengenai asesor</p>
                    </div>
                </div>

                <a href="{{ route('admin.asesor.index') }}" class="btn btn-outline-custom px-4">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- CARD DETAIL --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            {{-- ROW 1: Nama Asesor --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">Nama Asesor</div>
                <div class="col-md-9 text-dark fw-bold">
                    {{ $asesor->nama_asesor ?? ($asesor->user->name ?? '-') }}
                </div>
            </div>

            {{-- ROW 2: NIP --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">NIP</div>
                <div class="col-md-9">
                    {{ $asesor->nip ?? '-' }}
                </div>
            </div>

            {{-- ROW 3: Email --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">Email</div>
                <div class="col-md-9">
                    {{ $asesor->email ?? ($asesor->user->email ?? '-') }}
                </div>
            </div>

            {{-- ROW 4: Telepon --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">Telepon</div>
                <div class="col-md-9">
                    {{ $asesor->telepon ?? '-' }}
                </div>
            </div>

            {{-- ROW 5: Bidang Keahlian (dari Jurusan) --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">Bidang Keahlian</div>
                <div class="col-md-9">
                    @if($asesor->jurusan)
                        <span class="badge-keahlian px-3 py-2">
                            {{ $asesor->jurusan->nama_jurusan }}
                        </span>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
            </div>

            {{-- ROW 6: No. Registrasi --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">No. Registrasi</div>
                <div class="col-md-9">
                    {{ $asesor->no_registrasi ?? '-' }}
                </div>
            </div>

            {{-- ROW 7: Dibuat Pada --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">Dibuat Pada</div>
                <div class="col-md-9">
                    {{ \Carbon\Carbon::parse($asesor->created_at)->format('d M Y, H:i') }}
                </div>
            </div>

            {{-- ROW 8: Terakhir Diperbarui --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">Terakhir Diperbarui</div>
                <div class="col-md-9">
                    {{ \Carbon\Carbon::parse($asesor->updated_at)->format('d M Y, H:i') }}
                </div>
            </div>

            {{-- ROW 9: Skema yang Diampu --}}
            <div class="row mb-4">
                <div class="col-md-3 fw-semibold text-muted">Skema yang Diampu</div>
                <div class="col-md-9">
                    @if($asesor->skemas && $asesor->skemas->count() > 0)
                        @foreach($asesor->skemas as $skema)
                            <span class="badge-keahlian px-3 py-2 me-2 mb-2 d-inline-block">
                                {{ $skema->nama_skema }}
                            </span>
                        @endforeach
                    @else
                        <span class="text-muted">Belum ada skema</span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

{{-- CUSTOM CSS --}}
<style>
    :root {
        --primary-dark: #041562;
        --primary-light: #E9F1FF;
    }

    .header-card {
        border-left: 4px solid var(--primary-dark);
    }

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

    .btn-outline-custom {
        border-color: var(--primary-dark);
        color: var(--primary-dark);
        transition: 0.3s;
    }

    .btn-outline-custom:hover {
        background: var(--primary-dark);
        color: #fff;
    }

    .badge-keahlian {
        background: #e8f4f8;
        color: #0c5460;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
    }

    .row > div:first-child {
        font-size: 14px;
    }

    .row > div:last-child {
        font-size: 15px;
    }
</style>

@endsection
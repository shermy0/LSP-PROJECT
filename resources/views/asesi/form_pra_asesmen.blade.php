@extends('master')

@section('title', 'Form Pra Asesmen')

@section('konten')
<div class="container mt-4">

    <div class="form-header text-center mb-4">
        <h2 class="fw-bold">Form Pra Asesmen</h2>
        <p class="text-muted">Sistem Manajemen Asesmen Siswa - AsesKom</p>
        <div class="line"></div>
    </div>

    <!-- Card Pra Asesmen -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light fw-semibold">
            Pra Asesmen
        </div>
        <div class="card-body">

            {{-- FR.APL.01 Permohonan Sertifikasi Kompetensi --}}
            @php
                $status = $permohonan->status ?? null;

                if (!$permohonan) {
                    $link = route('asesi.permohonan.form1');
                    $disabled = false;
                } elseif ($status == 'Diajukan') {
                    $link = route('asesi.permohonan.menunggu');
                    $disabled = false;
                } elseif ($status == 'Diterima') {
                    $link = '#'; // tidak bisa isi lagi
                    $disabled = true;
                } else {
                    $link = route('asesi.permohonan.form1');
                    $disabled = false;
                }
            @endphp

            <a href="{{ $disabled ? 'javascript:void(0)' : $link }}" 
               class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none {{ $disabled ? 'disabled' : '' }}"
               @if($disabled) onclick="return false;" @endif>
                <div class="d-flex align-items-start">
                    <div class="icon-wrap me-3">📄</div>
                    <div>
                        <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                        <small class="text-muted">
                            @if($permohonan)
                                Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}
                            @else
                                Tanggal: -
                            @endif
                        </small>
                    </div>
                </div>
                <div class="text-end">
                    <span class="badge 
                        @if(!$permohonan) bg-secondary
                        @elseif($status == 'Diterima') bg-success
                        @elseif($status == 'Ditolak') bg-danger
                        @elseif($status == 'Diajukan') bg-warning text-dark
                        @else bg-secondary @endif">
                        {{ $permohonan ? $status : 'Belum diisi' }}
                    </span>
                </div>
            </a>

            {{-- FR.APL.02 Asesmen Mandiri (muncul hanya jika permohonan diterima) --}}
            @if($status == 'Diterima')
                @php
                    $asesmenStatus = $asesmenMandiri ? 'Sudah diisi' : 'Belum diisi';
                    $asesmenBadge = $asesmenMandiri ? 'bg-success' : 'bg-secondary';
                    $asesmenLink = $asesmenMandiri 
                        ? route('asesi.asesmen_mandiri.show', $asesmenMandiri->id_asesmen_mandiri)
                        : route('asesi.asesmen_mandiri.form1');
                @endphp

                <a href="{{ $asesmenLink }}" 
                   class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                    <div class="d-flex align-items-start">
                        <div class="icon-wrap me-3">✅</div>
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">FR.APL.02 Asesmen Mandiri</h6>
                            <small class="text-muted">
                                @if($asesmenMandiri)
                                    Terakhir diisi: {{ $asesmenMandiri->updated_at ?? '-' }}
                                @else
                                    Silakan lanjutkan mengisi asesmen mandiri setelah permohonan diterima.
                                @endif
                            </small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="badge {{ $asesmenBadge }}">{{ $asesmenStatus }}</span>
                    </div>
                </a>
            @endif

        </div>
    </div>

</div>

{{-- Style langsung di blade --}}
<style>
    .form-header h2 {
        color: #041562;
    }
    .form-header .line {
        width: 80px;
        height: 3px;
        background: #041562;
        margin: 10px auto;
        border-radius: 2px;
    }
    .card-header {
        background: #f0f7ff !important;
        color: #041562;
        border-bottom: 2px solid #041562;
    }
    .pra-item {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #fff;
        transition: 0.2s;
        color: inherit;
        cursor: pointer;
    }
    .pra-item:hover {
        background: #f8fafc;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        text-decoration: none;
    }
    .pra-item.disabled {
        background: #f1f1f1;
        color: #999 !important;
        cursor: not-allowed;
        pointer-events: none;
    }
    .icon-wrap {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #041562;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 18px;
    }
</style>
@endsection

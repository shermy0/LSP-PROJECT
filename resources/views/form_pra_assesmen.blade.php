{{-- File: resources/views/asesi/pra_asesmen.blade.php --}}
@extends('master')

@section('title', 'Form Pra Asesmen')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <!-- Header dengan ikon dan judul (warna #0b2f7c) -->
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                </svg>
            </div>
            <h1 class="display-6 fw-bold text-dark">Form Pra Asesmen</h1>
            <p class="text-secondary">Sistem Manajemen Asesmen Siswa - AsesKom</p>
        </div>

        <!-- Card Pra Asesmen -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list-check text-primary" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Pra Asesmen</h5>
                        <p class="text-secondary mb-0 small">Kelola permohonan sertifikasi dan asesmen mandiri</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                @if(Auth::user()->role === 'asesi')
                    @php
                        $status = $permohonan->status ?? null;
                    @endphp

                    {{-- FR.APL.01 - PERMOHONAN SERTIFIKASI --}}
                    @if(!$permohonan)
                        <a href="{{ route('asesi.permohonan.form1') }}" class="pra-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrap me-3 bg-primary bg-opacity-10 text-primary">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                    <small class="text-muted">Tanggal: -</small>
                                </div>
                            </div>
                            <span class="badge bg-secondary">Belum diisi</span>
                        </a>

                    @elseif($status === 'Diajukan')
                        <a href="{{ route('asesi.permohonan.menunggu') }}" class="pra-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrap me-3 bg-warning bg-opacity-10 text-warning">
                                    <i class="bi bi-hourglass-split"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                    <small class="text-muted">Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}</small>
                                </div>
                            </div>
                            <span class="badge bg-warning text-dark">Diajukan</span>
                        </a>

                    @elseif($status === 'Diterima')
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#infoPermohonanModal" class="pra-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrap me-3 bg-success bg-opacity-10 text-success">
                                    <i class="bi bi-check-circle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                    <small class="text-muted">Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}</small>
                                </div>
                            </div>
                            <span class="badge bg-success">Diterima</span>
                        </a>

                        {{-- Modal Info --}}
                        <div class="modal fade" id="infoPermohonanModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title fw-bold">Informasi Permohonan</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Status:</strong> {{ $permohonan->status }}</p>
                                        <p><strong>Tanggal Pengajuan:</strong> {{ $permohonan->tgl_permohonan ?? '-' }}</p>
                                        <p><strong>Catatan:</strong><br>{{ $permohonan->catatan ?? 'Tidak ada catatan' }}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @elseif($status === 'Ditolak')
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#permohonanDitolakModal"
                            class="pra-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrap me-3 bg-danger bg-opacity-10 text-danger">
                                    <i class="bi bi-x-circle"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                    <small class="text-muted">Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}</small>
                                </div>
                            </div>
                            <span class="badge bg-danger">Ditolak</span>
                        </a>

                        {{-- Modal Penolakan --}}
                        <div class="modal fade" id="permohonanDitolakModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title fw-bold">Detail Penolakan Permohonan</h5>
                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Status:</strong> Ditolak</p>
                                        <p><strong>Tanggal Pengajuan:</strong> {{ $permohonan->tgl_permohonan ?? '-' }}</p>
                                        <p><strong>Catatan:</strong><br>{{ $permohonan->catatan ?? 'Tidak ada catatan' }}</p>
                                        <hr>
                                        <h6>Dokumen belum memenuhi syarat:</h6>
                                        <ul>
                                            @forelse($dokumenTidakMemenuhi as $dok)
                                                <li>
                                                    {{ $dok->nama_dokumen }}
                                                    @if($dok->file_url)
                                                        ( <a href="{{ $dok->file_url }}" target="_blank">Lihat</a> )
                                                    @endif
                                                    @if($dok->catatan)
                                                        <br>
                                                        <small class="text-danger">
                                                            Catatan: {{ $dok->catatan }}
                                                        </small>
                                                    @endif
                                                </li>
                                            @empty
                                                <li>Tidak ada data dokumen.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="{{ route('asesi.permohonan.form1') }}" class="btn btn-primary">Isi Ulang Permohonan</a>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- FR.APL.02 - ASESMEN MANDIRI --}}
                    @if($status === 'Diterima')
                        @php
                            $asesmenExists = !empty($asesmenMandiri);
                            $rekom = $asesmenExists ? ($asesmenMandiri->rekomendasi ?? null) : null;

                            if (!$asesmenExists) {
                                $asesmenLabel = 'Belum diisi';
                                $asesmenBadge = 'bg-secondary';
                                $asesmenHref = route('asesi.asesmen_mandiri.form1');
                                $iconClass = 'bg-primary bg-opacity-10 text-primary';
                                $icon = 'bi-pencil-square';
                            } elseif (empty($rekom)) {
                                $asesmenLabel = 'Diperiksa';
                                $asesmenBadge = 'bg-warning text-dark';
                                $asesmenHref = route('asesi.asesmen_mandiri.waiting');
                                $iconClass = 'bg-warning bg-opacity-10 text-warning';
                                $icon = 'bi-hourglass-split';
                            } elseif ($rekom === 'Dapat Dilanjutkan') {
                                $asesmenLabel = 'Dapat Dilanjutkan';
                                $asesmenBadge = 'bg-success';
                                $asesmenHref = route('asesi.asesmen_mandiri.show', $asesmenMandiri->id_asesmen_mandiri);
                                $iconClass = 'bg-success bg-opacity-10 text-success';
                                $icon = 'bi-check-circle';
                            } else {
                                $asesmenLabel = 'Tidak Dapat Dilanjutkan';
                                $asesmenBadge = 'bg-danger';
                                $asesmenHref = route('asesi.asesmen_mandiri.form1');
                                $iconClass = 'bg-danger bg-opacity-10 text-danger';
                                $icon = 'bi-x-circle';
                            }
                        @endphp

                        <a href="{{ $asesmenHref }}" class="pra-item mt-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrap me-3 {{ $iconClass }}">
                                    <i class="bi {{ $icon }}"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-semibold text-dark">FR.APL.02 Asesmen Mandiri</h6>
                                    <small class="text-muted">
                                        @if($asesmenExists)
                                            Terakhir diisi: {{ $asesmenMandiri->updated_at ?? $asesmenMandiri->created_at ?? '-' }}
                                        @else
                                            Silakan isi asesmen mandiri setelah permohonan diterima.
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <span class="badge {{ $asesmenBadge }}">{{ $asesmenLabel }}</span>
                        </a>
                    @endif
                @endif

                {{-- ROLE: ASESOR --}}
                @if(Auth::user()->role === 'asesor')
                    <a href="{{ route('asesor.asesmen_mandiri.index') }}" class="pra-item">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrap me-3 bg-primary bg-opacity-10 text-primary">
                                <i class="bi bi-clipboard-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-semibold text-dark">FR.APL.02 Asesmen Mandiri</h6>
                                <small class="text-muted">Form asesmen mandiri peserta uji</small>
                            </div>
                        </div>
                        <span class="badge bg-primary">Akses</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('head')
    <style>
        /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
        :root {
            --primary: #0b2f7c;
            --primary-dark: #08205c;
            --primary-light: #1a3e9c;
            --secondary: #6c757d;
            --success: #198754;
            --warning: #ffc107;
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

        /* ===== PRA-ITEM (seperti card item) ===== */
        .pra-item {
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.25rem;
            transition: all 0.2s ease;
            text-decoration: none;
            color: inherit;
            margin-bottom: 0.75rem;
        }

        .pra-item:hover {
            background: #f8fafc;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transform: translateY(-1px);
            border-color: var(--primary-light);
            text-decoration: none;
        }

        .icon-wrap {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            border-radius: 12px;
        }

        /* ===== BADGE CUSTOM ===== */
        .badge {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.8rem;
        }

        .bg-warning {
            background-color: var(--warning) !important;
        }

        .bg-success {
            background-color: var(--success) !important;
        }

        .bg-danger {
            background-color: var(--danger) !important;
        }

        .bg-secondary {
            background-color: var(--secondary) !important;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .pra-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            .pra-item .badge {
                align-self: flex-start;
            }
        }
    </style>
@endpush

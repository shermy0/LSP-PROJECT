{{-- File: resources/views/asesi/pra_asesmen.blade.php --}}
{{-- Data source (uploaded): /mnt/data/permohonan.sql --}}

@extends('master')

@section('title', 'Form Pra Asesmen')

@section('konten')
    <div class="container-fluid px-4 py-3">
        {{-- HEADER --}}
        <div class="text-center mb-4">
            <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
            <h1 class="h4 fw-bold">Form Pra Asesmen</h1>
            <p class="text-muted">Sistem Manajemen Asesmen Siswa - AsesKom</p>
        </div>

        {{-- CARD PRA ASESMEN --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-light fw-semibold">
                Pra Asesmen
            </div>

            <div class="card-body">
                @if(Auth::user()->role === 'asesi')
                    @php
                        $status = $permohonan->status ?? null;
                    @endphp

                    {{-- FR.APL.01 - PERMOHONAN SERTIFIKASI --}}
                    @if(!$permohonan)
                        <a href="{{ route('asesi.permohonan.form1') }}" class="pra-item">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrap me-3 bg-secondary-subtle text-secondary">
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
                                <div class="icon-wrap me-3 text-warning bg-warning-subtle">
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
                                <div class="icon-wrap me-3 text-success bg-success-subtle">
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
                                <div class="icon-wrap me-3 text-danger bg-danger-subtle">
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
                                        <a href="{{ route('asesi.permohonan.form1') }}" class="btn btn-primary">Isi Ulang
                                            Permohonan</a>
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
                                $icon = 'bi-pencil-square text-secondary bg-secondary-subtle';
                            } elseif (empty($rekom)) {
                                $asesmenLabel = 'Diperiksa';
                                $asesmenBadge = 'bg-warning text-dark';
                                $asesmenHref = route('asesi.asesmen_mandiri.waiting');
                                $icon = 'bi-hourglass-split text-warning bg-warning-subtle';
                            } elseif ($rekom === 'Dapat Dilanjutkan') {
                                $asesmenLabel = 'Dapat Dilanjutkan';
                                $asesmenBadge = 'bg-success';
                                $asesmenHref = route('asesi.asesmen_mandiri.show', $asesmenMandiri->id_asesmen_mandiri);
                                $icon = 'bi-check-circle text-success bg-success-subtle';
                            } else {
                                $asesmenLabel = 'Tidak Dapat Dilanjutkan';
                                $asesmenBadge = 'bg-danger';
                                $asesmenHref = route('asesi.asesmen_mandiri.form1');
                                $icon = 'bi-x-circle text-danger bg-danger-subtle';
                            }
                        @endphp

                        <a href="{{ $asesmenHref }}" class="pra-item mt-3">
                            <div class="d-flex align-items-center">
                                <div class="icon-wrap me-3 {{ $icon }}">
                                    <i class="bi {{ explode(' ', $icon)[0] }}"></i>
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
                            <div class="icon-wrap me-3 text-primary bg-primary-subtle">
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

{{-- STYLE: gunakan styling yang konsisten dengan FR.APL.02 --}}
@push('head')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9fafc;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px;
            transition: all .2s ease;
            text-decoration: none;
            color: inherit;
            margin-bottom: 12px;
        }

        .pra-item:hover {
            background: #f8fafc;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            text-decoration: none;
        }

        .icon-wrap {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            border-radius: 8px;
        }

        .bg-secondary-subtle {
            background-color: rgba(108, 117, 125, 0.08);
        }

        .bg-warning-subtle {
            background-color: rgba(255, 193, 7, 0.08);
        }

        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.08);
        }

        .bg-danger-subtle {
            background-color: rgba(220, 53, 69, 0.08);
        }

        .bg-primary-subtle {
            background-color: rgba(4, 21, 98, 0.08);
        }
    </style>
@endpush
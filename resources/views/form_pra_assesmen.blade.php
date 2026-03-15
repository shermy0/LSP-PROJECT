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

            {{-- Jika role Asesi --}}
            @if(Auth::check() && Auth::user()->role == 'asesi')
                @php $status = $permohonan->status ?? null; @endphp

                {{-- FR.APL.01 Permohonan Sertifikasi --}}
                @if(!$permohonan)
                    <a href="{{ route('asesi.permohonan.form1') }}"
                       class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrap me-3">📄</div>
                            <div>
                                <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                <small class="text-muted">Tanggal: -</small>
                            </div>
                        </div>
                        <div class="text-end"><span class="badge bg-secondary">Belum diisi</span></div>
                    </a>
                @elseif($status == 'Diajukan')
                    <a href="{{ route('asesi.permohonan.menunggu') }}"
                       class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrap me-3">📄</div>
                            <div>
                                <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                <small class="text-muted">Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}</small>
                            </div>
                        </div>
                        <div class="text-end"><span class="badge bg-warning text-dark">Diajukan</span></div>
                    </a>
                @elseif($status == 'Diterima')
                    <!-- Diterima modal -->
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#infoPermohonanModal"
                       class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrap me-3">📄</div>
                            <div>
                                <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                <small class="text-muted">Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}</small>
                            </div>
                        </div>
                        <div class="text-end"><span class="badge bg-success">Diterima</span></div>
                    </a>

                    <div class="modal fade" id="infoPermohonanModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold">Informasi Permohonan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Status:</strong> {{ $permohonan->status }}</p>
                                    <p><strong>Tanggal Pengajuan:</strong> {{ $permohonan->tgl_permohonan ?? '-' }}</p>
                                    <p><strong>Keterangan/Catatan:</strong><br>{{ $permohonan->catatan ?? 'Tidak ada catatan' }}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($status == 'Ditolak')
                    <!-- Ditolak modal -->
                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#permohonanDitolakModal"
                       class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrap me-3">📄</div>
                            <div>
                                <h6 class="mb-1 fw-semibold text-dark">FR.APL.01 Permohonan Sertifikasi Kompetensi</h6>
                                <small class="text-muted">Tanggal: {{ $permohonan->tgl_permohonan ?? '-' }}</small>
                            </div>
                        </div>
                        <div class="text-end"><span class="badge bg-danger">Ditolak</span></div>
                    </a>

                    <div class="modal fade" id="permohonanDitolakModal" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title fw-bold">Detail Penolakan Permohonan</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <p><strong>Status:</strong> Ditolak</p>
                                    <p><strong>Tanggal Pengajuan:</strong> {{ $permohonan->tgl_permohonan ?? '-' }}</p>
                                    <p><strong>Keterangan/Catatan:</strong><br>{{ $permohonan->catatan ?? 'Tidak ada catatan' }}</p>
                                    <hr>
                                    <h6>Dokumen yang belum memenuhi syarat:</h6>
                                    <ul>
                                        @forelse($dokumenTidakMemenuhi as $dok)
                                            <li>
                                                {{ $dok->jenis->nama_dokumen ?? 'Dokumen #' . $dok->id_jenis_dokumen }}
                                                (<a href="{{ asset('storage/' . $dok->file_path) }}" target="_blank">Lihat</a>)
                                            </li>
                                        @empty
                                            <li>Tidak ada data dokumen.</li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('asesi.permohonan.form1') }}" class="btn btn-primary">Isi Ulang Permohonan</a>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- FR.APL.02 Asesmen Mandiri (hanya jika permohonan diterima) --}}
                @if($status == 'Diterima')
                    @php
                        $asesmenExists = !empty($asesmenMandiri);
                        $rekom = $asesmenExists ? ($asesmenMandiri->rekomendasi ?? null) : null;

                        if (!$asesmenExists) {
                            $asesmenLabel = 'Belum diisi';
                            $asesmenBadge = 'bg-secondary';
                            $asesmenHref = route('asesi.asesmen_mandiri.form1');
                        } elseif (empty($rekom)) {
                            $asesmenLabel = 'Di Periksa';
                            $asesmenBadge = 'bg-warning text-dark';
                            $asesmenHref = route('asesi.asesmen_mandiri.waiting');
                        } elseif ($rekom === 'Dapat Dilanjutkan') {
                            $asesmenLabel = 'Dapat Dilanjutkan';
                            $asesmenBadge = 'bg-success';
                            $asesmenHref = route('asesi.asesmen_mandiri.show', $asesmenMandiri->id_asesmen_mandiri);
                        } else {
                            $asesmenLabel = 'Tidak Dapat Dilanjutkan';
                            $asesmenBadge = 'bg-danger';
                            $asesmenHref = route('asesi.asesmen_mandiri.form1');
                        }
                    @endphp

                    <a href="{{ $asesmenHref }}"
                       class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                        <div class="d-flex align-items-start">
                            <div class="icon-wrap me-3">✅</div>
                            <div>
                                <h6 class="mb-1 fw-semibold text-dark">FR.APL.02 Asesmen Mandiri</h6>
                                <small class="text-muted">
                                    @if($asesmenExists)
                                        Terakhir diisi: {{ $asesmenMandiri->updated_at ?? $asesmenMandiri->created_at ?? '-' }}
                                    @else
                                        Silakan lanjutkan mengisi asesmen mandiri setelah permohonan diterima.
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="text-end"><span class="badge {{ $asesmenBadge }}">{{ $asesmenLabel }}</span></div>
                    </a>
                @endif
            @endif

            {{-- Jika role Asesor --}}
            @if(Auth::check() && Auth::user()->role == 'asesor')
                <a href="{{ route('asesor.asesmen_mandiri.index') }}"
                   class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                    <div class="d-flex align-items-start">
                        <div class="icon-wrap me-3">✅</div>
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">FR.APL.02 Asesmen Mandiri</h6>
                            <small class="text-muted">Form asesmen mandiri peserta uji</small>
                        </div>
                    </div>
                    <div class="text-end"><span class="badge bg-primary">Akses</span></div>
                </a>

                <a href="#"
                   class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                    <div class="d-flex align-items-start">
                        <div class="icon-wrap me-3">📝</div>
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">FR.AK.01 Persetujuan Asesmen dan Kerahasiaan</h6>
                            <small class="text-muted">Dokumen persetujuan antara asesor & asesi</small>
                        </div>
                    </div>
                    <div class="text-end"><span class="badge bg-primary">Akses</span></div>
                </a>

                <a href="#"
                   class="pra-item d-flex justify-content-between align-items-center mb-3 p-3 text-decoration-none">
                    <div class="d-flex align-items-start">
                        <div class="icon-wrap me-3">📋</div>
                        <div>
                            <h6 class="mb-1 fw-semibold text-dark">FR.AK.07 Ceklis Penyesuaian</h6>
                            <small class="text-muted">Form penyesuaian untuk kebutuhan khusus</small>
                        </div>
                    </div>
                    <div class="text-end"><span class="badge bg-primary">Akses</span></div>
                </a>
            @endif

        </div>
    </div>
</div>

{{-- Style --}}
<style>
    .form-header h2 { color: #041562; }
    .form-header .line {
        width: 80px; height: 3px; background: #041562;
        margin: 10px auto; border-radius: 2px;
    }
    .card-header {
        background: #f0f7ff !important;
        color: #041562; border-bottom: 2px solid #041562;
    }
    .pra-item {
        border: 1px solid #e2e8f0; border-radius: 10px;
        background: #fff; transition: .2s; cursor: pointer;
    }
    .pra-item:hover {
        background: #f8fafc;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        text-decoration: none;
    }
    .icon-wrap {
        width: 40px; height: 40px; border-radius: 8px;
        background: #041562; display: flex;
        align-items: center; justify-content: center;
        color: #fff; font-size: 18px;
    }
</style>
@endsection

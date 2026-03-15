@extends('master')

@section('title', 'Detail Permohonan Sertifikasi Asesi')

@section('konten')
<div class="container-fluid px-4 py-4">
    <!-- Header dengan gaya baru (lingkaran gradien) -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
            </svg>
        </div>
        <h1 class="display-6 fw-bold text-dark">Detail Permohonan Sertifikasi</h1>
        <p class="text-secondary">FR.APL.02 — Rincian Data Pemohon</p>
    </div>

    <form id="permohonanForm" action="{{ route('admin.permohonan.update', $permohonan->id_permohonan) }}" method="POST" class="needs-validation" novalidate>
        @csrf

        {{-- Data Pribadi --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle text-primary" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Data Pribadi</h5>
                        <p class="text-secondary mb-0 small">Rincian identitas pemohon</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nama Lengkap</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->nama_lengkap ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">NIK / No. Identitas</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->nik ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tempat Lahir</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->tempat_lahir ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tanggal Lahir</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ isset($asesi->tgl_lahir) ? \Carbon\Carbon::parse($asesi->tgl_lahir)->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Jenis Kelamin</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->jenis_kelamin == 'L' ? 'Laki-laki' : ($asesi->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kebangsaan</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->kebangsaan ?? '-' }}</p>
                    </div>
                    <div class="col-12">
                        <hr class="my-2">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Alamat Rumah</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->alamat_rumah ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kode Pos Rumah</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->kode_pos_rumah ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Telp. Rumah</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->telepon_rumah ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">HP (No. Seluler)</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->telepon_hp ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email Pribadi</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->email ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kualifikasi Pendidikan</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->kualifikasi_pendidikan ?? ($asesi->pendidikan_terakhir ?? '-') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Pekerjaan --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-building text-primary" viewBox="0 0 16 16">
                            <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-6 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-6 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                            <path d="M1 2a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm1 0v12h10V2H2z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Data Pekerjaan</h5>
                        <p class="text-secondary mb-0 small">Informasi pekerjaan / institusi saat ini</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nama Institusi / Perusahaan</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->nama_institusi ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Jabatan / Status</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->jabatan ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Alamat Kantor / Sekolah</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->alamat_kantor ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Kode Pos Kantor</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->kode_pos_kantor ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Telp. Kantor</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->telepon_kantor ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Fax Kantor</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->fax_kantor ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Email Kantor</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $asesi->email_kantor ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Data Sertifikasi --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-patch-check text-primary" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            <path d="M14 8.5V6.127c0-.353-.145-.69-.402-.938l-3.73-3.53A1.5 1.5 0 0 0 8.812 1H4.5A1.5 1.5 0 0 0 3 2.5v11A1.5 1.5 0 0 0 4.5 15h7a1.5 1.5 0 0 0 1.5-1.5v-1.959a2.5 2.5 0 0 0 .5-1.488V9.5h-.5v.042a2 2 0 0 1-2 2h-.5V9.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5v2h-.5a2 2 0 0 1-2-2v-.5h.042a2 2 0 0 1 1.488-.5H8.5v-.5a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 0-.5.5v.5h-.5a2 2 0 0 1-2-2V4.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v.5h2.5a.5.5 0 0 1 .5.5v.5h.5a2 2 0 0 1 2 2v.5h.5a2 2 0 0 1 2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Data Sertifikasi</h5>
                        <p class="text-secondary mb-0 small">Skema & status permohonan</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Skema Sertifikasi</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $skema->nama_skema ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Jenjang</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $skema->jenjang ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Judul Sertifikasi</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $skema->judul_skema ?? $skema->nama_skema ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Nomor Skema</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ $skema->kode_skema ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tujuan Asesmen</label>
                        <p class="fw-semibold border p-2 rounded bg-light">
                            @if(isset($permohonan->id_tujuan))
                                {{ \DB::table('tujuan_asesmen')->where('id_tujuan', $permohonan->id_tujuan)->value('nama_tujuan') ?? ($permohonan->tujuan_asesmen ?? '-') }}
                            @else
                                {{ $permohonan->tujuan_asesmen ?? '-' }}
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Tanggal Permohonan</label>
                        <p class="fw-semibold border p-2 rounded bg-light">{{ isset($permohonan->tgl_permohonan) ? \Carbon\Carbon::parse($permohonan->tgl_permohonan)->format('d M Y') : '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status</label>
                        <p>
                            <span class="badge bg-{{ $permohonan->status=='Diajukan' ? 'warning text-dark' : ($permohonan->status=='Diterima' ? 'success' : ($permohonan->status=='Diperiksa' ? 'info text-dark' : 'danger')) }} px-3 py-2 fs-6">
                                {{ $permohonan->status ?? '-' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Daftar Unit Kompetensi --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list-check text-primary" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Daftar Unit Kompetensi</h5>
                        <p class="text-secondary mb-0 small">Unit kompetensi pemohon</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Unit</th>
                                <th>Judul Unit</th>
                                <th>Standar Kompetensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($units as $i => $unit)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><span class="fw-semibold">{{ $unit->kode_unit ?? '-' }}</span></td>
                                    <td>{{ $unit->judul_unit ?? '-' }}</td>
                                    <td>{{ $unit->standar_kompetensi ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada unit kompetensi</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Bukti Kelengkapan --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-files text-primary" viewBox="0 0 16 16">
                            <path d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Bukti Kelengkapan</h5>
                        <p class="text-secondary mb-0 small">Lampiran dokumen pemohon</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Jenis Dokumen</th>
                                <th>Lampiran</th>
                                <th>Memenuhi Syarat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($dokumen as $i => $d)
                                <tr>
                                    <td class="text-center">{{ $i + 1 }}</td>
                                    <td class="fw-medium">{{ $d->jenis ?? $d->nama_jenis ?? $d->nama_dokumen ?? '-' }}</td>
                                    <td class="text-center">
                                        @if(!empty($d->path_file))
                                            <button type="button" class="btn btn-sm btn-outline-primary px-3"
                                                onclick="openPreview('{{ asset('storage/' . $d->path_file) }}', '{{ pathinfo($d->path_file, PATHINFO_EXTENSION) }}')">
                                                <i class="bi bi-eye me-1"></i> Lihat
                                            </button>
                                        @else
                                            <span class="text-muted fst-italic">Belum diunggah</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="syarat[{{ $d->id_dokumen ?? $d->id ?? $i }}]"
                                                       value="Ya"
                                                       id="ya{{ $i }}"
                                                       {{ isset($d->memenuhi_syarat) && $d->memenuhi_syarat ? 'checked' : '' }}>
                                                <label class="form-check-label" for="ya{{ $i }}">Ya</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio"
                                                       name="syarat[{{ $d->id_dokumen ?? $d->id ?? $i }}]"
                                                       value="Tidak"
                                                       id="tidak{{ $i }}"
                                                       {{ isset($d->memenuhi_syarat) && !$d->memenuhi_syarat ? 'checked' : '' }}>
                                                <label class="form-check-label" for="tidak{{ $i }}">Tidak</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada dokumen persyaratan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Tanda Tangan Persetujuan --}}
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
                        <p class="text-secondary mb-0 small">TTD Asesi & Admin</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row g-4">
                    <!-- Asesi (read-only image) -->
                    <div class="col-md-6">
                        <div class="bg-light p-4 rounded-4 h-100">
                            <h6 class="fw-bold mb-3">Asesi</h6>
                            <p><strong>Tanggal:</strong> {{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
                            @if(!empty($persetujuan->ttd_asesi))
                                <div class="text-center border rounded p-3 bg-white">
                                    <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="TTD Asesi"
                                         class="img-fluid" style="max-height:150px;">
                                </div>
                            @else
                                <p class="text-muted fst-italic">Belum ada tanda tangan asesi</p>
                            @endif
                        </div>
                    </div>

                    <!-- Admin (interactive canvas dengan desain baru) -->
                    <div class="col-md-6">
                        <div class="bg-light p-4 rounded-4 h-100">
                            <h6 class="fw-bold mb-3">Admin</h6>
                            <div class="mb-3">
                                <label for="tanggal-admin" class="form-label fw-medium">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" id="tanggal-admin" name="tanggal_admin" class="form-control"
                                       value="{{ old('tanggal_admin', date('Y-m-d')) }}" required>
                                <div class="invalid-feedback">Tanggal admin wajib diisi.</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-medium">Tanda Tangan Admin <span class="text-danger">*</span></label>
                                <div class="canvas-wrapper">
                                    <canvas id="ttd-admin" class="ttd-canvas" width="400" height="160"></canvas>
                                    <span class="canvas-placeholder">Tanda tangan di sini</span>
                                </div>
                                <input type="hidden" name="ttd_admin" id="ttd_admin_data" value="{{ old('ttd_admin', $persetujuan->ttd_admin ?? $permohonan->ttd_admin ?? '') }}">
                                <div class="invalid-feedback">Tanda tangan admin wajib diisi.</div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-3">
                                <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="clearCanvasAdmin()"><i class="bi bi-eraser me-1"></i>Hapus</button>
                                <button type="button" class="btn btn-outline-success rounded-pill px-4" onclick="downloadTTDAdmin()"><i class="bi bi-download me-1"></i>Unduh</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Keputusan Permohonan --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check2-circle text-primary" viewBox="0 0 16 16">
                            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Keputusan Permohonan</h5>
                        <p class="text-secondary mb-0 small">Pilih status dan catatan</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold fs-6">Status Keputusan <span class="text-danger">*</span></label>
                        <div class="d-flex gap-4 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="status_permohonan" id="statusDiterima" value="Diterima"
                                       {{ old('status_permohonan', $permohonan->status ?? '') == 'Diterima' ? 'checked' : '' }} required>
                                <label class="form-check-label text-success fw-semibold" for="statusDiterima"><i class="bi bi-check-circle me-1"></i>Diterima</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio"
                                       name="status_permohonan" id="statusDitolak" value="Ditolak"
                                       {{ old('status_permohonan', $permohonan->status ?? '') == 'Ditolak' ? 'checked' : '' }}>
                                <label class="form-check-label text-danger fw-semibold" for="statusDitolak"><i class="bi bi-x-circle me-1"></i>Ditolak</label>
                            </div>
                        </div>
                        <div class="invalid-feedback">Silakan pilih status keputusan.</div>
                    </div>
                    {{-- CATATAN SELALU TAMPIL --}}
                    <div class="col-md-6 mb-3">
                        <label for="catatan" class="form-label fw-semibold">Catatan / Keterangan</label>
                        <textarea id="catatan" name="catatan" class="form-control" rows="3" placeholder="Isi catatan jika diperlukan (wajib jika ditolak)">{{ old('catatan', $permohonan->catatan ?? '') }}</textarea>
                        <div class="invalid-feedback">Harap isi alasan penolakan.</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol aksi --}}
        <div class="d-flex justify-content-end gap-3 mt-4 mb-5">
            <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2 fw-semibold">Kembali</a>
            <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold">Simpan Keputusan</button>
        </div>
    </form>
</div>

{{-- Modal Preview --}}
<div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header border-bottom-0 bg-light">
                <h5 class="modal-title fw-bold">Preview Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-4" id="previewContent">
                <p class="text-muted">Memuat...</p>
            </div>
        </div>
    </div>
</div>

{{-- Modal Alert untuk TTD Admin (desain baru) --}}
<div class="modal fade" id="ttdWarningModal" tabindex="-1" aria-labelledby="ttdWarningModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 1.5rem; overflow: hidden;">
            <div class="modal-header bg-primary text-white border-0 py-3" style="background: linear-gradient(135deg, #0b2f7c, #08205c);">
                <h5 class="modal-title fw-bold" id="ttdWarningModalLabel">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    Tanda Tangan Diperlukan
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="my-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="#0b2f7c" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                        <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                    </svg>
                </div>
                <p class="fs-5 mb-2">Anda belum menandatangani.</p>
                <p class="text-secondary mb-0">Silakan tanda tangan pada area yang tersedia sebelum melanjutkan.</p>
            </div>
            <div class="modal-footer border-0 justify-content-center pb-4">
                <button type="button" class="btn btn-primary px-5 py-2 rounded-pill" style="background: linear-gradient(135deg, #0b2f7c, #08205c); border: none; box-shadow: 0 8px 18px rgba(11,47,124,0.3);" data-bs-dismiss="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-check-lg me-2" viewBox="0 0 16 16">
                        <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z"/>
                    </svg>
                    Mengerti
                </button>
            </div>
        </div>
    </div>
</div>

{{-- STYLE disesuaikan dengan tema #0b2f7c dan gaya halaman sebelumnya --}}
<style>
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

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        border: none;
        box-shadow: 0 8px 18px rgba(11,47,124,0.3);
        transition: all 0.2s;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), #061944);
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(11,47,124,0.35);
        color: #fff;
    }

    .btn-outline-secondary {
        border: 1.5px solid #dee2e6;
        color: var(--secondary);
        background: #fff;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-outline-secondary:hover {
        background-color: #f1f3f5;
        color: #495057;
        border-color: #ced4da;
    }

    .btn-outline-danger {
        border: 1.5px solid var(--danger);
        color: var(--danger);
        background: transparent;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.2s;
        text-decoration: none;
    }
    .btn-outline-danger:hover {
        background-color: var(--danger);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220,53,69,0.3);
    }

    .btn-outline-success {
        border: 1.5px solid var(--success);
        color: var(--success);
        background: transparent;
        padding: 0.5rem 1.5rem;
        border-radius: 2rem;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-outline-success:hover {
        background-color: var(--success);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(25,135,84,0.3);
    }

    .badge {
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 2rem;
        font-size: 0.8rem;
    }

    .canvas-wrapper {
        position: relative;
        width: 100%;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        border: 2px dashed #d0d9e8;
    }

    .ttd-canvas {
        display: block;
        width: 100%;
        height: 160px;
        background: #ffffff;
        cursor: crosshair;
        touch-action: none;
    }

    .canvas-placeholder {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        color: #9aa9b9;
        font-size: 0.9rem;
        background: rgba(255,255,255,0.7);
        padding: 4px 12px;
        border-radius: 40px;
        pointer-events: none;
        backdrop-filter: blur(2px);
    }

    @media (max-width: 768px) {
        .button-group {
            justify-content: center;
        }
    }
</style>

{{-- SCRIPT untuk canvas admin (diadaptasi dari halaman sebelumnya) --}}
<script>
    // Fungsi preview dokumen
    function openPreview(url, ext) {
        let content = '';
        ext = (ext || '').toLowerCase();
        if (['jpg','jpeg','png','gif','webp'].includes(ext)) {
            content = `<img src="${url}" class="img-fluid" alt="preview" style="max-height:80vh;">`;
        } else if (ext === 'pdf') {
            content = `<embed src="${url}" type="application/pdf" width="100%" height="600px">`;
        } else {
            content = `<a href="${url}" target="_blank" class="btn btn-primary">Download File</a>`;
        }
        document.getElementById('previewContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }

    // Inisialisasi canvas tanda tangan admin
    (function() {
        const canvas = document.getElementById('ttd-admin');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const placeholder = document.querySelector('.canvas-wrapper .canvas-placeholder');
        let drawing = false;
        const VISIBLE_HEIGHT = 160;
        let blankDataURL = null;

        function resizeCanvas() {
            const container = canvas.parentElement;
            const cssWidth = container.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';

            blankDataURL = canvas.toDataURL();
        }

        function getPointerPos(evt) {
            const rect = canvas.getBoundingClientRect();
            let clientX, clientY;
            if (evt.touches && evt.touches.length > 0) {
                clientX = evt.touches[0].clientX;
                clientY = evt.touches[0].clientY;
            } else {
                clientX = evt.clientX;
                clientY = evt.clientY;
            }
            return {
                x: (clientX - rect.left) * (canvas.width / rect.width),
                y: (clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDrawing(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPos(evt);
            ctx.beginPath();
            ctx.moveTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
            if (placeholder) placeholder.style.display = 'none';
        }

        function drawMove(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPos(evt);
            ctx.lineTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
            ctx.stroke();
        }

        function stopDrawing() {
            drawing = false;
            ctx.beginPath();
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', drawMove);
        window.addEventListener('mouseup', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', drawMove, { passive: false });
        window.addEventListener('touchend', stopDrawing);

        window.addEventListener('resize', () => {
            const prev = canvas.toDataURL();
            resizeCanvas();
            if (prev !== blankDataURL) {
                const img = new Image();
                img.onload = () => {
                    ctx.drawImage(img, 0, 0, canvas.clientWidth, VISIBLE_HEIGHT);
                };
                img.src = prev;
            }
        });

        resizeCanvas();

        window.clearCanvasAdmin = function() {
            const cssWidth = canvas.parentElement.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            blankDataURL = canvas.toDataURL();
            document.getElementById('ttd_admin_data').value = '';
            if (placeholder) placeholder.style.display = 'block';
        };

        window.isCanvasBlankAdmin = function() {
            return canvas.toDataURL() === blankDataURL;
        };

        window.saveAdminTTD = function(required = true) {
            const prev = document.getElementById('ttd_admin_data').value;
            if (prev && prev.trim().length > 0) {
                return true;
            }
            if (isCanvasBlankAdmin()) {
                if (required) {
                    new bootstrap.Modal(document.getElementById('ttdWarningModal')).show();
                }
                return false;
            }
            document.getElementById('ttd_admin_data').value = canvas.toDataURL('image/png');
            return true;
        };

        window.downloadTTDAdmin = function() {
            let dataUrl = '';
            if (!isCanvasBlankAdmin()) {
                dataUrl = canvas.toDataURL('image/png');
            } else {
                const prev = document.getElementById('ttd_admin_data').value;
                if (prev && prev.startsWith('data:image')) {
                    dataUrl = prev;
                }
            }
            if (!dataUrl) {
                new bootstrap.Modal(document.getElementById('ttdWarningModal')).show();
                return;
            }
            const link = document.createElement('a');
            const tanggal = document.getElementById('tanggal-admin').value || new Date().toISOString().split('T')[0];
            link.download = `Admin_${tanggal}_tanda_tangan.png`;
            link.href = dataUrl;
            link.click();
        };
    })();

    // Atur required catatan berdasarkan status (wajib jika ditolak)
    (function() {
        const diterima = document.getElementById('statusDiterima');
        const ditolak = document.getElementById('statusDitolak');
        const catatan = document.getElementById('catatan');

        function setCatatanRequired() {
            if (ditolak && ditolak.checked) {
                catatan.setAttribute('required', 'required');
            } else {
                catatan.removeAttribute('required');
                catatan.classList.remove('is-invalid');
            }
        }

        if (diterima && ditolak && catatan) {
            diterima.addEventListener('change', setCatatanRequired);
            ditolak.addEventListener('change', setCatatanRequired);
            setCatatanRequired();
        }
    })();

    // Validasi form + simpan TTD sebelum submit
    (function () {
        'use strict';
        const form = document.getElementById('permohonanForm');

        form.addEventListener('submit', function (event) {
            if (typeof saveAdminTTD === 'function') {
                const ok = saveAdminTTD(true);
                if (!ok) {
                    event.preventDefault();
                    event.stopPropagation();
                    return false;
                }
            }

            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                form.classList.add('was-validated');
                const firstInvalid = form.querySelector(':invalid');
                if (firstInvalid) {
                    try { firstInvalid.focus({ preventScroll: true }); } catch(e){ firstInvalid.focus(); }
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return false;
            }

            const ditolak = document.getElementById('statusDitolak');
            const catatan = document.getElementById('catatan');
            if (ditolak && ditolak.checked) {
                const val = (catatan && catatan.value) ? catatan.value.trim() : '';
                if (!val) {
                    event.preventDefault();
                    event.stopPropagation();
                    if (catatan) {
                        catatan.classList.add('is-invalid');
                        catatan.focus();
                        catatan.scrollIntoView({ behavior:'smooth', block: 'center' });
                    }
                    return false;
                }
            }

            form.classList.add('was-validated');
        }, false);
    })();
</script>
@endsection
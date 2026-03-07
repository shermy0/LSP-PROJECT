@extends('master')

@section('title', 'Detail Permohonan Sertifikasi Asesi')

@section('konten')
<div class="container-fluid px-4 py-3">
    <div class="bg-transparent">
        <!-- Header dengan sentuhan lebih elegan -->
        <div class="text-center mb-5">
            <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width:56px; height:56px; background: linear-gradient(145deg, #041562, #0a1e8a); box-shadow: 0 6px 12px rgba(4,21,98,0.2);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <h1 class="h3 fw-bold" style="color: #041562;">Detail Permohonan Sertifikasi</h1>
            <p class="text-secondary-emphasis bg-light d-inline-block px-4 py-2 rounded-pill fs-6"><span class="fw-semibold">FR.APL.02</span> — Rincian Data Pemohon</p>
        </div>

        <form id="permohonanForm" action="{{ route('admin.permohonan.update', $permohonan->id_permohonan) }}" method="POST" class="needs-validation" novalidate>
            @csrf

            {{-- Data Pribadi --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">1</span>
                    <p class="mb-1 fw-semibold fs-5">Data Pribadi</p>
                </div>
                <p class="mb-0 text-secondary">Rincian identitas pemohon</p>
            </div>

            <div class="question-box mb-4">
                <div class="ps-2 data-grid">
                    <p><strong>Nama Lengkap:</strong> {{ $asesi->nama_lengkap ?? '-' }}</p>
                    <p><strong>NIK / No. Identitas:</strong> {{ $asesi->nik ?? '-' }}</p>
                    <p><strong>Tempat Lahir:</strong> {{ $asesi->tempat_lahir ?? '-' }}</p>
                    <p><strong>Tanggal Lahir:</strong> {{ isset($asesi->tgl_lahir) ? \Carbon\Carbon::parse($asesi->tgl_lahir)->format('d M Y') : '-' }}</p>
                    <p><strong>Jenis Kelamin:</strong> {{ $asesi->jenis_kelamin == 'L' ? 'Laki-laki' : ($asesi->jenis_kelamin == 'P' ? 'Perempuan' : '-') }}</p>
                    <p><strong>Kebangsaan:</strong> {{ $asesi->kebangsaan ?? '-' }}</p>

                    <hr class="full-width my-3">

                    <p><strong>Alamat Rumah:</strong> {{ $asesi->alamat_rumah ?? '-' }}</p>
                    <p><strong>Kode Pos Rumah:</strong> {{ $asesi->kode_pos_rumah ?? '-' }}</p>
                    <p><strong>Telp. Rumah:</strong> {{ $asesi->telepon_rumah ?? '-' }}</p>
                    <p><strong>HP (No. Seluler):</strong> {{ $asesi->telepon_hp ?? '-' }}</p>
                    <p><strong>Email Pribadi:</strong> {{ $asesi->email ?? '-' }}</p>

                    <hr class="full-width my-3">

                    <p><strong>Kualifikasi Pendidikan:</strong> {{ $asesi->kualifikasi_pendidikan ?? ($asesi->pendidikan_terakhir ?? '-') }}</p>
                </div>
            </div>

            {{-- Data Pekerjaan --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">2</span>
                    <p class="mb-1 fw-semibold fs-5">Data Pekerjaan</p>
                </div>
                <p class="mb-0 text-secondary">Informasi pekerjaan / institusi saat ini</p>
            </div>

            <div class="question-box mb-4">
                <div class="ps-2 data-grid">
                    <p><strong>Nama Institusi / Perusahaan:</strong> {{ $asesi->nama_institusi ?? '-' }}</p>
                    <p><strong>Jabatan / Status:</strong> {{ $asesi->jabatan ?? '-' }}</p>
                    <p><strong>Alamat Kantor / Sekolah:</strong> {{ $asesi->alamat_kantor ?? '-' }}</p>
                    <p><strong>Kode Pos Kantor:</strong> {{ $asesi->kode_pos_kantor ?? '-' }}</p>
                    <p><strong>Telp. Kantor:</strong> {{ $asesi->telepon_kantor ?? '-' }}</p>
                    <p><strong>Fax Kantor:</strong> {{ $asesi->fax_kantor ?? '-' }}</p>
                    <p><strong>Email Kantor:</strong> {{ $asesi->email_kantor ?? '-' }}</p>
                </div>
            </div>

            {{-- Data TUK / Instansi --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">3</span>
                    <p class="mb-1 fw-semibold fs-5">Data TUK / Instansi</p>
                </div>
                <p class="mb-0 text-secondary">Informasi TUK yang terkait (jika tersedia)</p>
            </div>
            <div class="question-box mb-4">
                <div class="ps-2 data-grid">
                    <p><strong>Nama TUK / Lokasi Uji:</strong> {{ $tuk->nama_tuk ?? '-' }}</p>
                    <p><strong>Alamat TUK:</strong> {{ $tuk->alamat_tuk ?? '-' }}</p>
                    <p><strong>Telepon TUK:</strong> {{ $tuk->telepon ?? '-' }}</p>
                    <p><strong>Email TUK:</strong> {{ $tuk->email ?? '-' }}</p>
                </div>
            </div>

            {{-- Data Sertifikasi --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">4</span>
                    <p class="mb-1 fw-semibold fs-5">Data Sertifikasi</p>
                </div>
                <p class="mb-0 text-secondary">Skema & status permohonan</p>
            </div>
            <div class="question-box mb-4">
                <div class="ps-2 data-grid">
                    <p><strong>Skema Sertifikasi:</strong> {{ $skema->nama_skema ?? '-' }}</p>
                    <p><strong>Jenjang:</strong> {{ $skema->jenjang ?? '-' }}</p>
                    <p><strong>Judul Sertifikasi:</strong> {{ $skema->judul_skema ?? $skema->nama_skema ?? '-' }}</p>
                    <p><strong>Nomor Skema:</strong> {{ $skema->kode_skema ?? '-' }}</p>
                    <p><strong>Tujuan Asesmen:</strong>
                        @if(isset($permohonan->id_tujuan))
                            {{ \DB::table('tujuan_asesmen')->where('id_tujuan', $permohonan->id_tujuan)->value('nama_tujuan') ?? ($permohonan->tujuan_asesmen ?? '-') }}
                        @else
                            {{ $permohonan->tujuan_asesmen ?? '-' }}
                        @endif
                    </p>
                    <p><strong>Tanggal Permohonan:</strong> {{ isset($permohonan->tgl_permohonan) ? \Carbon\Carbon::parse($permohonan->tgl_permohonan)->format('d M Y') : '-' }}</p>
                    <p><strong>Status:</strong>
                        <span class="badge bg-{{ $permohonan->status=='Diajukan' ? 'warning text-dark' : ($permohonan->status=='Diterima' ? 'success' : ($permohonan->status=='Diperiksa' ? 'info text-dark' : 'danger')) }} px-3 py-2 fs-6">
                            {{ $permohonan->status ?? '-' }}
                        </span>
                    </p>
                </div>
            </div>

            {{-- Daftar Unit Kompetensi --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">5</span>
                    <p class="mb-1 fw-semibold fs-5">Daftar Unit Kompetensi</p>
                </div>
                <p class="mb-0 text-secondary">Unit kompetensi pemohon</p>
            </div>
            <div class="question-box mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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

            {{-- Bukti Kelengkapan --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">6</span>
                    <p class="mb-1 fw-semibold fs-5">Bukti Kelengkapan</p>
                </div>
                <p class="mb-0 text-secondary">Lampiran dokumen pemohon</p>
            </div>
            <div class="question-box mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
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
                                        @if(isset($d->memenuhi_syarat))
                                            <span class="badge {{ $d->memenuhi_syarat ? 'bg-success' : 'bg-danger' }} px-3 py-2">{{ $d->memenuhi_syarat ? 'Ya' : 'Tidak' }}</span>
                                        @else
                                            <div class="d-flex justify-content-center gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="syarat[{{ $d->id_dokumen ?? $d->id ?? $i }}]" value="Ya" id="ya{{ $i }}">
                                                    <label class="form-check-label" for="ya{{ $i }}">Ya</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="syarat[{{ $d->id_dokumen ?? $d->id ?? $i }}]" value="Tidak" id="tidak{{ $i }}">
                                                    <label class="form-check-label" for="tidak{{ $i }}">Tidak</label>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada dokumen persyaratan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tanda Tangan Persetujuan --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">7</span>
                    <p class="mb-1 fw-semibold fs-5">Tanda Tangan Persetujuan</p>
                </div>
                <p class="mb-0 text-secondary">TTD Asesi & Admin</p>
            </div>
            <div class="question-box mb-4">
                <div class="row g-4">
                    <!-- Asesi (read-only image) -->
                    <div class="col-md-6">
                        <div class="bg-light p-4 rounded-4 h-100 d-flex flex-column">
                            <p class="mb-3 fw-semibold fs-5 text-primary"><i class="bi bi-person-circle me-2"></i>Asesi</p>
                            <p><strong>Tanggal:</strong> {{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
                            @if(!empty($persetujuan->ttd_asesi))
                                <div class="mt-2 text-center border rounded-3 p-3 bg-white">
                                    <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="TTD Asesi"
                                         class="img-fluid" style="max-height:150px; object-fit:contain;">
                                </div>
                            @else
                                <div class="text-muted fst-italic border rounded-3 p-4 text-center bg-white">Belum ada tanda tangan asesi</div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin (interactive canvas) -->
                    <div class="col-md-6">
                        <div class="bg-light p-4 rounded-4 h-100 d-flex flex-column">
                            <p class="mb-3 fw-semibold fs-5 text-primary"><i class="bi bi-shield-lock me-2"></i>Admin</p>
                            <div class="mb-3">
                                <label for="tanggal-admin" class="form-label fw-medium">Tanggal</label>
                                <input type="date" id="tanggal-admin" name="tanggal_admin" class="form-control"
                                       value="{{ old('tanggal_admin', date('Y-m-d')) }}" required>
                                <div class="invalid-feedback">Tanggal admin wajib diisi.</div>
                            </div>

                            <div class="mb-3 grow d-flex flex-column">
                                <label class="form-label fw-medium">Tanda Tangan Admin <span class="text-danger">*</span></label>
                                <div class="canvas-wrapper border-2 border-primary" style="border: 2px dashed #007BFF; border-radius: 16px; background: white; padding: 4px;">
                                    <canvas id="ttd-admin" style="width:100%; height:160px; border-radius: 12px; background: #fff; cursor: crosshair;"></canvas>
                                    <span class="canvas-placeholder" style="color: #aaa; bottom: 20px;">Tanda tangan admin di sini</span>
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

            {{-- Keputusan Permohonan --}}
            <div class="unit-header">
                <div class="d-flex align-items-center gap-2">
                    <span class="badge bg-primary rounded-pill px-3 py-1 fs-6">8</span>
                    <p class="mb-1 fw-semibold fs-5">Keputusan Permohonan</p>
                </div>
                <p class="mb-0 text-secondary">Pilih status dan catatan</p>
            </div>
            <div class="question-box mb-4">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold fs-6">Status Keputusan</label>
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
                    <div class="col-md-6 mb-3" id="catatanBox" style="display: {{ old('status_permohonan', $permohonan->status ?? '') == 'Ditolak' ? 'block' : 'none' }};">
                        <label for="catatan" class="form-label fw-semibold">Alasan / Keterangan</label>
                        <textarea id="catatan" name="catatan" class="form-control" rows="3" placeholder="Isi alasan penolakan (wajib jika ditolak)">{{ old('catatan', $permohonan->catatan ?? '') }}</textarea>
                        <div class="invalid-feedback">Harap isi alasan penolakan.</div>
                    </div>
                </div>
            </div>

            {{-- Tombol aksi --}}
            <div class="d-flex justify-content-end gap-3 mt-4 mb-5">
                <a href="{{ route('admin.permohonan.index') }}" class="btn btn-outline-secondary rounded-pill px-5 py-2 fw-semibold">Kembali</a>
                <button type="submit" class="btn btn-primary rounded-pill px-5 py-2 fw-semibold" style="background: #041562; border: none;">Simpan Keputusan</button>
            </div>
        </form>
    </div>
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

{{-- Modal Alert untuk TTD Admin --}}
<div class="modal fade" id="ttdAlertModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Tanda Tangan Diperlukan</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body p-4">
        <p class="fs-6">Silakan isi tanda tangan admin terlebih dahulu sebelum menyimpan keputusan.</p>
      </div>
      <div class="modal-footer justify-content-center border-0">
        <button type="button" class="btn btn-primary px-5 rounded-pill" data-bs-dismiss="modal">Mengerti</button>
      </div>
    </div>
  </div>
</div>

{{-- STYLE ditingkatkan --}}
<style>
    /* === FONT & DASAR === */
    body {
        font-family: 'Inter', 'Poppins', system-ui, sans-serif;
        background: #f8fafd;
    }

    /* === UNIT HEADER (lebih elegan) === */
    .unit-header {
        background: linear-gradient(90deg, #E9F1FF 0%, #f1f7fe 100%);
        border-left: 8px solid #007BFF;
        border-radius: 20px 20px 20px 8px;
        padding: 1.25rem 1.5rem;
        margin-bottom: 1.25rem;
        box-shadow: 0 6px 14px rgba(0,123,255,0.08);
        transition: all 0.2s;
    }
    .unit-header:hover {
        box-shadow: 0 8px 20px rgba(4,21,98,0.12);
        border-left-width: 10px;
    }
    .unit-header .badge {
        background: #041562 !important;
        font-size: 0.9rem;
    }

    /* === QUESTION BOX (card modern) === */
    .question-box {
        border: none;
        border-radius: 28px;
        padding: 1.75rem;
        margin-bottom: 2rem;
        background: #ffffff;
        box-shadow: 0 15px 35px -10px rgba(4,21,98,0.1);
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .question-box:hover {
        box-shadow: 0 20px 40px -8px rgba(4,21,98,0.18);
    }

    /* === GRID DATA (dua kolom untuk field) === */
    .data-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem 2rem;
    }
    .data-grid p {
        margin: 0;
        background: #f8fbfe;
        padding: 0.75rem 1.25rem;
        border-radius: 18px;
        border: 1px solid #eef4fa;
        transition: 0.1s;
        display: flex;
        align-items: baseline;
        gap: 6px;
        font-size: 0.95rem;
    }
    .data-grid p:hover {
        background: #eef4fa;
        border-color: #b8d3f0;
    }
    .data-grid p strong {
        color: #041562;
        font-weight: 600;
        min-width: 130px;
        flex-shrink: 0;
    }
    .data-grid hr.full-width {
        grid-column: 1 / -1;
        margin: 0.5rem 0;
        border: 0;
        border-top: 2px dashed #cbd5e1;
        opacity: 0.6;
    }

    /* === TABEL (lebih rapi) === */
    .table {
        border-radius: 20px;
        overflow: hidden;
        border-collapse: separate;
        border-spacing: 0;
    }
    .table thead th {
        background: #eef2f7;
        color: #041562;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #cbd5e1;
    }
    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        background: white;
        border-bottom: 1px solid #e2e8f0;
    }
    .table-hover tbody tr:hover td {
        background: #f5f9ff;
    }

    /* === CANVAS TTD (dibersihkan) === */
    .canvas-wrapper {
        position: relative;
        background: white;
        border-radius: 20px;
        overflow: hidden;
    }
    #ttd-admin {
        display: block;
        width: 100%;
        height: 160px;
        background: #ffffff;
        cursor: crosshair;
        touch-action: none; /* untuk touch */
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

    /* === BUTTONS (kustom) === */
    .btn-back, .btn-next {
        transition: all 0.2s;
        font-weight: 600;
        border-radius: 40px;
        padding: 0.6rem 2rem;
        box-shadow: 0 6px 12px rgba(0,0,0,0.05);
    }
    .btn-back {
        background: #d9534f;
        color: white;
        border: none;
    }
    .btn-back:hover {
        background: #c13d39;
        transform: translateY(-2px);
        box-shadow: 0 12px 18px rgba(217,83,79,0.3);
    }
    .btn-next {
        background: #041562;
        color: white;
        border: none;
    }
    .btn-next:hover {
        background: #0a1e8a;
        transform: translateY(-2px);
        box-shadow: 0 12px 18px rgba(4,21,98,0.25);
    }

    /* === RADIO & FORM CUSTOM === */
    .form-check-input:checked {
        background-color: #041562;
        border-color: #041562;
    }
    .form-check-input:focus {
        border-color: #007BFF;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.15);
    }
    .form-control, .form-select {
        border-radius: 50px;
        padding: 0.6rem 1.2rem;
        border: 1px solid #dde3eb;
    }
    .form-control:focus, .form-select:focus {
        border-color: #007BFF;
        box-shadow: 0 0 0 3px rgba(0,123,255,0.15);
    }
    .invalid-feedback {
        font-size: 0.85rem;
        background: #fce8e8;
        padding: 0.3rem 1rem;
        border-radius: 30px;
        margin-top: 0.3rem;
        display: inline-block;
    }

    /* === BADGE STATUS === */
    .badge.bg-warning { background: #ffc107; color: #1e293b; }
    .badge.bg-success { background: #28a745; }
    .badge.bg-info { background: #17a2b8; color: white; }
    .badge.bg-danger { background: #dc3545; }

    /* === RESPONSIF === */
    @media (max-width: 768px) {
        .data-grid {
            grid-template-columns: 1fr;
        }
        .unit-header .badge {
            font-size: 0.8rem;
        }
        .question-box {
            padding: 1.2rem;
        }
    }
</style>

{{-- SCRIPTS (sama persis, hanya tambahan inisialisasi) --}}
<script>
    // Preview dokumen
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

    // === TTD Admin (fungsi lengkap) ===
    (function () {
        const canvas = document.getElementById('ttd-admin');
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        const placeholder = document.querySelector('.canvas-placeholder');
        const VISIBLE_HEIGHT = 160;
        let drawing = false;
        let blankDataURL = null;

        function resizeCanvasAndPrepareBlankAdmin() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.strokeStyle = '#000';

            blankDataURL = canvas.toDataURL();
        }

        function getPointerPosAdmin(evt) {
            const rect = canvas.getBoundingClientRect();
            let clientX, clientY;
            if (evt.touches && evt.touches.length > 0) {
                clientX = evt.touches[0].clientX;
                clientY = evt.touches[0].clientY;
            } else {
                clientX = evt.clientX;
                clientY = evt.clientY;
            }
            return { x: clientX - rect.left, y: clientY - rect.top };
        }

        function startDrawingAdmin(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPosAdmin(evt);
            ctx.beginPath();
            ctx.moveTo(pos.x, pos.y);
            placeholder.style.display = 'none';
        }
        function drawMoveAdmin(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPosAdmin(evt);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
        function stopDrawingAdmin(evt) {
            if (!drawing) return;
            evt.preventDefault();
            drawing = false;
            ctx.beginPath();
        }

        function clearCanvasAdmin() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            blankDataURL = canvas.toDataURL();
            document.getElementById('ttd_admin_data').value = '';
            placeholder.style.display = 'block';
        }

        function isCanvasBlankAdmin() {
            return canvas.toDataURL() === blankDataURL;
        }

        function saveAdminTTD(required = true) {
            const prev = document.getElementById('ttd_admin_data').value;
            if (prev && prev.trim().length > 0) {
                return true;
            }
            if (isCanvasBlankAdmin()) {
                if (required) {
                    new bootstrap.Modal(document.getElementById('ttdAlertModal')).show();
                    return false;
                } else {
                    document.getElementById('ttd_admin_data').value = '';
                    return true;
                }
            }
            document.getElementById('ttd_admin_data').value = canvas.toDataURL('image/png');
            return true;
        }

        function downloadTTDAdmin() {
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
                new bootstrap.Modal(document.getElementById('ttdAlertModal')).show();
                return;
            }
            const link = document.createElement('a');
            const tanggal = document.getElementById('tanggal-admin').value || new Date().toISOString().split('T')[0];
            link.download = `Admin_${tanggal}_tanda_tangan.png`;
            link.href = dataUrl;
            link.click();
        }

        canvas.addEventListener('mousedown', startDrawingAdmin);
        canvas.addEventListener('mousemove', drawMoveAdmin);
        window.addEventListener('mouseup', stopDrawingAdmin);

        canvas.addEventListener('touchstart', function(e){ startDrawingAdmin(e); }, { passive: false });
        canvas.addEventListener('touchmove', function(e){ drawMoveAdmin(e); }, { passive: false });
        window.addEventListener('touchend', stopDrawingAdmin);

        window.addEventListener('resize', function () {
            const prev = canvas.toDataURL();
            resizeCanvasAndPrepareBlankAdmin();
            if (prev && prev !== blankDataURL) {
                const img = new Image();
                img.onload = function () {
                    ctx.drawImage(img, 0, 0, canvas.clientWidth, VISIBLE_HEIGHT);
                };
                img.src = prev;
            }
        });

        resizeCanvasAndPrepareBlankAdmin();

        window.clearCanvasAdmin = clearCanvasAdmin;
        window.downloadTTDAdmin = downloadTTDAdmin;
        window.saveAdminTTD = saveAdminTTD;
        window.isCanvasBlankAdmin = isCanvasBlankAdmin;
    })();

    // Toggle catatan ketika ditolak
    (function () {
        const diterima = document.getElementById('statusDiterima');
        const ditolak = document.getElementById('statusDitolak');
        const catatanBox = document.getElementById('catatanBox');
        const catatan = document.getElementById('catatan');

        function toggleCatatan() {
            if (!catatanBox) return;
            if (ditolak && ditolak.checked) {
                catatanBox.style.display = 'block';
                if (catatan) catatan.setAttribute('required', 'required');
            } else {
                catatanBox.style.display = 'none';
                if (catatan) {
                    catatan.removeAttribute('required');
                    catatan.classList.remove('is-invalid');
                }
            }
        }

        if (diterima && ditolak) {
            diterima.addEventListener('change', toggleCatatan);
            ditolak.addEventListener('change', toggleCatatan);
            toggleCatatan();
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
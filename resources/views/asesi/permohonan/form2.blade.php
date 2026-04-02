@extends('master')

@section('title', 'FR.APL.02 - Permohonan Sertifikasi Kompetensi')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <form id="permohonanForm" action="{{ route('asesi.permohonan.storeDokumen') }}" method="POST"
            enctype="multipart/form-data" class="needs-validation" novalidate>
            @csrf

            <!-- Header dengan ikon dan judul (warna #0b2f7c) -->
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-file-text" viewBox="0 0 16 16">
                        <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                    </svg>
                </div>
                <h1 class="display-6 fw-bold text-dark">Permohonan Sertifikasi Kompetensi</h1>
                <p class="text-secondary">Form Asesmen FR.APL.02 – Isi data dengan lengkap dan benar</p>
            </div>

            <!-- Data Sertifikasi - Card Modern -->
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
                            <p class="text-secondary mb-0 small">Pilih skema sertifikasi dan tujuan asesmen</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Skema Sertifikasi <span class="text-danger">*</span></label>
                            <select id="skemaSelect" name="id_skema" class="form-select" required>
                                <option value="" disabled {{ old('id_skema', $permohonan->id_skema ?? '') ? '' : 'selected' }}>Pilih Skema Sertifikasi</option>
                                @foreach($skema as $s)
                                    <option value="{{ $s->id_skema }}" {{ (string) old('id_skema', $permohonan->id_skema ?? '') === (string) $s->id_skema ? 'selected' : '' }}>
                                        {{ $s->nama_skema }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Silakan pilih skema sertifikasi.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tujuan Asesmen <span class="text-danger">*</span></label>
                            <select id="tujuanAsesmen" name="tujuan_id" class="form-select" required>
                                <option value="" disabled {{ old('tujuan_id', $permohonan->id_tujuan ?? '') ? '' : 'selected' }}>Pilih Tujuan Asesmen</option>
                                @foreach($tujuanAsesmen as $t)
                                    <option value="{{ $t->id_tujuan }}" {{ (string) old('tujuan_id', $permohonan->id_tujuan ?? '') === (string) $t->id_tujuan ? 'selected' : '' }}>
                                        {{ $t->nama_tujuan }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">Silakan pilih tujuan asesmen.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Judul Sertifikasi</label>
                            <input type="text" id="judulSertifikasi" class="form-control" readonly value="">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor Skema</label>
                            <input type="text" id="nomorSkema" class="form-control" readonly value="">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daftar Unit Kompetensi -->
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
                            <p class="text-secondary mb-0 small">Unit kompetensi yang diujikan sesuai skema</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                32
                                    <th>No</th>
                                    <th>Kode Unit</th>
                                    <th>Judul Unit</th>
                                    <th>Standar Kompetensi Kerja</th>
                                </tr>
                            </thead>
                            <tbody id="unitTable">
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Pilih skema sertifikasi terlebih dahulu</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card A. Bukti Persyaratan Dasar Pemohon -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-text text-primary" viewBox="0 0 16 16">
                                <path d="M5.5 7a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/>
                                <path d="M9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.5L9.5 0zm0 1v2A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">A. Bukti Persyaratan Dasar Pemohon</h5>
                            <p class="text-secondary mb-0 small">Unggah dokumen persyaratan dasar yang diperlukan</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    @foreach($jenisDokumen->where('kategori', 'dasar') as $jd)
                        @php
                            $doc = $existingDocs->get($jd->id_jenis_dokumen) ?? null;
                            $invalidClass = ($doc && !$doc->memenuhi_syarat) ? 'is-invalid' : '';
                            $existingFileUrl = $doc && $doc->path_file ? Storage::url($doc->path_file) : '';
                            $existingFileName = $doc ? $doc->nama_file : '';
                        @endphp
                        <div class="mb-3 dokumen-item">
                            <label class="form-label">{{ $loop->iteration }}. {{ $jd->nama_dokumen }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="dokumen[{{ $jd->id_jenis_dokumen }}]"
                                    class="form-control dokumen-input {{ $invalidClass }}" accept=".jpg,.jpeg,.png,.pdf"
                                    onchange="previewFile(this)" data-existing-name="{{ $existingFileName }}"
                                    data-file-url="{{ $existingFileUrl }}"
                                    data-memenuhi="{{ $doc && $doc->memenuhi_syarat ? '1' : '0' }}">
                                <button type="button" class="btn btn-outline-primary lihat-btn" onclick="lihatFile(this)"
                                    data-file-url="{{ $existingFileUrl }}" {{ $existingFileUrl ? '' : 'disabled' }}>
                                    Lihat
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-hapus" onclick="hapusFile(this)">Hapus</button>
                            </div>
                            <input type="hidden" name="remove_dokumen[{{ $jd->id_jenis_dokumen }}]" value="0" class="remove-flag">
                            <div class="file-preview mt-2 small">
                                @if($existingFileName)
                                    <strong>File tersimpan:</strong> {{ $existingFileName }}
                                @else
                                    Belum ada file dipilih
                                @endif
                            </div>
                            @if($doc && !$doc->memenuhi_syarat)
                                <div class="text-danger small mt-1">Dokumen belum memenuhi syarat.</div>
                                @if(!empty($doc->catatan))
                                    <div class="text-muted small mt-1">Catatan: {{ $doc->catatan }}</div>
                                @endif
                            @endif
                            <div class="invalid-feedback dokumen-error">Silakan unggah dokumen ini.</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Card B. Bukti Administratif -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-files text-primary" viewBox="0 0 16 16">
                                <path d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">B. Bukti Administratif</h5>
                            <p class="text-secondary mb-0 small">Unggah dokumen administratif yang diperlukan</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    @foreach($jenisDokumen->where('kategori', 'administratif') as $jd)
                        @php
                            $doc = $existingDocs->get($jd->id_jenis_dokumen) ?? null;
                            $invalidClass = ($doc && !$doc->memenuhi_syarat) ? 'is-invalid' : '';
                            $existingFileUrl = $doc && $doc->path_file ? Storage::url($doc->path_file) : '';
                            $existingFileName = $doc ? $doc->nama_file : '';
                        @endphp
                        <div class="mb-3 dokumen-item">
                            <label class="form-label">{{ $loop->iteration }}. {{ $jd->nama_dokumen }} <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="file" name="dokumen[{{ $jd->id_jenis_dokumen }}]"
                                    class="form-control dokumen-input {{ $invalidClass }}" accept=".jpg,.jpeg,.png,.pdf"
                                    onchange="previewFile(this)" data-existing-name="{{ $existingFileName }}"
                                    data-file-url="{{ $existingFileUrl }}"
                                    data-memenuhi="{{ $doc && $doc->memenuhi_syarat ? '1' : '0' }}">
                                <button type="button" class="btn btn-outline-primary lihat-btn" onclick="lihatFile(this)"
                                    data-file-url="{{ $existingFileUrl }}" {{ $existingFileUrl ? '' : 'disabled' }}>
                                    Lihat
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-hapus" onclick="hapusFile(this)">Hapus</button>
                            </div>
                            <input type="hidden" name="remove_dokumen[{{ $jd->id_jenis_dokumen }}]" value="0" class="remove-flag">
                            <div class="file-preview mt-2 small">
                                @if($existingFileName)
                                    <strong>File tersimpan:</strong> {{ $existingFileName }}
                                @else
                                    Belum ada file dipilih
                                @endif
                            </div>
                            @if($doc && !$doc->memenuhi_syarat)
                                <div class="text-danger small mt-1">Dokumen belum memenuhi syarat.</div>
                                @if(!empty($doc->catatan))
                                    <div class="text-muted small mt-1">Catatan: {{ $doc->catatan }}</div>
                                @endif
                            @endif
                            <div class="invalid-feedback dokumen-error">Silakan unggah dokumen ini.</div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tanda Tangan Asesi - Card Modern (dengan tombol hapus baru) -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pen text-primary" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Tanda Tangan Asesi</h5>
                            <p class="text-secondary mb-0 small">Isi nama, tanggal, dan tanda tangan digital</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" id="nama-asesi" class="form-control"
                                value="{{ $asesi->nama_lengkap ?? Auth::user()->name }}" readonly required>
                            <div class="invalid-feedback">Nama wajib terisi.</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal</label>
                            <input type="date" id="tanggal-asesi" name="tanggal" class="form-control"
                                value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            <div class="invalid-feedback">Tanggal wajib diisi.</div>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Tanda Tangan <span class="text-danger">*</span></label>
                            <div class="canvas-wrapper">
                                <canvas id="ttd-asesi"></canvas>
                                <span class="canvas-placeholder">Tanda tangan di sini</span>
                            </div>
                            <input type="hidden" name="ttd_asesi" id="ttd_asesi_data" required>
                            <div class="invalid-feedback">Tanda tangan wajib diisi.</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="clearCanvas()">
                            <i class="bi bi-eraser me-1"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="button-group mt-4">
                <a href="{{ route('asesi.permohonan.form1') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali
                </a>
                <button type="submit" class="btn-next">
                    Simpan dan Kirim
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send ms-2" viewBox="0 0 16 16">
                        <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Preview -->
    <div class="modal fade" id="previewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Preview Dokumen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center" id="previewContent"></div>
            </div>
        </div>
    </div>

    <!-- Modal Peringatan Tanda Tangan (desain baru) -->
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
                    <p class="fs-5 mb-2">Anda belum menandatangani formulir ini.</p>
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

        /* Validasi styling */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border: 2px solid var(--danger) !important;
            background: #fff8f8 !important;
        }

        .invalid-feedback {
            font-size: 0.8rem;
            display: none;
            color: var(--danger);
            margin-top: 0.25rem;
        }

        .form-control.is-invalid + .invalid-feedback,
        .form-select.is-invalid + .invalid-feedback {
            display: block;
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
        }

        .btn-next:hover {
            background: linear-gradient(135deg, var(--primary-dark), #061944);
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(11,47,124,0.35);
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

        /* Tombol outline danger untuk hapus */
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

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* Canvas TTD */
        .canvas-wrapper {
            position: relative;
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
        }

        #ttd-asesi {
            display: block;
            width: 100%;
            height: 200px;
            border: 2px dashed #ccc;
            border-radius: 6px;
            background-color: #fff;
            cursor: crosshair;
        }

        .canvas-placeholder {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #aaa;
            font-size: 14px;
            pointer-events: none;
        }

        /* File preview */
        .file-preview {
            font-size: 13px;
        }

        /* Modal preview */
        .modal-body img {
            max-width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 6px;
        }

        .modal-body iframe {
            width: 100%;
            height: 600px;
            border: none;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .button-group {
                justify-content: center;
            }
        }
    </style>

    <script>
        // Fungsi preview file
        function previewFile(input) {
            const file = input.files[0];
            const previewDiv = input.closest('.dokumen-item').querySelector('.file-preview');
            const lihatBtn = input.closest('.input-group').querySelector('button.lihat-btn');
            const removeFlag = input.closest('.dokumen-item').querySelector('.remove-flag');
            const errorDiv = input.closest('.dokumen-item').querySelector('.dokumen-error');

            if (file) {
                previewDiv.innerHTML = `<strong>File dipilih:</strong> ${file.name}`;
                if (lihatBtn) lihatBtn.disabled = false;
                if (removeFlag) removeFlag.value = "0";
                input.classList.remove('is-invalid');
                if (errorDiv) errorDiv.style.display = 'none';
            } else {
                const existingName = input.dataset.existingName || '';
                const existingUrl = input.dataset.fileUrl || '';
                if (existingName) {
                    previewDiv.innerHTML = `<strong>File tersimpan:</strong> ${existingName}`;
                    if (lihatBtn) {
                        lihatBtn.disabled = !existingUrl;
                        lihatBtn.setAttribute('data-file-url', existingUrl || '');
                    }
                    if (removeFlag) removeFlag.value = "0";
                } else {
                    previewDiv.textContent = "Belum ada file dipilih";
                    if (lihatBtn) lihatBtn.disabled = true;
                    if (removeFlag) removeFlag.value = "0";
                }
            }
        }

        // Fungsi lihat file
        function lihatFile(btn) {
            const input = btn.closest('.input-group').querySelector('input[type="file"]');
            const file = input.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const modalBody = document.getElementById('previewContent');
                    modalBody.innerHTML = "";
                    if (file.type === "application/pdf") {
                        modalBody.innerHTML = `<iframe src="${e.target.result}"></iframe>`;
                    } else if (file.type.startsWith("image/")) {
                        modalBody.innerHTML = `<img src="${e.target.result}" alt="Preview Gambar">`;
                    } else {
                        modalBody.innerHTML = `<p>Tipe file tidak didukung untuk preview</p>`;
                    }
                    new bootstrap.Modal(document.getElementById('previewModal')).show();
                };
                reader.readAsDataURL(file);
                return;
            }

            const fileUrl = btn.getAttribute('data-file-url') || input.dataset.fileUrl || '';
            if (!fileUrl) return;

            const lower = fileUrl.toLowerCase();
            const modalBody = document.getElementById('previewContent');
            modalBody.innerHTML = "";
            if (lower.endsWith('.pdf')) {
                modalBody.innerHTML = `<iframe src="${fileUrl}"></iframe>`;
            } else if (lower.match(/\.(jpg|jpeg|png|gif|webp)$/)) {
                modalBody.innerHTML = `<img src="${fileUrl}" alt="Preview Gambar">`;
            } else {
                window.open(fileUrl, '_blank');
                return;
            }
            new bootstrap.Modal(document.getElementById('previewModal')).show();
        }

        // Fungsi hapus file
        function hapusFile(btn) {
            const mb = btn.closest('.dokumen-item');
            const input = mb.querySelector('input[type="file"]');
            const lihatBtn = mb.querySelector('button.lihat-btn');
            const previewDiv = mb.querySelector('.file-preview');
            const removeFlag = mb.querySelector('.remove-flag');
            const errorDiv = mb.querySelector('.dokumen-error');

            input.value = "";
            previewDiv.textContent = "Belum ada file dipilih";
            if (lihatBtn) lihatBtn.disabled = true;
            if (removeFlag) removeFlag.value = "1";
            input.classList.remove('is-invalid');
            if (errorDiv) errorDiv.style.display = 'none';
        }

        // Validasi dokumen wajib diisi sebelum submit
        function validateDocuments() {
            const dokumenItems = document.querySelectorAll('.dokumen-item');
            let valid = true;

            dokumenItems.forEach(item => {
                const input = item.querySelector('input[type="file"]');
                const removeFlag = item.querySelector('.remove-flag');
                const errorDiv = item.querySelector('.dokumen-error');
                const existingFileUrl = input.dataset.fileUrl || '';
                const hasExisting = existingFileUrl !== '';
                const isRemoved = removeFlag && removeFlag.value === '1';
                const hasNewFile = input.files.length > 0;

                // Dokumen dianggap ada jika: (ada file baru) atau (ada existing dan tidak dihapus)
                const isFilled = hasNewFile || (hasExisting && !isRemoved);

                if (!isFilled) {
                    valid = false;
                    input.classList.add('is-invalid');
                    if (errorDiv) {
                        errorDiv.style.display = 'block';
                        errorDiv.textContent = 'Dokumen ini wajib diisi.';
                    }
                } else {
                    input.classList.remove('is-invalid');
                    if (errorDiv) errorDiv.style.display = 'none';
                }
            });

            return valid;
        }

        // SKEMA AJAX LOADER
        document.getElementById('skemaSelect').addEventListener('change', function () {
            let id = this.value;
            if (!id) return;
            let url = "{{ route('get.skema', ':id') }}".replace(':id', id);
            fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('judulSertifikasi').value = data.skema.judul_skema ?? data.skema.nama_skema;
                    document.getElementById('nomorSkema').value = data.skema.kode_skema ?? '';
                    let tbody = document.getElementById('unitTable');
                    tbody.innerHTML = '';
                    if (data.units && data.units.length > 0) {
                        data.units.forEach((u, i) => {
                            tbody.innerHTML += `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>${u.kode_unit ?? '-'}</td>
                                    <td>${u.judul_unit ?? '-'}</td>
                                    <td>${u.standar_kompetensi ?? '-'}</td>
                                </tr>`;
                        });
                    } else {
                        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Tidak ada unit kompetensi</td></tr>`;
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Gagal memuat data skema');
                });
        });

        // TTD Canvas
        const canvas = document.getElementById("ttd-asesi");
        const ctx = canvas.getContext("2d");
        const placeholder = document.querySelector(".canvas-placeholder");
        let drawing = false;
        const VISIBLE_HEIGHT = 200;

        function resizeCanvasAndPrepareBlank() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);
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
            const x = clientX - rect.left;
            const y = clientY - rect.top;
            return { x, y };
        }

        function startDrawing(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPos(evt);
            ctx.beginPath();
            ctx.lineWidth = 2;
            ctx.lineCap = "round";
            ctx.strokeStyle = "#000";
            ctx.moveTo(pos.x, pos.y);
            placeholder.style.display = "none";
        }
        function drawMove(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPos(evt);
            ctx.lineTo(pos.x, pos.y);
            ctx.stroke();
        }
        function stopDrawing(evt) {
            if (!drawing) return;
            evt.preventDefault();
            drawing = false;
            ctx.beginPath();
        }

        function clearCanvas() {
            const cssWidth = canvas.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            document.getElementById("ttd_asesi_data").value = "";
            placeholder.style.display = "block";
        }

        // Deteksi canvas kosong dengan memeriksa pixel
        function isCanvasBlank() {
            const canvas = document.getElementById('ttd-asesi');
            const ctx = canvas.getContext('2d');
            const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            for (let i = 0; i < pixelData.length; i += 4) {
                // Jika ada pixel yang tidak putih (nilai RGB tidak semuanya 255)
                if (pixelData[i] !== 255 || pixelData[i+1] !== 255 || pixelData[i+2] !== 255) {
                    return false; // ada coretan
                }
            }
            return true; // semua putih
        }

        function saveTTD() {
            if (isCanvasBlank()) {
                const modalEl = document.getElementById('ttdWarningModal'); // ID baru
                if (modalEl) {
                    const modal = new bootstrap.Modal(modalEl);
                    modal.show();
                } else {
                    alert("Silakan tanda tangan terlebih dahulu.");
                }
                return false;
            }
            const dataURL = canvas.toDataURL("image/png");
            document.getElementById("ttd_asesi_data").value = dataURL;
            return true;
        }

        function attachCanvasEvents() {
            canvas.addEventListener('mousedown', startDrawing);
            canvas.addEventListener('mousemove', drawMove);
            window.addEventListener('mouseup', stopDrawing);

            canvas.addEventListener('touchstart', startDrawing, { passive: false });
            canvas.addEventListener('touchmove', drawMove, { passive: false });
            window.addEventListener('touchend', stopDrawing);
        }

        window.addEventListener('resize', function () {
            const prevData = canvas.toDataURL();
            resizeCanvasAndPrepareBlank();

            if (prevData && prevData !== canvas.toDataURL()) { // jika sebelumnya tidak kosong
                const img = new Image();
                img.onload = function () {
                    ctx.drawImage(img, 0, 0, canvas.clientWidth, VISIBLE_HEIGHT);
                };
                img.src = prevData;
            }
        });

        resizeCanvasAndPrepareBlank();
        attachCanvasEvents();

        // Event submit form dengan validasi dokumen dan TTD
        document.getElementById('permohonanForm').addEventListener('submit', function (event) {
            let isValid = true;

            // Validasi TTD
            if (!saveTTD()) {
                event.preventDefault();
                isValid = false;
            }

            // Validasi dokumen wajib
            if (!validateDocuments()) {
                event.preventDefault();
                isValid = false;
            }

            // Validasi form HTML5 (select, input required)
            if (!this.checkValidity()) {
                event.preventDefault();
                isValid = false;
            }

            if (!isValid) {
                event.stopPropagation();
                const firstInvalid = this.querySelector(':invalid, .is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
            }

            this.classList.add('was-validated');
        });

        // Setelah DOM siap, inisialisasi tombol lihat
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.input-group').forEach(group => {
                const input = group.querySelector('input[type="file"]');
                const lihatBtn = group.querySelector('button.lihat-btn');
                if (input && lihatBtn) {
                    const fileUrl = input.dataset.fileUrl || lihatBtn.getAttribute('data-file-url') || '';
                    lihatBtn.disabled = !fileUrl && !(input.files && input.files.length);
                }
            });

            // Trigger change untuk skema jika ada nilai awal
            const skemaSelect = document.getElementById('skemaSelect');
            if (skemaSelect && skemaSelect.value) skemaSelect.dispatchEvent(new Event('change'));
        });
    </script>
@endsection
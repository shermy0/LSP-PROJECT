@extends('master')

@section('title', 'FR.APL.02 - Verifikasi Asesmen Mandiri')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('asesor.asesmen_mandiri.verifikasi.store', $asesi->id_asesi) }}" method="POST"
                    id="verifikasiForm" novalidate>
                    @csrf

                    <!-- Header dengan ikon dan judul (warna #0b2f7c) -->
                    <div class="text-center mb-5">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                            </svg>
                        </div>
                        <h1 class="display-6 fw-bold text-dark">Verifikasi Asesmen Mandiri</h1>
                        <p class="text-secondary">Form Asesmen FR.APL.02 – Penilaian asesor</p>
                    </div>

                    <!-- Data Asesi - Card Modern -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pt-4 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-badge text-primary" viewBox="0 0 16 16">
                                        <path d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                        <path d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Data Pribadi Asesi</h5>
                                    <p class="text-secondary mb-0 small">Informasi identitas peserta</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <tr>
                                        <td width="30%" class="fw-semibold text-secondary">Nama Lengkap Peserta</td>
                                        <td class="text-dark">{{ $asesi->nama_lengkap ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-secondary">Nomor Peserta</td>
                                        <td class="text-dark">{{ $asesi->no_peserta ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold text-secondary">Skema Sertifikasi</td>
                                        <td class="text-dark">{{ $permohonan->skema ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Unit Kompetensi -->
                    @foreach($units as $unit)
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white border-0 pt-4 pb-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-grid-3x3-gap-fill text-primary" viewBox="0 0 16 16">
                                            <path d="M1 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V2zM1 7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1V7zM1 12a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-2zm5 0a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1h-2a1 1 0 0 1-1-1v-2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h5 class="fw-bold mb-0">Unit Kompetensi {{ $loop->iteration }}</h5>
                                        <p class="text-secondary mb-0 small">Kode Unit: {{ $unit->kode_unit }} | {{ $unit->judul_unit }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body pt-3">
                                @php $elemenUnit = $elemen->where('id_unit', $unit->id_unit); @endphp
                                @foreach($elemenUnit as $e)
                                    <div class="elemen-card mb-3">
                                        <div class="elemen-header">
                                            <span class="elemen-number">{{ $loop->iteration }}</span>
                                            <span class="fw-semibold">{{ $e->nama_elemen ?? '-' }}</span>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-hover align-middle mb-0">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th style="width:5%">No</th>
                                                        <th style="width:55%">Elemen</th>
                                                        <th style="width:10%" class="text-center">K</th>
                                                        <th style="width:10%" class="text-center">BK</th>
                                                        <th style="width:20%" class="text-center">Bukti</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $kukElemen = $kuk->where('id_elemen', $e->id_elemen); @endphp
                                                    @foreach($kukElemen as $k)
                                                        @php $j = $jawaban[$k->id_kuk] ?? null; @endphp
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $k->deskripsi_kuk }}</td>
                                                            <td class="text-center">
                                                                @if($j && $j->status === 'K')
                                                                    <span class="badge bg-success rounded-pill px-3 py-2">✔</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if($j && $j->status === 'BK')
                                                                    <span class="badge bg-danger rounded-pill px-3 py-2">✘</span>
                                                                @endif
                                                            </td>
                                                            <td class="text-center">
                                                                @if($j && $j->dokumen)
                                                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3"
                                                                        data-bs-toggle="modal" data-bs-target="#dokumenModal"
                                                                        data-src="{{ asset('storage/' . $j->dokumen->file_path) }}">
                                                                        <i class="bi bi-eye me-1"></i>Lihat
                                                                    </button>
                                                                @else
                                                                    <span class="text-muted small">Tidak ada bukti</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach

                    <!-- Rekomendasi Asesor -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pt-4 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-chat-text text-primary" viewBox="0 0 16 16">
                                        <path d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Rekomendasi Asesor</h5>
                                    <p class="text-secondary mb-0 small">Pilih rekomendasi untuk asesi</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rekomendasi" value="Dapat Dilanjutkan" id="rekomendasiYa" required>
                                    <label class="form-check-label fw-medium" for="rekomendasiYa">
                                        Asesi dapat melanjutkan ke asesmen berikutnya
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="rekomendasi" value="Tidak Dapat Dilanjutkan" id="rekomendasiTidak" required>
                                    <label class="form-check-label fw-medium" for="rekomendasiTidak">
                                        Asesi tidak dapat melanjutkan ke asesmen berikutnya
                                    </label>
                                </div>
                            </div>
                            <div class="invalid-feedback d-block text-danger" id="rekomendasiError" style="display:none;">
                                Harap pilih salah satu rekomendasi.
                            </div>
                        </div>
                    </div>

                    <!-- Catatan Asesor -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pt-4 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pencil-square text-primary" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Catatan Asesor</h5>
                                    <p class="text-secondary mb-0 small">(Opsional) Isi catatan jika diperlukan</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Tulis catatan di sini..."></textarea>
                        </div>
                    </div>

                    <!-- Tanda Tangan -->
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 pt-4 pb-0">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pen text-primary" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-0">Tanda Tangan</h5>
                                    <p class="text-secondary mb-0 small">Konfirmasi akhir dengan tanda tangan</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row g-4">
                                <!-- Asesi -->
                                <div class="col-md-6">
                                    <div class="bg-light p-4 rounded-4 h-100 d-flex flex-column">
                                        <p class="mb-3 fw-semibold fs-5 text-primary"><i class="bi bi-person-circle me-2"></i>Asesi</p>
                                        <p><strong>Nama:</strong> {{ $asesi->nama_lengkap ?? '-' }}</p>
                                        <p><strong>Tanggal:</strong> {{ $persetujuan->tgl_ttd_asesi ?? '-' }}</p>
                                        @if(!empty($persetujuan->ttd_asesi))
                                            <div class="mt-2 text-center border rounded-3 p-3 bg-white">
                                                <img src="{{ asset('storage/' . $persetujuan->ttd_asesi) }}" alt="TTD Asesi"
                                                     class="img-fluid" style="max-height:150px; object-fit:contain;">
                                            </div>
                                        @else
                                            <div class="text-muted fst-italic border rounded-3 p-4 text-center bg-white">
                                                Belum ada tanda tangan asesi
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Asesor -->
                                <div class="col-md-6">
                                    <div class="bg-light p-4 rounded-4 h-100 d-flex flex-column">
                                        <p class="mb-3 fw-semibold fs-5 text-primary"><i class="bi bi-shield-lock me-2"></i>Asesor</p>
                                        <p><strong>Nama:</strong> {{ Auth::user()->name ?? '-' }}</p>
                                        <p><strong>Tanggal:</strong> {{ date('Y-m-d') }}</p>
                                        <div class="mb-3 grow d-flex flex-column">
                                            <label class="form-label fw-medium">Tanda Tangan <span class="text-danger">*</span></label>
                                            <div class="canvas-wrapper">
                                                <canvas id="ttd-asesor" class="ttd-canvas" width="400" height="160"></canvas>
                                                <span class="canvas-placeholder">Tanda tangan di sini</span>
                                            </div>
                                            <input type="hidden" name="ttd_asesor" id="ttd-asesor-input" required>
                                            <div class="invalid-feedback text-danger" id="ttdError" style="display:none;">
                                                Harap tanda tangani terlebih dahulu.
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end gap-2 mt-2">
                                            <button type="button" class="btn btn-outline-danger rounded-pill px-4" onclick="clearCanvas('ttd-asesor')">
                                                <i class="bi bi-eraser me-1"></i>Hapus
                                            </button>
                                            <button type="button" class="btn btn-outline-success rounded-pill px-4" onclick="downloadTTD()">
                                                <i class="bi bi-download me-1"></i>Unduh
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="button-group mt-4">
                        <a href="{{ route('asesor.asesmen_mandiri.index') }}" class="btn-back">
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
        </div>
    </div>

    <!-- Modal Preview Dokumen -->
    <div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-light border-0">
                    <h5 class="modal-title fw-bold">Preview Dokumen</h5>
                    <div class="d-flex gap-2">
                        <a id="downloadLink" href="#" target="_blank" class="btn btn-sm btn-success rounded-pill px-3">
                            <i class="bi bi-download me-1"></i>Unduh
                        </a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                </div>
                <div class="modal-body text-center p-4" id="dokumenPreview">
                    <p class="text-muted">Memuat preview...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Peringatan Tanda Tangan -->
    <div class="modal fade" id="ttdAlertModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Tanda Tangan Diperlukan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="fs-6">Silakan isi tanda tangan asesor terlebih dahulu sebelum menyimpan keputusan.</p>
                </div>
                <div class="modal-footer justify-content-center border-0">
                    <button type="button" class="btn btn-primary px-5 rounded-pill" data-bs-dismiss="modal">Mengerti</button>
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

        /* ===== ELEMEN CARD ===== */
        .elemen-card {
            background: #ffffff;
            border: 1px solid #e9edf4;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .elemen-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1rem;
            background: #f8fbff;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border-left: 4px solid var(--primary);
        }

        .elemen-number {
            width: 28px;
            height: 28px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.9rem;
        }

        /* ===== TABLE ===== */
        .table {
            border-radius: 1rem;
            overflow: hidden;
        }

        .table thead th {
            background: #f0f5ff;
            color: var(--primary);
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            border-bottom: 2px solid #d0d9e8;
            padding: 0.75rem;
        }

        .table tbody td {
            padding: 0.75rem;
            vertical-align: middle;
            background: white;
            border-bottom: 1px solid #e9edf4;
        }

        .table-hover tbody tr:hover td {
            background: #f8fbff;
        }

        /* ===== FORM ELEMENTS ===== */
        .form-label {
            font-weight: 600;
            font-size: 0.9rem;
            color: #1e293b;
            margin-bottom: 0.3rem;
        }

        .form-control {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background-color: #fff;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
            outline: none;
        }

        .form-check-input:checked {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .form-check-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
        }

        /* ===== CANVAS ===== */
        .canvas-wrapper {
            position: relative;
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

        /* ===== BUTTONS ===== */
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

        .btn-outline-danger, .btn-outline-success, .btn-outline-primary {
            border-width: 1.5px;
            border-radius: 2rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-outline-danger:hover {
            background-color: var(--danger);
            color: white;
        }

        .btn-outline-success:hover {
            background-color: var(--success);
            color: white;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .button-group {
                justify-content: center;
            }
            .elemen-header {
                flex-wrap: wrap;
            }
            .canvas-placeholder {
                font-size: 0.8rem;
                padding: 2px 8px;
            }
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Preview dokumen
            var modal = document.getElementById('dokumenModal');
            var preview = document.getElementById('dokumenPreview');
            var downloadLink = document.getElementById('downloadLink');

            modal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var src = button.getAttribute('data-src');
                var ext = src.split('.').pop().toLowerCase();
                downloadLink.href = src;
                preview.innerHTML = "<p class='text-muted'>Memuat preview...</p>";

                if (["jpg", "jpeg", "png", "gif", "bmp", "webp"].includes(ext)) {
                    preview.innerHTML = `<img src="${src}" class="img-fluid rounded shadow" style="max-height:80vh;">`;
                } else if (ext === "pdf") {
                    preview.innerHTML = `<iframe src="${src}" frameborder="0" style="width:100%; height:80vh;"></iframe>`;
                } else {
                    preview.innerHTML = `<p class="text-muted">Preview tidak tersedia. Silakan unduh dokumen.</p>`;
                }
            });

            modal.addEventListener('hidden.bs.modal', function () {
                preview.innerHTML = "";
                downloadLink.href = "#";
            });

            // Signature Pad
            const canvas = document.getElementById('ttd-asesor');
            if (canvas) {
                const ctx = canvas.getContext('2d');
                let drawing = false;
                let blankDataURL = null;

                function resizeCanvas() {
                    const container = canvas.parentElement;
                    const cssWidth = container.clientWidth;
                    const cssHeight = 160;
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);

                    canvas.width = Math.round(cssWidth * ratio);
                    canvas.height = Math.round(cssHeight * ratio);

                    ctx.setTransform(1,0,0,1,0,0);
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
                canvas.addEventListener('mouseup', stopDrawing);
                canvas.addEventListener('mouseleave', stopDrawing);

                canvas.addEventListener('touchstart', startDrawing, { passive: false });
                canvas.addEventListener('touchmove', drawMove, { passive: false });
                canvas.addEventListener('touchend', stopDrawing);

                window.addEventListener('resize', resizeCanvas);
                resizeCanvas();

                window.clearCanvas = function (canvasId) {
                    const canvas = document.getElementById(canvasId);
                    const ctx = canvas.getContext('2d');
                    const container = canvas.parentElement;
                    const cssWidth = container.clientWidth;
                    const cssHeight = 160;
                    const ratio = Math.max(window.devicePixelRatio || 1, 1);

                    canvas.width = Math.round(cssWidth * ratio);
                    canvas.height = Math.round(cssHeight * ratio);

                    ctx.setTransform(1,0,0,1,0,0);
                    ctx.scale(ratio, ratio);

                    ctx.fillStyle = "#ffffff";
                    ctx.fillRect(0, 0, cssWidth, cssHeight);

                    blankDataURL = canvas.toDataURL();
                    document.getElementById('ttd-asesor-input').value = '';
                };

                window.downloadTTD = function () {
                    const link = document.createElement('a');
                    link.download = "tanda_tangan_asesor.png";
                    link.href = canvas.toDataURL("image/png");
                    link.click();
                };
            }

            function isCanvasBlank(canvas) {
                const ctx = canvas.getContext('2d');
                const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
                for (let i = 0; i < pixelData.length; i += 4) {
                    if (pixelData[i] < 255 || pixelData[i+1] < 255 || pixelData[i+2] < 255) {
                        return false;
                    }
                }
                return true;
            }

            // Validasi form
            const ttdAlertModal = new bootstrap.Modal(document.getElementById('ttdAlertModal'));

            document.getElementById('verifikasiForm').addEventListener('submit', function (e) {
                // Simpan TTD ke hidden input
                const canvas = document.getElementById('ttd-asesor');
                if (!isCanvasBlank(canvas)) {
                    document.getElementById('ttd-asesor-input').value = canvas.toDataURL('image/png');
                }

                let valid = true;
                let firstInvalid = null;

                // Cek rekomendasi
                const rekomendasi = document.querySelector('input[name="rekomendasi"]:checked');
                if (!rekomendasi) {
                    document.getElementById('rekomendasiError').style.display = 'block';
                    if (!firstInvalid) firstInvalid = document.querySelector('.card:has(input[name="rekomendasi"])');
                    valid = false;
                } else {
                    document.getElementById('rekomendasiError').style.display = 'none';
                }

                // Cek tanda tangan
                if (isCanvasBlank(canvas)) {
                    // Tampilkan modal peringatan
                    ttdAlertModal.show();
                    e.preventDefault();
                    return false;
                } else {
                    document.getElementById('ttdError').style.display = 'none';
                }

                if (!valid) {
                    e.preventDefault();
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    </script>
@endsection

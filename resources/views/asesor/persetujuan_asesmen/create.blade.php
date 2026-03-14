@extends('master')

@section('title', 'FR.AK.01 - Buat Persetujuan Asesmen')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <!-- Header dengan ikon lingkaran gradient -->
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-shield-check" viewBox="0 0 16 16">
                    <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.53.23-.786.299a1.677 1.677 0 0 1-.995 0 5.26 5.26 0 0 1-.786-.299 7.16 7.16 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z"/>
                    <path d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                </svg>
            </div>
            <h1 class="display-6 fw-bold text-dark">Persetujuan Asesmen dan Kerahasiaan</h1>
            <p class="text-secondary">FR.AK.01 – Buat Persetujuan Asesmen</p>
        </div>

        <form action="{{ route('asesor.persetujuan_asesmen.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <input type="hidden" name="id_permohonan" value="{{ $permohonan->id_permohonan }}">

            <!-- Card Informasi Skema, Tipe TUK, Asesor, Asesi -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-text text-primary" viewBox="0 0 16 16">
                                <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Informasi Skema</h5>
                            <p class="text-secondary mb-0 small">Skema sertifikasi yang diajukan</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Skema Sertifikasi (KKNI/Okupasi/Klaster)</label>
                            <input type="text" class="form-control" value="{{ $permohonan->skema->nama_skema }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" value="{{ $permohonan->skema->judul_skema ?? $permohonan->skema->nama_skema }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nomor</label>
                            <input type="text" class="form-control" value="{{ $permohonan->skema->kode_skema }}" readonly>
                        </div>
                    </div>

                    <!-- Nama Asesor dan Asesi -->
                    <div class="row g-3 mt-2">
                        <div class="col-md-6">
                            <label class="form-label">Nama Asesor</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Asesi</label>
                            <input type="text" class="form-control" value="{{ $permohonan->asesi->nama_lengkap }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Bukti yang akan dikumpulkan (sesuai dokumen) -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white border-0 pt-4 pb-0">
        <div class="d-flex align-items-center">
            <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-check text-primary" viewBox="0 0 16 16">
                    <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                </svg>
            </div>
            <div>
                <h5 class="fw-bold mb-0">Bukti yang akan dikumpulkan</h5>
                <p class="text-secondary mb-0 small">Pilih bukti yang akan digunakan</p>
            </div>
        </div>
    </div>
    <div class="card-body pt-3">
        <div class="row">
            <!-- Kolom Kiri -->
            <div class="col-md-6">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Hasil Verifikasi Portofolio" id="bukti_verifikasi" {{ in_array('Hasil Verifikasi Portofolio', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_verifikasi">Hasil Verifikasi Portofolio</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Hasil Observasi Langsung" id="bukti_observasi" {{ in_array('Hasil Observasi Langsung', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_observasi">Hasil Observasi Langsung</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Hasil Pertanyaan Lisan" id="bukti_lisan" {{ in_array('Hasil Pertanyaan Lisan', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_lisan">Hasil Pertanyaan Lisan</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Hasil Reviu Produk" id="bukti_reviu" {{ in_array('Hasil Reviu Produk', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_reviu">Hasil Reviu Produk</label>
                </div>
            </div>
            <!-- Kolom Kanan -->
            <div class="col-md-6">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Hasil Kegiatan Terstruktur" id="bukti_kegiatan" {{ in_array('Hasil Kegiatan Terstruktur', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_kegiatan">Hasil Kegiatan Terstruktur</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Hasil Pertanyaan Tertulis" id="bukti_tertulis" {{ in_array('Hasil Pertanyaan Tertulis', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_tertulis">Hasil Pertanyaan Tertulis</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Hasil Pertanyaan Wawancara" id="bukti_wawancara" {{ in_array('Hasil Pertanyaan Wawancara', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_wawancara">Hasil Pertanyaan Wawancara</label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="bukti[]" value="Lainnya" id="bukti_lainnya" {{ in_array('Lainnya', old('bukti', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="bukti_lainnya">Lainnya</label>
                    <input type="text" name="bukti_lainnya" class="form-control form-control-sm mt-1 @error('bukti_lainnya') is-invalid @enderror" value="{{ old('bukti_lainnya') }}" placeholder="Pisahkan dengan koma jika lebih dari satu" style="{{ in_array('Lainnya', old('bukti', [])) ? 'display:block;' : 'display:none;' }}">
                    @error('bukti_lainnya')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        @error('bukti')
            <div class="text-danger small mt-2">{{ $message }}</div>
        @enderror
    </div>
</div>

            <!-- Card Pelaksanaan Asesmen -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calendar-check text-primary" viewBox="0 0 16 16">
                                <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Pelaksanaan asesmen disepakati pada:</h5>
                            <p class="text-secondary mb-0 small">Tanggal, waktu, TUK, dan lokasi ruangan</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Hari / Tanggal</label>
                            <input type="date" name="tgl_pelaksanaan" class="form-control @error('tgl_pelaksanaan') is-invalid @enderror" value="{{ old('tgl_pelaksanaan') }}" required>
                            @error('tgl_pelaksanaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Waktu</label>
                            <input type="time" name="waktu" class="form-control @error('waktu') is-invalid @enderror" value="{{ old('waktu') }}" required>
                            @error('waktu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">TUK</label>
                            <select name="id_tuk" id="id_tuk" class="form-select @error('id_tuk') is-invalid @enderror" required>
                                <option value="">-- Pilih TUK --</option>
                                @foreach($tukList as $tuk)
                                    <option value="{{ $tuk->id_tuk }}" {{ old('id_tuk') == $tuk->id_tuk ? 'selected' : '' }}>
                                        {{ $tuk->nama_tuk }}
                                    </option>
                                @endforeach
                                <option value="lainnya" {{ old('id_tuk') == 'lainnya' ? 'selected' : '' }}>Lainnya...</option>
                            </select>
                            @error('id_tuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Lokasi (Ruang)</label>
                            <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" value="{{ old('lokasi') }}" placeholder="Contoh: Ruang 101 / Lab Komputer" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Field tambahan untuk TUK baru -->
                    <div id="tukBaruFields" style="display: none; margin-top: 1rem;">
                        <hr>
                        <h6 class="fw-semibold">Tambah TUK Baru</h6>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Nama TUK <span class="text-danger">*</span></label>
                                <input type="text" name="tuk_baru_nama" class="form-control @error('tuk_baru_nama') is-invalid @enderror" value="{{ old('tuk_baru_nama') }}" placeholder="Nama TUK">
                                @error('tuk_baru_nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis TUK <span class="text-danger">*</span></label>
                                <select name="tuk_baru_jenis" class="form-select @error('tuk_baru_jenis') is-invalid @enderror">
                                    <option value="">-- Pilih Jenis --</option>
                                    <option value="Mandiri" {{ old('tuk_baru_jenis') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                                    <option value="Perusahaan" {{ old('tuk_baru_jenis') == 'Perusahaan' ? 'selected' : '' }}>Perusahaan</option>
                                    <option value="Sekolah" {{ old('tuk_baru_jenis') == 'Sekolah' ? 'selected' : '' }}>Sekolah</option>
                                </select>
                                @error('tuk_baru_jenis')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Alamat TUK <span class="text-danger">*</span></label>
                                <textarea name="tuk_baru_alamat" class="form-control @error('tuk_baru_alamat') is-invalid @enderror" rows="2" placeholder="Alamat lengkap">{{ old('tuk_baru_alamat') }}</textarea>
                                @error('tuk_baru_alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Pernyataan -->
            <div class="card border-0 shadow-sm bg-light mb-4">
                <div class="card-body">
                    <p class="fw-semibold">Asesi :</p>
                    <p class="mb-3">Bahwa saya telah mendapatkan penjelasan terkait hak dan prosedur banding asesmen dari asesor.</p>
                    <p class="fw-semibold">Asesor :</p>
                    <p class="mb-3">Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya sebagai Asesor dalam pekerjaan Asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai Asesor yang ditugaskan oleh LSP.</p>
                    <p class="fw-semibold">Asesi :</p>
                    <p>Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</p>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="button-group mt-4">
                <a href="{{ route('asesor.persetujuan_asesmen.index') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali
                </a>
                <button type="submit" class="btn-next">
                    Simpan Draf
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save ms-2" viewBox="0 0 16 16">
                        <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2V2h2v12H2V2h2v4.5h2V2a1 1 0 0 0-1-1H2z"/>
                    </svg>
                </button>
            </div>
        </form>
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

        /* Tombol Next (gradient) */
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

        .btn-next:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
            background: linear-gradient(135deg, #6c757d, #495057);
            box-shadow: none;
        }

        /* Tombol Back (outline) */
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

        /* Responsive */
        @media (max-width: 768px) {
            .button-group {
                justify-content: center;
            }
            .card-body .row > [class*="col-"] {
                margin-bottom: 0.25rem;
            }
        }
    </style>

    <!-- Script untuk toggle TUK baru dan toggle input Lainnya -->
    <script>
        (function() {
            'use strict';

            // Toggle field TUK baru
            const idTukSelect = document.getElementById('id_tuk');
            const tukBaruFields = document.getElementById('tukBaruFields');

            function toggleTukBaru() {
                if (idTukSelect.value === 'lainnya') {
                    tukBaruFields.style.display = 'block';
                    document.querySelectorAll('#tukBaruFields input, #tukBaruFields select').forEach(field => {
                        field.setAttribute('required', 'required');
                    });
                } else {
                    tukBaruFields.style.display = 'none';
                    document.querySelectorAll('#tukBaruFields input, #tukBaruFields select').forEach(field => {
                        field.removeAttribute('required');
                    });
                }
            }

            idTukSelect.addEventListener('change', toggleTukBaru);
            toggleTukBaru();

            // Toggle input teks untuk "Lainnya" pada bukti
            const lainnyaCheckbox = document.getElementById('bukti_lainnya');
            const lainnyaText = document.querySelector('input[name="bukti_lainnya"]');

            function toggleLainnyaText() {
                if (lainnyaCheckbox.checked) {
                    lainnyaText.style.display = 'block';
                    lainnyaText.setAttribute('required', 'required');
                } else {
                    lainnyaText.style.display = 'none';
                    lainnyaText.removeAttribute('required');
                }
            }

            if (lainnyaCheckbox) {
                lainnyaCheckbox.addEventListener('change', toggleLainnyaText);
                toggleLainnyaText(); // inisialisasi
            }

            // Bootstrap-like validation
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
@endsection
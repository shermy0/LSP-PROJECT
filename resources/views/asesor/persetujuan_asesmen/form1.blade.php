@extends('master')

@section('title', 'FR.AK.01 - Persetujuan Asesmen dan Kerahasiaan')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <form action="{{ route('asesor.persetujuan_asesmen.store') }}" method="POST" enctype="multipart/form-data"
            class="needs-validation" novalidate>
            @csrf

            <!-- Header -->
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3"
                    style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                        class="bi bi-shield-check" viewBox="0 0 16 16">
                        <path
                            d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.53.23-.786.299a1.677 1.677 0 0 1-.995 0 5.26 5.26 0 0 1-.786-.299 7.16 7.16 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                        <path
                            d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                    </svg>
                </div>
                <h1 class="display-6 fw-bold text-dark">Persetujuan Asesmen dan Kerahasiaan</h1>
                <p class="text-secondary">FR.AK.01 – Menjamin bahwa Asesi telah diberi arahan rinci tentang perencanaan dan
                    proses asesmen</p>
            </div>

            <!-- Informasi Skema dan Asesi -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-info-circle text-primary" viewBox="0 0 16 16">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path
                                    d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Informasi Sertifikasi</h5>
                            <p class="text-secondary mb-0 small">Data skema, TUK, asesor, dan asesi</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Skema Sertifikasi (KKNI/Okupasi/Klaster)</label>
                            <input type="text" class="form-control" name="skema"
                                value="{{ old('skema', $skema->nama_skema ?? 'JUNIOR OPERATOR DESAIN GRAFIS') }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Judul</label>
                            <input type="text" class="form-control" name="judul"
                                value="{{ old('judul', $skema->judul_skema ?? 'JUNIOR OPERATOR DESAIN GRAFIS') }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nomor</label>
                            <input type="text" class="form-control" name="nomor_skema"
                                value="{{ old('nomor_skema', $skema->kode_skema ?? '') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">TUK</label>
                            <select name="tuk" class="form-select" required>
                                <option value="">Pilih TUK</option>
                                <option value="Sewaktu" {{ old('tuk') == 'Sewaktu' ? 'selected' : '' }}>Sewaktu</option>
                                <option value="Tempat Kerja" {{ old('tuk') == 'Tempat Kerja' ? 'selected' : '' }}>Tempat Kerja
                                </option>
                                <option value="Mandiri" {{ old('tuk') == 'Mandiri' ? 'selected' : '' }}>Mandiri</option>
                            </select>
                            <div class="invalid-feedback">Pilih TUK.</div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nama Asesor</label>
                            <input type="text" class="form-control" name="nama_asesor"
                                value="{{ old('nama_asesor', Auth::user()->name ?? '') }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Nama Asesi</label>
                            <input type="text" class="form-control" name="nama_asesi"
                                value="{{ old('nama_asesi', $asesi->nama_lengkap ?? '') }}" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metode Asesmen -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-check2-square text-primary" viewBox="0 0 16 16">
                                <path
                                    d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
                                <path
                                    d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Metode Asesmen</h5>
                            <p class="text-secondary mb-0 small">Pilih metode yang digunakan</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]"
                                    value="Hasil Verifikasi Portofolio" id="metode1" {{ in_array('Hasil Verifikasi Portofolio', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode1">Hasil Verifikasi Portofolio</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]" value="Hasil Reviu Produk"
                                    id="metode2" {{ in_array('Hasil Reviu Produk', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode2">Hasil Reviu Produk</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]"
                                    value="Hasil Observasi Langsung" id="metode3" {{ in_array('Hasil Observasi Langsung', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode3">Hasil Observasi Langsung</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]"
                                    value="Hasil Kegiatan Terstruktur" id="metode4" {{ in_array('Hasil Kegiatan Terstruktur', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode4">Hasil Kegiatan Terstruktur</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]"
                                    value="Hasil Pertanyaan Lisan" id="metode5" {{ in_array('Hasil Pertanyaan Lisan', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode5">Hasil Pertanyaan Lisan</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]"
                                    value="Hasil Pertanyaan Tertulis" id="metode6" {{ in_array('Hasil Pertanyaan Tertulis', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode6">Hasil Pertanyaan Tertulis</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]"
                                    value="Hasil Pertanyaan Wawancara" id="metode7" {{ in_array('Hasil Pertanyaan Wawancara', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode7">Hasil Pertanyaan Wawancara</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="metode[]" value="Lainnya" id="metode8"
                                    {{ in_array('Lainnya', old('metode', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="metode8">Lainnya</label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Jika memilih Lainnya, sebutkan:</label>
                        <input type="text" class="form-control" name="metode_lainnya" value="{{ old('metode_lainnya') }}"
                            placeholder="Misal: Demonstrasi, Simulasi, dll.">
                    </div>
                </div>
            </div>

            <!-- Bukti yang Akan Dikumpulkan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-files text-primary" viewBox="0 0 16 16">
                                <path
                                    d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Bukti yang Akan Dikumpulkan</h5>
                            <p class="text-secondary mb-0 small">Jelaskan bukti-bukti yang akan disertakan</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <textarea name="bukti" class="form-control" rows="3"
                        placeholder="Contoh: Portofolio, Produk, Laporan Observasi, dll.">{{ old('bukti') }}</textarea>
                </div>
            </div>

            <!-- Jadwal Pelaksanaan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-calendar-event text-primary" viewBox="0 0 16 16">
                                <path
                                    d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Jadwal Pelaksanaan Asesmen</h5>
                            <p class="text-secondary mb-0 small">Sepakati waktu dan tempat</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Hari / Tanggal</label>
                            <input type="date" name="tanggal" class="form-control"
                                value="{{ old('tanggal', date('Y-m-d')) }}" required>
                            <div class="invalid-feedback">Tanggal harus diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Waktu</label>
                            <input type="time" name="waktu" class="form-control" value="{{ old('waktu', '09:00') }}"
                                required>
                            <div class="invalid-feedback">Waktu harus diisi.</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">TUK (Tempat Uji Kompetensi)</label>
                            <input type="text" name="tempat_tuk" class="form-control"
                                value="{{ old('tempat_tuk', $tuk->nama_tuk ?? '') }}" required>
                            <div class="invalid-feedback">TUK harus diisi.</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pernyataan Asesi dan Asesor -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-chat-quote text-primary" viewBox="0 0 16 16">
                                <path
                                    d="M2.678 11.894a1 1 0 0 1 .287.801 10.97 10.97 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8.06 8.06 0 0 0 8 14c3.996 0 7-2.807 7-6 0-3.192-3.004-6-7-6S1 4.808 1 8c0 1.468.617 2.83 1.678 3.894zm-.493 3.905a21.682 21.682 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a9.68 9.68 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9.06 9.06 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105z" />
                                <path
                                    d="M7.066 6.76A1.665 1.665 0 0 0 8 5a1 1 0 0 0-1-1 .665.665 0 0 0-.668.575 1.5 1.5 0 0 0 0 .043 2.986 2.986 0 0 0 .163 1.527c.16.36.444.679.805.679.458 0 .806-.313.96-.68a.807.807 0 0 0 .04-.2.5.5 0 0 0-.5-.5.5.5 0 0 0-.5.5.5.5 0 0 0 .5.5h.034c.016 0 .032-.002.048-.006.111-.028.213-.072.305-.128.125-.076.233-.186.233-.366 0-.146-.066-.273-.175-.36a.5.5 0 0 0-.12-.074.5.5 0 0 0-.176-.033.5.5 0 0 0-.176.033.5.5 0 0 0-.12.074c-.11.087-.176.214-.176.36 0 .18.108.29.233.366.092.056.194.1.305.128.016.004.032.006.048.006h.034a.5.5 0 0 0 .5-.5.5.5 0 0 0-.5-.5.5.5 0 0 0-.5.5c0 .09.017.177.05.257.12.32.398.526.68.526.46 0 .806-.313.96-.68a.807.807 0 0 0 .04-.2 2.986 2.986 0 0 0-.163-1.527c-.16-.36-.444-.679-.805-.679-.458 0-.806.313-.96.68a.807.807 0 0 0-.04.2.5.5 0 0 0 .5.5.5.5 0 0 0 .5-.5.5.5 0 0 0-.5-.5.5.5 0 0 0-.5.5.5.5 0 0 0 .5.5.5.5 0 0 0 .5-.5z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Pernyataan</h5>
                            <p class="text-secondary mb-0 small">Bacalah pernyataan berikut dengan seksama</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="bg-light p-4 rounded-3 mb-3">
                        <p class="fw-semibold">Asesi :</p>
                        <p>Bahwa saya telah mendapatkan penjelasan terkait hak dan prosedur banding asesmen dari asesor.</p>
                    </div>
                    <div class="bg-light p-4 rounded-3 mb-3">
                        <p class="fw-semibold">Asesor :</p>
                        <p>Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya sebagai
                            Asesor dalam pekerjaan Asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang
                            berwenang sehubungan dengan kewajiban saya sebagai Asesor yang ditugaskan oleh LSP.</p>
                    </div>
                    <div class="bg-light p-4 rounded-3">
                        <p class="fw-semibold">Asesi :</p>
                        <p>Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan
                            untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</p>
                    </div>
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-pen text-primary" viewBox="0 0 16 16">
                                <path
                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z" />
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Tanda Tangan</h5>
                            <p class="text-secondary mb-0 small">Asesor dan Asesi</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-4">
                        <!-- Asesor -->
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded-4 h-100 d-flex flex-column">
                                <p class="mb-3 fw-semibold fs-5 text-primary"><i class="bi bi-shield-lock me-2"></i>Asesor
                                </p>
                                <p><strong>Nama:</strong> {{ Auth::user()->name ?? '-' }}</p>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tgl_ttd_asesor" class="form-control"
                                        value="{{ old('tgl_ttd_asesor', date('Y-m-d')) }}" required>
                                    <div class="invalid-feedback">Tanggal asesor harus diisi.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanda Tangan <span class="text-danger">*</span></label>
                                    <div class="canvas-wrapper">
                                        <canvas id="ttd-asesor" class="ttd-canvas" width="400" height="160"></canvas>
                                        <span class="canvas-placeholder">Tanda tangan di sini</span>
                                    </div>
                                    <input type="hidden" name="ttd_asesor" id="ttd_asesor_data" required>
                                    <div class="invalid-feedback">Tanda tangan asesor wajib diisi.</div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-2">
                                    <button type="button" class="btn btn-outline-danger rounded-pill px-4"
                                        onclick="clearCanvas('ttd-asesor')">
                                        <i class="bi bi-eraser me-1"></i>Hapus
                                    </button>
                                    <button type="button" class="btn btn-outline-success rounded-pill px-4"
                                        onclick="downloadTTD('ttd-asesor')">
                                        <i class="bi bi-download me-1"></i>Unduh
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Asesi -->
                        <div class="col-md-6">
                            <div class="bg-light p-4 rounded-4 h-100 d-flex flex-column">
                                <p class="mb-3 fw-semibold fs-5 text-primary"><i class="bi bi-person-circle me-2"></i>Asesi
                                </p>
                                <p><strong>Nama:</strong> {{ $asesi->nama_lengkap ?? '-' }}</p>
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" name="tgl_ttd_asesi" class="form-control"
                                        value="{{ old('tgl_ttd_asesi', date('Y-m-d')) }}" required>
                                    <div class="invalid-feedback">Tanggal asesi harus diisi.</div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tanda Tangan <span class="text-danger">*</span></label>
                                    <div class="canvas-wrapper">
                                        <canvas id="ttd-asesi" class="ttd-canvas" width="400" height="160"></canvas>
                                        <span class="canvas-placeholder">Tanda tangan di sini</span>
                                    </div>
                                    <input type="hidden" name="ttd_asesi" id="ttd_asesi_data" required>
                                    <div class="invalid-feedback">Tanda tangan asesi wajib diisi.</div>
                                </div>
                                <div class="d-flex justify-content-end gap-2 mt-2">
                                    <button type="button" class="btn btn-outline-danger rounded-pill px-4"
                                        onclick="clearCanvas('ttd-asesi')">
                                        <i class="bi bi-eraser me-1"></i>Hapus
                                    </button>
                                    <button type="button" class="btn btn-outline-success rounded-pill px-4"
                                        onclick="downloadTTD('ttd-asesi')">
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
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z" />
                    </svg>
                    Kembali
                </a>
                <button type="submit" class="btn-next">
                    Simpan dan Kirim
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-send ms-2" viewBox="0 0 16 16">
                        <path
                            d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Modal Preview (opsional, bisa ditambahkan jika diperlukan) -->
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

    <!-- Modal Peringatan Tanda Tangan -->
    <div class="modal fade" id="ttdRequiredModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-danger">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">Tanda Tangan Diperlukan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-0">Silakan tanda tangan pada area tanda tangan sebelum melanjutkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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

        .card {
            border-radius: 1.25rem;
            overflow: hidden;
            transition: all 0.2s ease;
            background: #ffffff;
        }

        .card:hover {
            box-shadow: 0 1rem 2rem rgba(0, 0, 0, 0.08) !important;
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

        .form-control,
        .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 0.6rem 1rem;
            font-size: 0.95rem;
            transition: border-color 0.15s ease, box-shadow 0.15s ease;
            background-color: #fff;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(11, 47, 124, 0.15);
            outline: none;
        }

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

        .form-control.is-invalid+.invalid-feedback,
        .form-select.is-invalid+.invalid-feedback {
            display: block;
        }

        .bg-primary {
            background-color: var(--primary) !important;
        }

        .bg-primary.bg-gradient {
            background: linear-gradient(145deg, var(--primary), var(--primary-dark)) !important;
        }

        .bg-primary.bg-opacity-10 {
            background-color: rgba(11, 47, 124, 0.1) !important;
        }

        .text-primary {
            color: var(--primary) !important;
        }

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
            box-shadow: 0 8px 18px rgba(11, 47, 124, 0.3);
            transition: all 0.2s;
        }

        .btn-next:hover {
            background: linear-gradient(135deg, var(--primary-dark), #061944);
            transform: translateY(-2px);
            box-shadow: 0 12px 22px rgba(11, 47, 124, 0.35);
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

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
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
            background: rgba(255, 255, 255, 0.7);
            padding: 4px 12px;
            border-radius: 40px;
            pointer-events: none;
            backdrop-filter: blur(2px);
        }

        .btn-outline-danger,
        .btn-outline-success {
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

        @media (max-width: 768px) {
            .button-group {
                justify-content: center;
            }
        }
    </style>

    <script>
        // Fungsi untuk inisialisasi canvas tanda tangan (sama seperti contoh)
        function initSignature(canvasId, hiddenId) {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;
            const ctx = canvas.getContext('2d');
            const placeholder = canvas.parentElement.querySelector('.canvas-placeholder');
            let drawing = false;
            let blankDataURL = null;
            const VISIBLE_HEIGHT = 160;

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
                placeholder.style.display = 'none';
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

            window.addEventListener('resize', function () {
                const prev = canvas.toDataURL();
                resizeCanvas();
                if (prev && prev !== blankDataURL) {
                    const img = new Image();
                    img.onload = function () {
                        ctx.drawImage(img, 0, 0, canvas.clientWidth, VISIBLE_HEIGHT);
                    };
                    img.src = prev;
                }
            });

            resizeCanvas();

            window.clearCanvas = function (id) {
                const canvas = document.getElementById(id);
                const ctx = canvas.getContext('2d');
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

                document.getElementById(hiddenId).value = '';
                placeholder.style.display = 'block';
            };

            window.downloadTTD = function (id) {
                const canvas = document.getElementById(id);
                const link = document.createElement('a');
                link.download = id + ".png";
                link.href = canvas.toDataURL("image/png");
                link.click();
            };
        }

        function isCanvasBlank(canvasId) {
            const canvas = document.getElementById(canvasId);
            const ctx = canvas.getContext('2d');
            const pixelData = ctx.getImageData(0, 0, canvas.width, canvas.height).data;
            for (let i = 0; i < pixelData.length; i += 4) {
                if (pixelData[i] !== 255 || pixelData[i + 1] !== 255 || pixelData[i + 2] !== 255) {
                    return false;
                }
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Inisialisasi canvas
            initSignature('ttd-asesor', 'ttd_asesor_data');
            initSignature('ttd-asesi', 'ttd_asesi_data');

            // Validasi form
            const form = document.getElementById('persetujuanForm');
            const ttdRequiredModal = new bootstrap.Modal(document.getElementById('ttdRequiredModal'));

            form.addEventListener('submit', function (event) {
                // Simpan tanda tangan ke hidden input
                const ttdAsesor = document.getElementById('ttd-asesor');
                const ttdAsesi = document.getElementById('ttd-asesi');

                if (!isCanvasBlank('ttd-asesor')) {
                    document.getElementById('ttd_asesor_data').value = ttdAsesor.toDataURL('image/png');
                }
                if (!isCanvasBlank('ttd-asesi')) {
                    document.getElementById('ttd_asesi_data').value = ttdAsesi.toDataURL('image/png');
                }

                let valid = true;
                let firstInvalid = null;

                // Cek tanda tangan asesor
                if (isCanvasBlank('ttd-asesor')) {
                    valid = false;
                    if (!firstInvalid) firstInvalid = document.querySelector('#ttd-asesor');
                    ttdRequiredModal.show();
                    event.preventDefault();
                    return false;
                }

                // Cek tanda tangan asesi
                if (isCanvasBlank('ttd-asesi')) {
                    valid = false;
                    if (!firstInvalid) firstInvalid = document.querySelector('#ttd-asesi');
                    ttdRequiredModal.show();
                    event.preventDefault();
                    return false;
                }

                // Cek validasi HTML5
                if (!form.checkValidity()) {
                    valid = false;
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                    const firstInvalidInput = form.querySelector(':invalid');
                    if (firstInvalidInput) {
                        firstInvalidInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                    return false;
                }

                if (!valid) {
                    event.preventDefault();
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }

                form.classList.add('was-validated');
            });
        });
    </script>
@endsection
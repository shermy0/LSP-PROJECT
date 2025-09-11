@extends('master')

@section('title', 'FR.APL.02 - Permohonan Sertifikasi Kompetensi')

@section('konten')
    <div class="container mt-2 my-5">
        <div class="bg-white border rounded-3 shadow-sm p-4">

            <!-- Header -->
            <div class="mb-4">
                <p class="small text-muted mb-1">Form Asesmen &gt; <span class="fw-semibold">FR.APL.02</span></p>
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="rounded mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                    <h1 class="h5 fw-bold">Permohonan Sertifikasi Kompetensi</h1>
                    <span class="badge bg-light text-dark mt-2 px-3 py-2 rounded-pill">
                        Rincian Data Pemohon Sertifikasi
                    </span>
                </div>
            </div>

            <!-- Data Sertifikasi -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Sertifikasi
                </div>

                <div class="mb-3">
                    <label class="form-label">Skema Sertifikasi</label>
                    <input type="text" class="form-control rounded-3" placeholder="Pilih Skema Sertifikasi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Sertifikasi</label>
                    <select class="form-select rounded-3">
                        <option selected disabled>Pilih Judul Sertifikasi</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Skema</label>
                    <input type="text" class="form-control rounded-3" placeholder="Menyesuaikan dengan Judul Sertifikasi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tujuan Asesmen</label>
                    <input type="text" class="form-control rounded-3">
                </div>
            </div>

            <!-- Daftar Unit Kompetensi -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Daftar Unit Kompetensi
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode Unit</th>
                                <th>Judul Unit</th>
                                <th>Standar Kompetensi Kerja</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>J.591MT00.010.01</td>
                                <td>Menterjemahkan Arah Visual ke Dalam Langkah Kerja</td>
                                <td rowspan="5" class="text-center">
                                    SKKNI No 067 Tahun 2018 <br> KATEGORI INFORMASI DAN KOMUNIKASI <br> BIDANG MULTIMEDIA
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>J.591MT00.011.01</td>
                                <td>Membuat Asset Visual Berdasarkan Langkah Kerja</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>J.59MT00.020.01</td>
                                <td>Mengumpulkan Asset Multimedia</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>J.59MT00.028.01</td>
                                <td>Membuat Dua Dimensi Multimedia</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>J.59MT00.029.01</td>
                                <td>Mendistribusikan Asset Multimedia</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bukti Kelengkapan -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Bagian 3 : Bukti Kelengkapan Pemohon
                </div>

                <h6 class="fw-bold mb-3">3.1 Bukti Persyaratan Dasar Pemohon</h6>

                <!-- Upload -->
                <div class="mb-3">
                    <label class="form-label">1. Fotokopi Rapor semester 1 s/d 5</label>
                    <div class="upload-box" onclick="document.getElementById('file1').click()">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Upload dokumen</span>
                    </div>
                    <input type="file" id="file1" class="upload-hidden">
                </div>

                <div class="mb-3">
                    <label class="form-label">2. Fotokopi Sertifikat PKL</label>
                    <div class="upload-box" onclick="document.getElementById('file2').click()">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Upload dokumen</span>
                    </div>
                    <input type="file" id="file2" class="upload-hidden">
                </div>

                <h6 class="fw-bold mt-4 mb-3">3.2 Bukti Administratif</h6>

                <div class="mb-3">
                    <label class="form-label">3. Fotokopi Kartu Siswa SMKN 11 Bandung Kompetensi DKV</label>
                    <div class="upload-box" onclick="document.getElementById('file3').click()">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Upload dokumen</span>
                    </div>
                    <input type="file" id="file3" class="upload-hidden">
                </div>

                <div class="mb-3">
                    <label class="form-label">4. Fotokopi Kartu Keluarga/KTP</label>
                    <div class="upload-box" onclick="document.getElementById('file4').click()">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Upload dokumen</span>
                    </div>
                    <input type="file" id="file4" class="upload-hidden">
                </div>

                <div class="mb-3">
                    <label class="form-label">5. Pas Foto 3x4 berwarna background merah (2 lembar)</label>
                    <div class="upload-box" onclick="document.getElementById('file5').click()">
                        <i class="bi bi-cloud-arrow-up"></i>
                        <span>Upload dokumen</span>
                    </div>
                    <input type="file" id="file5" class="upload-hidden">
                </div>
            </div>

            <!-- Tanda Tangan -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Tanda Tangan Asesi
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control rounded-3" placeholder="Masukkan nama lengkap asesi">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal</label>
                    <input type="date" class="form-control rounded-3">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanda Tangan</label>
                    <canvas id="signature-pad" class="border rounded-3 w-100" style="height:150px;"></canvas>
                    <button class="btn btn-sm btn-primary mt-2">Unduh</button>
                </div>
            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('asesi.permohonan.form1') }}" class="btn btn-danger">Kembali</a>
                <a href="{{ route('asesi.permohonan.form1') }}" class="btn" style="background-color:#041562; color:#fff;">Simpan dan Kirim</a>
            </div>
            

        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <style>
        .upload-box {
            border: 1px dashed #aaa;
            border-radius: 8px;
            background: #fafafa;
            text-align: center;
            padding: 25px;
            cursor: pointer;
            transition: 0.2s;
        }

        .upload-box:hover {
            background: #f0f0f0;
        }

        .upload-box i {
            font-size: 28px;
            color: #041562;
        }

        .upload-box span {
            display: block;
            margin-top: 6px;
            font-size: 14px;
            color: #666;
        }

        .upload-hidden {
            display: none;
        }
    </style>
@endsection
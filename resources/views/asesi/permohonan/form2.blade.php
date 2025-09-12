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
                    <select id="skemaSelect" class="form-select rounded-3">
                        <option selected disabled>Pilih Skema Sertifikasi</option>
                        @foreach($skema as $s)
                            <option value="{{ $s->id_skema }}">{{ $s->nama_skema }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Judul Sertifikasi</label>
                    <input type="text" id="judulSertifikasi" class="form-control rounded-3" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nomor Skema</label>
                    <input type="text" id="nomorSkema" class="form-control rounded-3" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tujuan Asesmen</label>
                    <input type="text" id="tujuanAsesmen" class="form-control rounded-3" readonly>
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
                        <tbody id="unitTable">
                            <tr>
                                <td colspan="4" class="text-center text-muted">Pilih skema sertifikasi terlebih dahulu</td>
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
                    <label class="form-label">3. Fotokopi Kartu Siswa</label>
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
                    <label class="form-label">5. Pas Foto 3x4</label>
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

            <!-- Buttons -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('asesi.permohonan.form1') }}" class="btn btn-danger">Kembali</a>
                <a href="{{ route('asesi.permohonan.form1') }}" class="btn"
                    style="background-color:#041562; color:#fff;">Simpan dan Kirim</a>
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

    <script>
        document.getElementById('skemaSelect').addEventListener('change', function () {
            let skemaId = this.value;
            fetch(`/get-skema/${skemaId}`)
                .then(res => res.json())
                .then(data => {
                    // isi input
                    document.getElementById('judulSertifikasi').value = data.skema.judul_skema ?? '';
                    document.getElementById('nomorSkema').value = data.skema.nomor_skema ?? '';
                    document.getElementById('tujuanAsesmen').value = data.skema.tujuan ?? '';

                    // isi tabel
                    let tbody = document.getElementById('unitTable');
                    tbody.innerHTML = '';
                    if (data.units.length > 0) {
                        data.units.forEach((u, i) => {
                            tbody.innerHTML += `
                            <tr>
                                <td>${i + 1}</td>
                                <td>${u.kode_unit}</td>
                                <td>${u.judul_unit}</td>
                                <td>${u.standar_kompetensi}</td>
                            </tr>
                        `;
                        });
                    } else {
                        tbody.innerHTML = `<tr><td colspan="4" class="text-center text-muted">Unit kompetensi belum tersedia</td></tr>`;
                    }
                });
        });
    </script>
@endsection
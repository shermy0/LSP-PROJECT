@extends('layouts.master')

@section('title', 'FR.APL.02 - Asesmen Mandiri')

@section('content')
<div class="container mt-2 my-5">
    <div class="bg-white border rounded-3 shadow-sm p-4">

        <!-- Header -->
        <div class="mb-4">
            <p class="small text-muted mb-1">Form Asesmen &gt; <span class="fw-semibold">FR.APL.02</span></p>
            <div class="d-flex flex-column align-items-center text-center">
                <div class="rounded mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                <h1 class="h5 fw-bold">Verifikasi Asesmen Mandiri</h1>
                <span class="badge bg-light text-dark mt-2 px-3 py-2 rounded-pill">
                    Rincian Form Asesmen Mandiri
                </span>
            </div>
        </div>

        <!-- Form Utama -->
        <form id="formApl02" action="{{ route('verifasesmen') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <!-- Data Umum -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Umum
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul</label>
                    <select name="judul" class="form-select rounded-3 required-field">
                        <option value="">Pilih Judul</option>
                        <option value="Desain Multimedia">Desain Multimedia</option>
                        <option value="Pengembangan Web">Pengembangan Web</option>
                    </select>
                    <div class="invalid-feedback">Judul wajib dipilih.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nomor</label>
                    <input type="text" name="nomor" class="form-control rounded-3 required-field" placeholder="Masukkan Nomor">
                    <div class="invalid-feedback">Nomor wajib diisi.</div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Skema Sertifikasi</label>
                    <select name="skema" class="form-select rounded-3 required-field">
                        <option value="">Pilih Skema</option>
                        <option value="Multimedia">Multimedia</option>
                        <option value="Web Development">Web Development</option>
                    </select>
                    <div class="invalid-feedback">Skema wajib dipilih.</div>
                </div>
            </div>

            <!-- Unit Kompetensi 1 -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Unit Kompetensi 1
                </div>
                <p class="fw-semibold mb-2">Kode Unit : J.58MT00.01.01</p>
                <p class="fw-semibold mb-3">Judul Unit : Menterjemahkan Arah Visual ke Dalam Langkah Kerja</p>

                <!-- Pertanyaan 1 -->
                <div class="mb-3">
                    <p class="fw-semibold">1. Mengidentifikasi elemen desain</p>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th>Elemen</th>
                                <th style="width:8%">K</th>
                                <th style="width:8%">BK</th>
                                <th style="width:25%">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>1.1 Elemen-elemen desain diidentifikasi.</li>
                                        <li>1.2 Langkah kerja setiap kebutuhan elemen desain ditetapkan.</li>
                                    </ul>
                                </td>
                                <td><input type="radio" name="q1" value="K"></td>
                                <td><input type="radio" name="q1" value="BK"></td>
                                <td>
                                    <input type="file" name="bukti_q1" class="form-control form-control-sm">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pertanyaan 2 -->
                <div class="mb-3">
                    <p class="fw-semibold">2. Merencanakan proses produksi aset visual multimedia</p>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width:5%">No</th>
                                <th>Elemen</th>
                                <th style="width:8%">K</th>
                                <th style="width:8%">BK</th>
                                <th style="width:25%">Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>2.1 Prosedur pengerjaan aset visual diidentifikasi.</li>
                                        <li>2.2 Kebutuhan aset visual multimedia diidentifikasi.</li>
                                    </ul>
                                </td>
                                <td><input type="radio" name="q2" value="K"></td>
                                <td><input type="radio" name="q2" value="BK"></td>
                                <td>
                                    <input type="file" name="bukti_q2" class="form-control form-control-sm">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Evaluasi -->
                <div class="mb-3">
                    <label class="form-label">Apakah Asesi Menyatakan Kompeten?</label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="kompeten_ya" name="kompeten" value="ya" class="form-check-input">
                        <label for="kompeten_ya" class="form-check-label">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="kompeten_tidak" name="kompeten" value="tidak" class="form-check-input">
                        <label for="kompeten_tidak" class="form-check-label">Tidak</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apakah bukti yang dilampirkan valid?</label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="valid_ya" name="valid" value="ya" class="form-check-input">
                        <label for="valid_ya" class="form-check-label">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="valid_tidak" name="valid" value="tidak" class="form-check-input">
                        <label for="valid_tidak" class="form-check-label">Tidak</label>
                    </div>
                </div>
            </div>

            <!-- Unit Kompetensi 2 -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Unit Kompetensi 2
                </div>
                <p class="fw-semibold mb-2">Kode Unit : J.58MT00.01.11</p>
                <p class="fw-semibold mb-3">Judul Unit : Membuat Aset Visual Berdasarkan Langkah Kerja yang Telah Ditetapkan</p>

                <!-- Pertanyaan 1 -->
                <div class="mb-3">
                    <p class="fw-semibold">1. Memproduksi aset visual multimedia</p>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Elemen</th>
                                <th>K</th>
                                <th>BK</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>1.1 Prosedur pengerjaan aset visual teridentifikasi.</li>
                                        <li>1.2 Aset visual multimedia diproduksi.</li>
                                        <li>1.3 Penyimpanan aset secara berkala dilakukan.</li>
                                    </ul>
                                </td>
                                <td><input type="radio" name="q3" value="K"></td>
                                <td><input type="radio" name="q3" value="BK"></td>
                                <td>
                                    <input type="file" name="bukti_q3" class="form-control form-control-sm">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pertanyaan 2 -->
                <div class="mb-3">
                    <p class="fw-semibold">2. Mereview hasil desain</p>
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Elemen</th>
                                <th>K</th>
                                <th>BK</th>
                                <th>Bukti</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2</td>
                                <td>
                                    <ul class="mb-0">
                                        <li>2.1 Hasil kerja dievaluasi secara berkala.</li>
                                        <li>2.2 Tuntutan perbaikan visual dipersiapkan.</li>
                                        <li>2.3 Proses perbaikan dilakukan.</li>
                                    </ul>
                                </td>
                                <td><input type="radio" name="q4" value="K"></td>
                                <td><input type="radio" name="q4" value="BK"></td>
                                <td>
                                    <input type="file" name="bukti_q4" class="form-control form-control-sm">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Evaluasi -->
                <div class="mb-3">
                    <label class="form-label">Apakah Asesi Menyatakan Kompeten?</label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="kompeten2_ya" name="kompeten2" value="ya" class="form-check-input">
                        <label for="kompeten2_ya" class="form-check-label">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="kompeten2_tidak" name="kompeten2" value="tidak" class="form-check-input">
                        <label for="kompeten2_tidak" class="form-check-label">Tidak</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Apakah bukti yang dilampirkan valid?</label><br>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="valid2_ya" name="valid2" value="ya" class="form-check-input">
                        <label for="valid2_ya" class="form-check-label">Ya</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" id="valid2_tidak" name="valid2" value="tidak" class="form-check-input">
                        <label for="valid2_tidak" class="form-check-label">Tidak</label>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn" style="background-color:#041562; color:#fff;">
                    Selanjutnya
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Script Validasi -->
<script>
    document.getElementById('formApl02').addEventListener('submit', function (e) {
        let valid = true;
        let firstInvalid = null;

        this.querySelectorAll('.required-field').forEach(field => {
            if (!field.value) {
                field.classList.add('is-invalid');
                valid = false;
                if (!firstInvalid) firstInvalid = field;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
            firstInvalid.focus();
        }
    });

    document.querySelectorAll('.required-field').forEach(field => {
        field.addEventListener('input', function () {
            if (this.value) {
                this.classList.remove('is-invalid');
            }
        });
    });
</script>
@endsection

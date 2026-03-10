@extends('master')

@section('title', 'FR.APL.01 - Permohonan Sertifikasi Kompetensi')

@section('konten')
    <div class="container-fluid px-4 py-4">
        <form id="formApl01" action="{{ route('asesi.permohonan.store') }}" method="POST" novalidate>
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
                <p class="text-secondary">Form Asesmen FR.APL.01 – Isi data dengan lengkap dan benar</p>
            </div>

            <!-- ALERT RINGKAS ERROR -->
            <div id="formErrors" class="alert alert-danger d-none shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill me-2" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                    </svg>
                    <strong>Perbaiki kesalahan berikut:</strong>
                </div>
                <ul class="mb-0 mt-2 ps-4"></ul>
            </div>

            <!-- Data Pribadi - Card Modern dengan aksen #0b2f7c -->
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
                            <h5 class="fw-bold mb-0">Data Pribadi</h5>
                            <p class="text-secondary mb-0 small">Cantumkan data pribadi, pendidikan formal, serta data pekerjaan saat ini.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <!-- Nama Lengkap -->
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                                value="{{ old('nama_lengkap', isset($asesi) ? $asesi->nama_lengkap : '') }}" placeholder="Masukkan nama lengkap"
                                required data-msg="Nama lengkap wajib diisi.">
                            <div class="invalid-feedback">
                                @error('nama_lengkap') {{ $message }} @else Nama lengkap wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- NIK -->
                        <div class="col-md-6">
                            <label class="form-label">No. KTP / NIK / Paspor <span class="text-danger">*</span></label>
                            <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror"
                                value="{{ old('nik', isset($asesi) ? $asesi->nik : '') }}"
                                placeholder="Masukkan nomor identitas" required pattern="\d{16}" title="NIK harus 16 digit angka"
                                data-msg="NIK harus 16 digit angka (hanya angka)" >
                            <div class="invalid-feedback">
                                @error('nik') {{ $message }} @else NIK harus 16 digit angka. @enderror
                            </div>
                        </div>

                        <!-- Tempat Lahir -->
                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                            <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                                value="{{ old('tempat_lahir', isset($asesi) ? $asesi->tempat_lahir : '') }}" placeholder="Masukkan tempat lahir"
                                required data-msg="Tempat lahir wajib diisi.">
                            <div class="invalid-feedback">
                                @error('tempat_lahir') {{ $message }} @else Tempat lahir wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- Tanggal Lahir -->
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                value="{{ old('tgl_lahir', isset($asesi->tgl_lahir) ? \Carbon\Carbon::parse($asesi->tgl_lahir)->format('Y-m-d') : '') }}"
                                required data-msg="Tanggal lahir wajib diisi.">
                            <div class="invalid-feedback">
                                @error('tgl_lahir') {{ $message }} @else Tanggal lahir wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- Jenis Kelamin -->
                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required data-msg="Jenis kelamin wajib dipilih.">
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin', isset($asesi) ? $asesi->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin', isset($asesi) ? $asesi->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="invalid-feedback">
                                @error('jenis_kelamin') {{ $message }} @else Jenis kelamin wajib dipilih. @enderror
                            </div>
                        </div>

                        <!-- Kebangsaan -->
                        <div class="col-md-6">
                            <label class="form-label">Kebangsaan <span class="text-danger">*</span></label>
                            <input type="text" name="kebangsaan" class="form-control @error('kebangsaan') is-invalid @enderror"
                                value="{{ old('kebangsaan', isset($asesi) ? $asesi->kebangsaan : 'Indonesia') }}" placeholder="Masukkan kebangsaan"
                                required data-msg="Kebangsaan wajib diisi.">
                            <div class="invalid-feedback">
                                @error('kebangsaan') {{ $message }} @else Kebangsaan wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- Alamat Rumah (full width) -->
                        <div class="col-12">
                            <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                            <input type="text" name="alamat_rumah" class="form-control @error('alamat_rumah') is-invalid @enderror"
                                value="{{ old('alamat_rumah', isset($asesi) ? $asesi->alamat_rumah : '') }}" placeholder="Masukkan alamat rumah"
                                required data-msg="Alamat rumah wajib diisi.">
                            <div class="invalid-feedback">
                                @error('alamat_rumah') {{ $message }} @else Alamat rumah wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- Kode Pos Rumah -->
                        <div class="col-md-4">
                            <label class="form-label">Kode Pos Rumah <span class="text-danger">*</span></label>
                            <input type="text" name="kode_pos_rumah" class="form-control @error('kode_pos_rumah') is-invalid @enderror"
                                value="{{ old('kode_pos_rumah', isset($asesi) ? $asesi->kode_pos_rumah : '') }}" placeholder="Kode pos"
                                required pattern="\d{5}" title="Kode pos harus 5 digit angka" data-msg="Kode pos harus 5 digit angka.">
                            <div class="invalid-feedback">
                                @error('kode_pos_rumah') {{ $message }} @else Kode pos rumah wajib 5 digit angka. @enderror
                            </div>
                        </div>

                        <!-- Telepon Rumah -->
                        <div class="col-md-4">
                            <label class="form-label">Telp. Rumah <span class="text-danger">*</span></label>
                            <input type="text" name="telepon_rumah" class="form-control @error('telepon_rumah') is-invalid @enderror"
                                value="{{ old('telepon_rumah', isset($asesi) ? $asesi->telepon_rumah : '') }}" placeholder="Telp. rumah"
                                required pattern="^\+?\d{7,15}$" title="Masukkan nomor telepon yang valid (7-15 digit, optional +)"
                                data-msg="Nomor telepon rumah tidak valid.">
                            <div class="invalid-feedback">
                                @error('telepon_rumah') {{ $message }} @else Telp. rumah wajib diisi dan format harus benar. @enderror
                            </div>
                        </div>

                        <!-- HP -->
                        <div class="col-md-4">
                            <label class="form-label">HP <span class="text-danger">*</span></label>
                            <input type="text" name="telepon_hp" class="form-control @error('telepon_hp') is-invalid @enderror"
                                value="{{ old('telepon_hp', isset($asesi) ? $asesi->telepon_hp : (auth()->user()->phone ?? '')) }}"
                                placeholder="Masukkan nomor HP" required pattern="^\+?\d{7,15}$"
                                title="Masukkan nomor HP yang valid (7-15 digit, optional +)" data-msg="Nomor HP tidak valid.">
                            <div class="invalid-feedback">
                                @error('telepon_hp') {{ $message }} @else Nomor HP wajib diisi dan format harus benar. @enderror
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label">E-mail <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', isset($asesi) ? $asesi->email : (auth()->user()->email ?? '')) }}"
                                placeholder="Masukkan email" required data-msg="Masukkan alamat email yang valid.">
                            <div class="invalid-feedback">
                                @error('email') {{ $message }} @else Email wajib diisi dan harus format email. @enderror
                            </div>
                        </div>

                        <!-- Kualifikasi Pendidikan -->
                        <div class="col-md-6">
                            <label class="form-label">Kualifikasi Pendidikan <span class="text-danger">*</span></label>
                            <input type="text" name="kualifikasi_pendidikan" class="form-control @error('kualifikasi_pendidikan') is-invalid @enderror"
                                value="{{ old('kualifikasi_pendidikan', isset($asesi) ? ($asesi->kualifikasi_pendidikan ?? $asesi->pendidikan_terakhir ?? '') : '') }}"
                                placeholder="Contoh: SMK - Desain Komunikasi Visual" required data-msg="Kualifikasi pendidikan wajib diisi.">
                            <div class="invalid-feedback">
                                @error('kualifikasi_pendidikan') {{ $message }} @else Kualifikasi pendidikan wajib diisi. @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Pekerjaan Sekarang - Card Modern dengan aksen #0b2f7c -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-briefcase text-primary" viewBox="0 0 16 16">
                                <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5zm1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0zM1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5z"/>
                            </svg>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0">Data Pekerjaan Sekarang</h5>
                            <p class="text-secondary mb-0 small">Isi data pekerjaan atau sekolah tempat peserta saat ini.</p>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row g-3">
                        <!-- Nama Institusi -->
                        <div class="col-md-6">
                            <label class="form-label">Nama Institusi / Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_institusi" class="form-control @error('nama_institusi') is-invalid @enderror"
                                value="{{ old('nama_institusi', isset($asesi) ? $asesi->nama_institusi : '') }}"
                                placeholder="Nama sekolah atau perusahaan" required data-msg="Nama institusi wajib diisi.">
                            <div class="invalid-feedback">
                                @error('nama_institusi') {{ $message }} @else Nama institusi wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- Jabatan -->
                        <div class="col-md-6">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                                value="{{ old('jabatan', isset($asesi) ? $asesi->jabatan : '') }}"
                                placeholder="Jabatan / status (mis. Siswa, Staff, Freelancer)" required data-msg="Jabatan wajib diisi.">
                            <div class="invalid-feedback">
                                @error('jabatan') {{ $message }} @else Jabatan wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- Alamat Kantor (full width) -->
                        <div class="col-12">
                            <label class="form-label">Alamat Kantor / Sekolah <span class="text-danger">*</span></label>
                            <input type="text" name="alamat_kantor" class="form-control @error('alamat_kantor') is-invalid @enderror"
                                value="{{ old('alamat_kantor', isset($asesi) ? $asesi->alamat_kantor : '') }}"
                                placeholder="Alamat institusi/perusahaan" required data-msg="Alamat kantor wajib diisi.">
                            <div class="invalid-feedback">
                                @error('alamat_kantor') {{ $message }} @else Alamat kantor wajib diisi. @enderror
                            </div>
                        </div>

                        <!-- Kode Pos Kantor -->
                        <div class="col-md-4">
                            <label class="form-label">Kode Pos Kantor <span class="text-danger">*</span></label>
                            <input type="text" name="kode_pos_kantor" class="form-control @error('kode_pos_kantor') is-invalid @enderror"
                                value="{{ old('kode_pos_kantor', isset($asesi) ? $asesi->kode_pos_kantor : '') }}" placeholder="Kode pos"
                                required pattern="\d{5}" title="Kode pos harus 5 digit angka" data-msg="Kode pos kantor harus 5 digit angka.">
                            <div class="invalid-feedback">
                                @error('kode_pos_kantor') {{ $message }} @else Kode pos kantor wajib 5 digit angka. @enderror
                            </div>
                        </div>

                        <!-- Telepon Kantor -->
                        <div class="col-md-4">
                            <label class="form-label">Telp. Kantor <span class="text-danger">*</span></label>
                            <input type="text" name="telepon_kantor" class="form-control @error('telepon_kantor') is-invalid @enderror"
                                value="{{ old('telepon_kantor', isset($asesi) ? $asesi->telepon_kantor : '') }}" placeholder="Contoh: (021) 1234567 atau -"
                                required
                                pattern="^([-+()0-9 ]+|-)$"
                                title="Masukkan nomor telepon kantor yang valid (angka, spasi, -, +, (, )) atau isi '-' jika tidak ada"
                                data-msg="Masukkan nomor telepon kantor yang valid atau '-' jika tidak ada.">
                            <div class="invalid-feedback">
                                @error('telepon_kantor') {{ $message }} @else Telp. kantor wajib diisi dan format harus benar. @enderror
                            </div>
                        </div>

                        <!-- Fax Kantor -->
                        <div class="col-md-4">
                            <label class="form-label">Fax Kantor <span class="text-danger">*</span></label>
                            <input type="text" name="fax_kantor" class="form-control @error('fax_kantor') is-invalid @enderror"
                                value="{{ old('fax_kantor', isset($asesi) ? $asesi->fax_kantor : '') }}" placeholder="Contoh: 021-123456 atau -"
                                required
                                pattern="^([-+()0-9 ]+|-)$"
                                title="Masukkan nomor fax yang valid (angka, spasi, -, +, (, )) atau isi '-' jika tidak ada"
                                data-msg="Masukkan nomor fax yang valid atau '-' jika tidak ada.">
                            <div class="invalid-feedback">
                                @error('fax_kantor') {{ $message }} @else Fax kantor wajib diisi dan format harus benar. @enderror
                            </div>
                        </div>

                        <!-- Email Kantor -->
                        <div class="col-md-6">
                            <label class="form-label">E-mail Kantor <span class="text-danger">*</span></label>
                            <input type="email" name="email_kantor" class="form-control @error('email_kantor') is-invalid @enderror"
                                value="{{ old('email_kantor', isset($asesi) ? $asesi->email_kantor : '') }}" placeholder="Email kantor / sekolah"
                                required data-msg="Masukkan alamat email kantor yang valid.">
                            <div class="invalid-feedback">
                                @error('email_kantor') {{ $message }} @else Email kantor wajib diisi dan harus format email. @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="button-group mt-4">
                <a href="{{ route('form_pra_assesmen') }}" class="btn-back">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                    </svg>
                    Kembali
                </a>
                <button type="submit" class="btn-next">
                    Selanjutnya
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-right ms-2" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
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

        /* Tombol Next */
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

        /* Tombol Back (tetap netral) */
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

        /* ===== ALERT ===== */
        #formErrors {
            border-left: 6px solid var(--danger);
            border-radius: 1rem;
            background-color: #fff2f2;
            color: #842029;
            font-size: 0.95rem;
            padding: 1rem 1.25rem;
        }

        #formErrors ul {
            list-style-type: disc;
            padding-left: 1.5rem;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .button-group {
                justify-content: center;
            }
            .card-body .row > [class*="col-"] {
                margin-bottom: 0.25rem;
            }
        }
    </style>

    <!-- Script (sama persis dengan aslinya) -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('formApl01');
        const alertBox = document.getElementById('formErrors');
        const serverErrors = @json($errors->getMessages());
        const messagesMap = {};

        if (serverErrors && Object.keys(serverErrors).length > 0) {
            Object.keys(serverErrors).forEach(field => {
                const msg = serverErrors[field] && serverErrors[field].length ? serverErrors[field][0] : null;
                if (msg) messagesMap[field] = msg;
            });
            updateAlertFromMap(true);
            setTimeout(() => {
                const firstInvalid = form.querySelector('.is-invalid');
                if (firstInvalid) {
                    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstInvalid.focus();
                }
            }, 120);
        }

        function updateAlertFromMap(doScroll = false) {
            const msgs = Object.values(messagesMap);
            if (!msgs.length) {
                alertBox.classList.add('d-none');
                alertBox.innerHTML = '';
                return;
            }
            alertBox.classList.remove('d-none');
            const list = msgs.slice(0,10).map(m => `<li>${m}</li>`).join('');
            // pastikan elemen ul ada
            let ul = alertBox.querySelector('ul');
            if (!ul) {
                ul = document.createElement('ul');
                ul.className = 'mb-0 mt-2 ps-4';
                alertBox.appendChild(ul);
            }
            ul.innerHTML = list;
            if (doScroll) {
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }

        function setFieldInvalid(fieldEl, msg) {
            fieldEl.classList.add('is-invalid');
            const fb = fieldEl.parentElement.querySelector('.invalid-feedback');
            if (fb) fb.textContent = msg;
            messagesMap[fieldEl.getAttribute('name')] = msg;
        }

        function clearFieldInvalid(fieldEl) {
            fieldEl.classList.remove('is-invalid');
            const fieldName = fieldEl.getAttribute('name');
            if (messagesMap[fieldName]) {
                delete messagesMap[fieldName];
                updateAlertFromMap(false);
            } else {
                updateAlertFromMap(false);
            }
        }

        form.addEventListener('submit', function (e) {
            let hasError = false;
            const fields = Array.from(form.querySelectorAll('input, select, textarea'));

            fields.forEach(field => {
                if (!field.name || field.disabled || field.closest('fieldset[disabled]')) return;

                const isRequired = field.hasAttribute('required');
                const value = (field.value || '').toString().trim();
                const fieldName = field.getAttribute('name');
                const serverHas = serverErrors && serverErrors[fieldName] && serverErrors[fieldName].length;

                if (!serverHas) {
                    field.classList.remove('is-invalid');
                }

                if (isRequired && !value) {
                    hasError = true;
                    const msg = field.dataset.msg || 'Field ini wajib diisi.';
                    setFieldInvalid(field, msg);
                    return;
                }

                if (value && !field.checkValidity()) {
                    hasError = true;
                    const msg = field.dataset.msg || field.title || field.validationMessage || 'Format tidak valid.';
                    setFieldInvalid(field, msg);
                    return;
                }

                if (!serverHas) {
                    if (messagesMap[fieldName]) {
                        delete messagesMap[fieldName];
                    }
                }
            });

            if (hasError) {
                e.preventDefault();
                updateAlertFromMap(true);
                const first = form.querySelector('.is-invalid');
                if (first) {
                    setTimeout(() => {
                        first.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        first.focus();
                    }, 120);
                }
            } else {
                alertBox.classList.add('d-none');
                alertBox.innerHTML = '';
            }
        });

        form.querySelectorAll('input, select, textarea').forEach(field => {
            if (!field.name) return;

            field.addEventListener('input', function () {
                const value = (this.value || '').toString().trim();
                if (value && this.checkValidity()) {
                    clearFieldInvalid(this);
                }
            });

            field.addEventListener('change', function () {
                const value = (this.value || '').toString().trim();
                if (value && this.checkValidity()) {
                    clearFieldInvalid(this);
                }
            });
        });
    });
    </script>
@endsection

@extends('master')

@section('title', 'FR.APL.01 - Permohonan Sertifikasi Kompetensi')

@section('konten')
    <div class="container-fluid px-4 py-3">
        <form id="formApl01" action="{{ route('asesi.permohonan.store') }}" method="POST" novalidate>
            @csrf

            <!-- Header -->
            <div class="text-center mb-4">
                <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                <h1 class="h4 fw-bold">Permohonan Sertifikasi Kompetensi</h1>
                <p class="text-muted">Form Asesmen &gt; FR.APL.01</p>
            </div>

            <!-- ALERT RINGKAS ERROR -->
            <div id="formErrors" class="alert alert-danger d-none" role="alert"></div>

            <!-- Data Pribadi -->
            <div class="unit-header">
                <p class="mb-1 fw-semibold">Data Pribadi</p>
                <p class="mb-0">Cantumkan data pribadi, pendidikan formal, serta data pekerjaan saat ini.</p>
            </div>

            <div class="question-box">
                <!-- Nama Lengkap -->
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama_lengkap" class="form-control"
                        value="{{ old('nama_lengkap', $asesi->nama_lengkap ?? '') }}" placeholder="Masukkan nama lengkap"
                        required data-msg="Nama lengkap wajib diisi.">
                    <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                </div>

                <!-- NIK -->
                <div class="mb-3">
                    <label class="form-label">No. KTP / NIK / Paspor <span class="text-danger">*</span></label>
                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $asesi->nik ?? '') }}"
                        placeholder="Masukkan nomor identitas" required pattern="\d{16}" title="NIK harus 16 digit angka"
                        data-msg="NIK harus 16 digit angka (hanya angka)" >
                    <div class="invalid-feedback">NIK harus 16 digit angka.</div>
                </div>

                <!-- Tempat Lahir -->
                <div class="mb-3">
                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-control"
                        value="{{ old('tempat_lahir', $asesi->tempat_lahir ?? '') }}" placeholder="Masukkan tempat lahir"
                        required data-msg="Tempat lahir wajib diisi.">
                    <div class="invalid-feedback">Tempat lahir wajib diisi.</div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_lahir" class="form-control"
                        value="{{ old('tgl_lahir', isset($asesi->tgl_lahir) ? \Carbon\Carbon::parse($asesi->tgl_lahir)->format('Y-m-d') : '') }}"
                        required data-msg="Tanggal lahir wajib diisi.">
                    <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select" required data-msg="Jenis kelamin wajib dipilih.">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin', $asesi->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $asesi->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                    <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
                </div>

                <!-- Kebangsaan -->
                <div class="mb-3">
                    <label class="form-label">Kebangsaan <span class="text-danger">*</span></label>
                    <input type="text" name="kebangsaan" class="form-control"
                        value="{{ old('kebangsaan', $asesi->kebangsaan ?? 'Indonesia') }}" placeholder="Masukkan kebangsaan"
                        required data-msg="Kebangsaan wajib diisi.">
                    <div class="invalid-feedback">Kebangsaan wajib diisi.</div>
                </div>

                <!-- Alamat Rumah -->
                <div class="mb-3">
                    <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                    <input type="text" name="alamat_rumah" class="form-control"
                        value="{{ old('alamat_rumah', $asesi->alamat_rumah ?? '') }}" placeholder="Masukkan alamat rumah"
                        required data-msg="Alamat rumah wajib diisi.">
                    <div class="invalid-feedback">Alamat rumah wajib diisi.</div>
                </div>

                <!-- Kode Pos Rumah -->
                <div class="mb-3">
                    <label class="form-label">Kode Pos Rumah <span class="text-danger">*</span></label>
                    <input type="text" name="kode_pos_rumah" class="form-control"
                        value="{{ old('kode_pos_rumah', $asesi->kode_pos_rumah ?? '') }}" placeholder="Kode pos"
                        required pattern="\d{5}" title="Kode pos harus 5 digit angka" data-msg="Kode pos harus 5 digit angka.">
                    <div class="invalid-feedback">Kode pos rumah wajib 5 digit angka.</div>
                </div>

                <!-- Telepon Rumah -->
                <div class="mb-3">
                    <label class="form-label">Telp. Rumah <span class="text-danger">*</span></label>
                    <input type="text" name="telepon_rumah" class="form-control"
                        value="{{ old('telepon_rumah', $asesi->telepon_rumah ?? '') }}" placeholder="Telp. rumah"
                        required pattern="^\+?\d{7,15}$" title="Masukkan nomor telepon yang valid (7-15 digit, optional +)"
                        data-msg="Nomor telepon rumah tidak valid.">
                    <div class="invalid-feedback">Telp. rumah wajib diisi dan format harus benar.</div>
                </div>

                <!-- HP -->
                <div class="mb-3">
                    <label class="form-label">HP <span class="text-danger">*</span></label>
                    <input type="text" name="telepon_hp" class="form-control"
                        value="{{ old('telepon_hp', $asesi->telepon_hp ?? auth()->user()->phone ?? '') }}"
                        placeholder="Masukkan nomor HP" required pattern="^\+?\d{7,15}$"
                        title="Masukkan nomor HP yang valid (7-15 digit, optional +)" data-msg="Nomor HP tidak valid.">
                    <div class="invalid-feedback">Nomor HP wajib diisi dan format harus benar.</div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">E-mail <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control"
                        value="{{ old('email', $asesi->email ?? auth()->user()->email ?? '') }}"
                        placeholder="Masukkan email" required data-msg="Masukkan alamat email yang valid.">
                    <div class="invalid-feedback">Email wajib diisi dan harus format email.</div>
                </div>

                <!-- Kualifikasi Pendidikan -->
                <div class="mb-3">
                    <label class="form-label">Kualifikasi Pendidikan <span class="text-danger">*</span></label>
                    <input type="text" name="kualifikasi_pendidikan" class="form-control"
                        value="{{ old('kualifikasi_pendidikan', $asesi->kualifikasi_pendidikan ?? $asesi->pendidikan_terakhir ?? '') }}"
                        placeholder="Contoh: SMK - Desain Komunikasi Visual" required data-msg="Kualifikasi pendidikan wajib diisi.">
                    <div class="invalid-feedback">Kualifikasi pendidikan wajib diisi.</div>
                </div>
            </div>

            <!-- Data Pekerjaan Sekarang -->
            <div class="unit-header mt-3">
                <p class="mb-1 fw-semibold">Data Pekerjaan Sekarang</p>
                <p class="mb-0">Isi data pekerjaan atau sekolah tempat peserta saat ini.</p>
            </div>

            <div class="question-box">
                <!-- Nama Institusi / Sekolah -->
                <div class="mb-3">
                    <label class="form-label">Nama Institusi / Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="nama_institusi" class="form-control"
                        value="{{ old('nama_institusi', $asesi->nama_institusi ?? '') }}"
                        placeholder="Nama sekolah atau perusahaan" required data-msg="Nama institusi wajib diisi.">
                    <div class="invalid-feedback">Nama institusi wajib diisi.</div>
                </div>

                <!-- Jabatan -->
                <div class="mb-3">
                    <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan" class="form-control"
                        value="{{ old('jabatan', $asesi->jabatan ?? '') }}"
                        placeholder="Jabatan / status (mis. Siswa, Staff, Freelancer)" required data-msg="Jabatan wajib diisi.">
                    <div class="invalid-feedback">Jabatan wajib diisi.</div>
                </div>

                <!-- Alamat Kantor -->
                <div class="mb-3">
                    <label class="form-label">Alamat Kantor / Sekolah <span class="text-danger">*</span></label>
                    <input type="text" name="alamat_kantor" class="form-control"
                        value="{{ old('alamat_kantor', $asesi->alamat_kantor ?? '') }}"
                        placeholder="Alamat institusi/perusahaan" required data-msg="Alamat kantor wajib diisi.">
                    <div class="invalid-feedback">Alamat kantor wajib diisi.</div>
                </div>

                <!-- Kode Pos Kantor -->
                <div class="mb-3">
                    <label class="form-label">Kode Pos Kantor <span class="text-danger">*</span></label>
                    <input type="text" name="kode_pos_kantor" class="form-control"
                        value="{{ old('kode_pos_kantor', $asesi->kode_pos_kantor ?? '') }}" placeholder="Kode pos"
                        required pattern="\d{5}" title="Kode pos harus 5 digit angka" data-msg="Kode pos kantor harus 5 digit angka.">
                    <div class="invalid-feedback">Kode pos kantor wajib 5 digit angka.</div>
                </div>

                <!-- Telepon Kantor -->
                <div class="mb-3">
                    <label class="form-label">Telp. Kantor <span class="text-danger">*</span></label>
                    <input type="text" name="telepon_kantor" class="form-control"
                        value="{{ old('telepon_kantor', $asesi->telepon_kantor ?? '') }}" placeholder="Telp. kantor"
                        required pattern="^\+?\d{7,15}$" title="Masukkan nomor telepon yang valid (7-15 digit, optional +)"
                        data-msg="Nomor telepon kantor tidak valid.">
                    <div class="invalid-feedback">Telp. kantor wajib diisi dan format harus benar.</div>
                </div>

                <!-- Fax Kantor -->
                <div class="mb-3">
                    <label class="form-label">Fax Kantor <span class="text-danger">*</span></label>
                    <input type="text" name="fax_kantor" class="form-control"
                        value="{{ old('fax_kantor', $asesi->fax_kantor ?? '') }}" placeholder="Fax kantor"
                        required pattern="^\+?[\d\-]{6,20}$" title="Masukkan nomor fax yang valid"
                        data-msg="Nomor fax tidak valid.">
                    <div class="invalid-feedback">Fax kantor wajib diisi dan format harus benar.</div>
                </div>

                <!-- Email Kantor -->
                <div class="mb-3">
                    <label class="form-label">E-mail Kantor <span class="text-danger">*</span></label>
                    <input type="email" name="email_kantor" class="form-control"
                        value="{{ old('email_kantor', $asesi->email_kantor ?? '') }}" placeholder="Email kantor / sekolah"
                        required data-msg="Masukkan alamat email kantor yang valid.">
                    <div class="invalid-feedback">Email kantor wajib diisi dan harus format email.</div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="button-group mt-4">
                <a href="{{ route('dashboard') }}" class="btn-back">Kembali</a>
                <button type="submit" class="btn-next">Selanjutnya</button>
            </div>
        </form>
    </div>


    <style>
        /* (tetap seperti style sebelumnya) */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f9f9fb;
        }

        .container-fluid {
            width: 100%;
        }

        .unit-header {
            background: #E9F1FF;
            border-left: 6px solid #007BFF;
            border-radius: 8px;
            padding: 15px 20px;
            margin-bottom: 12px;
            font-size: 14px;
        }

        .question-box {
            border: 1px solid #ddd;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border: 2px solid #d9534f !important;
            background: #fff8f8 !important;
        }

        .invalid-feedback {
            font-size: 12px;
            display: block;
        }

        .button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .btn-back {
            background: #d9534f;
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
        }

        .btn-next {
            background: #041562;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
        }

        .btn-back:hover {
            background: #c9302c;
        }

        .btn-next:hover {
            background: #06208a;
        }

        .unit-header {
            background: #E9F1FF;
            border-left: 6px solid #007BFF;
            border-radius: 8px;
            padding: 18px 20px;
            margin-bottom: 12px;
            font-size: 1.125rem;
            line-height: 1.3;
            font-weight: 700;
            color: #041562;
        }

        .unit-header p.mb-0 {
            font-size: 0.95rem;
            color: #334155;
            margin-top: 4px;
            font-weight: 500;
        }

        label.form-label {
            font-weight: 600;
            font-size: 0.95rem;
            /* 15px */
            color: #0f172a;
        }

        .question-box .mb-3 {
            margin-bottom: 14px;
        }

        @media (max-width: 576px) {
            .unit-header {
                font-size: 1rem;
            }

            label.form-label {
                font-size: 0.9rem;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('formApl01');
            const alertBox = document.getElementById('formErrors');

            function showAlert(messages) {
                if (!messages || messages.length === 0) {
                    alertBox.classList.add('d-none');
                    alertBox.innerHTML = '';
                    return;
                }
                alertBox.classList.remove('d-none');
                // tampilkan ringkasan error (maks 5)
                const list = messages.slice(0, 10).map(m => `<li>${m}</li>`).join('');
                alertBox.innerHTML = `<strong>Perhatikan:</strong><ul class="mb-0 mt-2">${list}</ul>`;
                alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            form.addEventListener('submit', function (e) {
                let valid = true;
                const messages = [];
                let firstInvalid = null;

                // remove previous invalid states
                form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

                // cek required + pattern/type
                form.querySelectorAll('[required]').forEach(field => {
                    // skip fields that are hidden/disabled
                    if (field.disabled || field.closest('fieldset[disabled]')) return;

                    const value = (field.value || '').toString().trim();

                    // basic required
                    if (!value) {
                        valid = false;
                        field.classList.add('is-invalid');
                        const msg = field.dataset.msg || 'Field ini wajib diisi.';
                        messages.push(msg);
                        if (!firstInvalid) firstInvalid = field;
                        return;
                    }

                    // use built-in validity for type/pattern checks
                    if (!field.checkValidity()) {
                        valid = false;
                        field.classList.add('is-invalid');

                        // prefer custom message, else title, else default
                        const msg = field.dataset.msg || field.title || field.validationMessage || 'Format tidak valid.';
                        messages.push(msg);
                        if (!firstInvalid) firstInvalid = field;
                        return;
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    showAlert(messages);

                    // fokus ke error pertama
                    if (firstInvalid) {
                        setTimeout(() => {
                            firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            firstInvalid.focus();
                        }, 150);
                    }
                } else {
                    // semua valid, sembunyikan alert
                    showAlert([]);
                }
            });

            // real-time clearing of errors
            form.querySelectorAll('input, select, textarea').forEach(field => {
                field.addEventListener('input', function () {
                    if (this.classList.contains('is-invalid')) {
                        // re-check validity for this field
                        const value = (this.value || '').toString().trim();
                        if (value && this.checkValidity()) {
                            this.classList.remove('is-invalid');
                            showAlert([]);
                        }
                    }
                });

                field.addEventListener('change', function () {
                    if (this.classList.contains('is-invalid')) {
                        const value = (this.value || '').toString().trim();
                        if (value && this.checkValidity()) {
                            this.classList.remove('is-invalid');
                            showAlert([]);
                        }
                    }
                });
            });
        });
    </script>
@endsection

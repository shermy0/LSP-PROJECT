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
                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
                        value="{{ old('nama_lengkap', isset($asesi) ? $asesi->nama_lengkap : '') }}" placeholder="Masukkan nama lengkap"
                        required data-msg="Nama lengkap wajib diisi.">
                    <div class="invalid-feedback">
                        @error('nama_lengkap') {{ $message }} @else Nama lengkap wajib diisi. @enderror
                    </div>
                </div>

                <!-- NIK -->
                <div class="mb-3">
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
                <div class="mb-3">
                    <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        value="{{ old('tempat_lahir', isset($asesi) ? $asesi->tempat_lahir : '') }}" placeholder="Masukkan tempat lahir"
                        required data-msg="Tempat lahir wajib diisi.">
                    <div class="invalid-feedback">
                        @error('tempat_lahir') {{ $message }} @else Tempat lahir wajib diisi. @enderror
                    </div>
                </div>

                <!-- Tanggal Lahir -->
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                    <input type="date" name="tgl_lahir" class="form-control @error('tgl_lahir') is-invalid @enderror"
                        value="{{ old('tgl_lahir', isset($asesi->tgl_lahir) ? \Carbon\Carbon::parse($asesi->tgl_lahir)->format('Y-m-d') : '') }}"
                        required data-msg="Tanggal lahir wajib diisi.">
                    <div class="invalid-feedback">
                        @error('tgl_lahir') {{ $message }} @else Tanggal lahir wajib diisi. @enderror
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required data-msg="Jenis kelamin wajib dipilih.">
                        <option value="">Pilih</option>
                        <option value="L" {{ old('jenis_kelamin', isset($asesi) ? $asesi->jenis_kelamin : '') == 'L' ? 'selected' : '' }}>
                            Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', isset($asesi) ? $asesi->jenis_kelamin : '') == 'P' ? 'selected' : '' }}>
                            Perempuan</option>
                    </select>
                    <div class="invalid-feedback">
                        @error('jenis_kelamin') {{ $message }} @else Jenis kelamin wajib dipilih. @enderror
                    </div>
                </div>

                <!-- Kebangsaan -->
                <div class="mb-3">
                    <label class="form-label">Kebangsaan <span class="text-danger">*</span></label>
                    <input type="text" name="kebangsaan" class="form-control @error('kebangsaan') is-invalid @enderror"
                        value="{{ old('kebangsaan', isset($asesi) ? $asesi->kebangsaan : 'Indonesia') }}" placeholder="Masukkan kebangsaan"
                        required data-msg="Kebangsaan wajib diisi.">
                    <div class="invalid-feedback">
                        @error('kebangsaan') {{ $message }} @else Kebangsaan wajib diisi. @enderror
                    </div>
                </div>

                <!-- Alamat Rumah -->
                <div class="mb-3">
                    <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                    <input type="text" name="alamat_rumah" class="form-control @error('alamat_rumah') is-invalid @enderror"
                        value="{{ old('alamat_rumah', isset($asesi) ? $asesi->alamat_rumah : '') }}" placeholder="Masukkan alamat rumah"
                        required data-msg="Alamat rumah wajib diisi.">
                    <div class="invalid-feedback">
                        @error('alamat_rumah') {{ $message }} @else Alamat rumah wajib diisi. @enderror
                    </div>
                </div>

                <!-- Kode Pos Rumah -->
                <div class="mb-3">
                    <label class="form-label">Kode Pos Rumah <span class="text-danger">*</span></label>
                    <input type="text" name="kode_pos_rumah" class="form-control @error('kode_pos_rumah') is-invalid @enderror"
                        value="{{ old('kode_pos_rumah', isset($asesi) ? $asesi->kode_pos_rumah : '') }}" placeholder="Kode pos"
                        required pattern="\d{5}" title="Kode pos harus 5 digit angka" data-msg="Kode pos harus 5 digit angka.">
                    <div class="invalid-feedback">
                        @error('kode_pos_rumah') {{ $message }} @else Kode pos rumah wajib 5 digit angka. @enderror
                    </div>
                </div>

                <!-- Telepon Rumah -->
                <div class="mb-3">
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
                <div class="mb-3">
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
                <div class="mb-3">
                    <label class="form-label">E-mail <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email', isset($asesi) ? $asesi->email : (auth()->user()->email ?? '')) }}"
                        placeholder="Masukkan email" required data-msg="Masukkan alamat email yang valid.">
                    <div class="invalid-feedback">
                        @error('email') {{ $message }} @else Email wajib diisi dan harus format email. @enderror
                    </div>
                </div>

                <!-- Kualifikasi Pendidikan -->
                <div class="mb-3">
                    <label class="form-label">Kualifikasi Pendidikan <span class="text-danger">*</span></label>
                    <input type="text" name="kualifikasi_pendidikan" class="form-control @error('kualifikasi_pendidikan') is-invalid @enderror"
                        value="{{ old('kualifikasi_pendidikan', isset($asesi) ? ($asesi->kualifikasi_pendidikan ?? $asesi->pendidikan_terakhir ?? '') : '') }}"
                        placeholder="Contoh: SMK - Desain Komunikasi Visual" required data-msg="Kualifikasi pendidikan wajib diisi.">
                    <div class="invalid-feedback">
                        @error('kualifikasi_pendidikan') {{ $message }} @else Kualifikasi pendidikan wajib diisi. @enderror
                    </div>
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
                    <input type="text" name="nama_institusi" class="form-control @error('nama_institusi') is-invalid @enderror"
                        value="{{ old('nama_institusi', isset($asesi) ? $asesi->nama_institusi : '') }}"
                        placeholder="Nama sekolah atau perusahaan" required data-msg="Nama institusi wajib diisi.">
                    <div class="invalid-feedback">
                        @error('nama_institusi') {{ $message }} @else Nama institusi wajib diisi. @enderror
                    </div>
                </div>

                <!-- Jabatan -->
                <div class="mb-3">
                    <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                    <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                        value="{{ old('jabatan', isset($asesi) ? $asesi->jabatan : '') }}"
                        placeholder="Jabatan / status (mis. Siswa, Staff, Freelancer)" required data-msg="Jabatan wajib diisi.">
                    <div class="invalid-feedback">
                        @error('jabatan') {{ $message }} @else Jabatan wajib diisi. @enderror
                    </div>
                </div>

                <!-- Alamat Kantor -->
                <div class="mb-3">
                    <label class="form-label">Alamat Kantor / Sekolah <span class="text-danger">*</span></label>
                    <input type="text" name="alamat_kantor" class="form-control @error('alamat_kantor') is-invalid @enderror"
                        value="{{ old('alamat_kantor', isset($asesi) ? $asesi->alamat_kantor : '') }}"
                        placeholder="Alamat institusi/perusahaan" required data-msg="Alamat kantor wajib diisi.">
                    <div class="invalid-feedback">
                        @error('alamat_kantor') {{ $message }} @else Alamat kantor wajib diisi. @enderror
                    </div>
                </div>

                <!-- Kode Pos Kantor -->
                <div class="mb-3">
                    <label class="form-label">Kode Pos Kantor <span class="text-danger">*</span></label>
                    <input type="text" name="kode_pos_kantor" class="form-control @error('kode_pos_kantor') is-invalid @enderror"
                        value="{{ old('kode_pos_kantor', isset($asesi) ? $asesi->kode_pos_kantor : '') }}" placeholder="Kode pos"
                        required pattern="\d{5}" title="Kode pos harus 5 digit angka" data-msg="Kode pos kantor harus 5 digit angka.">
                    <div class="invalid-feedback">
                        @error('kode_pos_kantor') {{ $message }} @else Kode pos kantor wajib 5 digit angka. @enderror
                    </div>
                </div>

                <!-- Telepon Kantor -->
                <div class="mb-3">
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
                <div class="mb-3">
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
                <div class="mb-3">
                    <label class="form-label">E-mail Kantor <span class="text-danger">*</span></label>
                    <input type="email" name="email_kantor" class="form-control @error('email_kantor') is-invalid @enderror"
                        value="{{ old('email_kantor', isset($asesi) ? $asesi->email_kantor : '') }}" placeholder="Email kantor / sekolah"
                        required data-msg="Masukkan alamat email kantor yang valid.">
                    <div class="invalid-feedback">
                        @error('email_kantor') {{ $message }} @else Email kantor wajib diisi dan harus format email. @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol -->
            <div class="button-group mt-4">
                <a href="{{ route('form_pra_assesmen') }}" class="btn-back">Kembali</a>
                <button type="submit" class="btn-next">Selanjutnya</button>
            </div>
        </form>
    </div>

    <style>
        /* (tetap seperti style sebelumnya, dengan penyesuaian untuk invalid-feedback default hidden) */
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

        /* input invalid style (keystyling kept) */
        .form-control.is-invalid,
        .form-select.is-invalid {
            border: 2px solid #d9534f !important;
            background: #fff8f8 !important;
        }

        /* invalid-feedback hidden by default; shown only when input/select has is-invalid directly before it */
        .invalid-feedback {
            font-size: 12px;
            display: none;
            color: #d9534f;
        }

        /* show invalid-feedback when the preceding input/select has is-invalid */
        .form-control.is-invalid + .invalid-feedback,
        .form-select.is-invalid + .invalid-feedback {
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

    // serverErrors keyed by field (if any)
    const serverErrors = @json($errors->getMessages());

    // maintain a map of current messages (keyed by field name) to show in the alert summary
    const messagesMap = {};

    // initialize messagesMap from serverErrors (if any)
    if (serverErrors && Object.keys(serverErrors).length > 0) {
        Object.keys(serverErrors).forEach(field => {
            // take first message for that field
            const msg = serverErrors[field] && serverErrors[field].length ? serverErrors[field][0] : null;
            if (msg) messagesMap[field] = msg;
        });
        updateAlertFromMap(true); // initial server errors -> scroll to alert
        // focus the first invalid field (Blade already added .is-invalid server-side)
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
        // show up to 10 messages
        const list = msgs.slice(0,10).map(m => `<li>${m}</li>`).join('');
        alertBox.innerHTML = `<strong>Perhatikan:</strong><ul class="mb-0 mt-2">${list}</ul>`;
        // scroll to alert for visibility only when requested
        if (doScroll) {
            alertBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    // helper to set a field invalid with message (client-side)
    function setFieldInvalid(fieldEl, msg) {
        fieldEl.classList.add('is-invalid');
        // set text of the adjacent .invalid-feedback so user sees message under field
        const fb = fieldEl.parentElement.querySelector('.invalid-feedback');
        if (fb) fb.textContent = msg;
        messagesMap[fieldEl.getAttribute('name')] = msg;
    }

    // helper to clear invalid state for a field and remove its message from map
    function clearFieldInvalid(fieldEl) {
        fieldEl.classList.remove('is-invalid');
        const fieldName = fieldEl.getAttribute('name');
        // Remove this field's message from messagesMap
        if (messagesMap[fieldName]) {
            delete messagesMap[fieldName];
            updateAlertFromMap(false); // do NOT scroll when user is fixing fields
        } else {
            // still update alert in case other messages exist (no scroll)
            updateAlertFromMap(false);
        }
    }

    // main submit handler: validate required & patterns using HTML5 validity
    form.addEventListener('submit', function (e) {
        let hasError = false;

        // We'll validate all required fields and fields with patterns
        const fields = Array.from(form.querySelectorAll('input, select, textarea'));

        fields.forEach(field => {
            // skip fields without name or that are disabled/hidden in disabled fieldset
            if (!field.name || field.disabled || field.closest('fieldset[disabled]')) return;

            // treat fields with required attribute / pattern / type validation
            const isRequired = field.hasAttribute('required');
            const value = (field.value || '').toString().trim();

            // Clear previous client-side messages for this validation pass (but keep server-provided is-invalid if serverErrors exist)
            const fieldName = field.getAttribute('name');
            const serverHas = serverErrors && serverErrors[fieldName] && serverErrors[fieldName].length;

            // If server had errors and we haven't changed the field yet, keep the server is-invalid (we will remove when user edits)
            if (!serverHas) {
                field.classList.remove('is-invalid');
            }

            if (isRequired && !value) {
                hasError = true;
                const msg = field.dataset.msg || 'Field ini wajib diisi.';
                setFieldInvalid(field, msg);
                return;
            }

            // pattern/type checks using HTML5 validity
            if (value && !field.checkValidity()) {
                hasError = true;
                const msg = field.dataset.msg || field.title || field.validationMessage || 'Format tidak valid.';
                setFieldInvalid(field, msg);
                return;
            }

            // if reach here, field is valid -> ensure it's cleared from messagesMap (client-side)
            if (!serverHas) {
                if (messagesMap[fieldName]) {
                    delete messagesMap[fieldName];
                }
            }
        });

        if (hasError) {
            e.preventDefault();
            updateAlertFromMap(true); // on submit errors -> scroll to alert
            // focus first invalid
            const first = form.querySelector('.is-invalid');
            if (first) {
                setTimeout(() => {
                    first.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    first.focus();
                }, 120);
            }
        } else {
            // no client-side error -> clear alert summary (server will handle backend validation)
            alertBox.classList.add('d-none');
            alertBox.innerHTML = '';
            // allow form submission proceed
        }
    });

    // when user types/changes a field: if it has is-invalid -> re-validate and remove invalid if fixed
    form.querySelectorAll('input, select, textarea').forEach(field => {
        // skip fields without name
        if (!field.name) return;

        field.addEventListener('input', function () {
            const value = (this.value || '').toString().trim();
            if (value && this.checkValidity()) {
                // valid now -> clear invalid state and remove its message from map WITHOUT SCROLL
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
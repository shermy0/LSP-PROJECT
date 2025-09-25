@extends('master')

@section('title', 'FR.APL.01 - Permohonan Sertifikasi Kompetensi')

@section('konten')
    <div class="container mt-2 my-5">
        <div class="bg-white border rounded-3 shadow-sm p-4">

            <!-- Header -->
            <div class="mb-4">
                <p class="small text-muted mb-1">Form Asesmen &gt; <span class="fw-semibold">FR.APL.01</span></p>
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="rounded mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                    <h1 class="h5 fw-bold">Permohonan Sertifikasi Kompetensi</h1>
                    <span class="badge bg-light text-dark mt-2 px-3 py-2 rounded-pill">
                        Rincian Data Pemohon Sertifikasi
                    </span>
                </div>
            </div>

            <!-- Form -->
            <form id="formApl01" action="{{ route('asesi.permohonan.store') }}" method="POST" novalidate>
                @csrf

                <!-- Data Pribadi -->
                <div class="border rounded-3 p-3 mb-4">
                    <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                        <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start"
                              style="width:8px;"></span>
                        &nbsp;&nbsp;Data Pribadi
                    </div>

                    <!-- Nama Lengkap -->
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                        @if(!empty($asesi->nama_lengkap))
                            <input type="text" class="form-control rounded-3" value="{{ $asesi->nama_lengkap }}" readonly>
                            <input type="hidden" name="nama_lengkap" value="{{ $asesi->nama_lengkap }}">
                        @else
                            <input type="text" name="nama_lengkap" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan nama" value="{{ old('nama_lengkap') }}" required>
                            <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
                        @endif
                    </div>

                    <!-- NIK -->
                    <div class="mb-3">
                        <label class="form-label">No. KTP/NIK/Paspor <span class="text-danger">*</span></label>
                        @if(!empty($asesi->nik))
                            <input type="text" class="form-control rounded-3" value="{{ $asesi->nik }}" readonly>
                            <input type="hidden" name="nik" value="{{ $asesi->nik }}">
                        @else
                            <input type="text" name="nik" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan nomor identitas" value="{{ old('nik') }}" required>
                            <div class="invalid-feedback">Nomor identitas wajib diisi.</div>
                        @endif
                    </div>

                    <!-- Tanggal Lahir -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                        @if(!empty($asesi->tgl_lahir))
                            <input type="date" class="form-control rounded-3" value="{{ $asesi->tgl_lahir }}" readonly>
                            <input type="hidden" name="tgl_lahir" value="{{ $asesi->tgl_lahir }}">
                        @else
                            <input type="date" name="tgl_lahir" class="form-control rounded-3 required-field"
                                   value="{{ old('tgl_lahir') }}" required>
                            <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
                        @endif
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        @if(!empty($asesi->jenis_kelamin))
                            <input type="text" class="form-control rounded-3"
                                   value="{{ $asesi->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly>
                            <input type="hidden" name="jenis_kelamin" value="{{ $asesi->jenis_kelamin }}">
                        @else
                            <select name="jenis_kelamin" class="form-select rounded-3 required-field" required>
                                <option value="">Pilih</option>
                                <option value="L" {{ old('jenis_kelamin')=='L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin')=='P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            <div class="invalid-feedback">Jenis kelamin wajib dipilih.</div>
                        @endif
                    </div>

                    <!-- Alamat -->
                    <div class="mb-3">
                        <label class="form-label">Alamat Rumah <span class="text-danger">*</span></label>
                        @if(!empty($asesi->alamat))
                            <input type="text" class="form-control rounded-3" value="{{ $asesi->alamat }}" readonly>
                            <input type="hidden" name="alamat" value="{{ $asesi->alamat }}">
                        @else
                            <input type="text" name="alamat" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan alamat" value="{{ old('alamat') }}" required>
                            <div class="invalid-feedback">Alamat wajib diisi.</div>
                        @endif
                    </div>

                    <!-- Telepon -->
                    <div class="mb-3">
                        <label class="form-label">No Telepon <span class="text-danger">*</span></label>
                        @if(!empty($asesi->telepon))
                            <input type="text" class="form-control rounded-3" value="{{ $asesi->telepon }}" readonly>
                            <input type="hidden" name="telepon" value="{{ $asesi->telepon }}">
                        @else
                            <input type="text" name="telepon" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan nomor telepon" value="{{ old('telepon') }}" required>
                            <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
                        @endif
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        @if(!empty($asesi->email))
                            <input type="email" class="form-control rounded-3" value="{{ $asesi->email }}" readonly>
                            <input type="hidden" name="email" value="{{ $asesi->email }}">
                        @else
                            <input type="email" name="email" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                            <div class="invalid-feedback">Email wajib diisi.</div>
                        @endif
                    </div>

                    <!-- Pendidikan -->
                    <div class="mb-3">
                        <label class="form-label">Kualifikasi Pendidikan <span class="text-danger">*</span></label>
                        @if(!empty($asesi->pendidikan_terakhir))
                            <input type="text" class="form-control rounded-3" value="{{ $asesi->pendidikan_terakhir }}" readonly>
                            <input type="hidden" name="pendidikan_terakhir" value="{{ $asesi->pendidikan_terakhir }}">
                        @else
                            <input type="text" name="pendidikan_terakhir" class="form-control rounded-3 required-field"
                                   placeholder="Masukkan pendidikan terakhir" value="{{ old('pendidikan_terakhir') }}" required>
                            <div class="invalid-feedback">Pendidikan terakhir wajib diisi.</div>
                        @endif
                    </div>
                </div>

                <!-- Data Pekerjaan (ambil dari TUK) -->
                <div class="border rounded-3 p-3 mb-4">
                    <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                        <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                        &nbsp;&nbsp;Data Pekerjaan
                    </div>
                    <div class="px-2">
                        <p><strong>Nama Sekolah</strong> : {{ $tuk->nama_tuk }}</p>
                        <p><strong>Jabatan</strong> : {{ $tuk->jabatan }}</p>
                        <p><strong>Alamat</strong> : {{ $tuk->alamat_tuk }}</p>
                        <p><strong>Telepon</strong> : <a href="tel:{{ $tuk->telepon }}" class="text-primary">{{ $tuk->telepon }}</a></p>
                        <p><strong>Fax</strong> : {{ $tuk->fax ?? '-' }}</p>
                        <p><strong>Email</strong> : {{ $tuk->email }}</p>
                    </div>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn" style="background-color:#041562; color:#fff;">Selanjutnya</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Validasi -->
    <script>
        document.getElementById('formApl01').addEventListener('submit', function (e) {
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

        // hilangkan merah saat user isi field
        document.querySelectorAll('.required-field').forEach(field => {
            field.addEventListener('input', function () {
                if (this.value) {
                    this.classList.remove('is-invalid');
                }
            });
        });
    </script>
@endsection

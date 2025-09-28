@extends('master')

@section('title', 'FR.APL.01 - Permohonan Sertifikasi Kompetensi')

@section('konten')
<div class="container">
    <form id="formApl01" action="{{ route('asesi.permohonan.store') }}" method="POST">
        @csrf

        <!-- Header -->
        <div class="text-center mb-4">
            <div class="rounded mx-auto mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
            <h1 class="h5 fw-bold">Permohonan Sertifikasi Kompetensi</h1>
            <p class="small text-muted">Form Asesmen &gt; FR.APL.01</p>
        </div>

        <!-- Data Pribadi -->
        <div class="unit-header">
            <p class="mb-1 fw-semibold">Data Pribadi</p>
            <p class="mb-0">Lengkapi data pribadi peserta sertifikasi</p>
        </div>

        <div class="question-box">
            <!-- Nama Lengkap -->
            <div class="mb-3">
                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                <input type="text" name="nama_lengkap"
                       class="form-control"
                       value="{{ old('nama_lengkap', $asesi->nama_lengkap ?? '') }}"
                       placeholder="Masukkan nama lengkap"
                       required {{ !empty($asesi->nama_lengkap) ? 'readonly' : '' }}>
                <div class="invalid-feedback">Nama lengkap wajib diisi.</div>
            </div>

            <!-- NIK -->
            <div class="mb-3">
                <label class="form-label">No. KTP/NIK/Paspor <span class="text-danger">*</span></label>
                <input type="text" name="nik"
                       class="form-control"
                       value="{{ old('nik', $asesi->nik ?? '') }}"
                       placeholder="Masukkan nomor identitas"
                       required {{ !empty($asesi->nik) ? 'readonly' : '' }}>
                <div class="invalid-feedback">Nomor identitas wajib diisi.</div>
            </div>

            <!-- Tanggal Lahir -->
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                <input type="{{ empty($asesi->tgl_lahir) ? 'date' : 'text' }}" name="tgl_lahir"
                       class="form-control"
                       value="{{ old('tgl_lahir', $asesi->tgl_lahir ?? '') }}"
                       required {{ !empty($asesi->tgl_lahir) ? 'readonly' : '' }}>
                <div class="invalid-feedback">Tanggal lahir wajib diisi.</div>
            </div>

            <!-- Jenis Kelamin -->
            <div class="mb-3">
                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                @if(!empty($asesi->jenis_kelamin))
                    <input type="text" class="form-control"
                           value="{{ $asesi->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}" readonly>
                    <input type="hidden" name="jenis_kelamin" value="{{ $asesi->jenis_kelamin }}">
                @else
                    <select name="jenis_kelamin" class="form-select" required>
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
                <input type="text" name="alamat"
                       class="form-control"
                       value="{{ old('alamat', $asesi->alamat ?? '') }}"
                       placeholder="Masukkan alamat"
                       required {{ !empty($asesi->alamat) ? 'readonly' : '' }}>
                <div class="invalid-feedback">Alamat wajib diisi.</div>
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label class="form-label">No Telepon <span class="text-danger">*</span></label>
                <input type="text" name="telepon"
                       class="form-control"
                       value="{{ old('telepon', $asesi->telepon ?? '') }}"
                       placeholder="Masukkan nomor telepon"
                       required {{ !empty($asesi->telepon) ? 'readonly' : '' }}>
                <div class="invalid-feedback">Nomor telepon wajib diisi.</div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email"
                       class="form-control"
                       value="{{ old('email', $asesi->email ?? auth()->user()->email ?? '') }}"
                       placeholder="Masukkan email"
                       required {{ !empty($asesi->email) ? 'readonly' : '' }}>
                <div class="invalid-feedback">Email wajib diisi.</div>
            </div>

            <!-- Pendidikan -->
            <div class="mb-0">
                <label class="form-label">Kualifikasi Pendidikan <span class="text-danger">*</span></label>
                <input type="text" name="pendidikan_terakhir"
                       class="form-control"
                       value="{{ old('pendidikan_terakhir', $asesi->pendidikan_terakhir ?? '') }}"
                       placeholder="Masukkan pendidikan terakhir"
                       required {{ !empty($asesi->pendidikan_terakhir) ? 'readonly' : '' }}>
                <div class="invalid-feedback">Pendidikan terakhir wajib diisi.</div>
            </div>
        </div>

        <!-- Data Pekerjaan -->
        <div class="unit-header">
            <p class="mb-1 fw-semibold">Data Pekerjaan</p>
            <p class="mb-0">Informasi pekerjaan atau lembaga tempat peserta</p>
        </div>

        <div class="question-box">
            <p><strong>Nama Sekolah:</strong> {{ $tuk->nama_tuk }}</p>
            <p><strong>Jabatan:</strong> {{ $tuk->jabatan }}</p>
            <p><strong>Alamat:</strong> {{ $tuk->alamat_tuk }}</p>
            <p><strong>Telepon:</strong> <a href="tel:{{ $tuk->telepon }}" class="text-primary">{{ $tuk->telepon }}</a></p>
            <p><strong>Fax:</strong> {{ $tuk->fax ?? '-' }}</p>
            <p><strong>Email:</strong> {{ $tuk->email }}</p>
        </div>

        <!-- Tombol -->
        <div class="button-group mt-4">
            <a href="{{ route('dashboard') }}" class="btn-back">Kembali</a>
            <button type="submit" class="btn-next">Selanjutnya</button>
        </div>
    </form>
</div>
@endsection

<style>
    body { font-family: 'Poppins', sans-serif; background: #f9f9fb; }
    .container { max-width: 850px; margin: 20px auto; }
    .unit-header {
        background: #E9F1FF;
        border-left: 6px solid #007BFF;
        border-radius: 8px;
        padding: 15px 20px;
        margin-bottom: 20px;
        font-size: 14px;
    }
    .question-box {
        border: 1px solid #ddd;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        background: #fff;
    }
    .form-control.is-invalid, .form-select.is-invalid {
        border: 2px solid #d9534f !important;
        background: #fff8f8 !important;
    }
    .invalid-feedback {
        font-size: 12px;
    }
    .button-group { display: flex; justify-content: flex-end; gap: 12px; }
    .btn-back { background: #d9534f; color: #fff; padding: 10px 20px; border-radius: 8px; font-weight: 600; text-decoration: none; }
    .btn-next { background: #041562; color: #fff; padding: 10px 24px; border-radius: 8px; font-weight: 600; border: none; }
    .btn-back:hover { background: #c9302c; }
    .btn-next:hover { background: #06208a; }
</style>

<script>
document.getElementById('formApl01').addEventListener('submit', function (e) {
    let valid = true;
    let firstInvalid = null;

    this.querySelectorAll('[required]').forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            valid = false;
            if (!firstInvalid) firstInvalid = field;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    if (!valid) {
        e.preventDefault();
        if (firstInvalid) {
            firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
            firstInvalid.focus();
        }
    }
});

// Hilangkan merah saat user isi
document.querySelectorAll('[required]').forEach(field => {
    field.addEventListener('input', function () {
        if (this.value.trim()) {
            this.classList.remove('is-invalid');
        }
    });
});
</script>

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
            <form action="{{ route('asesi.permohonan.store') }}" method="POST">
                @csrf

                <!-- Data Pribadi -->
                <div class="border rounded-3 p-3 mb-4">
                    <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                        <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                        &nbsp;&nbsp;Data Pribadi
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" class="form-control rounded-3"
                               placeholder="Masukkan nama"
                               value="{{ old('nama_lengkap', $asesi->nama_lengkap ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No. KTP/NIK/Paspor</label>
                        <input type="text" name="nik" class="form-control rounded-3"
                               placeholder="Masukkan nomor identitas"
                               value="{{ old('nik', $asesi->nik ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control rounded-3"
                               value="{{ old('tgl_lahir', $asesi->tgl_lahir ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" class="form-select rounded-3">
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jenis_kelamin', $asesi->jenis_kelamin ?? '')=='L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $asesi->jenis_kelamin ?? '')=='P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Rumah</label>
                        <input type="text" name="alamat" class="form-control rounded-3"
                               placeholder="Masukkan alamat"
                               value="{{ old('alamat', $asesi->alamat ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No Telepon</label>
                        <input type="text" name="telepon" class="form-control rounded-3"
                               placeholder="Masukkan nomor telepon"
                               value="{{ old('telepon', $asesi->telepon ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control rounded-3"
                               placeholder="Masukkan email"
                               value="{{ old('email', $asesi->email ?? auth()->user()->email ?? '') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kualifikasi Pendidikan</label>
                        <input type="text" name="pendidikan_terakhir" class="form-control rounded-3"
                               placeholder="Masukkan pendidikan terakhir"
                               value="{{ old('pendidikan_terakhir', $asesi->pendidikan_terakhir ?? '') }}">
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
                        <p><strong>Telepon</strong> :
                            <a href="tel:{{ $tuk->telepon }}" class="text-primary">{{ $tuk->telepon }}</a>
                        </p>
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
@endsection

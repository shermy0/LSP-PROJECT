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

            <!-- Data Pribadi -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Pribadi
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control rounded-3" placeholder="Masukkan nama">
                </div>
                <div class="mb-3">
                    <label class="form-label">No. KTP/NIK/Paspor</label>
                    <input type="text" class="form-control rounded-3" placeholder="Masukkan nomor identitas">
                </div>
                <div class="mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control rounded-3">
                </div>
                <div class="mb-3">
                    <label class="form-label">Jenis Kelamin</label>
                    <select class="form-select rounded-3">
                        <option selected>Pilih</option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Alamat Rumah</label>
                    <input type="text" class="form-control rounded-3" placeholder="Masukkan alamat">
                </div>
                <div class="mb-3">
                    <label class="form-label">No Telepon/Email</label>
                    <input type="text" class="form-control rounded-3" placeholder="Masukkan kontak">
                </div>
                <div class="mb-3">
                    <label class="form-label">Kualifikasi Pendidikan</label>
                    <input type="text" class="form-control rounded-3" placeholder="Masukkan pendidikan">
                </div>
            </div>

            <!-- Data Pekerjaan -->
            <div class="border rounded-3 p-3 mb-4">
                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Data Pekerjaan
                </div>

                <div class="px-2">
                    <p><strong>Nama Sekolah</strong> : SMK Negeri 11 Bandung</p>
                    <p><strong>Jabatan</strong> : SMK Negeri 11 Bandung</p>
                    <p><strong>Alamat</strong> : Jl. Raya Cilember, RT.01/RW.04, Sukaraja, Kec. Cicendo, Kota Bandung, Jawa
                        Barat 40153</p>
                    <p><strong>Telepon</strong> : <a href="tel:0226652442" class="text-primary">022-6652442</a></p>
                    <p><strong>Fax</strong> : -</p>
                    <p><strong>Email</strong> : smkn11bdg@gmail.com</p>
                </div>
            </div>

            <!-- Button -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('asesi.permohonan.form2') }}" class="btn"
                    style="background-color:#041562; color:#fff;">Selanjutnya</a>
            </div>

        </div>
    </div>
@endsection
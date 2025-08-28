@extends('master')
@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('ninjau_asesemen') }}">FR.AK.06</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                Komentar Asesor & Tanda Tangan
            </li>
        </ol>
    </nav>
</div>

<!-- Komentar dan TTD -->
<div class="card-box">
    <div class="komen_ttd-box">
        <div class="komen_ttd-header">Komentar Asesor & Tanda Tangan</div>
    </div>
    <h5 style="text-align: left;">Asesor</h5>
    <div class="col-md-12">
        <label for="namaAsesor" class="form-label fw-semibold">Nama Asesor</label>
        <input type="text" class="form-control" id="namaAsesor" placeholder="Nama Asesor">
    </div>
    <div class="col-md-12">
        <label for="nomorregistrasi" class="form-label fw-semibold">Nomor Registrasi</label>
        <input type="text" class="form-control" id="nomorregistrasi" placeholder="Nomor Registrasi">
    </div>
    <div class="col-md-12">
        <label for="tanggalAsesmen" class="form-label fw-semibold">Tanggal Asesmen</label>
        <input type="date" class="form-control" id="tanggalAsesmen">
    </div>
    <div class="col-md-12">
        <label for="komentar" class="form-label fw-semibold">Komentar</label>
        <textarea id="rekomendasi" class="form-control mt-2" rows="3" placeholder="Masukkan Komentar Anda"></textarea>
    </div>
</div>

<form id="simpan-form" action="{{ route('formperencanaan') }}" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan</span>
    </button>
</form>

@endsection

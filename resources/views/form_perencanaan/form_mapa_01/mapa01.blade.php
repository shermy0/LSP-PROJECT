@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="container mt-4">

    <!-- Card utama -->
    <div class="card mapa-card">
    <!-- Breadcrumb -->
        <div class="mapa-breadcrumb">
            <a href="{{ route('formperencanaan') }}">Form Perencanaan</a> > 
            <span class="active">FR.MAPA.01</span>
        </div>
        <div class="text-center mb-4">
            <div class="mapa-logo"></div>
            <h4 class="mapa-title">FR.MAPA.01 – MERENCANAKAN AKTIVITAS DAN PROSES ASESMEN</h4>
        </div>

        <!-- Dropdown skema -->
        <div class="text-center mb-4">
            <span class="fw-semibold">SKEMA:</span>
            <select class="mapa-dropdown">
                <option selected>JUNIOR OPERATOR DESAIN GRAFIS</option>
                <option>Skema Lain</option>
            </select>
        </div>

        <!-- Form input -->
        <div class="row g-3">
            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                    <div class="jenis-skema">
                        <input type="radio" id="kkni" name="skema" class="form-check-input me-2">
                        <label for="kkni">KKNI</label>
                        <input type="radio" id="okupasi" name="skema" class="form-check-input me-2" checked>
                        <label for="okupasi">Okupasi</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mapa-box">
                    <label for="nomorSkema" class="fw-semibold d-block mb-2">Nomor</label>
                    <input type="text" id="nomorSkema" class="form-control" placeholder="Nomor Skema">
                </div>
            </div>
        </div>
    </div>

    <!-- Menentukan Pendekatan Asesmen -->
<div class="mapa-section">
        <div class="card mapa-card">

    <div class="mapa-section-header-light">Menentukan Pendekatan Asesmen</div>

    <div class="mapa-subsection">
        <div class="mapa-subsection-header">Asesi</div>
        <div class="mapa-options">
            <div>
                <input type="checkbox" id="asesi1" name="asesi[]" value="Pelatihan dengan kurikulum & fasilitas sesuai standar" class="form-check-input me-2">
                <label for="asesi1">Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi</label>
            </div>
            <div>
                <input type="checkbox" id="asesi2" name="asesi[]" value="Pelatihan dengan kurikulum belum berbasis kompetensi" class="form-check-input me-2">
                <label for="asesi2">Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi</label>
            </div>
            <div>
                <input type="checkbox" id="asesi3" name="asesi[]" value="Pekerja berpengalaman kompeten" class="form-check-input me-2">
                <label for="asesi3">Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi</label>
            </div>
            <div>
                <input type="checkbox" id="asesi4" name="asesi[]" value="Pekerja berpengalaman belum kompeten" class="form-check-input me-2">
                <label for="asesi4">Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi</label>
            </div>
            <div>
                <input type="checkbox" id="asesi5" name="asesi[]" value="Belajar mandiri/otodidak" class="form-check-input me-2">
                <label for="asesi5">Pelatihan / belajar mandiri atau otodidak.</label>
            </div>
        </div>
    </div>
        </div>
</div>


</div>
@endsection

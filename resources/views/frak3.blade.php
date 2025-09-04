@extends('master')

@section('konten')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Asesmen</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.AK.03</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.03 Umpan Balik dan Catatan Asesmen</h3>
        <h5>Skema: <span class="text-primary fw-semibold">JUNIOR OPERATOR DESAIN GRAFIS</span></h5>
    </div>

    <!-- Form -->
    <form id="frak03-form" action="{{ route('frak3.simpan') }}" method="POST" class="simpan-form">
        @csrf

        <!-- Identitas -->
        <div class="card-box mb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Skema Sertifikasi</label>
                    <div class="d-flex gap-3">
                        <label><input type="radio" name="skema" value="KKNI"> KKNI</label>
                        <label><input type="radio" name="skema" value="Okupasi"> Okupasi</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nomor</label>
                    <input type="text" class="form-control" name="nomor_skema" placeholder="Nomor Skema">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Asesor</label>
                    <input type="text" class="form-control" name="nama_asesor" placeholder="Nama Asesor">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Nama Asesi</label>
                    <input type="text" class="form-control" name="nama_asesi" placeholder="Nama Asesi">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tempat</label>
                    <input type="text" class="form-control" name="tempat" placeholder="Tempat Asesmen">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Tanggal Asesmen</label>
                    <input type="date" class="form-control" name="tanggal_mulai">
                </div>
            </div>
        </div>

        <!-- Pertanyaan -->
        <div class="card-box">
            <div class="judul-box"><div class="judul-header">Umpan balik dari Asesi</div></div>

            @for($i = 1; $i <= 10; $i++)
                <div class="box mb-3">
                    <div class="box-header">
                        @switch($i)
                            @case(1) Saya mendapatkan penjelasan yang cukup memadai mengenai proses asesmen/uji kompetensi @break
                            @case(2) Saya diberikan kesempatan untuk mempelajari standar kompetensi yang akan diuji dan menilai diri sendiri terhadap pencapaiannya @break
                            @case(3) Asesor memberikan kesempatan untuk mendiskusikan/menegosiasikan metoda, instrumen dan sumber asesmen serta jadwal asesmen @break
                            @case(4) Asesor berusaha menggali seluruh bukti pendukung yang sesuai dengan latar belakang pelatihan dan pengalaman yang saya miliki @break
                            @case(5) Saya sepenuhnya diberikan kesempatan untuk mendemonstrasikan kompetensi yang relevan dengan skema asesmen @break
                            @case(6) Saya mendapatkan penjelasan yang memadai mengenai keputusan asesmen @break
                            @case(7) Asesor memberikan umpan balik yang mendukung setelah asesmen serta tindak lanjutnya @break
                            @case(8) Asesor bersama saya mengidentifikasi semua dokumen asesmen serta menandatanganinya @break
                            @case(9) Saya mendapatkan jaminan kerahasiaan hasil asesmen serta penyimpanan dokumen asesmen @break
                            @case(10) Asesor menggunakan keterampilan komunikasi yang efektif selama asesmen @break
                        @endswitch
                    </div>
                    <div class="d-flex gap-3 mt-2">
                        <label><input type="radio" name="q{{ $i }}" value="Ya"> Ya</label>
                        <label><input type="radio" name="q{{ $i }}" value="Tidak"> Tidak</label>
                    </div>
                    <textarea name="catatan{{ $i }}" class="box-input mt-2" rows="2" placeholder="Catatan Asesi"></textarea>
                </div>
            @endfor

            <!-- Catatan tambahan -->
            <div class="box mb-3">
                <div class="box-header">Catatan / Komentar Lainnya</div>
                <textarea name="catatan_lain" class="box-input" rows="3" placeholder="Jika ada, tuliskan di sini"></textarea>
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="simpan-btn mt-4"><span>Simpan</span></button>
    </form>
</div>
@endsection

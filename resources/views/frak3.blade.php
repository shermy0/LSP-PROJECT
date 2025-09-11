@extends('master')

@section('title', 'FR.AK.03 - Umpan Balik dan Catatan Asesmen')

@section('konten')
    <div class="container mt-2 my-5">
        <div class="bg-white border rounded-3 shadow-sm p-4">

            <!-- Header -->
            <div class="mb-4">
                <p class="small text-muted mb-1">Form Asesmen &gt; <span class="fw-semibold">FR.AK.03</span></p>
                <div class="d-flex flex-column align-items-center text-center">
                    <div class="rounded mb-3" style="width:40px; height:40px; background-color:#041562;"></div>
                    <h1 class="h5 fw-bold">FR.AK.03 Umpan Balik dan Catatan Asesmen</h1>
                    <span class="badge bg-light text-dark mt-2 px-3 py-2 rounded-pill">
                        Skema: JUNIOR OPERATOR DESAIN GRAFIS
                    </span>
                </div>
            </div>

            <!-- Form -->
            <form id="frak03-form" action="{{ route('frak3.simpan') }}" method="POST" class="simpan-form">
                @csrf

                <!-- Identitas -->
                <div class="border rounded-3 p-3 mb-4">
                    <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                        <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                        &nbsp;&nbsp;Identitas Asesor & Asesi
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Skema Sertifikasi</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="skema" value="KKNI" id="kkni">
                                    <label class="form-check-label" for="kkni">KKNI</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="skema" value="Okupasi" id="okupasi">
                                    <label class="form-check-label" for="okupasi">Okupasi</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nomor</label>
                            <input type="text" class="form-control rounded-3" name="nomor_skema" placeholder="Nomor Skema">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Asesor</label>
                            <input type="text" class="form-control rounded-3" name="nama_asesor" placeholder="Nama Asesor">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Asesi</label>
                            <input type="text" class="form-control rounded-3" name="nama_asesi" placeholder="Nama Asesi">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat</label>
                            <input type="text" class="form-control rounded-3" name="tempat" placeholder="Tempat Asesmen">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Asesmen</label>
                            <input type="date" class="form-control rounded-3" name="tanggal_mulai">
                        </div>
                    </div>
                </div>

                <!-- Pertanyaan -->
                <div class="border rounded-3 p-3 mb-4">
                    <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                        <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                        &nbsp;&nbsp;Umpan Balik dari Asesi
                    </div>

                    @for($i = 1; $i <= 10; $i++)
                        <div class="mb-4">
                            <label class="fw-semibold d-block mb-2">
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
                            </label>
                            <div class="d-flex gap-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q{{ $i }}" value="Ya" id="q{{ $i }}ya">
                                    <label class="form-check-label" for="q{{ $i }}ya">Ya</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="q{{ $i }}" value="Tidak" id="q{{ $i }}tdk">
                                    <label class="form-check-label" for="q{{ $i }}tdk">Tidak</label>
                                </div>
                            </div>
                            <textarea name="catatan{{ $i }}" class="form-control rounded-3" rows="2" placeholder="Catatan Asesi"></textarea>
                        </div>
                    @endfor

                    <!-- Catatan tambahan -->
                    <div class="mb-3">
                        <label class="fw-semibold d-block mb-2">Catatan / Komentar Lainnya</label>
                        <textarea name="catatan_lain" class="form-control rounded-3" rows="3" placeholder="Jika ada, tuliskan di sini"></textarea>
                    </div>
                </div>

                <!-- Button -->
                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn" style="background-color:#041562; color:#fff;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

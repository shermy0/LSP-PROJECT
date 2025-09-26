@extends('master')
@section('konten')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan(blm gnti disesuaikan)</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.AK.03</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.03 - Umpan Balik dan Catatan Asesmen</h3>
        <p class="text-muted">Umpan Balik dan Catatan Asesmen</p>
    </div>

    <!-- Skema -->
    <div class="skema-container">
        <div class="skema-group">
            <span class="skema-label">SKEMA:</span>
            <select name="skema_id" id="skema_id" class="skema-select">
                <option value="">-- Pilih Skema --</option>
                @foreach($skemas as $skema)
                    <option value="{{ $skema->id_skema }}"
                            data-kode="{{ $skema->kode_skema }}"
                            data-jenjang="{{ $skema->jenjang }}">
                        {{ $skema->nama_skema }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- FORM UTAMA -->
    <form action="{{ route('umpan-balik.store') }}" method="POST">
        @csrf
        <div class="row g-3 mb-4">
            <!-- Skema Sertifikasi -->
            <div class="col-md-6">
                <div class="card-field">
                    <label class="form-label">Skema Sertifikasi</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="skema" id="skema1" value="KKNI">
                            <label class="form-check-label" for="skema1">KKNI</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="skema" id="skema2" value="Okupasi">
                            <label class="form-check-label" for="skema2">Okupasi</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nomor -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="nomor" class="form-label">Nomor</label>
                    <input type="text" class="form-control" id="nomor" name="nomor" readonly>
                </div>
            </div>

            <!-- Nama Asesor -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="namaAsesor" class="form-label">Nama Asesor</label>
                    <select id="namaAsesor" name="asesor_id" class="form-control">
                        <option value="">-- Pilih Asesor --</option>
                    </select>
                </div>
            </div>

            <!-- Tanggal Asesmen -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                    <input type="date" class="form-control" id="tanggalAsesmen" name="tanggal_asesmen">
                </div>
            </div>
        </div>

        <!-- TUK -->
        <div class="col-12 text-center">
            <label class="form-label fw-semibold d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
            <div class="d-flex justify-content-center gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukSewaktu" value="Sewaktu">
                    <label class="form-check-label" for="tukSewaktu">Sewaktu</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukTempatKerja" value="Tempat Kerja">
                    <label class="form-check-label" for="tukTempatKerja">Tempat Kerja</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukMandiri" value="Mandiri">
                    <label class="form-check-label" for="tukMandiri">Mandiri</label>
                </div>
            </div>
        </div>
        <br>
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
                            <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-3 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q{{ $i }}" value="Ya" id="q{{ $i }}ya" required>
                                <label class="form-check-label" for="q{{ $i }}ya">Ya</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="q{{ $i }}" value="Tidak" id="q{{ $i }}tdk" required>
                                <label class="form-check-label" for="q{{ $i }}tdk">Tidak</label>
                            </div>
                        </div>
                        <!-- Catatan tetap opsional -->
                        <textarea name="catatan{{ $i }}" class="form-control rounded-3" rows="2" placeholder="Catatan Asesi (opsional)"></textarea>
                    </div>
                @endfor

                <div class="bg-light position-relative mb-3 px-3 py-2 fw-semibold text-dark rounded">
                    <span class="position-absolute top-0 start-0 h-100 bg-primary rounded-start" style="width:8px;"></span>
                    &nbsp;&nbsp;Catatan / Komentar
                </div>

                <!-- Catatan tambahan -->
                <div class="mb-3">
                    <label class="fw-semibold d-block mb-2">Catatan / Komentar Lainnya (opsional)</label>
                    <textarea name="catatan_lain" class="form-control rounded-3" rows="3" placeholder="Jika ada, tuliskan di sini"></textarea>
                </div>
            </div>

            <!-- Button -->
            <div class="d-flex justify-content-end gap-2">
                <button type="submit" class="btn" style="background-color:#041562; color:#fff;">Simpan</button>
            </div>
    </form>
</div>

<script>
    document.getElementById('skema_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let kode = selected.getAttribute('data-kode');
        let jenjang = selected.getAttribute('data-jenjang');
        let skemaId = this.value;

        document.getElementById('nomor').value = kode || '';

        if (jenjang) {
            if (jenjang.toLowerCase().includes("kkni")) {
                document.getElementById('skema1').checked = true;
            } else if (jenjang.toLowerCase().includes("okupasi")) {
                document.getElementById('skema2').checked = true;
            }
        }

        if(skemaId) {
            fetch(`/get-asesor/${skemaId}`)
                .then(response => response.json())
                .then(data => {
                    let selectAsesor = document.getElementById('namaAsesor');
                    selectAsesor.innerHTML = '<option value="">-- Pilih Asesor --</option>';
                    data.forEach(asesor => {
                        selectAsesor.innerHTML += `<option value="${asesor.id_asesor}">${asesor.nama_asesor}</option>`;
                    });
                });
        }
    });
</script>
@endsection

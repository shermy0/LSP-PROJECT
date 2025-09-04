@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.AK.05</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.05 – LAPORAN ASESMEN</h3>
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

    <!-- Form -->
    <form>
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
                    <input type="text" class="form-control" id="nomor" placeholder="Nomor Skema" readonly>
                </div>
            </div>

            <!-- Nama Asesor -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="namaAsesor" class="form-label">Nama Asesor</label>
                    <input type="text" class="form-control" id="namaAsesor" placeholder="Nama Asesor">
                </div>
            </div>

            <!-- Tanggal Asesmen -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                    <input type="date" class="form-control" id="tanggalAsesmen">
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
    </form>
</div>

<!-- Data Asesi -->
<div class="card-box">
    <div class="judul-box">
        <div class="judul-header">Data Asesi</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table text-center align-middle">
                <thead class="table-title">
                    <tr>
                        <th rowspan="2" class="text-center align-middle">No</th>
                        <th rowspan="2" class="text-center align-middle">Nama Asesi</th>
                        <th colspan="2" class="text-center">Rekomendasi</th>
                        <th rowspan="2" class="text-center align-middle">Keterangan</th>
                    </tr>
                    <tr>
                        <th class="text-center">K</th>
                        <th class="text-center">BK</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1; $i<=5; $i++)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>
                                <input type="text" name="nama[{{ $i }}]" 
                                       class="form-control" 
                                       placeholder="Nama Asesi Otomatis Isi">
                            </td>
                            <td>
                                <input type="radio" name="rekomendasi[{{ $i }}][]" value="K">
                            </td>
                            <td>
                                <input type="radio" name="rekomendasi[{{ $i }}][]" value="BK">
                            </td>
                            <td>
                                <input type="text" name="keterangan[{{ $i }}]" 
                                       class="form-control" 
                                       placeholder="Cari Kode dan Judul unit">
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Catatan Asesmen -->
<div class="card-box">
    <div class="judul-box">
        <div class="judul-header">Catatan Asesmen</div>

        <div class="box">
            <div class="box-header">Aspek Negatif dan Positif dalam Asesmen</div>
            <textarea id="rekomendasi" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
        </div>

        <div class="box">
            <div class="box-header">Pencatatan Penolakan Hasil Asesmen</div>
            <textarea id="rekomendasi" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
        </div>

        <div class="box">
            <div class="box-header">Saran Perbaikan : (Asesor/Personil Terkait)</div>
            <textarea id="rekomendasi" class="box-input" rows="3" placeholder="Masukkan teks"></textarea>
        </div>
    </div>
</div>

<form id="simpan-lanjut-form" action="{{ route('laporan_asesor') }}" method="POST" class="simpan-form">
    @csrf
    <button type="submit" class="simpan-btn">
        <span>Simpan dan Lanjut</span>
    </button>
</form>

<script>
    document.getElementById('skema_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let kode = selected.getAttribute('data-kode');
        let jenjang = selected.getAttribute('data-jenjang');

        // biar bisa isi nomor otomatis
        document.getElementById('nomor').value = kode || '';

        // pilih radio otomatis sesuai skemanya
        if (jenjang) {
            if (jenjang.toLowerCase().includes("kkni")) {
                document.getElementById('skema1').checked = true;
            } else if (jenjang.toLowerCase().includes("okupasi")) {
                document.getElementById('skema2').checked = true;
            }
        }
    });
</script>
@endsection

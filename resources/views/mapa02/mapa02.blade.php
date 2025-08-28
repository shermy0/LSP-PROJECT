@extends('master')
@section('konten')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan') }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.02</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">
            FR.MAPA.02 – PETA INSTRUMEN ASESSMEN HASIL PENDEKATAN ASESMEN DAN PERENCANAAN ASESMEN
        </h3>
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
        </div>
    </form>
</div>

<!-- Judul -->
<div class="card-box">
    <div class="judul-header">Data Asesi</div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered custom-table">
            <thead class="table-title">
                <tr>
                    <th rowspan="2" class="text-center align-middle">No</th>
                    <th rowspan="2" class="text-center align-middle">Kode Unit</th>
                    <th rowspan="2" class="text-center align-middle">Judul Unit</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>J.59MTM00.027.1</td>
                    <td>Mengumpulkan Aset Multimedia</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Instrumen Asesmen -->
<div class="card-box">
    <div class="judul-header">Instrumen Asesmen</div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered custom-table">
            <thead class="table-title">
                <tr>
                    <th rowspan="2" class="text-center align-middle">No</th>
                    <th rowspan="2" class="text-center align-middle">Instrumen Asesi</th>
                    <th colspan="5" class="text-center">Potensi Asesi</th>
                </tr>
                <tr>
                    <th class="text-center">1</th>
                    <th class="text-center">2</th>
                    <th class="text-center">3</th>
                    <th class="text-center">4</th>
                    <th class="text-center">5</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $instrumen = [
                        'FR.IA.01. CL - Ceklis Observasi Aktivitas Di Tempat Kerja atau Tempat Kerja Simulasi',
                        'FR.IA.02. TPD - Tugas Praktik Demonstrasi',
                        'FR.IA.03. PMO – Pertanyaan Untuk Mendukung Observasi',
                        'FR.IA.04. DIT - Daftar Instruksi Tertulis (Pengerjaan Singkat Proyek/Teknik/Pekerjaan/ Kegiatan Terstruktur Lainnya)',
                        'FR.IA.05. DPT – Daftar Pertanyaan Tertulis Pilihan Ganda',
                        'FR.IA.06. DPT – Daftar Pertanyaan Tertulis Pilihan Esai',
                        'FR.IA.07. DPT – Daftar Pertanyaan Uraian',
                        'FR.IA.08. CVP – Ceklis Verifikasi Portofolio',
                        'FR.IA.09. PW – Pertanyaan Wawancara',
                        'FR.IA.10. VPK – Verifikasi Pihak Ketiga',
                        'FR.IA.11. CRP – Ceklis Reviu Produk',
                    ];
                @endphp

                @foreach($instrumen as $i => $judul)
                    <tr>
                        <td class="text-center">{{ $i+1 }}</td>
                        <td>{{ $judul }}</td>
                        @for($j=1; $j<=5; $j++)
                            <td class="text-center">
                                <input type="radio" name="potensi{{ $i+1 }}" value="{{ $j }}">
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-danger mt-2">
            *diisi berdasarkan hasil penentuan pendekatan asesmen dan perencanaan asesmen
        </div>
    </div>
</div>

<!-- Penjelasan -->
<div class="card-box">
    <div class="judul-box">
        <div class="judul-header">Penjelasan</div>
        <ol class="judul-list">
            <li>Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi.</li>
            <li>Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi.</li>
            <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi.</li>
            <li>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi.</li>
            <li>Pelatihan / belajar mandiri atau otodidak</li>
        </ol>
    </div>
</div>

<!-- Simpan dan Lanjut -->
<form id="simpan-lanjut-form" action="{{ route('mapa02_asesor') }}" method="POST" class="simpan-form">
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
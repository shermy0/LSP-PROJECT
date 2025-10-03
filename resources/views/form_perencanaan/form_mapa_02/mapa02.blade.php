@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">
    <div class="card mapa-card">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            @if(isset($skema))
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.02</li>
            @endif
        </ol>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="mapa-logo"></div>
            <h3 class="fw-bold">FR.MAPA.02 – PETA INSTRUMEN ASESSMEN</h3>
            <p class="text-muted">Peninjauan Proses Asesmen</p>
        </div>

        @if(isset($skema))
        <!-- Skema Info -->
        <div class="skema-container mb-4">
            <div class="skema-group">
                <span class="skema-label">SKEMA:</span>
                <span class="skema-select">{{ $skema->nama_skema }}</span>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                    <div class="jenis-skema">
                        <input type="radio" id="kkni" name="skema" class="form-check-input me-2"
                               value="KKNI" @if($skema->jenjang == 'KKNI') checked @endif disabled>
                        <label for="kkni">KKNI</label>

                        <input type="radio" id="okupasi" name="skema" class="form-check-input me-2"
                               value="Okupasi" @if($skema->jenjang == 'Okupasi') checked @endif disabled>
                        <label for="okupasi">Okupasi</label>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mapa-box">
                    <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                    <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Kelompok Pekerjaan (AJAX dinamis) -->
<div id="kelompok-container"></div>

<!-- Instrumen Asesmen -->
<form action="{{ route('mapa02.simpanInstrumen') }}" method="POST">
    @csrf
<input type="hidden" name="skema_id" value="{{ $skema->id_skema }}">

{{-- Looping kelompok pekerjaan --}}
@forelse ($kelompokPekerjaan as $index => $kelompok)
    <div class="mapa-card">
            <div class="judul-header">Kelompok Pekerjaan {{ $index + 1 }}</div>
 <div class="table-responsive mt-4">
        <table class="table table-bordered custom-table">
            <thead class="table-title">
                <tr>
                    <th>Kode Unit</th>
                    <th>Unit Kompetensi</th>
                    {{-- <th>Bukti-Bukti</th>
                    <th>Jenis Bukti</th>
                    <th>Metode dan Perangkat Asesmen</th> --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($kelompok->hasilAsesmen as $hasil)
                    <tr>
                        <td>{{ $hasil->unit->kode_unit ?? '-' }}</td>
                        <td>{{ $hasil->unit->judul_unit ?? '-' }}</td>
                        {{-- <td>{{ $hasil->catatan }}</td>
                        <td>
                            @foreach ($hasil->bukti as $bukti)
                                {{ $bukti->jenisBukti->nama_bukti ?? '-' }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($hasil->perangkat as $perangkat)
                                {{ $perangkat->perangkat->catatan_penerapan ?? '-' }}<br>
                            @endforeach
                        </td> --}}
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center">Belum ada unit ditambahkan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
@empty
    <div class="alert alert-warning text-center">
        Belum ada <strong>Kelompok Pekerjaan</strong> ditambahkan pada skema ini.
    </div>
@endforelse



<!-- Instrumen Asesmen -->
  <div class="mapa-card">
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
                        $instrumenList = [
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

                    @foreach($instrumenList as $i => $judul)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>
                                <input type="hidden" name="instrumen[{{ $i }}][nama]" value="{{ $judul }}">
                                {{ $judul }}
                            </td>
                            @for($j=1; $j<=5; $j++)
                                <td class="text-center">
                                    <input type="radio" 
                                           name="instrumen[{{ $i }}][potensi]" 
                                           value="{{ $j }}">
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
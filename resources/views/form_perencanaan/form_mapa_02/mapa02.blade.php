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
        <!-- Info Skema -->
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

<form action="{{ route('mapa02.simpanInstrumen') }}" method="POST">
    @csrf
    <input type="hidden" name="skema_id" value="{{ $skema->id_skema }}">

    @php
    $instrumenMap = [
        'cek_observasi'    => 'FR.IA.01. CL - Ceklis Observasi Aktivitas Di Tempat Kerja atau Tempat Kerja Simulasi',
        'tugas_praktik'    => 'FR.IA.02. TPD - Tugas Praktik Demonstrasi',
        'tanya_observasi'  => 'FR.IA.03. PMO – Pertanyaan Untuk Mendukung Observasi',
        'instruksi_tertulis'=> 'FR.IA.04. DIT - Daftar Instruksi Tertulis',
        'soal_pg'          => 'FR.IA.05. DPT – Pertanyaan Tertulis Pilihan Ganda',
        'soal_esai'        => 'FR.IA.06. DPT – Pertanyaan Tertulis Pilihan Esai',
        'soal_uraian'      => 'FR.IA.07. DPT – Pertanyaan Tertulis Uraian',
        'cek_portofolio'   => 'FR.IA.08. CVP – Ceklis Verifikasi Portofolio',
        'tanya_wawancara'  => 'FR.IA.09. PW – Pertanyaan Wawancara',
        'verifikasi_pihak3'=> 'FR.IA.10. VPK – Verifikasi Pihak Ketiga',
        'cek_produk'       => 'FR.IA.11. CRP – Ceklis Reviu Produk',
    ];
    @endphp

    {{-- LOOP KELOMPOK PEKERJAAN --}}
    @forelse ($kelompokPekerjaan as $index => $kelompok)
    <div class="mapa-card mt-4">
        <div class="judul-header">Kelompok Pekerjaan {{ $index + 1 }}: {{ $kelompok->nama_kelompok }}</div>
        <input type="hidden" name="id_kelompok[]" value="{{ $kelompok->id_kelompok }}">

        {{-- Tabel Unit Kompetensi --}}
        <div class="table-responsive mt-3">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th>No</th>
                        <th>Kode Unit</th>
                        <th>Unit Kompetensi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($kelompok->hasilAsesmen as $hasil)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hasil->unit->kode_unit ?? '-' }}</td>
                        <td>{{ $hasil->unit->judul_unit ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center">Belum ada unit ditambahkan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Instrumen Asesmen per Kelompok --}}
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
                    @foreach($instrumenMap as $field => $judul)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td>{{ $judul }}</td>
                        @for($j=1; $j<=5; $j++)
                            <td class="text-center">
                                <input type="radio" 
                                 class="form-check-input me-2"
                                    name="{{ $field }}_{{ $kelompok->id_kelompok }}" 
                                    value="{{ $j }}"
                                    @if(isset($instrumenPerKelompok[$kelompok->id_kelompok]) 
                                        && $instrumenPerKelompok[$kelompok->id_kelompok]->$field == $j)
                                        checked
                                    @endif>
                            </td>
                        @endfor
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="text-danger mt-2">
                *Diisi berdasarkan hasil penentuan pendekatan asesmen dan perencanaan asesmen.
            </div>
        </div>
    </div>
    @empty
    <div class="alert alert-warning text-center">
        Belum ada <strong>Kelompok Pekerjaan</strong> ditambahkan pada skema ini.
    </div>
    @endforelse

    {{-- Penjelasan --}}
    <div class="card-box mt-4">
        <div class="judul-box">
            <div class="judul-header">Penjelasan</div>
            <ol class="judul-list">
                <li>Hasil pelatihan dan/atau pendidikan, dimana kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi.</li>
                <li>Hasil pelatihan dan/atau pendidikan, dimana kurikulum belum berbasis kompetensi.</li>
                <li>Pekerja berpengalaman dari industri/tempat kerja yang mampu telusur dengan standar kompetensi.</li>
                <li>Pekerja berpengalaman dari industri/tempat kerja yang belum berbasis kompetensi.</li>
                <li>Pelatihan atau belajar mandiri/otodidak.</li>
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
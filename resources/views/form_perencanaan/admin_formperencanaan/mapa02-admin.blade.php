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
    <div class="judul-header">Kelompok Pekerjaan {{ $index + 1 }}</div>

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
                <tr><td colspan="3" class="text-center">Belum ada unit ditambahkan</td></tr>
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
                            <input type="radio" class="form-check-input me-2" disabled
                                name="{{ $field }}_{{ $kelompok->id_kelompok }}"
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
            *Berdasarkan hasil penentuan pendekatan dan perencanaan asesmen.
        </div>
    </div>
</div>
@empty
<div class="alert alert-warning text-center">
    Belum ada <strong>Kelompok Pekerjaan</strong> ditambahkan pada skema ini.
</div>
@endforelse

{{-- PENYUSUN DAN VALIDATOR --}}
<div class="section mt-5">
    <div class="section-title">Penyusun dan Validator</div>
    <table class="table table-bordered custom-table">
        <thead class="table-title">
            <tr>
                <th>Status</th>
                <th>No.</th>
                <th>Nama</th>
                <th>No. MET / Registrasi</th>
                <th>Tanda Tangan &amp; Tanggal</th>
            </tr>
        </thead>
        <tbody>
            {{-- Penyusun --}}
            @php $no=1; @endphp
            @forelse($penyusun as $p)
            <tr>
                <td>Penyusun</td>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $p->id_asesor ? ($asesors->firstWhere('id_asesor', $p->id_asesor)->nama_asesor ?? '-') : '-' }}</td>
                <td>{{ $p->no_met ?? ($asesors->firstWhere('id_asesor',$p->id_asesor)->no_met ?? '-') }}</td>
                <td class="text-center">
                    @if(!empty($p->tanda_tangan))
                        <img src="{{ $p->tanda_tangan }}" class="signature-img"><br>
                        <span class="date-text">{{ $p->tanggal ?? '-' }}</span>
                    @else
                        <span class="muted">Belum ada tanda tangan</span><br>
                        <span class="date-text">{{ $p->tanggal ?? '-' }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada penyusun</td></tr>
            @endforelse

            {{-- Validator --}}
            @php $no=1; @endphp
            @forelse($validators as $v)
            <tr>
                <td>Validator</td>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $v->nama_validator ?? $v->nama_asesor ?? '-' }}</td>
                <td>{{ $v->no_registrasi ?? $v->no_met ?? '-' }}</td>
                <td class="text-center">
                    @if(!empty($v->tanda_tangan) || !empty($v->ttd))
                        <img src="{{ $v->tanda_tangan ?? $v->ttd }}" class="signature-img"><br>
                        <span class="date-text">
                            {{ isset($v->tanggal) ? \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') : '-' }}
                        </span>
                    @else
                        <span class="muted">Belum ada tanda tangan</span><br>
                        <span class="date-text">
                            {{ isset($v->tanggal) ? \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') : '-' }}
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="text-center text-muted">Belum ada validator</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

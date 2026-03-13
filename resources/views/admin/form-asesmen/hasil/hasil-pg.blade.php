@extends('master')

@section('konten')

<style>
.tbl-header{
    background:#0d47a1!important;
    color:white!important;
    font-weight:600;
    text-align:center;
}

.badge-scheme{
    background:#0d47a1;
    color:white;
    padding:6px 15px;
    border-radius:6px;
    font-size:.8rem;
    font-weight:600;
    letter-spacing:.5px;
}

.section-title{
    background:#e7f0fb;
    border-left:6px solid #0d47a1;
    padding:10px 14px;
    font-weight:600;
    margin:25px 0 15px;
    border-radius:6px;
    color:#0d47a1;
}

.checkbox-cell{
    font-size:18px;
    text-align:center;
    color:#0d47a1;
    font-weight:bold;
}

.table td{
    vertical-align:middle;
}

.signature-box{
    height:80px;
    border:1px dashed #0d47a1;
    border-radius:6px;
    margin-top:8px;
}

.signature-area{
    height:90px;
    display:flex;
    align-items:center;
    justify-content:center;
}

.signature-img{
    max-height:70px;
}

.signature-box{
    width:180px;
    height:70px;
    border:1px dashed #0d47a1;
    border-radius:6px;
}

.signature-label{
    margin-top:5px;
    font-size:.85rem;
    color:#555;
}

.table-fixed {
    table-layout: fixed;
    width: 100%;
}

.table-fixed td,
.table-fixed th {
    word-wrap: break-word;
}

/* Flex container supaya kiri-kanan sejajar */
.flex-tables {
    display: flex;
    gap: 10px; /* jarak antar tabel */
}

.flex-tables > div {
    flex: 1;
}

/* pastikan tinggi baris konsisten */
.table-fixed tbody tr {
    height: 40px;
}
</style>

<div class="container mt-4">

{{-- ================= JUDUL ================= --}}
<div class="text-center mb-4">
    <h4 class="fw-bold">FR.IA.05.C – Lembar Jawaban Pilihan Ganda</h4>
    <p class="text-muted">Skema Sertifikasi Kompetensi</p>

    <span class="badge-scheme">
        {{ strtoupper($skema->nama_skema ?? '-') }}
    </span>
</div>

<div class="card shadow-sm p-4">

{{-- ================= INFORMASI UMUM ================= --}}
<div class="section-title">Informasi Umum</div>

<table class="table table-bordered">
<tr>
    <th class="tbl-header" width="25%">Skema Sertifikasi</th>
    <td>{{ $skema->nama_skema ?? '-' }}</td>

    <th class="tbl-header" width="20%">Judul</th>
    <td>{{ $nomorSertifikat }}</td>
</tr>

<tr>
    <th class="tbl-header">TUK</th>
    <td>-</td>

    <th class="tbl-header">Nomor</th>
    <td>{{ $nomorSertifikat ?? '-' }}</td>
</tr>

<tr>
    <th class="tbl-header">Nama Asesor</th>
    <td>{{ $asesor->nama_asesor ?? '-' }}</td>

    <th class="tbl-header">Waktu</th>
    <td>{{ $waktuPenilaian ?? '-' }}</td>
</tr>

<tr>
    <th class="tbl-header">Nama Asesi</th>
    <td>{{ $asesi->name ?? '-' }}</td>

    <th class="tbl-header">Tanggal</th>
    <td>{{ $tanggalTTD ?? '-' }}</td>
</tr>
</table>

{{-- ================= LEMBAR JAWABAN ================= --}}
<div class="section-title text-center">
Lembar Jawaban Pertanyaan Tertulis – Pilihan Ganda
</div>

@if(empty($jawabanPg) || $jawabanPg->count() === 0)

<div class="alert alert-warning text-center">
Asesi <strong>belum mengerjakan</strong> penilaian pilihan ganda.
</div>

@else

<div class="flex-tables">

    {{-- ================= KIRI ================= --}}
    <div>
        <table class="table table-bordered m-0">
            <thead>
            <tr>
                <th class="tbl-header" width="10%">No</th>
                <th class="tbl-header">Jawaban</th>
                <th class="tbl-header" width="12%">Ya</th>
                <th class="tbl-header" width="12%">Tidak</th>
            </tr>
            </thead>
            <tbody>
            @foreach($jawabanPg as $i => $row)
                @break($i == 5)
                @php
                    $benar = ($row->jawaban_opsi ?? '') === ($row->opsi_benar ?? '');
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>    {{ $row->kode_opsi ?? '-' }} - {{ $row->isi_opsi ?? '-' }}</td>
                    <td class="checkbox-cell">{{ $benar ? '✓' : '' }}</td>
                    <td class="checkbox-cell">{{ !$benar ? '✓' : '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- ================= KANAN ================= --}}
    <div>
        <table class="table table-bordered m-0">
            <thead>
            <tr>
                <th class="tbl-header" width="10%">No</th>
                <th class="tbl-header">Jawaban</th>
                <th class="tbl-header" width="12%">Ya</th>
                <th class="tbl-header" width="12%">Tidak</th>
            </tr>
            </thead>
            <tbody>
            @foreach($jawabanPg as $i => $row)
                @continue($i < 5)
                @php
                    $benar = ($row->jawaban_opsi ?? '') === ($row->opsi_benar ?? '');
                @endphp
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td>{{ $row->jawaban_opsi ?? '-' }}</td>
                    <td class="checkbox-cell">{{ $benar ? '✓' : '' }}</td>
                    <td class="checkbox-cell">{{ !$benar ? '✓' : '' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</div>

@endif

{{-- ================= UMPAN BALIK ================= --}}
<div class="section-title">Umpan Balik untuk Asesi</div>

<table class="table table-bordered">
<tr>
<td width="35%"><strong>Umpan balik</strong></td>
<td width="65%">
Aspek pengetahuan seluruh unit kompetensi yang diujikan
(tercapai / belum tercapai). <br><br>

Tuliskan unit/elemen/KUK jika belum tercapai:
..........................................................................</td>
</tr>
</table>

{{-- ================= TANDA TANGAN ================= --}}
<div class="section-title text-center">Tanda Tangan</div>

<table class="table table-bordered text-center">
<tr>

<td width="50%" style="padding:25px">
    
    <strong>Asesi</strong><br>
    Nama : {{ $asesi->name ?? '-' }}<br>
    Tanggal : {{ $tanggalTTD }}

    <div class="signature-area mt-3">
        @if($ttdAsesi)
            <img src="{{ $ttdAsesi }}" class="signature-img">
        @else
            <div class="signature-box"></div>
        @endif
    </div>

    <div class="signature-label">Tanda tangan</div>

</td>

<td width="50%" style="padding:25px">

    <strong>Asesor</strong><br>
    Nama : {{ $namaTTD }}<br>
    No. Reg : {{ $asesor->no_registrasi ?? '-' }}<br>
    Tanggal : {{ $tanggalTTD }}

    <div class="signature-area mt-3">
        @if($ttdAsesor)
            <img src="{{ $ttdAsesor }}" class="signature-img">
        @else
            <div class="signature-box"></div>
        @endif
    </div>

    <div class="signature-label">Tanda tangan</div>

</td>
</tr>
</table>

{{-- ================= DOWNLOAD PDF ================= --}}
<div class="text-end mt-3">
<a href="{{ route('admin.formasesmen.hasil.pdf', [
    'skemaId' => $skema->id_skema,
    'asesiId' => $asesi->id_asesi,
    'tipe'    => 'pilihan_ganda'
]) }}" class="btn btn-danger">
<i class="bi bi-file-earmark-pdf"></i> Download PDF
</a>
</div>

</div>
</div>

@endsection
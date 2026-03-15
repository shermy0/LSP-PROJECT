@extends('master')

@section('konten')

<style>
.tbl-header{
    background:#0d47a1 !important;
    color:white !important;
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
}

.table th,.table td{
    vertical-align:middle;
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

.header-group{
    background:#0d47a1;
    color:#fff;
    padding:10px 14px;
    font-weight:600;
    border-radius:6px 6px 0 0;
}

.header-unit{
    background:#eef5ff;
    border-left:5px solid #0d47a1;
    padding:10px 14px;
    font-weight:600;
    margin-bottom:10px;
    border-radius:4px;
}
</style>

<div class="container mt-4">

<div class="text-center mb-4">

<h4 class="fw-bold">
FR.IA.01 – Ceklis Observasi Aktivitas
</h4>

<p class="text-muted">Skema Sertifikasi Kompetensi</p>

<span class="badge-scheme">
{{ strtoupper($judulSkema) }}
</span>

</div>

<div class="card shadow-sm p-4">

<div class="section-title">Informasi Umum</div>

<table class="table table-bordered">
<tr>
<th class="tbl-header" width="18%">Skema Sertifikasi</th>
<td width="32%">{{ $judulSkema }}</td>
<th class="tbl-header" width="15%">Judul</th>
<td width="35%">{{ $nomorSertifikat }}</td>
</tr>
<tr>
<th class="tbl-header">TUK</th>
<td>-</td>
<th class="tbl-header">Nomor</th>
<td>{{ $nomorSertifikat }}</td>
</tr>
<tr>
<th class="tbl-header">Nama Asesor</th>
<td>{{ $namaTTD }}</td>
<th class="tbl-header">Waktu</th>
<td>{{ $waktuPenilaian }}</td>
</tr>
<tr>
<th class="tbl-header">Nama Asesi</th>
<td>{{ $asesi->name ?? '-' }}</td>
<th class="tbl-header">Tanggal</th>
<td>{{ $tanggalTTD }}</td>
</tr>
</table>

<div class="section-title text-center">
Hasil Observasi
</div>

@forelse($kelompok as $k => $kel)

<div class="card mb-4">

<div class="header-group">
Kelompok Pekerjaan {{ $k+1 }} : {{ $kel->nama_kelompok ?? '-' }}
</div>

<div class="card-body">

@foreach($kel->unitKompetensi as $unit)

<div class="header-unit">
{{ $unit->kode_unit }} – {{ $unit->judul_unit }}
</div>

<table class="table table-bordered">
<thead>
<tr>
<th class="tbl-header" width="5%">No</th>
<th class="tbl-header" width="20%">Elemen</th>
<th class="tbl-header">Kriteria Unjuk Kerja</th>
<th class="tbl-header" width="18%">Standar Industri</th>
<th class="tbl-header" width="6%">Ya</th>
<th class="tbl-header" width="6%">Tidak</th>
<th class="tbl-header">Penilaian Lanjut</th>
</tr>
</thead>

<tbody>
@foreach($unit->elemen as $ele)
@php $jumlahKuk = $ele->kuk->count(); @endphp

@foreach($ele->kuk as $i => $kuk)
@php
$nilai = $hasilObservasi->detail[$kuk->id_kuk] ?? null;
@endphp

<tr>
@if($i === 0)
<td rowspan="{{ $jumlahKuk }}" class="text-center">
{{ $ele->nomor_elemen }}
</td>
<td rowspan="{{ $jumlahKuk }}">
{{ $ele->nama_elemen }}
</td>
@endif

<td>
<strong>{{ $ele->nomor_elemen }}.{{ $i+1 }}</strong>
{{ $kuk->deskripsi_kuk }}
</td>

<td>
{{ $nilai->standar_industri ?? '-' }}
</td>

<td class="checkbox-cell">
{{ ($nilai->status ?? '') == 'Ya' ? '☑' : '☐' }}
</td>

<td class="checkbox-cell">
{{ ($nilai->status ?? '') == 'Tidak' ? '☑' : '☐' }}
</td>

<td>
{{ $nilai->catatan ?? '-' }}
</td>

</tr>
@endforeach
@endforeach
</tbody>
</table>

@endforeach

</div>
</div>

@empty
<p class="text-center text-muted">
Belum ada data observasi
</p>
@endforelse

<div class="section-title">
Umpan Balik untuk Asesi
</div>

<table class="table table-bordered">
<tr>
<td width="35%">
<strong>Umpan balik</strong>
</td>
<td width="65%">
{{ $hasilObservasi->umpan_balik ?? '-' }}
</td>
</tr>
</table>

<div class="section-title text-center">
Tanda Tangan
</div>

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

<div class="signature-label">
Tanda tangan
</div>
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

<div class="signature-label">
Tanda tangan
</div>
</td>
</tr>
</table>

<div class="text-end mt-3">
<a href="{{ route('admin.formasesmen.hasil.pdf',[
    'skemaId'=>$skema->id_skema,
    'asesiId'=>$asesi->id_asesi,
    'tipe'=>$tipe
]) }}"
class="btn btn-danger">
<i class="bi bi-file-earmark-pdf"></i>
Download PDF
</a>
</div>

</div>
</div>

@endsection
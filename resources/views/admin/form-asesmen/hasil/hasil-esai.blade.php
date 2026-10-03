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
</style>

<div class="container mt-4">

<nav aria-label="breadcrumb" class="mb-3">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.formasesmen.asesi', ['skemaId'=>$skema->id_skema, 'asesiId'=>$asesi->id_asesi, 'tipe'=>$tipe]) }}">
            Kembali ke Data Asesi
        </a>
    </li>
  </ol>
</nav>

{{-- ================= JUDUL ================= --}}
<div class="text-center mb-4">
<h4 class="fw-bold">FR.IA.06.C – Lembar Jawaban Pertanyaan Tertulis (Esai)</h4>
<p class="text-muted">Skema Sertifikasi Kompetensi</p>
<span class="badge-scheme">{{ strtoupper($judulSkema) }}</span>
</div>

<div class="card shadow-sm p-4">

{{-- ================= INFORMASI UMUM ================= --}}
<div class="section-title">Informasi Umum</div>
<table class="table table-bordered">
<tr>
<th class="tbl-header" width="25%">Skema Sertifikasi</th>
<td>{{ $judulSkema }}</td>

<th class="tbl-header" width="15%">Judul</th>
<td>{{ $nomorSertifikat }}</td>
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

{{-- ================= JAWABAN ESAI ================= --}}
@if($tipe === 'esai')
<div class="section-title text-center">Jawaban Esai</div>
<table class="table table-bordered">
<thead>
<tr>
<th class="tbl-header" width="5%">No</th>
<th class="tbl-header">Jawaban</th>
<th class="tbl-header" width="8%">Ya</th>
<th class="tbl-header" width="8%">Tidak</th>
</tr>
</thead>
<tbody>

@forelse($jawabanEsai as $i => $j)
<tr>

<td class="text-center">{{ $i+1 }}</td>

<td style="height:90px;">
{{ $j->jawaban_text ?? $j->jawaban ?? '' }}
</td>

<td class="checkbox-cell">
@if($j->pencapaian == 1)
✔
@endif
</td>

<td class="checkbox-cell">
@if($j->pencapaian == 0)
✔
@endif
</td>

</tr>
@empty
<tr>
<td colspan="4" class="text-center">Belum ada jawaban</td>
</tr>
@endforelse

</tbody>
</table>
@endif

{{-- ================= OBSERVASI ================= --}}
@if($tipe === 'observasi')
<div class="section-title text-center">Observasi</div>
<table class="table table-bordered">
<thead>
<tr>
<th class="tbl-header">Unit / Elemen / KUK</th>
<th class="tbl-header">Status</th>
</tr>
</thead>
<tbody>
@foreach($kelompok as $k)
<tr>
<td>{{ $k->unitKompetensi->nama_unit ?? '-' }} / {{ $k->unitKompetensi->elemen->nama_elemen ?? '-' }}</td>
<td>-</td>
</tr>
@endforeach
</tbody>
</table>
@endif

{{-- ================= PMO ================= --}}
@if($tipe === 'pmo')
<div class="section-title text-center">PMO</div>

@foreach($unit as $u)
<div class="mb-3">

<strong>{{ $u->kode_unit ?? '-' }} – {{ $u->nama_unit ?? '-' }}</strong>

<table class="table table-bordered">

<tr>
<th>Pertanyaan</th>
<th>Pencapaian</th>
<th>Tanggapan</th>
</tr>

@foreach($pmoPertanyaan[$u->id_unit] ?? [] as $p)

<tr>
<td>{{ $p->pertanyaan ?? '-' }}</td>
<td>{{ $p->pencapaian ?? '-' }}</td>
<td>{{ $p->tanggapan ?? '-' }}</td>
</tr>

@endforeach

</table>
</div>
@endforeach
@endif

{{-- ================= UMPAN BALIK ================= --}}
<div class="section-title">Umpan Balik untuk Asesi</div>
<table class="table table-bordered">
<tr>
    <td width="35%"><strong>Umpan balik</strong></td>
    <td width="65%">
        {{ $umpanBalik ?? 'Aspek pengetahuan seluruh unit kompetensi yang diujikan (tercapai / belum tercapai).' }}
    </td>
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
<a href="{{ route('admin.formasesmen.hasil.pdf', ['skemaId'=>$skema->id_skema, 'asesiId'=>$asesi->id_asesi, 'tipe'=>$tipe]) }}" class="btn btn-danger">
<i class="bi bi-file-earmark-pdf"></i> Download PDF
</a>
</div>

</div>
@endsection
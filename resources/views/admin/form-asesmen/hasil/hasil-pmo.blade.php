@extends('master')

@section('konten')
<div class="container mt-4">

{{-- ================= HEADER ================= --}}
<div class="text-center mb-4">
<h4 class="fw-bold">FR.IA.03. PERTANYAAN UNTUK MENDUKUNG OBSERVASI</h4>
<p class="text-muted">Skema Sertifikasi Kompetensi</p>

<span class="badge-scheme">
{{ strtoupper($skema->nama_skema ?? 'NAMA SKEMA') }}
</span>
</div>

<style>

.badge-scheme{
background:#0d47a1;
color:#fff;
padding:6px 16px;
border-radius:6px;
font-weight:600;
font-size:0.85rem;
letter-spacing:.5px;
}

.section-title{
background:#e7f0fb;
border-left:6px solid #0d47a1;
padding:10px 14px;
font-weight:600;
margin:30px 0 15px;
border-radius:6px;
color:#0d47a1;
text-align:center;
}

.tbl-header{
background:#0d47a1 !important;
color:#fff !important;
font-weight:600;
text-align:center;
}

.header-unit{
background:#e3f0ff;
border-left:6px solid #0d47a1;
padding:8px 12px;
font-weight:600;
margin:22px 0 10px;
border-radius:4px;
color:#0d47a1;
}

.signature-box{
height:80px;
border:1px dashed #0d47a1;
border-radius:6px;
margin-top:8px;
display:flex;
align-items:center;
justify-content:center;
}

.signature-box img{
max-height:70px;
}

</style>

<div class="card shadow-sm p-4">

{{-- ================= INFORMASI UMUM ================= --}}
<h5 class="fw-bold mb-3 text-center">Informasi Umum</h5>

<table class="table table-bordered align-middle">

<tr>
<td width="35%">Skema Sertifikasi</td>
<td width="3%">:</td>
<td>{{ $judulSkema }}</td>
</tr>

<tr>
<td>Judul</td>
<td>:</td>
<td>{{ $nomorSertifikat }}</td>
</tr>

<tr>
<td>Nomor</td>
<td>:</td>
<td>{{ $nomorSertifikat }}</td>
</tr>

<tr>
<td>TUK</td>
<td>:</td>
<td>{{ '-' }}</td>
</tr>

<tr>
<td>Nama Asesor</td>
<td>:</td>
<td>{{ $asesor->nama_asesor ?? '-' }}</td>
</tr>

<tr>
<td>Nama Asesi</td>
<td>:</td>
<td>{{ $asesi->nama_lengkap ?? '-' }}</td>
</tr>

<tr>
<td>Tanggal</td>
<td>:</td>
<td>{{ $tanggalTTD }}</td>
</tr>

</table>

{{-- ================= HASIL PMO ================= --}}
<h5 class="fw-bold mt-4 mb-3 text-center">Hasil Evaluasi PMO</h5>

@foreach($unit as $u)
    @php $list = $pmoPertanyaan[$u->id_unit] ?? collect(); @endphp

    @if($list->isNotEmpty())
    <div class="card mb-4">
        <div class="card-header fw-bold">
            {{ $u->kode_unit }} – {{ $u->judul_unit }}
        </div>

        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Pertanyaan</th>
                <th>Status</th>
            </tr>

            @foreach($list as $i => $row)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $row->pertanyaan }}</td>
                <td class="text-center">{{ $row->pencapaian }}</td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
@endforeach


{{-- ================= UMPAN BALIK ================= --}}
<div class="section-title">Umpan Balik untuk Asesi</div>

<table class="table table-bordered">

<tr>

<td width="35%">
<strong>Umpan balik</strong>
</td>

<td width="65%">
{{ optional($hasil->first())->umpan_balik_untuk_asesi ?? '-' }}
</td>

</tr>

</table>


{{-- ================= TANDA TANGAN ================= --}}
<div class="section-title">Tanda Tangan</div>

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


{{-- ================= DOWNLOAD PDF ================= --}}
<div class="text-end mt-3">

<a href="{{ route('admin.formasesmen.hasil.pdf', [
    'skemaId' => $skema->id_skema,
    'asesiId' => $asesi->id_asesi,
    'tipe' => 'pmo'
]) }}" class="btn btn-danger">
Download PDF
</a>

</div>

</div>
</div>

@endsection
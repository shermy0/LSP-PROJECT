<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:14px;
}

th,td{
    border:1px solid #000;
    padding:6px;
    vertical-align:top;
}

th{
    font-weight:bold;
    text-align:center;
}

.text-center{
    text-align:center;
}

.mb-2{margin-bottom:8px;}
.mb-3{margin-bottom:12px;}

</style>
</head>
<body>

{{-- ================= JUDUL ================= --}}
<div class="text-center mb-2">
<strong>HASIL ASESMEN PMO</strong>
</div>

<div class="text-center mb-3">
{{ strtoupper($skema->nama_skema ?? '-') }}
</div>


{{-- ================= INFORMASI UMUM ================= --}}
<table>

<tr>
<th width="30%">Skema Sertifikasi</th>
<td width="70%">
{{ $skema->nama_skema ?? '-' }}
</td>
</tr>

<tr>
<th>Nama Asesi</th>
<td>
{{ $asesi->nama_lengkap ?? ($asesi->name ?? '-') }}
</td>
</tr>

<tr>
<th>Nama Asesor</th>
<td>
{{ $asesor->nama_asesor ?? ($asesor->name ?? '-') }}
</td>
</tr>

<tr>
<th>TUK</th>
<td>
{{ $hasil->tuk ?? '-' }}
</td>
</tr>

<tr>
<th>Tanggal</th>
<td>
{{ $form->tanggal_asesmen ?? '-' }}
</td>
</tr>

</table>


{{-- ================= HASIL PMO ================= --}}
@foreach($unit as $u)

<div class="mb-2">
<strong>
{{ $u->kode_unit }} – {{ $u->judul_unit }}
</strong>
</div>

<table>

<thead>
<tr>
<th width="6%">No</th>
<th width="64%">Pertanyaan</th>
<th width="15%">Ya</th>
<th width="15%">Tidak</th>
</tr>
</thead>

<tbody>

@php
$list = $pmoPertanyaan[$u->id_unit] ?? [];
@endphp

@if(count($list) === 0)

<tr>
<td colspan="4" class="text-center">
Belum ada data evaluasi PMO
</td>
</tr>

@else

@php $no = 1; @endphp

@foreach($list as $p)

<tr>
<td class="text-center">
{{ $no++ }}
</td>

<td>
{{ $p->pertanyaan ?? '-' }}
</td>

<td class="text-center">
{{ ($p->pencapaian ?? '') === 'Ya' ? '✓' : '' }}
</td>
<td class="text-center">
{{ ($p->pencapaian ?? '') === 'Tidak' ? '✓' : '' }}
</td>

</tr>

<tr>
<td></td>
<td colspan="3">

<strong>Tanggapan:</strong><br>

{{ $p->tanggapan ?? '-' }}

</td>
</tr>

@endforeach

@endif

</tbody>
</table>

@endforeach


{{-- ================= UMPAN BALIK ================= --}}
<table>

<tr>
<th width="30%">Umpan Balik</th>

<td width="70%">
{{ $hasil->umpan_balik ?? '-' }}
</td>

</tr>

</table>


{{-- ================= TANDA TANGAN ================= --}}
<table>

<tr>

<td width="50%">

<strong>Asesi</strong><br>

Nama: {{ $asesi->nama_lengkap ?? ($asesi->name ?? '-') }}

<br><br>

@if(!empty($hasil->ttd_asesi))
<img src="{{ public_path('storage/'.$hasil->ttd_asesi) }}" height="70">
@endif

<br>

Tanggal: {{ $hasil->tanggal_ttd_asesi ?? '-' }}

</td>


<td width="50%">

<strong>Asesor</strong><br>

Nama: {{ $asesor->nama_asesor ?? ($asesor->name ?? '-') }}

<br><br>

@if(!empty($hasil->ttd_asesor))
<img src="{{ public_path('storage/'.$hasil->ttd_asesor) }}" height="70">
@endif

<br>

Tanggal: {{ $hasil->tanggal_ttd_asesor ?? '-' }}

</td>

</tr>

</table>


</body>
</html>
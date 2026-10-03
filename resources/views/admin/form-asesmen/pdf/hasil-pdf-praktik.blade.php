<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>
body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
    line-height:1.4;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-bottom:12px;
}

td,th{
    border:1px solid #000;
    padding:5px;
    vertical-align:top;
}

.center{
    text-align:center;
}

.title{
    font-weight:bold;
    margin-bottom:6px;
    font-size:14px;
}

.signature-img{
    max-height:70px;
}

.space{
    height:50px;
}
</style>

</head>

<body>

{{-- ================= JUDUL ================= --}}
<div class="title">
FR.IA.08 – HASIL PRAKTIK DEMONSTRASI
</div>


{{-- ================= INFORMASI UMUM ================= --}}
<table>

<tr>
<td width="25%">Skema Sertifikasi</td>
<td width="2%">:</td>
<td width="33%">{{ $skema->nama_skema ?? '-' }}</td>

<td width="10%">Judul</td>
<td width="2%">:</td>
<td width="28%">{{ $judulSkema ?? '-' }}</td>
</tr>

<tr>
<td>TUK</td>
<td>:</td>
<td>{{ $tuk ?? '-' }}</td>

<td>Nomor</td>
<td>:</td>
<td>{{ $nomorSertifikat ?? '-' }}</td>
</tr>

<tr>
<td>Nama Asesor</td>
<td>:</td>
<td>{{ $asesor->nama_asesor ?? '-' }}</td>

<td>Waktu</td>
<td>:</td>
<td>{{ $waktuPenilaian ?? '-' }}</td>
</tr>

<tr>
<td>Nama Asesi</td>
<td>:</td>
<td>{{ $asesi->nama_lengkap ?? '-' }}</td>

<td>Tanggal</td>
<td>:</td>
<td>{{ $tanggalTTD ?? '-' }}</td>
</tr>

</table>

<br>

{{-- ================= TUGAS DEMONSTRASI ================= --}}

<table>

<tr>
<th width="5%">No</th>
<th width="30%">Tugas / Pertanyaan</th>
<th width="20%">Deskripsi</th>
<th width="25%">Jawaban Asesi</th>
<th width="20%">Lampiran</th>
</tr>

@forelse($demonstrasi as $i => $tugas)

@php
    // cari jawaban sesuai id_tugas
    $jawaban = $jawabanAsesi->firstWhere('id_pertanyaan', $tugas->id_tugas);
@endphp

<tr>

<td class="center">
{{ $i+1 }}
</td>

<td>
{{ $tugas->isi_pertanyaan_demonstrasi ?? '-' }}
</td>

<td>
{{ $tugas->deskripsi_pertanyaan ?? '-' }}
</td>

<td>
{{ $jawaban->jawaban_text ?? '-' }}
</td>

<td class="center">

@if(!empty($jawaban->file_jawaban))
<img src="{{ public_path($jawaban->file_jawaban) }}" style="max-height:90px">
@else
-
@endif

</td>

</tr>

@empty

<tr>
<td colspan="5" class="center">
Tidak ada data demonstrasi
</td>
</tr>

@endforelse

</table>

<br>

{{-- ================= TANDA TANGAN ================= --}}

<table>

<tr>

<td width="50%" class="center">

<strong>Asesi</strong><br><br>

Nama : {{ $asesi->nama_lengkap ?? '-' }}<br><br>

Tanggal : {{ $tanggalTTD ?? '-' }}<br><br>

@if(!empty($ttdAsesi))
<img src="{{ $ttdAsesi }}" class="signature-img">
@else
<div style="border:1px dashed #000;width:180px;height:70px;"></div>
@endif

</td>


<td width="50%" class="center">

<strong>Asesor</strong><br><br>

Nama : {{ $asesor->nama_asesor ?? '-' }}<br>
No. Reg : {{ $asesor->no_registrasi ?? '-' }}<br><br>

Tanggal : {{ $tanggalTTD ?? '-' }}<br><br>

@if(!empty($ttdAsesor))
<img src="{{ $ttdAsesor }}" class="signature-img">
@else
<div style="border:1px dashed #000;width:180px;height:70px;"></div>
@endif

</td>

</tr>

</table>

</body>
</html>
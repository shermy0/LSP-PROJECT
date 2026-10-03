<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; line-height: 1.4; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        td, th { border: 1px solid #000; padding: 5px; vertical-align: top; }
        .no-border td { border: none; padding: 2px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .checkbox { text-align: center; font-size: 14px; }
        .space { height: 50px; }
        .title { font-weight: bold; margin-bottom: 6px; font-size: 14px; }
        .signature-img { max-height: 70px; }
    </style>
</head>
<body>

{{-- ================= JUDUL ================= --}}
<div class="title center">
    FR.IA.05.C – LEMBAR JAWABAN PILIHAN GANDA
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

<small>*Coret yang tidak perlu</small>
<br><br>

{{-- ================= JAWABAN PILIHAN GANDA ================= --}}
<table>
<tr>
<th width="5%">No.</th>
<th width="65%">Jawaban</th>
<th colspan="2" width="30%" class="center">Pencapaian</th>
</tr>

<tr>
<th></th>
<th></th>
<th width="15%" class="center">Ya</th>
<th width="15%" class="center">Tidak</th>
</tr>

@forelse($jawabanPg as $i => $row)

<tr>

<td class="center">
{{ $i + 1 }}.
</td>

<td class="space">

{{-- tampilkan kode opsi + isi opsi --}}
@if(!empty($row->kode_opsi))
{{ $row->kode_opsi }} - {{ $row->isi_opsi }}
@else
-
@endif

</td>

<td class="checkbox">

{{-- YA --}}
@if(($row->pencapaian ?? 0) == 1)
&#x2611; {{-- ☑ --}}
@else
&#x2610; {{-- ☐ --}}
@endif

</td>

<td class="checkbox">

{{-- TIDAK --}}
@if(($row->pencapaian ?? 0) == 0)
&#x2611; {{-- ☑ --}}
@else
&#x2610; {{-- ☐ --}}
@endif

</td>

</tr>

@empty

<tr>
<td colspan="4" class="center">Tidak ada jawaban</td>
</tr>

@endforelse

</table>
<br>

{{-- ================= UMPAN BALIK ================= --}}
<table>
    <tr>
        <td width="30%" class="bold">Umpan balik untuk asesi</td>
        <td width="70%">
{{ $umpanBalik ?? 'Aspek pengetahuan seluruh unit kompetensi yang diujikan (tercapai / belum tercapai)*' }}    </tr>
</table>

<br>

{{-- ================= TANDA TANGAN ================= --}}
<table>
    <tr>
        <td width="50%" class="center">
            <strong>Asesi</strong><br><br>
            Nama : {{ $asesi->nama_lengkap ?? '-' }}<br><br>
            Tanda tangan / Tanggal : {{ $tanggalTTD ?? '-' }}<br><br>
            @if(!empty($ttdAsesi))
                <img src="{{ $ttdAsesi }}" class="signature-img">
            @else
                <div style="border:1px dashed #000; width:180px; height:70px;"></div>
            @endif
        </td>

        <td width="50%" class="center">
            <strong>Asesor</strong><br><br>
            Nama : {{ $asesor->nama_asesor ?? '-' }}<br>
            No. Reg : {{ $asesor->no_registrasi ?? '-' }}<br>
            Tanggal : {{ $tanggalTTD ?? '-' }}<br><br>
            @if(!empty($ttdAsesor))
                <img src="{{ $ttdAsesor }}" class="signature-img">
            @else
                <div style="border:1px dashed #000; width:180px; height:70px;"></div>
            @endif
        </td>
    </tr>
</table>

</body>
</html>
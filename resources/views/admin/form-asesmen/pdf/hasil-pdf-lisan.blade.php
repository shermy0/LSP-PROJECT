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
<div class="title">
FR.IA.07 – DAFTAR PERTANYAAN LISAN
</div>

<p>
Skema Sertifikasi :
<strong>{{ strtoupper($skema->nama_skema ?? '-') }}</strong>
</p>

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

{{-- ================= PERTANYAAN ================= --}}
<table>

<tr>
<th width="5%">No</th>
<th width="40%">Pertanyaan</th>
<th width="25%">Jawaban Asesi</th>
<th width="20%">Kunci Jawaban</th>
<th width="5%">Ya</th>
<th width="5%">Tidak</th>
</tr>

@forelse($pertanyaan as $i => $p)

<tr>

<td class="center">
{{ $i + 1 }}
</td>

<td>
{{ $p->isi_pertanyaan ?? '-' }}
</td>

<td>
{{ $p->jawaban_asesi ?? '-' }}
</td>

<td>
{{ $p->kunci_jawaban ?? '-' }}
</td>

<td class="center">
@if(($p->jawaban_asesi ?? '') == ($p->kunci_jawaban ?? ''))
✓
@endif
</td>

<td class="center">
@if(($p->jawaban_asesi ?? '') != ($p->kunci_jawaban ?? '') && !empty($p->jawaban_asesi))
✓
@endif
</td>

</tr>

@empty

<tr>
<td colspan="6" class="center">
Tidak ada pertanyaan lisan
</td>
</tr>

@endforelse

</table>

<br>

{{-- ================= UMPAN BALIK ================= --}}
<table>

<tr>
<td width="30%">
<strong>Umpan balik untuk asesi</strong>
</td>

<td width="70%">
<div style="white-space: pre-line; line-height: 1.6;">
    {!! e($umpanBalik ?? 'Aspek pengetahuan seluruh unit kompetensi yang diujikan (tercapai / belum tercapai)*') !!}
</div>
</tr>

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
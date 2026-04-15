@php
\Carbon\Carbon::setLocale('id');
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>FR.AK.05 – Laporan Asesmen</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/pdfmapa.css') }}">
</head>
<body>

<h3>FR.AK.05 - LAPORAN ASESMEN</h3>

<!-- Bagian Header -->
<table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
        <td rowspan="2" style="border:1px solid #000; padding:6px; width:30%;"><strong>Skema Sertifikasi</strong>
            <br>
         (
            <span @if(Str::contains($skema->jenjang, 'KKNI')) style="text-decoration: none; font-weight:bold;" @else class="strike" @endif>KKNI</span> /
            <span @if(Str::contains($skema->jenjang, 'Okupasi')) style="text-decoration: none; font-weight:bold;" @else class="strike" @endif>Okupasi</span> /
            <span @if(Str::contains($skema->jenjang, 'Klaster')) style="text-decoration: none; font-weight:bold;" @else class="strike" @endif>Klaster</span>
            )
        </td>
        <td style="border:1px solid #000; padding:6px; width:8%;"><strong>Judul</strong></td>
        <td style="border:1px solid #000; padding:6px; width:2%;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            {{ $skema->nama_skema }}
        </td>
    </tr>
    <tr>
        <td style="border:1px solid #000; padding:6px;"><strong>Nomor</strong></td>
        <td style="border:1px solid #000; padding:6px;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            {{ $skema->kode_skema }}
        </td>
    </tr>
    <tr>
        <td  colspan="2" style="border:1px solid #000; padding:6px; font-weight:bold">TUK</td>
        <td style="border:1px solid #000; padding:6px;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            {{ $tuk->nama_tuk }}
        </td>
    </tr>
    <tr>
        <td  colspan="2" style="border:1px solid #000; padding:6px; font-weight:bold">Nama Asesor</td>
        <td style="border:1px solid #000; padding:6px;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            {{ $asesor->nama_asesor }}
        </td>
    </tr>
    <tr>
        <td  colspan="2" style="border:1px solid #000; padding:6px; font-weight:bold">Tanggal</td>
        <td style="border:1px solid #000; padding:6px;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            @if(!empty($laporan->tgl_laporan))
            {{ \Carbon\Carbon::parse($laporan->tgl_laporan)->translatedFormat('d F Y') }}
            @else
                -
            @endif
        </td>
    </tr>
</table>

<!-- ========================= -->
<!-- TABEL 1: HASIL ASESMEN -->
<!-- ========================= -->
<br>
<table  class="table" style="width:100%; border-collapse: collapse; font-size:12px; text-align:center;">
    <thead class="table-title">
        <tr>
            <th rowspan="2" style="border:1px solid #000; padding:6px; width:5%;">No.</th>
            <th rowspan="2" style="border:1px solid #000; padding:6px; width:40%;">Nama Asesi</th>
            <th colspan="2" style="border:1px solid #000; padding:6px; width:15%;">Rekomendasi</th>
            <th rowspan="2" style="border:1px solid #000; padding:6px; width:40%;">Keterangan</th>
        </tr>
        <tr>
            <th style="border:1px solid #000; padding:4px;">K</th>
            <th style="border:1px solid #000; padding:4px;">BK</th>
        </tr>
    </thead>
    <tbody>
        @forelse($asesis as $index => $asesi)
        <tr>
            <td style="border:1px solid #000; padding:6px;">{{ $index + 1 }}</td>
            <td style="border:1px solid #000; padding:6px; text-align:left;">{{ $asesi->nama_lengkap }}</td>
            
            <!-- Kolom K -->
            <td style="border:1px solid #000; padding:6px;">
                @if($asesi->hasil === 'K')
                    ✔
                @endif
            </td>

            <!-- Kolom BK -->
            <td style="border:1px solid #000; padding:6px;">
                @if($asesi->hasil === 'BK')
                    ✔
                @endif
            </td>

            <!-- Kolom Keterangan -->
            <td style="border:1px solid #000; padding:6px;  text-align:left;">
                @if($asesi->hasil === 'BK')
                    {{ $asesi->kode_unit ?? '' }} – {{ $asesi->judul_unit ?? '' }}
                @else
                    –
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" style="border:1px solid #000; padding:6px;">Tidak ada data asesi</td>
        </tr>
        @endforelse
    </tbody>
</table>

<br>
<!-- ========================= -->
<!-- TABEL 2: CATATAN ASESMEN -->
<!-- ========================= -->
<table  class="table" style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
        <td style="border:1px solid #000; padding:6px; width:45%; background-color:#fff2cc; font-weight:bold">
            Aspek Negatif dan Positif dalam Asesmen
        </td>
        <td style="border:1px solid #000; padding:6px;">
            {!! nl2br(e($laporan->aspek_positif_negatif ?? '')) !!}
        </td>
    </tr>
    <tr>
        <td style="border:1px solid #000; padding:6px; background-color:#fff2cc; font-weight:bold">Pencatatan Penolakan Hasil Asesmen</td>
        <td style="border:1px solid #000; padding:6px;">
            {!! nl2br(e($laporan->penolakan ?? '')) !!}
        </td>
    </tr>
    <tr>
        <td style="border:1px solid #000; padding:6px; background-color:#fff2cc; font-weight:bold">Saran Perbaikan:<br>(Asesor/Personil Terkait)</td>
        <td style="border:1px solid #000; padding:6px;">
            {!! nl2br(e($laporan->saran_perbaikan ?? '')) !!}
        </td>
    </tr>
</table>
<!-- ========================= -->
<!-- TABEL 3: CATATAN & TANDA TANGAN ASESOR -->
<!-- ========================= -->
<br>
<table  class="table" style="width:100%; border-collapse: collapse; font-size:12px; border:1px solid #000;">
    <!-- Baris pertama: Catatan + Judul Asesor -->
    <tr>
        <!-- Kolom Catatan -->
        <td rowspan="4" style="border:1px solid #000; padding:6px; width:50%; vertical-align:top;">
            <strong>Catatan:</strong><br>
            {!! nl2br(e($penyusun->catatan ?? '')) !!}
        </td>

        <!-- Judul kolom Asesor -->
        <td colspan="2" style="border:1px solid #000; padding:6px; text-align:left;">
            <strong>Asesor:</strong>
        </td>
    </tr>

    <!-- Baris kedua: Nama -->
    <tr>
        <td style="border:1px solid #000; padding:6px; width:25%;"><strong>Nama</strong></td>
        <td style="border:1px solid #000; padding:6px;">{{ $asesor->nama_asesor ?? '-' }}</td>
    </tr>

    <!-- Baris ketiga: No. Reg -->
    <tr>
        <td style="border:1px solid #000; padding:6px;"><strong>No. Reg</strong></td>
        <td style="border:1px solid #000; padding:6px;">{{ $penyusun->no_met ?? $asesor->no_registrasi ?? '-' }}</td>
    </tr>

    <!-- Baris keempat: Tanda Tangan / Tanggal -->
    <tr>
        <td style="border:1px solid #000; padding:6px;"><strong>Tanda Tangan / Tanggal</strong></td>
        <td style="border:1px solid #000; padding:6px; text-align:center">
            @if(!empty($penyusun->tanda_tangan))
                <img src="{{ Str::startsWith($penyusun->tanda_tangan, 'data:image') 
                    ? $penyusun->tanda_tangan 
                    : 'data:image/png;base64,' . $penyusun->tanda_tangan }}" 
                    alt="Tanda Tangan" style="height:60px;">
            @else
                <em>Belum ada tanda tangan</em>
            @endif
            <br>
            @if(!empty($penyusun->tanggal))
                {{ \Carbon\Carbon::parse($penyusun->tanggal)->translatedFormat('d F Y') }}
            @else
                <em>Belum ada tanggal</em>
            @endif
        </td>
    </tr>
</table>
</body>
</html>
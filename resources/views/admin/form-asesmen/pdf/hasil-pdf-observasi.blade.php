<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 11px;
    color: #000;
    line-height: 1.4;
    margin: 0;
    padding: 0;
}
.title {
    font-weight: bold;
    text-align: center;
    margin-bottom: 10px;
}
table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 12px;
}
th, td {
    border: 1px solid #000;
    padding: 5px;
    vertical-align: top;
    font-size: 11px;
}
th {
    font-weight: bold;
    text-align: center;
}
.center { text-align: center; }
.bold { font-weight: bold; }
.checkbox { text-align: center; font-size: 14px; }
.signature-img { max-height: 70px; }
.signature-box { border: 1px dashed #000; width: 180px; height: 70px; }
.section-title {
    font-weight: bold;
    margin-top: 25px;
    margin-bottom: 10px;
}
</style>
</head>
<body>

<div class="title">FR.IA.01 – Ceklis Observasi Aktivitas</div>

<!-- Informasi Umum -->
<table>
<tr>
<td width="25%">Skema Sertifikasi</td>
<td width="2%">:</td>
<td width="33%">{{ $skema->nama_skema ?? $judulSkema ?? '-' }}</td>
<td width="10%">Nomor Sertifikat</td>
<td width="2%">:</td>
<td width="28%">{{ $nomorSertifikat ?? '-' }}</td>
</tr>
<tr>
<td>Nama Asesor</td>
<td>:</td>
<td>{{ $asesor->nama_asesor ?? $namaTTD ?? '-' }}</td>
<td>Waktu</td>
<td>:</td>
<td>{{ $waktuPenilaian ?? '-' }}</td>
</tr>
<tr>
<td>Nama Asesi</td>
<td>:</td>
<td>{{ $asesi->nama_lengkap ?? $asesi->name ?? '-' }}</td>
<td>Tanggal</td>
<td>:</td>
<td>{{ $tanggalTTD ?? '-' }}</td>
</tr>
</table>

<!-- Hasil Observasi -->
@forelse($kelompok as $k => $kel)
<p class="section-title">Kelompok Pekerjaan {{ $k+1 }} : {{ $kel->nama_kelompok ?? '-' }}</p>

<!-- Hasil Observasi -->
@if($hasilObservasi->detail->isNotEmpty())
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Elemen Kompetensi</th>
            <th>KUK</th>
            <th>Standar Industri</th>
            <th>Ya</th>
            <th>Tidak</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($hasilObservasi->detail as $nilai)
            <tr>
                <td>{{ $nilai->nama_elemen ?? '-' }}</td>
                <td>{{ $nilai->deskripsi_kuk ?? '-' }}</td>
                <td>{{ $nilai->standar_industri ?? '-' }}</td>
                <td class="center">{{ ($nilai->pencapaian ?? '') == 'Ya' ? '☑' : '☐' }}</td>
                <td class="center">{{ ($nilai->pencapaian ?? '') == 'Tidak' ? '☑' : '☐' }}</td>
                <td>{{ $nilai->penilaian_lanjut ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@else
<p class="center">Belum ada data observasi</p>
@endif

<!-- Umpan Balik -->
<p class="section-title">Umpan Balik untuk Asesi</p>
<table>
<tr>
<td width="30%" class="bold">Umpan balik</td>
<td width="70%">{{ $hasilObservasi->umpan_balik ?? $umpanBalik ?? '-' }}</td>
</tr>
</table>

<!-- Tanda Tangan -->
<p class="section-title">Tanda Tangan</p>
<table>
<tr>
<td width="50%" class="center">
<strong>Asesi</strong><br>
Nama: {{ $asesi->nama_lengkap ?? $asesi->name ?? '-' }}<br>
Tanggal: {{ $tanggalTTD ?? '-' }}<br><br>
@if(!empty($ttdAsesi))
<img src="{{ $ttdAsesi }}" class="signature-img">
@else
<div class="signature-box"></div>
@endif
</td>

<td width="50%" class="center">
<strong>Asesor</strong><br>
Nama: {{ $asesor->nama_asesor ?? $namaTTD ?? '-' }}<br>
No. Reg: {{ $asesor->no_reg ?? '-' }}<br>
Tanggal: {{ $tanggalTTD ?? '-' }}<br><br>
@if(!empty($ttdAsesor))
<img src="{{ $ttdAsesor }}" class="signature-img">
@else
<div class="signature-box"></div>
@endif
</td>
</tr>
</table>

</body>
</html>
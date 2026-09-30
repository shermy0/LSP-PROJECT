<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>FR.AK.06 – Meninjau Proses Asesmen</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/pdfmapa.css') }}">
</head>
<body>

<h3>FR.AK.06 – MENINJAU PROSES ASESMEN</h3>

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
        <td colspan="2" style="border:1px solid #000; padding:6px; font-weight:bold">TUK</td>
        <td style="border:1px solid #000; padding:6px;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            {{ $tuk->nama_tuk }}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border:1px solid #000; padding:6px; font-weight:bold">Nama Asesor</td>
        <td style="border:1px solid #000; padding:6px;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            {{ $asesor->nama_asesor }}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="border:1px solid #000; padding:6px; font-weight:bold">Tanggal</td>
        <td style="border:1px solid #000; padding:6px;">:</td>
        <td style="border:1px solid #000; padding:6px;">
            @if(!empty($meninjau->created_at))
                {{ \Carbon\Carbon::parse($meninjau->created_at)->translatedFormat('d F Y') }}
            @endif
        </td>
    </tr>
</table>

<br>

<!-- ================================== -->
<!-- PENJELASAN -->
<!-- ================================== -->
<table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
        <td style="border:1px solid #000; padding:8px; background-color:#fff2cc;">
            <strong>Penjelasan:</strong>
            <ol style="margin:5px 0; padding-left:20px;">
                <li>Peninjauan dapat dilakukan oleh lead asesor atau asesor yang melaksanakan asesmen.</li>
                <li>Peninjauan dapat dilakukan secara terpadu dalam skema sertifikasi dan / atau peserta kelompok yang homogen.</li>
                <li>Isilah pemenuhan dimensi kompetensi dengan menuliskan jenis bukti dan instrumen yang digunakan.</li>
            </ol>
        </td>
    </tr>
</table>

<br>

<!-- ================================== -->
<!-- TABEL 1: KESESUAIAN PRINSIP ASESMEN -->
<!-- ================================== -->
<table class="table" style="width:100%; border-collapse: collapse; font-size:12px; text-align:center;">
    <thead class="table-title">
        <tr>
            <th rowspan="2" style="border:1px solid #000; padding:6px; width:40%;">Aspek yang Ditinjau</th>
            <th colspan="4" style="border:1px solid #000; padding:6px;">Kesesuaian dengan Prinsip Asesmen</th>
        </tr>
        <tr>
            <th style="border:1px solid #000; padding:4px; width:15%;">Validitas</th>
            <th style="border:1px solid #000; padding:4px; width:15%;">Reliabel</th>
            <th style="border:1px solid #000; padding:4px; width:15%;">Fleksibel</th>
            <th style="border:1px solid #000; padding:4px; width:15%;">Adil</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border:1px solid #000; padding:6px; text-align:left;">Rencana asesmen</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->rencana_valid) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->rencana_reliabel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->rencana_fleksibel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->rencana_adil) ? '✔' : '' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; text-align:left;">Persiapan asesmen</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->persiapan_valid) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->persiapan_reliabel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->persiapan_fleksibel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->persiapan_adil) ? '✔' : '' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; text-align:left;">Implementasi asesmen</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->implementasi_valid) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->implementasi_reliabel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->implementasi_fleksibel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->implementasi_adil) ? '✔' : '' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; text-align:left;">Keputusan asesmen</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->keputusan_valid) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->keputusan_reliabel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">–</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->keputusan_adil) ? '✔' : '' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; text-align:left;">Umpan balik asesmen</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->umpan_valid) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->umpan_reliabel) ? '✔' : '' }}</td>
            <td style="border:1px solid #000; padding:6px;">–</td>
            <td style="border:1px solid #000; padding:6px;">{{ !empty($meninjau->umpan_adil) ? '✔' : '' }}</td>
        </tr>
    </tbody>
</table>

<br>

<!-- ================================== -->
<!-- REKOMENDASI 1 -->
<!-- ================================== -->
<table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
        <td style="border:1px solid #000; padding:6px; background-color:#fff2cc; font-weight:bold; width:30%;">
            Rekomendasi 1:
        </td>
        <td style="border:1px solid #000; padding:6px;">
            {!! nl2br(e($meninjau->rekomendasi1 ?? '')) !!}
        </td>
    </tr>
</table>

<br>

<!-- ================================== -->
<!-- TABEL 2: PEMENUHAN DIMENSI KOMPETENSI -->
<!-- ================================== -->
<table class="table" style="width:100%; border-collapse: collapse; font-size:11px; text-align:center;">
    <thead class="table-title">
        <tr>
            <th rowspan="2" style="border:1px solid #000; padding:6px; width:30%;">Aspek yang Ditinjau</th>
            <th colspan="5" style="border:1px solid #000; padding:6px;">Pemenuhan dimensi kompetensi</th>
        </tr>
        <tr>
            <th style="border:1px solid #000; padding:4px; width:14%;">Task Skills</th>
            <th style="border:1px solid #000; padding:4px; width:14%;">Task Management Skills</th>
            <th style="border:1px solid #000; padding:4px; width:14%;">Contingency Management Skills</th>
            <th style="border:1px solid #000; padding:4px; width:14%;">Job Role/Environment Skills</th>
            <th style="border:1px solid #000; padding:4px; width:14%;">Transfer Skills</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border:1px solid #000; padding:6px; text-align:left;">Konsistensi keputusan asesmen</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->konsistensi_task ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->konsistensi_task_mgmt ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->konsistensi_contingency ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->konsistensi_jobrole ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->konsistensi_transfer ?? '' }}</td>
        </tr>
        <tr>
            <td style="border:1px solid #000; padding:6px; text-align:left;">Bukti dari berbagai asesmen diperiksa untuk konsistensi dimensi kompetensi</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->bukti_task ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->bukti_task_mgmt ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->bukti_contingency ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->bukti_jobrole ?? '' }}</td>
            <td style="border:1px solid #000; padding:6px;">{{ $meninjau->bukti_transfer ?? '' }}</td>
        </tr>
    </tbody>
</table>

<br>

<!-- ================================== -->
<!-- REKOMENDASI 2 -->
<!-- ================================== -->
<table style="width:100%; border-collapse: collapse; font-size:12px;">
    <tr>
        <td style="border:1px solid #000; padding:6px; background-color:#fff2cc; font-weight:bold; width:30%;">
            Rekomendasi 2:
        </td>
        <td style="border:1px solid #000; padding:6px;">
            {!! nl2br(e($meninjau->rekomendasi2 ?? '')) !!}
        </td>
    </tr>
</table>

<br>

<!-- ================================== -->
<!-- TABEL 3: CATATAN & TANDA TANGAN ASESOR -->
<!-- ================================== -->
<table class="table" style="width:100%; border-collapse: collapse; font-size:12px; border:1px solid #000;">
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
            @if(!empty($penyusun->created_at))
                {{ \Carbon\Carbon::parse($penyusun->created_at)->translatedFormat('d F Y') }}
            @else
                <em>Belum ada tanggal</em>
            @endif
        </td>
    </tr>
</table>

</body>
</html>
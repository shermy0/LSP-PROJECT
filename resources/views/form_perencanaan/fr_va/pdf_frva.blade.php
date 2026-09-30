<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FR.VA – Memberikan Kontribusi dalam Validasi Asesmen</title>
    <style>
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 12px; 
            margin: 30px; 
        }

        h3 { 
            text-align: left; 
            font-size: 13px; 
            font-weight: bold; 
            margin-bottom: 5px; 
        }

        table { 
            width: 100%; 
            border-collapse: collapse; 
        }

        th, td { 
            border: 1px solid #000; 
            padding: 5px; 
            vertical-align: top; 
        }

        .section-title { 
            background-color: #f9d7aa; 
            font-weight: bold; 
            padding: 4px; 
        }

        .header-table td { 
            border: 1px solid #000; 
            padding: 4px; 
        }

        .table-section-title {
            background-color: #f9d7aa;
            font-weight: bold;
            padding: 5px;
            text-align: left;
        }

        /* Checkbox center */
        input[type="checkbox"] {
            vertical-align: middle;
            margin-right: 4px;
        }
    </style>
</head>
<body>

<h3>FR.VA MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN</h3>

<!-- HEADER -->
<table class="header-table">
    <tr>
        <td width="20%" rowspan="2" style="font-weight:bold;">Tim Validasi</td>
        <td colspan="3" rowspan="2" style="padding:0; border-right:1px solid #000;">
            <table style="width:100%; border-collapse:collapse; font-size:12px; border:none;">
                @forelse($validators->take(3) as $v)
                    <tr>
                        <td style="border:none; {{ !$loop->last ? 'border-bottom:1px solid #000;' : '' }} padding:5px 6px;">
                            {{ $loop->iteration }}. {{ $v->nama_asesor }}
                        </td>
                    </tr>
                @empty
                    <tr><td style="border:none; border-bottom:1px solid #000; padding:8px;">&nbsp;</td></tr>
                    <tr><td style="border:none; border-bottom:1px solid #000; padding:8px;">&nbsp;</td></tr>
                    <tr><td style="border:none; padding:8px;">&nbsp;</td></tr>
                @endforelse
            </table>
        </td>
        <td width="20%" style="font-weight:bold;">Hari/Tanggal</td>
        <td colspan="2">{{ $validators->first()->tanggal ?? '' }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Tempat</td>
        <td colspan="2">SMKN 11 BANDUNG - Mandiri</td>
    </tr>

    {{-- PERIODE --}}
    @php
        $periodeAktif = $periode ?? ($periodeList[0] ?? null);
    @endphp
    <tr>
        <td style="font-weight:bold;">Periode</td>
        <td colspan="6" style="padding:5px;">
            <table style="width:100%; border-collapse:collapse; border:none;">
                <tr style="text-align:center;">
                    <td style="border:none; text-align:left; white-space:nowrap;">
                        <span style="display:inline-block; width:13px; height:13px; border:1px solid #000; text-align:center; line-height:12px; font-size:10px; margin-right:5px;">
                            {!! $periodeAktif === 'sebelum' ? '✔' : '&nbsp;' !!}
                        </span> Sebelum Asesmen
                    </td>
                    <td style="border:none; text-align:center; white-space:nowrap;">
                        <span style="display:inline-block; width:13px; height:13px; border:1px solid #000; text-align:center; line-height:12px; font-size:10px; margin-right:5px;">
                            {!! $periodeAktif === 'saat' ? '✔' : '&nbsp;' !!}
                        </span> Pada Saat Asesmen
                    </td>
                    <td style="border:none; text-align:right; white-space:nowrap;">
                        <span style="display:inline-block; width:13px; height:13px; border:1px solid #000; text-align:center; line-height:12px; font-size:10px; margin-right:5px;">
                            {!! $periodeAktif === 'sesudah' ? '✔' : '&nbsp;' !!}
                        </span> Setelah Asesmen
                    </td>
                </tr>
            </table>
        </td>
    </tr>

    <tr>
        <td style="font-weight:bold;">Nama Skema</td>
        <td colspan="6" style="font-weight:bold;">{{ $skema->nama_skema }}</td>
    </tr>
    <tr>
        <td style="font-weight:bold;">Nomor Skema</td>
        <td colspan="6">{{ $skema->kode_skema ?? '' }}</td>
    </tr>
</table>
<br>
<table style="width:100%; border-collapse:collapse; border:1px solid #000;">
    <!-- 1. Menyiapkan Proses Validasi -->
    <tr>
        <td colspan="3" style="font-weight:bold; padding:4px;" class="table-section-title">
            1. Menyiapkan Proses Validasi
        </td>
    </tr>

    <!-- Header -->
    <tr style="background-color:#fff2cc; font-weight:bold; text-align:center;">
        <td style="border:1px solid #000; padding:4px;">Tujuan dan Fokus Validasi</td>
        <td style="border:1px solid #000; padding:4px;">Konteks Validasi</td>
        <td style="border:1px solid #000; padding:4px;">Pendekatan Validasi</td>
    </tr>

    @php
        $maxRows = max(
            count($allTujuan) + ($tujuanLainVal ? 1 : 0),
            count($allKonteks) + count($konteksLainList),
            count($allPendekatan) + (!in_array('Mengkaji Bukti-bukti', (array)$pendekatanSelected) ? 1 : 0)
        );
    @endphp

    @for($i = 0; $i < $maxRows; $i++)
        <tr>
            <!-- Tujuan -->
            <td style="border:1px solid #000; padding:4px;">
                @if(isset($allTujuan[$i]))
                    {{ in_array($allTujuan[$i], (array)$tujuanSelected) ? '☑' : '☐' }} {{ $allTujuan[$i] }}
                @elseif($i === count($allTujuan))
                    {{ !empty($tujuanLainVal) ? '☑' : '☐' }} {{ $tujuanLainVal ?? 'Tujuan Lain...' }}
                @else
                    &nbsp;
                @endif
            </td>

            <!-- Konteks -->
            <td style="border:1px solid #000; padding:4px;">
                @if(isset($allKonteks[$i]))
                    {{ in_array($allKonteks[$i], (array)$allKonteksSelected) ? '☑' : '☐' }} {{ $allKonteks[$i] }}
                @else
                    {{-- Kotak ceklis selalu muncul untuk "Konteks Lain" --}}
                    {{ !empty($konteksLainList[$i - count($allKonteks)]) ? '☑' : '☐' }}
                    {{ $konteksLainList[$i - count($allKonteks)] ?? '' }}
                @endif
            </td>

            <!-- Pendekatan -->
            <td style="border:1px solid #000; padding:4px;">
                @if(isset($allPendekatan[$i]))
                    {{ in_array($allPendekatan[$i], (array)$pendekatanSelected) ? '☑' : '☐' }} {{ $allPendekatan[$i] }}
                @elseif($i === count($allPendekatan) && !in_array('Mengkaji Bukti-bukti', (array)$pendekatanSelected))
                    ☐ Mengkaji Bukti-bukti
                @else
                    &nbsp;
                @endif
            </td>
        </tr>
    @endfor

    {{-- Orang Relevan --}}
    <tr style="background-color:#fff2cc; font-weight:bold; text-align:center;">
        <td>Orang yang Relevan</td>
        <td>Nama</td>
        <td>Hasil Konfirmasi / Diskusi <br>[Tujuan, Fokus & Konteks]</td>
    </tr>

    @foreach($orangRelevanTable as $row)
    <tr>
        <!-- Jabatan -->
        <td style="border:1px solid #000; padding:4px; vertical-align:top;">
            {{ $row['adaIsi'] ? '☑' : '☐' }} {{ $row['jabatan'] }}
        </td>

        <!-- Nama -->
        <td style="border:1px solid #000; padding:0; vertical-align:top;">
            @if($row['adaIsi'])
                <table style="width:100%; border-collapse:collapse; font-size:12px; border:none;">
                    @foreach($row['namaList'] as $index => $nama)
                        <tr>
                            <td style="
                                border:none; 
                                {{ !$loop->last ? 'border-bottom:1px solid #000;' : '' }};
                                padding:4px 6px;
                                text-align:center;
                                vertical-align:middle;
                            ">
                                {{ $nama }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <div style="padding:4px;"></div>
            @endif
        </td>

        <!-- Hasil Diskusi -->
        @if($loop->first) {{-- Hanya tampil sekali --}}
            <td style="border:1px solid #000; padding:4px; vertical-align:top;" rowspan="{{ count($orangRelevanTable) }}">
                {{ $hasilDiskusiGlobal ?: '-' }}
            </td>
        @endif
    </tr>
    @endforeach
</table>
<br>
<!-- ACUAN PEMBANDING -->
<div class="card-box mb-4">
    <div class="table-responsive mt-4">
        <table class="table custom-table" style="border:1px solid #000; border-collapse:collapse; width:100%; font-size:12px;">
            <thead>
                <tr style="text-align:center; font-weight:bold;">
                    <th style="border:1px solid #000; width:50%;">Acuan Pembanding</th>
                    <th style="border:1px solid #000; width:50%;">Dokumen Terkait dan Bahan-bahan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    // Pastikan tambahan dari DB selalu array
                    $acuanLain = $acuanLain ?? [];
                    $dokumenLain = $dokumenLain ?? [];

                    // Gabungkan default + tambahan
                    $allAcuan = array_merge($defaultAcuan ?? [], $acuanLain);
                    $allDokumen = array_merge($defaultDokumen ?? [], $dokumenLain);

                    // Minimal 7 baris
                    $maxRows = max(6, count($allAcuan), count($allDokumen));
                @endphp

                @for($i = 0; $i < $maxRows; $i++)
                    <tr>
                        <!-- Acuan Pembanding -->
                        <td style="border:1px solid #000; padding:4px;">
                            @php
                                $acuanText = $allAcuan[$i] ?? '';
                                $acuanCheck = $acuanText !== '' && (in_array($acuanText, $acuanSelected ?? []) || in_array($acuanText, $acuanLain ?? []));
                            @endphp
                            <input type="checkbox" {{ $acuanCheck ? 'checked' : '' }} disabled>
                            {{ $acuanText }}
                        </td>

                        <!-- Dokumen Terkait dan Bahan-bahan -->
                        <td style="border:1px solid #000; padding:4px;">
                            @php
                                $dokumenText = $allDokumen[$i] ?? '';
                                $dokumenCheck = $dokumenText !== '';
                            @endphp
                            <input type="checkbox" {{ $dokumenCheck ? 'checked' : '' }} disabled>
                            {{ $dokumenText }}
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
<br>
<table style="width:100%; border-collapse:collapse; border:1px solid #000;">
    <tr>
        <td colspan="2" class="table-section-title">2. Memberikan Kontribusi dalam Proses Validasi</td>
    </tr>

    <tr>
        <td style="width:50%; border:1px solid #000;">
            Keterampilan komunikasi yang digunakan dalam kegiatan validasi :
        </td>

        <td style="width:50%; padding:0; border-left:1px solid #000; border-right:1px solid #000;">
            <table style="width:100%; border-collapse:collapse;">
                @foreach ($defaultKeterampilan as $item)
                    <div style="
                        display: flex;
                        align-items: center;
                        gap: 6px;
                        padding: 4px 0;
                        border-bottom: 1px solid #000;
                    ">
                        <input type="checkbox"
                            {{ in_array(strtolower($item), $keterampilanSelected) ? 'checked' : '' }}
                            style="width: 14px; height: 14px;">

                        <span style="font-size: 13px;">
                            {{ strtoupper($item) }}
                        </span>
                    </div>
                @endforeach
            </table>
        </td>
    </tr>
</table>
<br>
<table style="width:100%; border-collapse:collapse; border:1px solid #000; font-size:12px;">
    <thead>
        <tr style="background-color:#fff2cc; font-weight:bold; text-align:center;">
            <td rowspan="2" style="border:1px solid #000;">No</td>
            <td rowspan="2" style="border:1px solid #000;">
                Aspek Dalam Kegiatan Validasi <br>(Meninjau, Membandingkan, Mengevaluasi)
            </td>
            <td colspan="{{ count($aturanList) }}" style="border:1px solid #000;">Aturan Bukti</td>
            <td colspan="{{ count($prinsipList) }}" style="border:1px solid #000;">Prinsip Asesmen</td>
        </tr>
        <tr style="text-align:center; background-color:#fff2cc; font-weight:bold;">
            @foreach($aturanList as $kode)
                <td>{{ $kode }}</td>
            @endforeach
            @foreach($prinsipHeaderPdf as $kode)
                <td>{{ $kode }}</td>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach($aspekList as $row)
            <tr>
                <td style="text-align:center; border:1px solid #000;">{{ $row['no'] }}</td>
                <td style="border:1px solid #000;">{{ $row['label'] }}</td>

                {{-- Aturan Bukti --}}
                @foreach($aturanList as $kode)
                    <td style="text-align:center; border:1px solid #000;">
                        {{ in_array($kode, $row['aturan']) ? '☑' : '☐' }}
                    </td>
                @endforeach

                {{-- Prinsip Asesmen --}}
                @foreach($prinsipList as $kode)
                    @php
                        $isRed = in_array([$row['no'], $kode], $redCells);
                    @endphp
                    <td style="text-align:center; border:1px solid #000; {{ $isRed ? 'color:red;font-weight:bold;' : '' }}">
                        {{ in_array($kode, $row['prinsip']) ? '☑' : '☐' }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<p>☑ yang perlu</p>
<br>
<table style="width:100%; border-collapse:collapse; border:1px solid #000;">
    <!-- 3. Memberikan Kontribusi untuk Hasil Asesmen -->
    <tr>
        <td colspan="3" style="font-weight:bold;">3. Memberikan Kontribusi untuk Hasil Asesmen</td>
    </tr>
    <tr style="background:#fff2cc; font-weight:bold; text-align:center;">
        <td style="width:5%; border:1px solid #000;">No</td>
        <td style="width:45%; border:1px solid #000;">Temuan Validasi</td>
        <td style="width:50%; border:1px solid #000;">Rekomendasi untuk Meningkatkan Praktek Asesmen</td>
    </tr>

    @forelse($kontribusiList as $index => $row)
        <tr>
            <td style="border:1px solid #000; text-align:center;">{{ $index + 1 }}</td>
            <td style="border:1px solid #000;">{{ $row->temuan ?? '-' }}</td>
            <td style="border:1px solid #000;">{{ $row->rekomendasi ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" style="border:1px solid #000; text-align:center;">Belum ada data kontribusi</td>
        </tr>
    @endforelse
</table>
<br>
<table style="width:100%; border-collapse:collapse; border:1px solid #000; font-size:12px; margin-top:10px;">
    <!-- 4. Rencana Implementasi Perubahan / Perbaikan Pelaksanaan Asesmen -->
    <tr>
        <td colspan="4" style="font-weight:bold;">Rencana Implementasi Perubahan / Perbaikan Pelaksanaan Asesmen</td>
    </tr>

    <tr style="background:#fff2cc; font-weight:bold; text-align:center;">
        <td style="width:5%; border:1px solid #000;">No</td>
        <td style="width:50%; border:1px solid #000;">Kegiatan Perbaikan Sesuai Rekomendasi</td>
        <td style="width:20%; border:1px solid #000;">Waktu Penyelesaian</td>
        <td style="width:25%; border:1px solid #000;">Penanggung Jawab</td>
    </tr>

    @forelse($rencanaList as $index => $rencana)
        <tr>
            <td style="border:1px solid #000; text-align:center;">{{ $index + 1 }}</td>
            <td style="border:1px solid #000;">{{ $rencana->kegiatan_perbaikan ?? '-' }}</td>
            <td style="border:1px solid #000; text-align:center;">
                {{ $rencana->waktu_penyelesaian ? \Carbon\Carbon::parse($rencana->waktu_penyelesaian)->format('d/m/Y') : '-' }}
            </td>
            <td style="border:1px solid #000;">{{ $rencana->penanggung_jawab ?? '-' }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="4" style="border:1px solid #000; text-align:center;">Belum ada data rencana perbaikan</td>
        </tr>
    @endforelse
</body>
</html>
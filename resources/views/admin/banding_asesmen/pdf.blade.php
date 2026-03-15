<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FR.AK.04 - Banding Asesmen</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 2cm;
            font-size: 12px;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 5px;
        }
        .subheader {
            text-align: center;
            font-size: 14px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        td, th {
            border: 1px solid black;
            padding: 8px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            background-color: #f0f0f0;
        }
        .checkbox {
            font-size: 20px;
            font-family: 'DejaVu Sans', sans-serif;
        }
        .signature {
            margin-top: 40px;
        }
        .signature-line {
            border-bottom: 1px solid black;
            width: 300px;
            display: inline-block;
            margin: 0 10px;
        }
        .info-note {
            margin: 20px 0;
            font-style: italic;
        }
        .footer {
            margin-top: 50px;
            font-size: 10px;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">FR.AK.04.</div>
    <div class="subheader">BANDING ASESMEN</div>

    <!-- Data Asesi, Asesor, Tanggal -->
    <table>
        <tr>
            <td class="label" style="width: 30%;">Nama Asesi</td>
            <td style="width: 70%;">{{ $banding->asesi->user->name ?? $banding->asesi->nama_asesi ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Nama Asesor</td>
            <td>{{ $banding->permohonan->asesi->asesor->user->name ?? $banding->permohonan->asesi->asesor->nama_asesor ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Asesmen</td>
            <td>{{ $banding->tgl_asesmen ? \Carbon\Carbon::parse($banding->tgl_asesmen)->format('d/m/Y') : '-' }}</td>
        </tr>
    </table>

    <!-- Tabel Pertanyaan Ya/Tidak -->
    <table>
        <tr>
            <th style="width: 70%;">Pertanyaan</th>
            <th style="width: 15%;">YA</th>
            <th style="width: 15%;">TIDAK</th>
        </tr>
        <tr>
            <td>Apakah Proses Banding telah dijelaskan kepada Anda?</td>
            <td style="text-align: center;">{!! $banding->banding_dijelaskan == 'Ya' ? '☑' : '☐' !!}</td>
            <td style="text-align: center;">{!! $banding->banding_dijelaskan == 'Tidak' ? '☑' : '☐' !!}</td>
        </tr>
        <tr>
            <td>Apakah Anda telah mendiskusikan Banding dengan Asesor?</td>
            <td style="text-align: center;">{!! $banding->diskusi_dengan_asesor == 'Ya' ? '☑' : '☐' !!}</td>
            <td style="text-align: center;">{!! $banding->diskusi_dengan_asesor == 'Tidak' ? '☑' : '☐' !!}</td>
        </tr>
        <tr>
            <td>Apakah Anda mau melibatkan "orang lain" membantu Anda dalam Proses Banding?</td>
            <td style="text-align: center;">{!! $banding->libatkan_orang_lain == 'Ya' ? '☑' : '☐' !!}</td>
            <td style="text-align: center;">{!! $banding->libatkan_orang_lain == 'Tidak' ? '☑' : '☐' !!}</td>
        </tr>
    </table>

    <!-- Skema Sertifikasi -->
    <table>
        <tr>
            <td class="label" style="width: 30%;">Skema Sertifikasi</td>
            <td style="width: 40%;">{{ $banding->permohonan->skema->nama_skema ?? '-' }}</td>
            <td class="label" style="width: 15%;">No. Skema</td>
            <td style="width: 15%;">{{ $banding->permohonan->skema->kode_skema ?? '-' }}</td>
        </tr>
    </table>

    <!-- Alasan Banding -->
    <table>
        <tr>
            <td class="label">Banding ini diajukan atas alasan sebagai berikut :</td>
        </tr>
        <tr>
            <td style="height: 100px;">{{ $banding->alasan_banding ?? '-' }}</td>
        </tr>
    </table>

    <!-- Hak Banding (catatan) -->
    <div class="info-note">
        <p>Anda mempunyai hak mengajukan banding jika Anda menilai Proses Asesmen tidak sesuai SOP dan tidak memenuhi Prinsip Asesmen.</p>
    </div>

    <!-- Tanda Tangan Asesi -->
    <div class="signature">
        <table style="border: none; width: 100%;">
            <tr style="border: none;">
                <td style="border: none; width: 50%;">Tanda tangan Asesi :</td>
                <td style="border: none; width: 50%;">Tanggal :</td>
            </tr>
            <tr style="border: none;">
                <td style="border: none;">
                    @if($banding->persetujuan && $banding->persetujuan->ttd_asesi)
                        <img src="{{ public_path('storage/' . $banding->persetujuan->ttd_asesi) }}" style="max-height: 80px; max-width: 200px;">
                    @else
                        ............................
                    @endif
                </td>
                <td style="border: none;">
                    {{ $banding->persetujuan->tgl_ttd_asesi ?? '............................' }}
                </td>
            </tr>
        </table>
    </div>

    <!-- Footer tanggal cetak -->
    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }}
    </div>
</body>
</html>
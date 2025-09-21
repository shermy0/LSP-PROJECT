<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Form Asesmen PDF</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .section-box { margin-bottom: 20px; padding: 10px; border: 1px solid #ccc; }
        .header-title { font-size: 16px; font-weight: bold; color: #041C5C; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        table, th, td { border: 1px solid #000; }
        th, td { padding: 6px; text-align: center; }
        .signature { width: 200px; height: 100px; border: 1px solid #000; margin-top: 5px; }
    </style>
</head>
<body>

    <div class="section-box">
        <div class="header-title">Biodata</div>
        <p>No. Form: {{ $no_form }}</p>
        <p>Judul Skema: {{ $judul_skema }}</p>
        <p>Nama Asesor: {{ $nama_asesor }}</p>
        <p>Nama Asesi: {{ $nama_asesi }}</p>
        <p>Tanggal Asesmen: {{ $tanggal_asesmen }}</p>
        <p>TUK: {{ $tuk }}</p>
    </div>

    <div class="section-box">
        <div class="header-title">Lembar Jawaban Pilihan Ganda</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jawaban</th>
                    <th>Ya</th>
                    <th>Tidak</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jawaban as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['jawaban'] ?? '-' }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section-box">
        <div class="header-title">Umpan Balik</div>
        <p>{{ $umpan_balik }}</p>
    </div>

    <div class="section-box">
        <div class="header-title">Tanda Tangan</div>
        <table>
            <tr>
                <td>
                    <p>Asesi</p>
                    @if($ttdAsesi)
                        <img src="{{ $ttdAsesi }}" class="signature">
                    @else
                        <div class="signature"></div>
                    @endif
                </td>
                <td>
                    <p>Asesor</p>
                    @if($ttdAsesor)
                        <img src="{{ $ttdAsesor }}" class="signature">
                    @else
                        <div class="signature"></div>
                    @endif
                </td>
            </tr>
        </table>
    </div>

</body>
</html>

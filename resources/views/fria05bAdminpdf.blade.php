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
    </style>
</head>
<body>

    {{-- ================= BIODATA ================= --}}
    <div class="section-box">
        <div class="header-title">Biodata</div>
        <p>No. Form: {{ $no_form }}</p>
        <p>Judul Skema: {{ $judul_skema }}</p>
        <p>TUK: {{ $tuk }}</p>
    </div>

    {{-- ================= KUNCI JAWABAN ================= --}}
    <div class="section-box">
        <div class="header-title">Lembar Kunci Jawaban Pilihan Ganda</div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jawaban as $i => $item)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['jawaban'] ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ================= PENYUSUN & VALIDATOR ================= --}}
    <div class="section-box">
        <div class="header-title">Penyusun dan Validator</div>
        <table>
            <thead>
                <tr>
                    <th>Status</th>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nomor MET</th>
                    <th>Tanda Tangan & Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penyusun as $i => $item)
                    <tr>
                        <td>{{ $item['status'] ?? '' }}</td>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $item['nama'] ?? '' }}</td>
                        <td>{{ $item['nomor'] ?? '' }}</td>
                        <td>{{ $item['ttd'] ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>FRIA05A - Kunci Jawaban</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h3 { margin: 0; }
        .section { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid #000; padding: 6px; text-align: left; }
        .pertanyaan { margin-top: 10px; }
        .jawaban { margin-left: 15px; }
    </style>
</head>
<body>
    {{-- HEADER --}}
    <div style="text-align: center; margin-bottom: 20px;">
        <h2>FR.IA.05.A</h2>
        <p>Kunci Jawaban Tes Tertulis Pilihan Ganda</p>
    </div>

    {{-- BIODATA --}}
    <div class="section">
        <p><strong>No. Form:</strong> {{ $no_form }}</p>
        <p><strong>Judul Skema Sertifikasi:</strong> {{ $judul_skema }}</p>
        <p><strong>TUK:</strong> {{ $tuk }}</p>
    </div>

    {{-- PERTANYAAN DAN JAWABAN --}}
    <div class="section">
        <h3>Pertanyaan & Jawaban</h3>
        @forelse($jawaban as $no => $data)
            <div class="pertanyaan">
                <p><strong>{{ $no }}. {{ $data['pertanyaan'] ?? '---' }}</strong></p>
                <div class="jawaban">
                    @foreach(['a','b','c','d','e'] as $opsi)
                        <p>
                            {{ $opsi }}. {{ $data['opsi'][$opsi] ?? '-' }}
                            @if(($data['jawaban'] ?? '') == $opsi)
                                <strong>(✔)</strong>
                            @endif
                        </p>
                    @endforeach
                </div>
            </div>
        @empty
            <p>Belum ada data pertanyaan.</p>
        @endforelse
    </div>

    {{-- PENYUSUN --}}
    <div class="section">
        <h3>Penyusun dan Validator</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No. MET</th>
                </tr>
            </thead>
            <tbody>
                @forelse($penyusun as $i => $p)
                    <tr>
                        <td>{{ $p['status'] ?? '-' }}</td>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $p['nama'] ?? '-' }}</td>
                        <td>{{ $p['nomor_met'] ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada data penyusun.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>

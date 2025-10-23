<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>FR.MAPA.02 - {{ $skema->nama_skema ?? '' }}</title>
<style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #000; }
    h3 { text-align:center; margin-bottom:5px; }
    .text-center { text-align:center; }
    .table { width:100%; border-collapse:collapse; margin-top:10px; }
    .table th, .table td { border:1px solid #000; padding:5px; vertical-align:top; }
    .table-title th { background:#f0f0f0; font-weight:bold; text-align:center; }
    img { max-width:120px; }
    .judul-header { font-weight:bold; margin-top:20px; }
    .muted { color:#777; }
</style>
</head>
<body>

<h3>FR.MAPA.02 – PETA INSTRUMEN ASESSMEN</h3>
<p class="text-center"><strong>{{ $skema->nama_skema ?? '-' }}</strong></p>

{{-- LOOP KELOMPOK --}}
@foreach($kelompokPekerjaan as $index => $kelompok)
    <div class="judul-header">Kelompok Pekerjaan {{ $index + 1 }}</div>

    <table class="table">
        <thead class="table-title">
            <tr>
                <th>No</th>
                <th>Kode Unit</th>
                <th>Unit Kompetensi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kelompok->hasilAsesmen as $hasil)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $hasil->unit->kode_unit ?? '-' }}</td>
                    <td>{{ $hasil->unit->judul_unit ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">Belum ada unit</td></tr>
            @endforelse
        </tbody>
    </table>

    <br>

    {{-- Instrumen --}}
    <table class="table">
        <thead class="table-title">
            <tr>
                <th rowspan="2">No</th>
                <th rowspan="2">Instrumen Asesi</th>
                <th colspan="5">Potensi Asesi</th>
            </tr>
            <tr>
                @for($i=1;$i<=5;$i++)
                    <th>{{ $i }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @php
                $instrumenMap = [
                    'cek_observasi' => 'FR.IA.01. CL - Ceklis Observasi Aktivitas',
                    'tugas_praktik' => 'FR.IA.02. TPD - Tugas Praktik Demonstrasi',
                    'tanya_observasi' => 'FR.IA.03. PMO – Pertanyaan Mendukung Observasi',
                    'instruksi_tertulis' => 'FR.IA.04. DIT - Daftar Instruksi Tertulis',
                    'soal_pg' => 'FR.IA.05. DPT – Pertanyaan Tertulis Pilihan Ganda',
                    'soal_esai' => 'FR.IA.06. DPT – Pertanyaan Esai',
                    'soal_uraian' => 'FR.IA.07. DPT – Pertanyaan Uraian',
                    'cek_portofolio' => 'FR.IA.08. CVP – Verifikasi Portofolio',
                    'tanya_wawancara' => 'FR.IA.09. PW – Pertanyaan Wawancara',
                    'verifikasi_pihak3' => 'FR.IA.10. VPK – Verifikasi Pihak Ketiga',
                    'cek_produk' => 'FR.IA.11. CRP – Reviu Produk',
                ];
            @endphp

            @foreach($instrumenMap as $field => $judul)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $judul }}</td>
                    @for($j=1;$j<=5;$j++)
                        <td class="text-center">
                            @if(isset($instrumenPerKelompok[$kelompok->id_kelompok]) 
                                && $instrumenPerKelompok[$kelompok->id_kelompok]->$field == $j)
                                &#10003;
                            @endif
                        </td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach

{{-- PENYUSUN --}}
<div class="judul-header">Penyusun</div>
<table class="table">
    <thead class="table-title">
        <tr>
            <th>Nama Asesor</th>
            <th>No Met</th>
            <th>Tanggal</th>
            <th>Tanda Tangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($penyusun as $p)
        <tr>
            <td>{{ $p->id_asesor ? ($asesors->firstWhere('id_asesor',$p->id_asesor)->nama_asesor ?? '-') : '-' }}</td>
            <td>{{ $p->no_met ?? ($asesors->firstWhere('id_asesor',$p->id_asesor)->no_met ?? '-') }}</td>
            <td>{{ isset($p->tanggal) ? \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') : '-' }}</td>
            <td class="text-center">
                @if($p->tanda_tangan)
                    <img src="{{ $p->tanda_tangan }}" alt="TTD" width="120">
                @else
                    <span class="muted">Belum ada TTD</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{-- VALIDATOR --}}
<div class="judul-header">Validator</div>
<table class="table">
    <thead class="table-title">
        <tr>
            <th>Nama Validator</th>
            <th>No Met</th>
            <th>Tanggal</th>
            <th>Tanda Tangan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($validators as $v)
        <tr>
            <td>{{ $v->nama_validator ?? $v->nama_asesor ?? '-' }}</td>
            <td>{{ $v->no_registrasi ?? $v->no_met ?? '-' }}</td>
            <td>{{ isset($v->tanggal) ? \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') : '-' }}</td>
            <td class="text-center">
                @if($v->tanda_tangan ?? $v->ttd)
                    <img src="{{ $v->tanda_tangan ?? $v->ttd }}" alt="TTD" width="120">
                @else
                    <span class="muted">Belum ada TTD</span>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>

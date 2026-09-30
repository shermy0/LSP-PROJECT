<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>FR.MAPA.02 - {{ $skema->nama_skema ?? '' }}</title>
<link rel="stylesheet" href="{{ public_path('assets/css/pdfmapa.css') }}">
</head>
<body>

<h3>FR.MAPA.02 – PETA INSTRUMEN ASESSMEN</h3>
@php
    use Illuminate\Support\Str;
@endphp

<table class="table" style="margin-bottom: 8px;">
    <tr>
        <td style="width: 50%; border-right: 1px solid #000; vertical-align: top; padding: 6px 8px;">
            <strong>Skema Sertifikasi</strong><br>
            (
            <span @if(Str::contains($skema->jenjang, 'KKNI')) style="text-decoration: none; font-weight:bold;" @else class="strike" @endif>KKNI</span> /
            <span @if(Str::contains($skema->jenjang, 'Okupasi')) style="text-decoration: none; font-weight:bold;" @else class="strike" @endif>Okupasi</span> /
            <span @if(Str::contains($skema->jenjang, 'Klaster')) style="text-decoration: none; font-weight:bold;" @else class="strike" @endif>Klaster</span>
            )
        </td>
        <td style="width: 50%; vertical-align: top; padding: 0;">
            <div style="display: flex; flex-direction: column; width: 100%; margin: 0;">
                <div style="padding: 6px 8px 6px 8px;">
                    <strong>Judul:</strong> {{ $skema->nama_skema }}
                </div>
                <div style="border-bottom: 1px solid #000; width: 100%; margin: 0;"></div>
                <div style="padding: 4px 8px 6px 8px;">
                    <strong>Nomor:</strong> {{ $skema->kode_skema }}
                </div>
            </div>
        </td>
    </tr>
</table>


{{-- LOOP KELOMPOK --}}
@foreach($kelompokPekerjaan as $index => $kelompok)
    {{-- Kalau bukan kelompok pertama, mulai di halaman baru --}}
    @if($index > 0)
        <div class="page-break"></div>
    @endif

    @php 
        $no = 1; 
        $totalUnit = count($kelompok->hasilAsesmen);
    @endphp

    {{-- === TABEL KELOMPOK === --}}
    <table border="1" cellspacing="0" cellpadding="4" width="100%"
        style="border-collapse: collapse; font-size: 11px; margin-top: 10px; table-layout: fixed;">
        <tr style="background-color:#fff2cc; font-weight:bold;">
            <td rowspan="{{ $totalUnit + 1 }}" 
                style="width:30%; border:1px solid #000; vertical-align: middle; text-align:center;">
                {{ $kelompok->nama_kelompok ?? '-' }}
            </td>
            <td style="width:10%; border:1px solid #000;">No.</td>
            <td style="width:20%; border:1px solid #000;">Kode Unit</td>
            <td style="width:40%; border:1px solid #000;">Judul Unit</td>
        </tr>

        @forelse ($kelompok->hasilAsesmen as $hasil)
            <tr>
                <td style="text-align:center; border:1px solid #000;">{{ $no++ }}</td>
                <td style="border:1px solid #000;">{{ $hasil->unit->kode_unit ?? '-' }}</td>
                <td style="border:1px solid #000;">{{ $hasil->unit->judul_unit ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" style="text-align:center; border:1px solid #000;">Belum ada unit</td>
            </tr>
        @endforelse
    </table>

    <br>

    {{-- === TABEL INSTRUMEN === --}}
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


<!-- === Penyusun dan Validator === -->
<div class="section">
    <div class="section-title">Penyusun dan Validator</div>

    <table class="table">
        <thead>
            <tr>
                <th style="width:18%;">Status</th>
                <th style="width:7%; text-align:center;">No.</th>
                <th style="width:30%;">Nama</th>
                <th style="width:20%;">Nomor MET / Registrasi</th>
                <th style="width:25%;">Tanda Tangan &amp; Tanggal</th>
            </tr>
        </thead>
        <tbody>
            {{-- === PENYUSUN === --}}
            @php $no = 1; @endphp
            @if(count($penyusun) > 0)
                @foreach($penyusun as $index => $p)
                    <tr>
                        @if($index == 0)
                            <td rowspan="{{ count($penyusun) }}" style="vertical-align: middle;">Penyusun</td>
                        @endif
                        <td class="center">{{ $no++ }}</td>
                        <td>
                            {{ $p->id_asesor
                                ? ($asesors->firstWhere('id_asesor', $p->id_asesor)->nama_asesor ?? '-')
                                : '-' }}
                        </td>
                        <td>
                            {{ $p->no_met ?? ($asesors->firstWhere('id_asesor', $p->id_asesor)->no_met ?? '-') }}
                        </td>
                        <td style="text-align:center;">
                            @if(!empty($p->tanda_tangan))
                                <img src="{{ $p->tanda_tangan }}" class="signature-img" alt="ttd-penyusun" width="120"><br>
                                <span class="date-text">
                                    {{ isset($p->tanggal) ? \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') : '-' }}
                                </span>
                            @else
                                <span class="muted">Belum ada tanda tangan</span><br>
                                <span class="date-text">
                                    {{ isset($p->tanggal) ? \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') : '-' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="5" class="muted">Belum ada penyusun</td></tr>
            @endif

            {{-- === VALIDATOR === --}}
            @php $no = 1; @endphp
            @if(count($validators) > 0)
                @foreach($validators as $index => $v)
                    <tr>
                        @if($index == 0)
                            <td rowspan="{{ count($validators) }}" style="vertical-align: middle;">Validator</td>
                        @endif
                        <td class="center">{{ $no++ }}</td>
                        <td>{{ $v->nama_asesor ?? $v->nama_validator ?? '-' }}</td>
                        <td>{{ $v->no_registrasi ?? $v->no_met ?? '-' }}</td>
                        <td style="text-align:center;">
                            @if(!empty($v->tanda_tangan) || !empty($v->ttd))
                                <img src="{{ $v->tanda_tangan ?? $v->ttd }}" class="signature-img" alt="ttd-validator" width="120"><br>
                                <span class="date-text">
                                    {{ isset($v->tanggal) ? \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') : '-' }}
                                </span>
                            @else
                                <span class="muted">Belum ada tanda tangan</span><br>
                                <span class="date-text">
                                    {{ isset($v->tanggal) ? \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') : '-' }}
                                </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr><td colspan="5" class="muted">Belum ada validator</td></tr>
            @endif
        </tbody>
    </table>
</div>
</body>
</html>

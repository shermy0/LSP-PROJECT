<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>FR.MAPA.01 - Perencanaan Asesmen</title>

<style>
    /* A4 portrait */
    @page { size: A4 portrait; margin: 20mm 12mm; }
    body {
        font-family: "DejaVu Sans", "Arial", sans-serif;
        font-size: 12px;
        color: #000;
        line-height: 1.25;
    }

    .header {
        text-align: center;
        margin-bottom: 8px;
    }
    .title {
        font-weight: 700;
        font-size: 16px;
        margin-bottom: 2px;
    }
    .subtitle {
        font-size: 12px;
        color: #333;
        margin-bottom: 10px;
    }

    .skema-row {
        display:flex;
        justify-content:space-between;
        margin-bottom: 8px;
    }
    .skema-label { font-weight:600; }
    .box { border: 1px solid #222; padding:8px; border-radius:4px; }

    .section { margin-bottom: 14px; }
    .section .heading { font-weight:700; margin-bottom:6px; background:#f0f0f0; padding:6px; display:block; }

    table { width:100%; border-collapse: collapse; margin-bottom: 8px; }
    table th, table td { border: 1px solid #666; padding:6px; vertical-align: top; }
    table th { background:#efefef; font-weight:700; }

    .label-inline { display:inline-block; margin-right:10px; }
    .checkbox { display:inline-block; width:14px; height:14px; border:1px solid #222; text-align:center; line-height:12px; font-size:10px; margin-right:6px; vertical-align:middle; }
    .checked { background:#222; color:#fff; }

    .small { font-size:11px; color:#333; }
    .muted { color:#666; font-size:11px; }

    .signature-img { max-width:140px; max-height:80px; display:block; }

    .page-break { page-break-after: always; }

    /* make tables look good on PDF */
    .no-border td, .no-border th { border: none; padding: 4px; }
    .compact td { padding:4px; }

    /* for consistent spacing */
    .gap { height:8px; }

</style>
</head>
<body>

<!-- Header -->
<div class="header">
    <div class="title">FR.MAPA.01 – Perencanaan Asesmen</div>
    <div class="subtitle">Merencanakan Aktivitas dan Proses — Peninjauan Proses Asesmen</div>
</div>

<!-- SKEMA -->
<div class="section">
    <div class="box">
        <table class="no-border">
            <tr>
                <td style="width:65%">
                    <strong>Nama Skema:</strong><br>
                    {{ $skema->nama_skema ?? '-' }}
                </td>
                <td style="width:35%">
                    <strong>Nomor Skema:</strong><br>
                    {{ $skema->kode_skema ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>
                    <strong>Jenjang:</strong><br>
                    {{ $skema->jenjang ?? '-' }}
                </td>
                <td>
                    <strong>Unit Kompetensi (terdaftar):</strong><br>
                    {{ count($standarKompetensi) }} item
                </td>
            </tr>
        </table>
    </div>
</div>

<!-- 1. Menentukan Pendekatan -->
<div class="section">
    <div class="heading">1. Menentukan Pendekatan Asesmen</div>

    <div style="margin-bottom:6px;"><strong>Asesi — Pendekatan yang dipilih:</strong></div>
    <div>
        <span class="label-inline">
            <span class="checkbox {{ ($pendekatan && $pendekatan->pelatihan_standar) ? 'checked' : '' }}">{{ ($pendekatan && $pendekatan->pelatihan_standar) ? '✓' : '' }}</span>
            Hasil pelatihan dan/atau pendidikan (Kurikulum & fasilitas telusur)
        </span>
        <span class="label-inline">
            <span class="checkbox {{ ($pendekatan && $pendekatan->pelatihan_nonstandar) ? 'checked' : '' }}">{{ ($pendekatan && $pendekatan->pelatihan_nonstandar) ? '✓' : '' }}</span>
            Hasil pelatihan/pendidikan (kurikulum belum berbasis kompetensi)
        </span>
    </div>

    <div style="margin-top:6px;">
        <span class="label-inline">
            <span class="checkbox {{ ($pendekatan && $pendekatan->pengalaman_standar) ? 'checked' : '' }}">{{ ($pendekatan && $pendekatan->pengalaman_standar) ? '✓' : '' }}</span>
            Pekerja berpengalaman (tempat kerja telusur)
        </span>
        <span class="label-inline">
            <span class="checkbox {{ ($pendekatan && $pendekatan->pengalaman_nonstandar) ? 'checked' : '' }}">{{ ($pendekatan && $pendekatan->pengalaman_nonstandar) ? '✓' : '' }}</span>
            Pekerja berpengalaman (tempat kerja belum berbasis kompetensi)
        </span>
        <span class="label-inline">
            <span class="checkbox {{ ($pendekatan && $pendekatan->otodidak) ? 'checked' : '' }}">{{ ($pendekatan && $pendekatan->otodidak) ? '✓' : '' }}</span>
            Otodidak / pembelajaran mandiri
        </span>
    </div>

    <div class="gap"></div>

    <div><strong>Tujuan Asesmen:</strong></div>
    <table class="compact">
        <tbody>
            @foreach($defaultTujuan as $nama)
            <tr>
                <td style="width:6%"><span class="checkbox {{ in_array($nama, $tujuanDipilih ?? []) ? 'checked' : '' }}">{{ in_array($nama, $tujuanDipilih ?? []) ? '✓' : '' }}</span></td>
                <td>{{ $nama }}</td>
            </tr>
            @endforeach

            @foreach($customTujuan as $nama)
            <tr>
                <td><span class="checkbox {{ in_array($nama, $tujuanDipilih ?? []) ? 'checked' : '' }}">{{ in_array($nama, $tujuanDipilih ?? []) ? '✓' : '' }}</span></td>
                <td>{{ $nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>

<div class="page-break"></div>

<!-- 2. Konteks Asesmen -->
<div class="section">
    <div class="heading">2. Konteks Asesmen</div>

    <div style="margin-bottom:8px;">
        <strong>Lingkungan:</strong>
        <span class="label-inline"><span class="checkbox {{ $konteks->lingkungan == 'Tempat kerja nyata' ? 'checked' : '' }}">{{ $konteks->lingkungan == 'Tempat kerja nyata' ? '✓' : '' }}</span> Tempat kerja nyata</span>
        <span class="label-inline"><span class="checkbox {{ $konteks->lingkungan == 'Tempat kerja simulasi' ? 'checked' : '' }}">{{ $konteks->lingkungan == 'Tempat kerja simulasi' ? '✓' : '' }}</span> Tempat kerja simulasi</span>
    </div>

    <div style="margin-bottom:8px;">
        <strong>Peluang:</strong>
        <span class="label-inline"><span class="checkbox {{ $konteks->peluang == 'Tersedia' ? 'checked' : '' }}">{{ $konteks->peluang == 'Tersedia' ? '✓' : '' }}</span> Tersedia</span>
        <span class="label-inline"><span class="checkbox {{ $konteks->peluang == 'Terbatas' ? 'checked' : '' }}">{{ $konteks->peluang == 'Terbatas' ? '✓' : '' }}</span> Terbatas</span>
    </div>

    <div style="margin-top:8px;">
        <strong>Hubungan antar standar kompetensi dan:</strong>
        <table>
            <thead>
                <tr><th>Aspek</th><th>Status</th><th>Rating</th></tr>
            </thead>
            <tbody>
                @php
                    $hubItems = ['Bukti untuk mendukung asesmen','Aktivitas kerja di tempat kerja Asesi','Kegiatan Pembelajaran'];
                @endphp
                @foreach($hubItems as $h)
                @php
                    $checked = in_array($h, $konteks->hubungan ?? []);
                    $rating = $konteks->hubungan_rating[$h] ?? '';
                    $ratingText = $rating ? ucfirst($rating) : '-';
                @endphp
                <tr>
                    <td>{{ $h }}</td>
                    <td style="width:10%"><span class="checkbox {{ $checked ? 'checked' : '' }}">{{ $checked ? '✓' : '' }}</span></td>
                    <td>{{ $ratingText }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

<div class="page-break"></div>

<!-- 3. Standar Industri / Tempat Kerja -->
<div class="section">
    <div class="heading">3. Standar Industri / Tempat Kerja</div>

    <div style="margin-bottom:8px;">
        <strong>Standar Kompetensi yang terkait:</strong>
        <ul>
            @foreach($standarKompetensi as $sk)
                <li>{{ $sk }}</li>
            @endforeach
        </ul>
    </div>

    <div style="margin-bottom:8px;">
        <strong>Kriteria asesmen dari kurikulum pelatihan:</strong>
        <span class="label-inline"><span class="checkbox {{ isset($standar) && $standar->standar_kriteria_asesmen ? 'checked' : '' }}">{{ isset($standar) && $standar->standar_kriteria_asesmen ? '✓' : '' }}</span></span>
    </div>

    <div style="margin-bottom:6px;">
        <strong>Spesifikasi kinerja perusahaan:</strong><br>
        <div class="box small">{{ $standar->standar_kinerja_perusahaan ?? '-' }}</div>
    </div>

    <div style="margin-bottom:6px;">
        <strong>Spesifikasi produk:</strong><br>
        <div class="box small">{{ $standar->standar_spesifikasi_produk ?? '-' }}</div>
    </div>

    <div style="margin-bottom:6px;">
        <strong>Pedoman khusus:</strong><br>
        <div class="box small">{{ $standar->standar_pedoman_khusus ?? '-' }}</div>
    </div>
</div>

<div class="page-break"></div>

<!-- 4. Modifikasi & Kontekstualisasi -->
<div class="section">
    <div class="heading">4. Persyaratan Modifikasi & Kontekstualisasi</div>

    <table>
        <thead>
            <tr>
                <th style="width:35%">Aspek</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>3.1 a. Karakteristik Kandidat</td>
                <td>{{ $modifikasi->karakteristik_keterangan ?? '-' }}</td>
            </tr>
            <tr>
                <td>3.1 b. Kebutuhan kontekstual terkait tempat kerja</td>
                <td>{{ $modifikasi->kebutuhan_keterangan ?? '-' }}</td>
            </tr>
            <tr>
                <td>3.2 Saran paket pelatihan / pengembang</td>
                <td>{{ $modifikasi->saran_keterangan ?? '-' }}</td>
            </tr>
            <tr>
                <td>3.3 Penyesuaian perangkat asesmen</td>
                <td>{{ $modifikasi->penyesuaian_keterangan ?? '-' }}</td>
            </tr>
            <tr>
                <td>3.4 Peluang asesmen terintegrasi</td>
                <td>{{ $modifikasi->peluang_keterangan ?? '-' }}</td>
            </tr>
        </tbody>
    </table>
</div>

<div class="page-break"></div>

<!-- 5. Rencana Asesmen (Kelompok Pekerjaan & Unit) -->
<div class="section">
    <div class="heading">5. Rencana Asesmen — Kelompok Pekerjaan & Unit</div>

    @foreach($kelompokPekerjaan as $index => $kelompok)
        <div style="margin-bottom:8px;">
            <strong>Kelompok Pekerjaan {{ $index + 1 }} — {{ $kelompok->nama_kelompok ?? '' }}</strong>
            <table>
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:18%">Kode Unit</th>
                        <th>Unit Kompetensi</th>
                        <th>Bukti / Catatan</th>
                        <th>Jenis Bukti</th>
                        <th>Metode / Perangkat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelompok->hasilAsesmen as $i => $hasil)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hasil->unit->kode_unit ?? '-' }}</td>
                        <td>{{ $hasil->unit->judul_unit ?? '-' }}</td>
                        <td>{{ $hasil->catatan ?? '-' }}</td>
                        <td>
                            @foreach($hasil->bukti as $b)
                                {{ $b->jenisBukti->nama_bukti ?? '-' }}<br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($hasil->perangkat as $p)
                                {{ $p->perangkat->catatan_penerapan ?? '-' }}<br>
                            @endforeach
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="muted">Belum ada unit ditambahkan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endforeach

</div>

<div class="page-break"></div>

<!-- 6. Konfirmasi dengan Orang Relevan, Penyusun, Validator (Readonly) -->
<div class="section">
    <div class="heading">6. Konfirmasi & Tanda Tangan</div>

    <div style="margin-bottom:8px;">
        <strong>Konfirmasi dengan Orang Lain yang Relevan</strong>
        <table>
            <thead>
                <tr><th>Orang yang relevan</th><th>Nama</th><th>Tanggal</th><th>Tanda Tangan</th></tr>
            </thead>
            <tbody>
                @foreach($activeRoles as $role => $info)
                <tr>
                    <td>{{ $info['label'] }}</td>
                    <td>
                        @if($info['data'])
                            {{-- jika ada id_asesor di dataRole, coba nama dari asesors --}}
                            @php
                                $nama = $info['data']->id_asesor ? ($asesors->firstWhere('id_asesor', $info['data']->id_asesor)->nama_asesor ?? '-') : ($info['data']->nama ?? null);
                            @endphp
                            {{ $nama ?? '-' }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $info['data']->tanggal ?? '-' }}</td>
                    <td style="text-align:center;">
                        @if(!empty($info['data']->tanda_tangan))
                            <img src="{{ $info['data']->tanda_tangan }}" class="signature-img" alt="ttd">
                        @else
                            <span class="muted">Belum ada tanda tangan</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top:10px;">
        <strong>Penyusun</strong>
        <table>
            <thead><tr><th>Nama Asesor</th><th>No Met</th><th>Tanggal</th><th>Tanda Tangan</th></tr></thead>
            <tbody>
                @forelse($penyusun as $p)
                <tr>
                    <td>{{ $p->id_asesor ? ($asesors->firstWhere('id_asesor', $p->id_asesor)->nama_asesor ?? '-') : '-' }}</td>
                    <td>{{ $p->no_met ?? ($asesors->firstWhere('id_asesor',$p->id_asesor)->no_met ?? '-') }}</td>
                    <td>{{ $p->tanggal ?? '-' }}</td>
                    <td style="text-align:center;">
                        @if(!empty($p->tanda_tangan))
                            <img src="{{ $p->tanda_tangan }}" class="signature-img" alt="ttd-penyusun">
                        @else
                            <span class="muted">Belum ada tanda tangan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="muted">Belum ada penyusun</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div style="margin-top:10px;">
        <strong>Validator</strong>
        <table>
            <thead><tr><th>Nama Validator</th><th>No Registrasi</th><th>Tanggal</th><th>Tanda Tangan</th></tr></thead>
            <tbody>
                @forelse($validators as $v)
                <tr>
                    <td>{{ $v->nama_asesor ?? $v->nama_validator ?? '-' }}</td>
                    <td>{{ $v->no_registrasi ?? $v->no_met ?? '-' }}</td>
                    <td>{{ isset($v->tanggal) ? \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') : '-' }}</td>
                    <td style="text-align:center;">
                        @if(!empty($v->tanda_tangan) || !empty($v->ttd))
                            <img src="{{ $v->tanda_tangan ?? $v->ttd }}" class="signature-img" alt="ttd-validator">
                        @else
                            <span class="muted">Belum ada tanda tangan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="muted">Belum ada validator</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<!-- Footer kecil -->
<div style="margin-top:10px; font-size:10px; color:#555;">
    Dokumen dihasilkan otomatis dari sistem LSP — FR.MAPA.01 (Versi cetak untuk admin). Generated: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>

</body>
</html>

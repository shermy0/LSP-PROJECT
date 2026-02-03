<!DOCTYPE html>
<html lang="id">
<head>
<link rel="stylesheet" href="{{ public_path('assets/css/pdfmapa.css') }}">

<meta charset="UTF-8">
<title>FR.MAPA.01 - Perencanaan Asesmen</title>

</head>
<body>

<h3>FR.MAPA.01 - MERENCANAKAN AKTIVITAS DAN PROSES ASESMEN</h3>

<table class="table" style="margin-bottom: 8px;">
    <tr>
        <td style="width: 50%; border-right: 1px solid #000; vertical-align: top; padding: 6px 8px;">
            <strong>Skema Sertifikasi</strong><br>
            (<span class="strike">KKNI</span> / <span>Okupasi</span> / <span class="strike">Klaster</span>)
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

<!-- BAGIAN PENDEKATAN ASESMEN -->
<div class="section-title">1. Menentukan Pendekatan Asesmen</div>

<table class="table">

    <!-- === 1.1 Asesi, Tujuan, dan Konteks === -->
    <tr>
        <td class="center" style="width: 5%; vertical-align: top;">1.1</td>
        <td style="width: 40%; vertical-align: top;"><strong>Asesi</strong></td>
        <td class="no-padding" style="width: 100%; vertical-align: top;">
            <div class="checklist-group">
                <label class="checklist-box">
                    <input type="checkbox" checked disabled> Hasil pelatihan dengan kurikulum standar
                </label>
                <label class="checklist-box">
                    <input type="checkbox" disabled> Pekerja berpengalaman
                </label>
                <label class="checklist-box">
                    <input type="checkbox" disabled> Belajar mandiri (otodidak)
                </label>
            </div>
        </td>
    </tr>

    <!-- === 1.2 Tujuan Asesmen === -->
    <tr>
        <td class="center" style="width: 5%; vertical-align: top;">1.2</td>
        <td style="width: 40%; vertical-align: top;"><strong>Tujuan Asesmen</strong></td>
        <td class="no-padding" style="vertical-align: top;">
            <div class="checklist-group">
                @foreach($defaultTujuan as $nama)
                    <label class="checklist-box">
                        <input type="checkbox" disabled {{ in_array($nama, $tujuanDipilih ?? []) ? 'checked' : '' }}>
                        {{ $nama }}
                    </label>
                @endforeach
                @foreach($customTujuan as $nama)
                    <label class="checklist-box">
                        <input type="checkbox" disabled {{ in_array($nama, $tujuanDipilih ?? []) ? 'checked' : '' }}>
                        {{ $nama }}
                    </label>
                @endforeach
            </div>
        </td>
    </tr>

    <!-- === Konteks Asesmen (Revisi: Checkbox + tanpa garis pemisah) === -->
    <tr>
        <td></td>
        <td><strong>Konteks Asesmen</strong></td>
        <td class="no-padding">
            <table class="table" style="margin:0; border:none; width:100%;">
                <tr>
                    <td style="width:35%; vertical-align:top;">Lingkungan</td>
                    <td class="no-padding" style="width:65%; vertical-align:top;">
                        <div class="checklist-group no-border">
                            <label class="checklist-box">
                                <input type="checkbox" checked disabled> Tempat kerja nyata
                            </label>
                            <label class="checklist-box">
                                <input type="checkbox" disabled> Tempat kerja simulasi
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Peluang bukti dalam sejumlah situasi</td>
                    <td class="no-padding" style="vertical-align:top;">
                        <div class="checklist-group no-border">
                            <label class="checklist-box">
                                <input type="checkbox" checked disabled> Tersedia
                            </label>
                            <label class="checklist-box">
                                <input type="checkbox" disabled> Terbatas
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>

                <tr>
                    <td style="vertical-align:top;">Hubungan antara standar kompetensi dan</td>
                    <td class="no-padding" style="vertical-align:top;">
                        <div class="checklist-group">
                            @php
                                $emojiPaths = [
                                    'senang' => public_path('images/emojis/senang.png'),
                                    'datar'  => public_path('images/emojis/datar.png'),
                                    'sedih'  => public_path('images/emojis/sedih.png'),
                                ];
                                $hubunganList = [
                                    'Bukti untuk mendukung asesmen',
                                    'Aktivitas kerja di tempat kerja Asesi',
                                    'Kegiatan Pembelajaran',
                                ];
                                $hubunganRating = $konteks->hubungan_rating ?? [];
                                $hubunganChecked = $konteks->hubungan ?? [];
                            @endphp

                            @foreach($hubunganList as $label)
                                @php
                                    $selectedEmoji = $hubunganRating[$label] ?? '';
                                    $isChecked = in_array($label, $hubunganChecked);
                                @endphp

                                <div class="checklist-box" style="display:flex; align-items:center; justify-content:space-between;">
                                    <label style="display:flex; align-items:center; flex:1;">
                                        <input type="checkbox" {{ $isChecked ? 'checked' : '' }} disabled>
                                        <span style="margin-left:4px;">{{ $label }}</span>
                                    </label>
                                    <div class="emoji-group" style="display:flex; gap:6px; margin-right:4px;">
                                        @foreach(['senang','datar','sedih'] as $e)
                                            @php
                                                $emojiData = base64_encode(file_get_contents($emojiPaths[$e]));
                                            @endphp
                                            <img src="data:image/png;base64,{{ $emojiData }}"
                                                 alt="{{ $e }}"
                                                 class="emoji {{ $selectedEmoji === $e ? 'active' : '' }}"
                                                 style="width:16px; height:16px; border-radius:4px; padding:2px;">
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Pelaksana Asesmen / RPL</td>
                    <td class="no-padding" style="vertical-align:top;">
                        <div class="checklist-group">
                            <label class="checklist-box">
                                <input type="checkbox" checked disabled> Lembaga Sertifikasi
                            </label>
                            <label class="checklist-box">
                                <input type="checkbox" disabled> Organisasi Pelatihan
                            </label>
                            <label class="checklist-box">
                                <input type="checkbox" disabled> Asesor Perusahaan
                            </label>
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>

        <!-- === 1.1 Konfirmasi dengan Orang Relevan === -->
    <tr>
        <td></td>
        <td><strong>Konfirmasi dengan Orang Lain yang Relevan</strong></td>
        <td class="no-padding">
            <div class="checklist-group">
                <label class="checklist-box">
                    <input type="checkbox" {{ $konfirmasi && $konfirmasi->konfirmasi_manajer_lsp ? 'checked' : '' }} disabled>
                    Manajer Sertifikasi LSP P1 SMKN 11 Bandung
                </label>
                <label class="checklist-box">
                    <input type="checkbox" {{ $konfirmasi && $konfirmasi->konfirmasi_master_asesor ? 'checked' : '' }} disabled>
                    Master Asesor / Master Trainer / Lead Asesor Kompetensi
                </label>
                <label class="checklist-box">
                    <input type="checkbox" {{ $konfirmasi && $konfirmasi->konfirmasi_manajer_pelatihan ? 'checked' : '' }} disabled>
                    Manajer Pelatihan Lembaga Training
                </label>
                <label class="checklist-box">
                    <input type="checkbox" {{ $konfirmasi && $konfirmasi->konfirmasi_supervisor ? 'checked' : '' }} disabled>
                    Manajer atau Supervisor di Tempat Kerja
                </label>
            </div>
        </td>
    </tr>

    <!-- === 1.2 Standar Industri / Tempat Kerja === -->
    <tr>
        <td class="center" style="border-top:1px solid #000;">1.2</td>
        <td style="border-top:1px solid #000;"><strong>Standar Industri / Tempat Kerja</strong></td>
        <td class="no-padding" style="border-top:1px solid #000;">
            <div class="checklist-group">
                @foreach($standarKompetensi as $sk)
                    <label class="checklist-box">
                        <input type="checkbox" checked disabled> Standar Kompetensi: {{ $sk }}
                    </label>
                @endforeach

                <label class="checklist-box">
                    <input type="checkbox" {{ $standar->standar_kriteria_asesmen ? 'checked' : '' }} disabled>
                    Kriteria asesmen dari kurikulum pelatihan
                </label>

                <label class="checklist-box">
                    <input type="checkbox" {{ $standar->standar_kinerja_perusahaan ? 'checked' : '' }} disabled>
                    Spesifikasi kinerja perusahaan:
                    @if(!empty($standar->standar_kinerja_perusahaan) && !is_numeric($standar->standar_kinerja_perusahaan))
                        <div style="margin-left:28px; font-style:italic;">
                            {{ $standar->standar_kinerja_perusahaan }}
                        </div>
                    @endif
                </label>

                <label class="checklist-box">
                    <input type="checkbox" {{ $standar->standar_spesifikasi_produk ? 'checked' : '' }} disabled>
                    Spesifikasi Produk:
                    @if(!empty($standar->standar_spesifikasi_produk) && !is_numeric($standar->standar_spesifikasi_produk))
                        <div style="margin-left:28px; font-style:italic;">
                            {{ $standar->standar_spesifikasi_produk }}
                        </div>
                    @endif
                </label>

                <label class="checklist-box">
                    <input type="checkbox" {{ $standar->standar_pedoman_khusus ? 'checked' : '' }} disabled>
                    Pedoman Khusus:
                    @if(!empty($standar->standar_pedoman_khusus) && !is_numeric($standar->standar_pedoman_khusus))
                        <div style="margin-left:28px; font-style:italic;">
                            {{ $standar->standar_pedoman_khusus }}
                        </div>
                    @endif
                </label>
            </div>
        </td>
    </tr>
            </table>
        </td>
    </tr>
</table>

<div class="section-title">2. Mempersiapkan Rencana Asesmen</div>

@foreach($kelompokPekerjaan as $kelompok)
    @php 
        $no = 1; 
        $totalUnit = count($kelompok->hasilAsesmen);
    @endphp

    <table border="1" cellspacing="0" cellpadding="4" width="100%"
        style="border-collapse: collapse; font-size: 11px; margin-top: 10px; table-layout: fixed;">
        <tr style="background-color:#fff2cc; font-weight:bold;">
            {{-- Kolom "Kelompok Pekerjaan" akan digabung dengan isi di bawahnya --}}
            <td rowspan="{{ $totalUnit + 1 }}" 
                style="width:30%; border:1px solid #000; vertical-align: middle; text-align:center;">
                {{ $kelompok->nama_kelompok ?? '-' }}
            </td>
            <td style="width:10%; border:1px solid #000;">No.</td>
            <td style="width:20%; border:1px solid #000;">Kode Unit</td>
            <td style="width:40%; border:1px solid #000;">Judul Unit</td>
        </tr>

        @foreach($kelompok->hasilAsesmen as $hasil)
            <tr>
                <td style="text-align:center; border:1px solid #000;">{{ $no++ }}</td>
                <td style="border:1px solid #000;">{{ $hasil->unit->kode_unit ?? '-' }}</td>
                <td style="border:1px solid #000;">{{ $hasil->unit->judul_unit ?? '-' }}</td>
            </tr>
        @endforeach
    </table>

{{-- ====== TABEL METODE & PERANGKAT ASESMEN ====== --}}
<table  class="table-break" border="1" cellspacing="0" cellpadding="4" width="100%" 
    style="border-collapse: collapse; font-size: 11px; margin-top:6px;">
    <thead style="text-align:center; font-weight:bold;background-color:#fff2cc;">
        <tr>
            <td rowspan="2" style="width:15%; border:1px solid #000;">Unit Kompetensi</td>
            <td rowspan="2" style="width:20%; border:1px solid #000;">
                Bukti-Bukti<br>
                <i>(Kinerja, Produk, Portofolio, dan/atau Pengetahuan)</i>
            </td>
            <td colspan="3" style="border:1px solid #000; width:9%;">Jenis Bukti</td>
            <td colspan="5" style="border:1px solid #000; width:56%;">
                <b><i>Metode dan Perangkat Asesmen</i></b><br>
                <span style="font-style:italic; font-weight:normal;">
                    CL (Ceklis Observasi), DIT (Daftar Instruksi Terstruktur),
                    DPL (Daftar Pertanyaan Lisan), DPT (Daftar Pertanyaan Tertulis),
                    VPK (Verifikasi Pihak Ketiga), CVP (Ceklis Verifikasi Portofolio),
                    CRP (Ceklis Reviu Produk), PW (Pertanyaan Wawancara)
                </span>
            </td>
        </tr>
        <tr>
            {{-- Kolom Jenis Bukti (lebih sempit) --}}
            <td style="width:3%; border:1px solid #000;">L</td>
            <td style="width:3%; border:1px solid #000;">TL</td>
            <td style="width:3%; border:1px solid #000;">T</td>

            {{-- Kolom Metode (dibuat lebih lebar dan teks horizontal) --}}
            <td style="width:12%; border:1px solid #000; vertical-align:top;">
                <b><i>Observasi Langsung</i></b><br>
                <span style="font-style:italic; font-weight:normal;">(aktivitas nyata di tempat kerja atau simulasi)</span>
            </td>
            <td style="width:12%; border:1px solid #000; vertical-align:top;">
                <b><i>Kegiatan Terstruktur</i></b><br>
                <span style="font-style:italic; font-weight:normal;">(latihan simulasi, proyek, presentasi, lembar kegiatan)</span>
            </td>
            <td style="width:12%; border:1px solid #000; vertical-align:top;">
                <b><i>Tanya Jawab</i></b><br>
                <span style="font-style:italic; font-weight:normal;">(tertulis, wawancara, asesmen diri, angket)</span>
            </td>
            <td style="width:12%; border:1px solid #000; vertical-align:top;">
                <b><i>Verifikasi Portofolio &amp; Pihak Ketiga</i></b><br>
                <span style="font-style:italic; font-weight:normal;">(sampel pekerjaan, testimoni atasan, bukti pendukung)</span>
            </td>
            <td style="width:12%; border:1px solid #000; vertical-align:top;">
                <b><i>Reviu Produk</i></b><br>
                <span style="font-style:italic; font-weight:normal;">(hasil proyek, contoh hasil kerja/produk)</span>
            </td>
        </tr>
    </thead>

    <tbody>
        @foreach($kelompok->hasilAsesmen as $hasil)
            @php
                $unit = $hasil->unit;
                $jenisBuktiList = $hasil->bukti->pluck('jenisBukti.nama_bukti')->toArray();
                $perangkatList = $hasil->perangkat->pluck('perangkat.jenis_bukti')->toArray();
            @endphp

            <tr>
                <td style="border:1px solid #000;">{{ $unit->judul_unit ?? '-' }}</td>
                <td style="border:1px solid #000;">{{ $hasil->catatan ?? '-' }}</td>

                <td style="text-align:center; border:1px solid #000;">{{ in_array('L', $jenisBuktiList) ? 'L' : '' }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ in_array('TL', $jenisBuktiList) ? 'TL' : '' }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ in_array('T', $jenisBuktiList) ? 'T' : '' }}</td>

                <td style="text-align:center; border:1px solid #000;">{{ in_array('CL', $perangkatList) ? 'CL' : '' }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ in_array('DIT', $perangkatList) ? 'DIT' : '' }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ implode(', ', array_intersect(['DPL','DPT'], $perangkatList)) }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ implode(', ', array_intersect(['VPK','PW','CVP'], $perangkatList)) }}</td>
                <td style="text-align:center; border:1px solid #000;">{{ in_array('CRP', $perangkatList) ? 'CRP' : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endforeach



<!-- 3. Modifikasi & Kontekstualisasi -->
<div class="section">
    <div class="section-title">3. Persyaratan Modifikasi & Kontekstualisasi</div>


    <table class="table">
        <thead>
            <tr>
                <th style="width:8%; text-align:center;">No.</th>
                <th style="width:32%;">Aspek</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <!-- 3.1 a -->
            <tr>
                <td class="center">3.1 a</td>
                <td>a. Karakteristik Kandidat</td>
                <td>
                    @if($modifikasi->karakteristik_kandidat === 'Ada')
                        (Ada) / <span class="strike">Tidak Ada</span><br>
                        {{ $modifikasi->karakteristik_keterangan ?? '' }}
                    @else
                        <span class="strike">(Ada)</span> / (Tidak Ada)
                    @endif
                </td>
            </tr>

            <!-- 3.1 b -->
            <tr>
                <td class="center"></td>
                <td>b. Kebutuhan kontekstual terkait tempat kerja</td>
                <td>
                    @if($modifikasi->kebutuhan_tempat_kerja === 'Ada')
                        (Ada) / <span class="strike">Tidak Ada</span><br>
                        {{ $modifikasi->kebutuhan_keterangan ?? '' }}
                    @else
                        <span class="strike">(Ada)</span> / (Tidak Ada)
                    @endif
                </td>
            </tr>

            <!-- 3.2 -->
            <tr>
                <td class="center">3.2</td>
                <td>Saran paket pelatihan / pengembang</td>
                <td>
                    @if($modifikasi->saran_pelatihan === 'Ada')
                        (Ada) / <span class="strike">Tidak Ada</span><br>
                        {{ $modifikasi->saran_keterangan ?? '' }}
                    @else
                        <span class="strike">(Ada)</span> / (Tidak Ada)
                    @endif
                </td>
            </tr>

            <!-- 3.3 -->
            <tr>
                <td class="center">3.3</td>
                <td>Penyesuaian perangkat asesmen</td>
                <td>
                    @if($modifikasi->penyesuaian_asesmen === 'Ada')
                        (Ada) / <span class="strike">Tidak Ada</span><br>
                        {{ $modifikasi->penyesuaian_keterangan ?? '' }}
                    @else
                        <span class="strike">(Ada)</span> / (Tidak Ada)
                    @endif
                </td>
            </tr>

            <!-- 3.4 -->
            <tr>
                <td class="center">3.4</td>
                <td>Peluang asesmen terintegrasi</td>
                <td>
                    @if($modifikasi->peluang_asesmen === 'Ada')
                        (Ada) / <span class="strike">Tidak Ada</span><br>
                        {{ $modifikasi->peluang_keterangan ?? '' }}
                    @else
                        <span class="strike">(Ada)</span> / (Tidak Ada)
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>


<!-- Konfirmasi dengan Orang Lain yang Relevan -->
<div class="section">
    <div class="section-title">Konfirmasi dengan Orang Lain yang Relevan</div>

    <table class="table">
        <thead>
            <tr>
                <th style="width:40%;">Orang yang Relevan</th>
                <th style="width:30%;">Nama</th>
                <th style="width:30%;">Tanda Tangan &amp; Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activeRoles as $role => $info)
            <tr>
                <td>{{ $info['label'] }}</td>
                <td>
                    @if($info['data'])
                        @php
                            $nama = $info['data']->id_asesor
                                ? ($asesors->firstWhere('id_asesor', $info['data']->id_asesor)->nama_asesor ?? '-')
                                : ($info['data']->nama ?? '-');
                        @endphp
                        {{ $nama }}
                    @else
                        -
                    @endif
                </td>
                <td style="text-align:center;">
                    @if(!empty($info['data']->tanda_tangan))
                        <img src="{{ $info['data']->tanda_tangan }}" class="signature-img" alt="ttd"><br>
                        <span class="date-text">{{ $info['data']->tanggal ?? '-' }}</span>
                    @else
                        <span class="muted">Belum ada tanda tangan</span><br>
                        <span class="date-text">{{ $info['data']->tanggal ?? '-' }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

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
            @php $jumlahPenyusun = count($penyusun); $no = 1; @endphp
            @forelse($penyusun as $i => $p)
            <tr>
                {{-- kolom status hanya muncul sekali --}}
                @if($i === 0)
                    <td rowspan="{{ $jumlahPenyusun }}" style="vertical-align: middle; text-align: left;">Penyusun</td>
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
            @empty
            <tr><td colspan="5" class="muted">Belum ada penyusun</td></tr>
            @endforelse

            {{-- === VALIDATOR === --}}
            @php $jumlahValidator = count($validators); $no = 1; @endphp
            @forelse($validators as $i => $v)
            <tr>
                {{-- kolom status hanya muncul sekali --}}
                @if($i === 0)
                    <td rowspan="{{ $jumlahValidator }}" style="vertical-align: middle; text-align: left;">Validator</td>
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
            @empty
            <tr><td colspan="5" class="muted">Belum ada validator</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<!-- Footer kecil -->
<div style="margin-top:10px; font-size:10px; color:#555;">
    Dokumen dihasilkan otomatis dari sistem LSP — FR.MAPA.01 (Versi cetak untuk admin). Generated: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}
</div>

</body>
</html>

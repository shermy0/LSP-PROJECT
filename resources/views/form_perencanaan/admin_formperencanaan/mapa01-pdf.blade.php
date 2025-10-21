<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>FR.MAPA.01 - Perencanaan Asesmen</title>
<style>
@page { margin: 15mm 12mm; }
body {
    font-family: DejaVu Sans, sans-serif;
    font-size: 12px;
    color: #000;
}

h3 { 
    text-align: left; 
    font-size: 13px; 
    font-weight: bold; 
    margin-bottom: 5px; 
}

/* === TABEL UMUM === */
.table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
    font-size: 12px;
}

.table th, .table td {
    border: 1px solid #000;
    padding: 6px 8px; /* ✅ kembalikan padding default biar teks gak nempel garis */
    vertical-align: top;
}

.table th {
    text-align: center;
}

/* === HAPUS PADDING KHUSUS UNTUK CHECKLIST === */
.no-padding {
    padding: 0 !important;
}

/* === CHECKLIST STYLE (Full Edge-to-Edge Lines) === */
.checklist-group {
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
    width: 100%;
}

.checklist-box {
    display: flex;
    align-items: center;
    gap: 8px;
    width: 100%;
    border-bottom: 1px solid #000;
    margin: 0;
    padding: 5px 0; /* hanya padding vertikal agar garis mentok kiri-kanan */
    box-sizing: border-box;
}

.checklist-box:first-child {
    margin-top: -1px;
}

.checklist-box:last-child {
    border-bottom: none;
}

.checklist-box input[type=checkbox],
.checklist-box input[type=radio] {
    width: 18px;
    height: 18px;
    accent-color: #000;
    margin-left: 4px;
    margin-right: 8px;
}

/* === KELAS TAMBAHAN UNTUK HILANGKAN PADDING === */
.no-padding {
    padding: 0 !important;
}

/* === JUDUL UTAMA === */
.judul {
    text-align: center;
    font-weight: bold;
    font-size: 13px;
    background-color: #f9d7aa;
    border: 1px solid #000;
    padding: 6px 0;
    margin-bottom: 12px;
    text-transform: uppercase;
}

/* === HEADER BAGIAN === */
.section-title {
    font-weight: bold;
    background-color: #f9d7aa;
    padding: 6px 8px;
    border: 1px solid #000;
    margin-top: 12px;
}
/* === EMOJI STYLE === */
.emoji-group {
    display: flex;
    align-items: center; /* biar sejajar vertikal */
    gap: 6px;
    margin-right: 4px;
}

.emoji {
    width: 16px;
    height: 16px;
    vertical-align: middle; /* bantu sejajarkan kalau ada inline item */
    transform: translateY(1px); /* sedikit turunin emoji biar gak “numpuk” */
        transform: translateX(100px);
    border-radius: 4px;
    padding: 2px;
    box-sizing: content-box;
}

.emoji.active {
    background-color: #47ec3f;
    box-shadow: 0 0 4px #6cff6c;
}

/* === LAINNYA === */
.center { text-align: center; }
.signature-img { max-width: 120px; max-height: 80px; }
.muted { color: #777; font-style: italic; }
.strike { text-decoration: line-through; }

</style>
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

    <tr>
        <td></td>
        <td><strong>Tujuan Asesmen</strong></td>
        <td class="no-padding">
            <div class="checklist-group">
                <label class="checklist-box">
                    <input type="checkbox" checked disabled> Sertifikasi
                </label>
                <label class="checklist-box">
                    <input type="checkbox" disabled> Pengakuan Kompetensi Terkini (PKT)
                </label>
                <label class="checklist-box">
                    <input type="checkbox" disabled> Rekognisi Pembelajaran Lampau (RPL)
                </label>
            </div>
        </td>
    </tr>

    <tr>
        <td></td>
        <td><strong>Konteks Asesmen</strong></td>
        <td class="no-padding">
            <table class="table" style="margin:0; border:none; width:100%;">
                <tr>
                    <td style="width:35%; vertical-align:top;">Lingkungan</td>
                    <td class="no-padding" style="width:65%; vertical-align:top;">
                        <div class="checklist-group">
                            <label class="checklist-box">
                                <input type="radio" checked disabled> Tempat kerja nyata
                            </label>
                            <label class="checklist-box">
                                <input type="radio" disabled> Tempat kerja simulasi
                            </label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="vertical-align:top;">Peluang bukti dalam sejumlah situasi</td>
                    <td class="no-padding" style="vertical-align:top;">
                        <div class="checklist-group">
                            <label class="checklist-box">
                                <input type="radio" checked disabled> Tersedia
                            </label>
                            <label class="checklist-box">
                                <input type="radio" disabled> Terbatas
                            </label>
                        </div>
                    </td>
                </tr>
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
            @php $no = 1; @endphp
            @forelse($penyusun as $p)
            <tr>
                <td>Penyusun</td>
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
                        <img src="{{ $p->tanda_tangan }}" class="signature-img" alt="ttd-penyusun"><br>
                        <span class="date-text">{{ $p->tanggal ?? '-' }}</span>
                    @else
                        <span class="muted">Belum ada tanda tangan</span><br>
                        <span class="date-text">{{ $p->tanggal ?? '-' }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="5" class="muted">Belum ada penyusun</td></tr>
            @endforelse

            {{-- === VALIDATOR === --}}
            @php $no = 1; @endphp
            @forelse($validators as $v)
            <tr>
                <td>Validator</td>
                <td class="center">{{ $no++ }}</td>
                <td>{{ $v->nama_asesor ?? $v->nama_validator ?? '-' }}</td>
                <td>{{ $v->no_registrasi ?? $v->no_met ?? '-' }}</td>
                <td style="text-align:center;">
                    @if(!empty($v->tanda_tangan) || !empty($v->ttd))
                        <img src="{{ $v->tanda_tangan ?? $v->ttd }}" class="signature-img" alt="ttd-validator"><br>
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

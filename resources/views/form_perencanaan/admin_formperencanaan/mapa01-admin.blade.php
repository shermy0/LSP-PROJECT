@extends('master')

@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">


<style>
    .readonly-input,
    .readonly-textarea {
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6;
        color: #212529 !important;
    }

    .disabled-checkbox,
    .disabled-radio {
        pointer-events: none;
        opacity: 0.7;
    }

    .floating-download-btn {
        position: fixed;
        bottom: 40px;
        right: 40px;
        z-index: 1000;
        background-color: #198754;
        color: #fff;
        border-radius: 50%;
        width: 65px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        font-size: 1.8rem;
        transition: 0.3s ease;
    }

    .floating-download-btn:hover {
        background-color: #157347;
        transform: scale(1.05);
    }
</style>

<div class="container mt-4 mb-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">FR.MAPA.01</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.MAPA 01. Merencanakan Aktivitas dan Proses</h3>
        <p class="text-muted">Peninjauan Proses Asesmen</p>
    </div>

    <!-- Informasi Skema -->
    <div class="skema-container">
        <div class="skema-group">
            <span class="skema-label">SKEMA:</span>
            <span class="skema-select">{{ $skema->nama_skema }}</span>
        </div>
    </div>

    <div class="row g-3 mt-2">
        <div class="col-md-6">
            <div class="mapa-box">
                <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                <div class="jenis-skema">
                    <input type="radio" id="kkni" name="skema" class="form-check-input me-2"
                        value="KKNI" @if($skema->jenjang == 'KKNI') checked @endif disabled>
                    <label for="kkni">KKNI</label>

                    <input type="radio" id="okupasi" name="skema" class="form-check-input me-2"
                        value="Okupasi" @if($skema->jenjang == 'Okupasi') checked @endif disabled>
                    <label for="okupasi">Okupasi</label>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mapa-box">
                <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                <input type="text" class="form-control readonly-input" value="{{ $skema->kode_skema }}" readonly>
            </div>
        </div>
    </div>

    <!-- Menentukan Pendekatan Asesmen -->
    <div class="mapa-section mt-4">
        <div class="card mapa-card">
            <div class="judul-header">Menentukan Pendekatan Asesmen</div>

            <div class="mapa-subsection">
                <div class="mapa-subsection-header">Asesi</div>
                <div class="mapa-options">
                    <div>
                        <input class="form-check-input" type="checkbox" disabled
                            {{ $pendekatan && $pendekatan->pelatihan_standar ? 'checked' : '' }}>
                        <label>Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="checkbox" disabled
                            {{ $pendekatan && $pendekatan->pelatihan_nonstandar ? 'checked' : '' }}>
                        <label>Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="checkbox" disabled
                            {{ $pendekatan && $pendekatan->pengalaman_standar ? 'checked' : '' }}>
                        <label>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="checkbox" disabled
                            {{ $pendekatan && $pendekatan->pengalaman_nonstandar ? 'checked' : '' }}>
                        <label>Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi</label>
                    </div>
                    <div>
                        <input class="form-check-input" type="checkbox" disabled
                            {{ $pendekatan && $pendekatan->otodidak ? 'checked' : '' }}>
                        <label>Pelatihan / belajar mandiri atau otodidak.</label>
                    </div>
                </div>
            </div>

            <!-- Tujuan Asesmen -->
            <div class="mapa-subsection-header mt-4">Tujuan Asesmen</div>
            <div class="mapa-options">
                @foreach($defaultTujuan as $nama)
                    <div>
                        <input type="checkbox" class="form-check-input me-2" disabled
                            {{ in_array($nama, $tujuanDipilih ?? []) ? 'checked' : '' }}>
                        <label>{{ $nama }}</label>
                    </div>
                @endforeach
                @foreach($customTujuan as $nama)
                    <div>
                        <input type="checkbox" class="form-check-input me-2" disabled
                            {{ in_array($nama, $tujuanDipilih ?? []) ? 'checked' : '' }}>
                        <label>{{ $nama }}</label>
                    </div>
                @endforeach
            </div>
<!-- KONTEKS ASESMEN -->
<div class="mapa-section">
    <div class="mapa-subsection-header">Konteks Asesmen</div>
    <div class="konteks-section">

        <!-- LINGKUNGAN -->
        <div class="form-group mb-3">
            <label class="form-label d-block">Lingkungan</label>
            <label class="me-3">
                <input type="radio" name="lingkungan" value="Tempat kerja nyata" class="form-check-input me-1" 
                    {{ $konteks->lingkungan == 'Tempat kerja nyata' ? 'checked' : '' }} disabled>
                Tempat kerja nyata
            </label>
            <label>
                <input type="radio" name="lingkungan" value="Tempat kerja simulasi" class="form-check-input me-1"
                    {{ $konteks->lingkungan == 'Tempat kerja simulasi' ? 'checked' : '' }} disabled>
                Tempat kerja simulasi
            </label>
        </div>

        <!-- PELUANG -->
        <div class="form-group mb-3">
            <label class="form-label d-block">Peluang untuk mengumpulkan bukti dalam sejumlah situasi</label>
            <label class="me-3">
                <input type="radio" name="peluang" value="Tersedia" class="form-check-input me-1"
                    {{ $konteks->peluang == 'Tersedia' ? 'checked' : '' }} disabled>
                Tersedia
            </label>
            <label>
                <input type="radio" name="peluang" value="Terbatas" class="form-check-input me-1"
                    {{ $konteks->peluang == 'Terbatas' ? 'checked' : '' }} disabled>
                Terbatas
            </label>
        </div>

        <!-- HUBUNGAN -->
        <div class="form-group mb-3">
            <label class="form-label d-block mb-2">Hubungan antara standar kompetensi dan:</label>

            <div class="hubungan-list">
                @foreach(['Bukti untuk mendukung asesmen','Aktivitas kerja di tempat kerja Asesi','Kegiatan Pembelajaran'] as $h)
                @php
                    $selected = $konteks->hubungan_rating[$h] ?? '';
                    $checked = in_array($h, $konteks->hubungan);
                @endphp
                <div class="hubungan-item">
                    <label class="d-flex align-items-center flex-grow-1">
                        <input type="checkbox"
                               name="hubungan[]"
                               value="{{ $h }}"
                               class="form-check-input me-2 hubungan-checkbox"
                               {{ $checked ? 'checked' : '' }} disabled>
                        <span class="hubungan-text">{{ $h }}</span>
                    </label>

                    <div class="emoji-group ms-3 {{ $checked ? '' : 'disabled' }}">
                        <div class="emoji-option {{ $selected === 'senang' ? 'active' : '' }}" data-value="senang">😊</div>
                        <div class="emoji-option {{ $selected === 'datar' ? 'active' : '' }}" data-value="datar">😐</div>
                        <div class="emoji-option {{ $selected === 'sedih' ? 'active' : '' }}" data-value="sedih">☹️</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- KONFIRMASI ORANG RELEVAN -->
<div class="mapa-section">
    <div class="mapa-subsection-header">Konfirmasi dengan Orang Lain yang Relevan</div>
    <div class="mapa-options">
        <div>
            <input type="checkbox" class="form-check-input me-2" name="orang_relevan[]" value="Manajer sertifikasi LSP P1 SMKN 11 Bandung"
                @if($konfirmasi && $konfirmasi->konfirmasi_manajer_lsp) checked @endif disabled>
            Manajer sertifikasi LSP P1 SMKN 11 Bandung
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-2" name="orang_relevan[]" value="Master Asesor / Master Trainer / Lead Asesor Kompetensi"
                @if($konfirmasi && $konfirmasi->konfirmasi_master_asesor) checked @endif disabled>
            Master Asesor / Master Trainer / Lead Asesor Kompetensi
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-2" name="orang_relevan[]" value="Manajer Pelatihan Lembaga Training terakreditasi / Lembaga Training Terdaftar"
                @if($konfirmasi && $konfirmasi->konfirmasi_manajer_pelatihan) checked @endif disabled>
            Manajer Pelatihan Lembaga Training
        </div>
        <div>
            <input type="checkbox" class="form-check-input me-2" name="orang_relevan[]" value="Manajer atau supervisor di tempat kerja"
                @if($konfirmasi && $konfirmasi->konfirmasi_supervisor) checked @endif disabled>
            Manajer atau supervisor di tempat kerja
        </div>
    </div>
</div>

            <!-- Standar Industri atau Tempat Kerja -->
            <div class="mapa-subsection-header mt-4">Standar Industri atau Tempat Kerja</div>
            <div class="mapa-options">
                @foreach($standarKompetensi as $sk)
                    <div>
                        <input type="checkbox" class="form-check-input me-2" checked disabled>
                        <label>Standar Kompetensi: {{ $sk }}</label>
                    </div>
                @endforeach

                <div>
                    <input type="checkbox" class="form-check-input me-2" disabled
                        {{ isset($standar) && $standar->standar_kriteria_asesmen ? 'checked' : '' }}>
                    <label>Kriteria asesmen dari kurikulum pelatihan</label>
                </div>

                <div>
                    <input type="checkbox" class="form-check-input me-2" disabled
                        {{ isset($standar) && $standar->standar_kinerja_perusahaan ? 'checked' : '' }}>
                    <label>Spesifikasi kinerja suatu perusahaan atau industri</label>
                    @if($standar->standar_kinerja_perusahaan)
                        <input type="text" class="form-control readonly-input mt-2" value="{{ $standar->standar_kinerja_perusahaan }}" readonly>
                    @endif
                </div>

                <div>
                    <input type="checkbox" class="form-check-input me-2" disabled
                        {{ isset($standar) && $standar->standar_spesifikasi_produk ? 'checked' : '' }}>
                    <label>Spesifikasi Produk:</label>
                    @if($standar->standar_spesifikasi_produk)
                        <input type="text" class="form-control readonly-input mt-2" value="{{ $standar->standar_spesifikasi_produk }}" readonly>
                    @endif
                </div>

                <div>
                    <input type="checkbox" class="form-check-input me-2" disabled
                        {{ isset($standar) && $standar->standar_pedoman_khusus ? 'checked' : '' }}>
                    <label>Pedoman Khusus:</label>
                    @if($standar->standar_pedoman_khusus)
                        <input type="text" class="form-control readonly-input mt-2" value="{{ $standar->standar_pedoman_khusus }}" readonly>
                    @endif
                </div>
            </div>
        </div>
    </div>


<!-- RENCANA ASESMEN -->
<div class=" card mapa-card">

<div class="mapa-section">
    <div class="judul-header">Mempersiapkan Rencana Asesmen</div>

    {{-- Looping kelompok pekerjaan --}}
    @foreach ($kelompokPekerjaan as $index => $kelompok)
    <div class="mapa-card mb-4">
        <div class="mapa-subsection-header d-flex justify-content-between align-items-center">
            <span>Kelompok Pekerjaan {{ $index + 1 }}</span>
        </div>

        <table class="mapa-table">
            <thead>
                <tr>
                    <th style="width: 40px;">No</th>
                    <th style="width: 120px;">Kode Unit</th>
                    <th>Unit Kompetensi</th>
                    <th>Bukti-Bukti</th>
                    <th>Jenis Bukti</th>
                    <th>Metode dan Perangkat Asesmen</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kelompok->hasilAsesmen as $hasil)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $hasil->unit->kode_unit ?? '-' }}</td>
                        <td>{{ $hasil->unit->judul_unit ?? '-' }}</td>
                        <td class="text-wrap">{{ $hasil->catatan ?? '-' }}</td>
                        <td>
                            @forelse ($hasil->bukti as $bukti)
                                {{ $bukti->jenisBukti->nama_bukti ?? '-' }}<br>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                        <td>
                            @forelse ($hasil->perangkat as $perangkat)
                                {{ $perangkat->perangkat->catatan_penerapan ?? '-' }}<br>
                            @empty
                                <span class="text-muted">-</span>
                            @endforelse
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada unit ditambahkan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endforeach
</div>
</div>

<!-- 5. Persyaratan Modifikasi dan Kontekstualisasi -->
<div class="card mapa-card">
<div class="container mt-3">
    <div class="judul-header">Mengidentifikasi Persyaratan Modifikasi dan Kontekstualisasi:</div>

    <!-- 3.1 a -->
    <div class="mb-3 p-3 border rounded bg-light">
        <div class="mapa-subsection-header">3.1 a. Karakteristik Kandidat:</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->karakteristik_kandidat == 'Tidak Ada' ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->karakteristik_kandidat == 'Ada' ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea class="form-control mt-2" readonly style="background-color: #f8f9fa;">{{ $modifikasi->karakteristik_keterangan ?? '' }}</textarea>
    </div>

    <!-- 3.1 b -->
    <div class="mb-3 p-3 border rounded bg-light">
        <div class="mapa-subsection-header">3.1 b. Kebutuhan kontekstualisasi terkait tempat kerja:</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->kebutuhan_tempat_kerja == 'Tidak Ada' ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->kebutuhan_tempat_kerja == 'Ada' ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea class="form-control mt-2" readonly style="background-color: #f8f9fa;">{{ $modifikasi->kebutuhan_keterangan ?? '' }}</textarea>
    </div>

    <!-- 3.2 -->
    <div class="mb-3 p-3 border rounded bg-light">
        <div class="mapa-subsection-header">3.2. Saran yang diberikan oleh paket pelatihan atau pengembang pelatihan:</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->saran_pelatihan == 'Tidak Ada' ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->saran_pelatihan == 'Ada' ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea class="form-control mt-2" readonly style="background-color: #f8f9fa;">{{ $modifikasi->saran_keterangan ?? '' }}</textarea>
    </div>

    <!-- 3.3 -->
    <div class="mb-3 p-3 border rounded bg-light">
        <div class="mapa-subsection-header">3.3. Penyesuaian perangkat asesmen terkait kebutuhan kontekstualisasi:</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->penyesuaian_asesmen == 'Tidak Ada' ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->penyesuaian_asesmen == 'Ada' ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea class="form-control mt-2" readonly style="background-color: #f8f9fa;">{{ $modifikasi->penyesuaian_keterangan ?? '' }}</textarea>
    </div>

    <!-- 3.4 -->
    <div class="mb-3 p-3 border rounded bg-light">
        <div class="mapa-subsection-header">3.4. Peluang untuk kegiatan asesmen terintegrasi dan mencatat setiap perubahan yang diperlukan untuk alat asesmen:</div>
        <div class="d-flex gap-3 my-2">
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->peluang_asesmen == 'Tidak Ada' ? 'checked' : '' }}>
                Tidak Ada
            </label>
            <label>
                <input type="radio" disabled class="form-check-input me-2"
                       {{ isset($modifikasi) && $modifikasi->peluang_asesmen == 'Ada' ? 'checked' : '' }}>
                Ada
            </label>
        </div>
        <textarea class="form-control mt-2" readonly style="background-color: #f8f9fa;">{{ $modifikasi->peluang_keterangan ?? '' }}</textarea>
    </div>
</div>
</div>
<!-- 7. Konfirmasi Dengan Orang yang Relevan -->
<div class="container mt-4">
    <div class="card-box">
        <div class="judul-header">Konfirmasi Dengan Orang Yang Relevan</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th>Orang yang relevan</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeRoles as $role => $info)
                        @php
                            $asesorData = $info['data'] 
                                ? $asesors->firstWhere('id_asesor', $info['data']->id_asesor)
                                : null;
                        @endphp
                        <tr>
                            <td>{{ $info['label'] }}</td>
                            <td>{{ $asesorData->nama_asesor ?? '-' }}</td>
                            <td>
                                @if(!empty($info['data']->tanggal))
                                    {{ \Carbon\Carbon::parse($info['data']->tanggal)->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if(!empty($info['data']->tanda_tangan))
                                    <img src="{{ $info['data']->tanda_tangan }}" width="120" alt="TTD">
                                @else
                                    <span class="text-muted">Belum ada tanda tangan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- 8. Penyusun -->
<div class="container mt-4">
    <div class="card-box">
        <div class="judul-header">Penyusun</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th>Nama Asesor</th>
                        <th>No. Met</th>
                        <th>Tanggal</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penyusun as $p)
                        <tr>
                            <td>{{ $asesors->firstWhere('id_asesor', $p->id_asesor)->nama_asesor ?? '-' }}</td>
                            <td>{{ $p->no_met ?? '-' }}</td>
                            <td>
                                @if(!empty($p->tanggal))
                                    {{ \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->tanda_tangan)
                                    <img src="{{ $p->tanda_tangan }}" width="120" alt="TTD Penyusun">
                                @else
                                    <span class="text-muted">Belum ada tanda tangan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada data penyusun</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- 9. Validator -->
<div class="container mt-4 mb-5">
    <div class="card-box">
        <div class="judul-header">Validator</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th>Nama Validator</th>
                        <th>No Registrasi</th>
                        <th>Tanggal</th>
                        <th>Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($validators as $v)
                        <tr>
                            <td>{{ $v->nama_validator ?? '-' }}</td>
                            <td>{{ $v->no_registrasi ?? '-' }}</td>
                            <td>
                                @if(!empty($v->tanggal))
                                    {{ \Carbon\Carbon::parse($v->tanggal)->format('d/m/Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($v->ttd)
                                    <img src="{{ $v->ttd }}" width="120" alt="TTD Validator">
                                @else
                                    <span class="text-muted">Belum ada tanda tangan</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-muted">Belum ada data validator</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
<!-- Floating Download Button -->
<a href="{{ route('admin.mapa01.pdf', $skema->id_skema) }}" class="floating-download-btn" title="Download FR.MAPA.01 PDF">
    <i class="bi bi-download"></i>
</a>

@endsection

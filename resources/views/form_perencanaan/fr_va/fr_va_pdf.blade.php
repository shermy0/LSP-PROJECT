@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                @isset($skema)
                    <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
                @else
                    <span>Form Perencanaan</span>
                @endisset
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                FR.VA {{ $periodeText }}
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.VA – MEMBERIKAN KONTRIBUSI DALAM VALIDASI ASESMEN</h3>
    </div>

    <!-- Skema & Periode -->
    <div class="skema-container mb-4">
        <div class="skema-group">
            <span class="skema-label fw-bold">SKEMA:</span>
            <span class="skema-select">{{ $skema->nama_skema }}</span>
        </div>
    </div>
    <div class="skema-container mb-4">
        <div class="skema-group">
            <span class="skema-label fw-bold">PERIODE:</span>
            <span class="text-primary fw-bold">{{ $periodeText }}</span>
        </div>
    </div>

    <!-- Form Asesmen -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="fw-semibold d-block mb-2">Nomor Skema</label>
            <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tempat</label>
            <input type="text" class="form-control" value="SMKN 11 BANDUNG - Mandiri" readonly>
        </div>
        <div class="col-md-4">
            <label class="form-label">Tanggal Asesmen</label>
            <input type="date" class="form-control" value="{{ $hasilValidasi->tanggal ?? date('Y-m-d') }}" readonly>
        </div>
    </div>

    <!-- 1. Menyiapkan Proses Validasi -->
    <div class="card-box mb-4">
        <div class="judul-box">
            <div class="judul-header">1. Menyiapkan Proses Validasi</div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Tujuan dan Fokus Validasi</th>
                        <th class="text-center">Konteks Validasi</th>
                        <th class="text-center">Pendekatan Validasi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach([
                        ['tujuan'=>'Bagian dari Proses Penjaminan Mutu Organisasi','konteks'=>'Internal Organisasi','pendekatan'=>'Internal Organisasi'],
                        ['tujuan'=>'Mengantisipasi Risiko','konteks'=>'Eksternal Organisasi','pendekatan'=>'Pertemuan Moderasi'],
                        ['tujuan'=>'Memenuhi Persyaratan BNSP','konteks'=>'Proses Lisensi / Re-Lisensi','pendekatan'=>'Mengkaji Perangkat Asesmen'],
                        ['tujuan'=>'Memastikan Kesesuaian Bukti','konteks'=>'Dengan Kolega Asesor','pendekatan'=>'Acuan Pembanding'],
                        ['tujuan'=>'Meningkatkan Kualitas Asesmen','konteks'=>'Kolega dari Organisasi Pelatihan atau Asesmen','pendekatan'=>'Pengujian lapangan dan uji coba perangkat asesmen'],
                        ['tujuan'=>'Mengevaluasi Kualitas Perangkat Asesmen','konteks'=>'','pendekatan'=>'Umpan Balik dari Klien']
                    ] as $row)
                    <tr>
                        {{-- Tujuan --}}
                        <td>
                            <input type="checkbox" 
                                value="{{ $row['tujuan'] }}"
                                {{ in_array($row['tujuan'], (array)$tujuanSelected) ? 'checked' : '' }} disabled>
                            {{ $row['tujuan'] }}
                        </td>

                        {{-- Konteks --}}
                        <td>
                            @if($row['konteks'])
                                <input type="checkbox" 
                                    value="{{ $row['konteks'] }}"
                                    {{ in_array($row['konteks'], $allKonteksSelected) ? 'checked' : '' }} disabled>
                                {{ $row['konteks'] }}
                            @else
                                {{-- Input konteks_lain pertama --}}
                                <input type="checkbox" 
                                    {{ !empty($konteksLainList[0]) ? 'checked' : '' }} disabled>
                                <input type="text" class="form-control mt-1"
                                    value="{{ $konteksLainList[0] ?? '' }}" disabled>
                            @endif
                        </td>

                        {{-- Pendekatan --}}
                        <td>
                            <input type="checkbox" 
                                value="{{ $row['pendekatan'] }}"
                                {{ in_array($row['pendekatan'], (array)$pendekatanSelected) ? 'checked' : '' }} disabled>
                            {{ $row['pendekatan'] }}
                        </td>
                    </tr>
                    @endforeach

                    {{-- Baris Tujuan/Konteks Lain --}}
                    <tr>
                        <td>
                            <input type="checkbox" {{ !empty($tujuanLainVal) ? 'checked' : '' }} disabled>
                            <input type="text" class="form-control mt-1"
                                value="{{ $tujuanLainVal }}" disabled>
                        </td>
                        <td>
                            <input type="checkbox" {{ !empty($konteksLainList[1]) ? 'checked' : '' }} disabled>
                            <input type="text" class="form-control mt-1"
                                value="{{ $konteksLainList[1] ?? '' }}" disabled>
                        </td>
                        <td>
                            <input type="checkbox" 
                                value="Mengkaji Bukti-bukti"
                                {{ in_array('Mengkaji Bukti-bukti', (array)$pendekatanSelected) ? 'checked' : '' }} disabled>
                            Mengkaji Bukti-bukti
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Orang yang Relevan -->
    <div class="card-box mb-4">
        <div class="judul-box"><div class="judul-header">Orang yang Relevan</div></div>

        @php
            $orangRelevan = [
                'asesorCheckbox' => 'Asesor Kompetensi (wajib)',
                'leadCheckbox' => 'Lead Asesor [Ketua TUK]',
                'managerCheckbox' => 'Manager, Supervisor',
                'ahliCheckbox' => 'Tenaga Ahli di bidangnya',
                'koordinatorCheckbox' => 'Koordinator Pelatihan',
                'anggotaCheckbox' => 'Anggota Asosiasi Industry Profesi'
            ];
        @endphp

        @foreach($orangRelevan as $id => $label)
            <div class="mb-3">
                <div class="form-check mb-2">
                    <input type="checkbox" disabled
                        {{ isset($orangRelevanData[$id]) && $orangRelevanData[$id] ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold">{{ $label }}</label>
                </div>

                @if(isset($orangRelevanData[$id.'_detail']) && count($orangRelevanData[$id.'_detail']) > 0)
                    <ol class="ms-4 mb-0" style="counter-reset:item;">
                        @foreach($orangRelevanData[$id.'_detail'] as $detail)
                            <li style="display: flex; align-items: center; margin-bottom: 0.25rem;">
                                <span style="width: 1.5em; text-align: right; margin-right: 0.5em;">{{ $loop->iteration }}.</span>
                                <input type="text" class="form-control" value="{{ $detail['nama'] }}" readonly>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        @endforeach
        <hr>
        <div class="mb-3">
            <label class="fw-semibold d-block mb-2">Hasil Diskusi Global</label>
            <textarea class="form-control" rows="3" readonly>{{ $hasilDiskusi ?? '' }}</textarea>
        </div>
    </div>

    <!-- 2. Acuan Pembanding & Dokumen -->
    <div class="card-box mb-4">
        <div class="judul-box">
            <div class="judul-header">2. Acuan Pembanding & Dokumen</div>
        </div>

        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Acuan Pembanding</th>
                        <th class="text-center">Dokumen Terkait dan Bahan-bahan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($acuanList as $index => $item)
                        <tr>
                            <td>
                                <input type="checkbox" {{ in_array($item, $acuanSelected) ? 'checked' : '' }} disabled>
                                {{ $item }}
                            </td>
                            <td>
                                @php
                                    $dokumen = $dokumenList[$index] ?? null;
                                    $dokumenLainValue = $dokumenLain[$index - 2] ?? '';
                                @endphp

                                @if($dokumen)
                                    <input type="checkbox" {{ in_array($dokumen, $dokumenSelected) ? 'checked' : '' }} disabled>
                                    {{ $dokumen }}
                                @else
                                    <input type="checkbox" {{ $dokumenLainValue ? 'checked' : '' }} disabled>
                                    <input type="text" class="form-control mt-1" value="{{ $dokumenLainValue }}" disabled>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                        {{-- Baris terakhir: Acuan Lain & Dokumen Lain ke-4 --}}
                        <tr>
                            <td>
                                <input type="checkbox" {{ $acuanLain ? 'checked' : '' }} disabled>
                                <input type="text" class="form-control mt-1" value="{{ $acuanLain }}" disabled>
                            </td>
                            <td>
                                <input type="checkbox" {{ $dokumenLain[3] ? 'checked' : '' }} disabled>
                                <input type="text" class="form-control mt-1" value="{{ $dokumenLain[3] }}" disabled>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Memberikan Kontribusi dalam Proses Validasi -->
    <div class="card-box mb-4">
        <div class="judul-box"><div class="judul-header">3. Memberikan Kontribusi dalam Proses Validasi</div></div>
        <div class="table-responsive mt-4">
            <table class="table custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Keterangan</th>
                        <th class="text-center">Keterampilan Komunikasi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Keterampilan komunikasi yang digunakan dalam kegiatan validasi :</td>
                        <td>
                            @php
                                $skills = ['Pro Aktif','Active Listening','Empati'];
                                @endphp

                                @foreach($skills as $skill)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                        {{ in_array($skill, $selectedSkills ?? []) ? 'checked' : '' }} disabled>
                                    <label class="form-check-label">{{ $skill }}</label>
                                </div>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Aspek dalam Kegiatan -->
    @php
        $aspek = [
            'Rencana Asesmen',
            'Interpretasi Standar Kompetensi',
            'Interpretasi Acuan Pembanding lainnya',
            'Proses Asesmen',
            'Penyeleksian dan Penerapan Metode Asesmen',
            'Penyeleksian dan Penerapan Perangkat Asesmen',
            'Bukti-bukti yang Dikumpulkan',
            'Pengambilan Keputusan'
        ];
    @endphp

    <div class="card-box mb-4">
        <div class="judul-header">Aspek dalam Kegiatan</div>
        <div class="table-responsive">
            <table class="table custom-table">
                <thead class="table-title">
                    <tr>
                        <th rowspan="3" class="text-center align-middle">No</th>
                        <th rowspan="3" class="text-center align-middle">
                            Aspek dalam Kegiatan Validasi <br>(Meninjau, Membandingkan, Mengevaluasi)
                        </th>
                        <th colspan="4" class="text-center">Aturan Bukti</th>
                        <th colspan="4" class="text-center">Prinsip Asesmen</th>
                    </tr>
                    <tr>
                        <th class="text-center">V</th>
                        <th class="text-center">A</th>
                        <th class="text-center">T</th>
                        <th class="text-center">M</th>
                        <th class="text-center">V</th>
                        <th class="text-center">R</th>
                        <th class="text-center">F</th>
                        <th class="text-center">F</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($aspek as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td>{{ $item }}</td>
                            @for($j = 1; $j <= 8; $j++)
                                <td class="text-center">
                                    <input type="checkbox" 
                                        {{ isset($aspekData[$i][$j]) && $aspekData[$i][$j] ? 'checked' : '' }} 
                                        disabled>
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Memberikan Kontribusi untuk Hasil Asesmen -->
    <div class="card-box mt-4">
        <div class="judul-header">3. Memberikan Kontribusi untuk Hasil Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Temuan Validasi</th>
                        <th class="text-center">Rekomendasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($temuan ?? [] as $i => $t)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td><input type="text" class="form-control" value="{{ $t }}" readonly></td>
                            <td><input type="text" class="form-control" value="{{ $rekomendasi[$i] ?? '' }}" readonly></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Rencana Perbaikan -->
    <div class="card-box mt-4">
        <div class="judul-header">Rencana Implementasi Perubahan / Perbaikan Pelaksanaan Asesmen</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Kegiatan perbaikan</th>
                        <th class="text-center">Waktu Penyelesaian</th>
                        <th class="text-center">Penanggung Jawab</th>
                        <th class="text-center">Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($perbaikan ?? [] as $i => $p)
                        <tr>
                            <td class="text-center">{{ $i + 1 }}</td>
                            <td><input type="text" class="form-control" value="{{ $p }}" readonly></td>
                            <td><input type="date" class="form-control" value="{{ $waktuPerbaikan[$i] ?? '' }}" readonly></td>
                            <td><input type="text" class="form-control" value="{{ $penanggungPerbaikan[$i] ?? '' }}" readonly></td>
                            <td>
                                @if(!empty($ttdPerbaikan[$i]))
                                    <img src="{{ $ttdPerbaikan[$i] }}" alt="Tanda Tangan" style="width:120px; height:50px;">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Validator -->
    <div class="card-box mt-4">
        <div class="judul-header">Validator</div>
        <div class="table-responsive mt-4">
            <table class="table table-bordered custom-table">
                <thead class="table-title">
                    <tr>
                        <th class="text-center">Nama Validator</th>
                        <th class="text-center">No Met</th>
                        <th class="text-center">Tanggal</th>
                        <th class="text-center">Tanda Tangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($validator ?? [] as $i => $v)
                        <tr>
                            <td><input type="text" class="form-control" value="{{ $v }}" readonly></td>
                            <td><input type="text" class="form-control" value="{{ $noMet[$i] ?? '' }}" readonly></td>
                            <td><input type="text" class="form-control" value="{{ $tanggal[$i] ?? '' }}" readonly></td>
                            <td>
                                @if(!empty($ttdValidator[$i]))
                                    <img src="{{ $ttdValidator[$i] }}" alt="Tanda Tangan" style="width:120px; height:50px;">
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Floating Download Button FR VA -->
    <a href="{{ route('form_perencanaan.pdf_frva', ['skema_id'=>$skema->id_skema, 'periode'=>$periode]) }}" class="floating-download-btn" title="Download FR VA PDF">
        <i class="bi bi-download"></i>
    </a>

</div>
@endsection

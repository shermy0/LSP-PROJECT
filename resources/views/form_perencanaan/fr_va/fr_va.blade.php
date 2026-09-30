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

    <form action="{{ route('form_perencanaan.fr_va_asesor.simpan') }}" method="POST">
        @csrf
        <input type="hidden" name="skema_id" value="{{ $skema_id }}">
        <input type="hidden" name="periode" value="{{ $periode }}">

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
                <input type="date" class="form-control" name="tanggalAsesmen" 
                    value="{{ old('tanggalAsesmen', $hasilValidasi->tanggal ?? '') }}">
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
                        @php
                            $tujuanSelected     = old('tujuan', $tujuanSelected ?? []);
                            $konteksSelected    = old('konteks', $konteksSelected ?? []);
                            $pendekatanSelected = old('pendekatan', $pendekatanSelected ?? []);

                            // KONTEXT LAIN (ANTI ERROR)
                            $rawKonteksLain = old('konteks_lain', $konteksLain ?? []);
                            $konteksLainList = is_string($rawKonteksLain) 
                                ? json_decode($rawKonteksLain, true) 
                                : $rawKonteksLain;

                            $tujuanLainVal = old('tujuan_lain', $tujuanLain ?? '');
                        @endphp
                        @foreach([
                            ['tujuan'=>'Bagian dari Proses Penjaminan Mutu Organisasi','konteks'=>'Internal Organisasi','pendekatan'=>'Internal Organisasi'],
                            ['tujuan'=>'Mengantisipasi Risiko','konteks'=>'Eksternal Organisasi','pendekatan'=>'Pertemuan Moderasi'],
                            ['tujuan'=>'Memenuhi Persyaratan BNSP','konteks'=>'Proses Lisensi / Re-Lisensi','pendekatan'=>'Mengkaji Perangkat Asesmen'],
                            ['tujuan'=>'Memastikan Kesesuaian Bukti','konteks'=>'Dengan Kolega Asesor','pendekatan'=>'Acuan Pembanding'],
                            ['tujuan'=>'Meningkatkan Kualitas Asesmen','konteks'=>'Kolega dari Organisasi Pelatihan atau Asesmen','pendekatan'=>'Pengujian lapangan dan uji coba perangkat asesmen'],
                            ['tujuan'=>'Mengevaluasi Kualitas Perangkat Asesmen','konteks'=>'','pendekatan'=>'Umpan Balik dari Klien']
                        ] as $row)
                        <tr>
                            {{-- Kolom 1: Tujuan --}}
                            <td>
                                <label style="cursor: pointer;">
                                    <input type="checkbox" name="tujuan[]"
                                        value="{{ $row['tujuan'] }}"
                                        {{ in_array($row['tujuan'], (array)$tujuanSelected) ? 'checked' : '' }}>
                                    {{ $row['tujuan'] }}
                                </label>
                            </td>

                            {{-- Kolom 2: Konteks (jika kosong, tampilkan satu input konteks_lain[]) --}}
                            <td>
                                @if($row['konteks'])
                                    <label style="cursor: pointer;">
                                        <input type="checkbox" name="konteks[]"
                                            value="{{ $row['konteks'] }}"
                                            {{ in_array($row['konteks'], (array)$konteksSelected) ? 'checked' : '' }}>
                                        {{ $row['konteks'] }}
                                    </label>
                                @else
                                    {{-- Satu input konteks_lain di sini (index 0 jika ada) --}}
                                    <label style="cursor: pointer;">
                                        <input type="checkbox" class="check-konteks" data-target="konteksLain1"
                                            {{ !empty($konteksLainList[0]) ? 'checked' : '' }}>
                                    </label>
                                    <input type="text" class="form-control mt-1"
                                        name="konteks_lain[]" id="konteksLain1"
                                        placeholder="Masukkan Konteks lain"
                                        value="{{ $konteksLainList[0] ?? '' }}"
                                        {{ !empty($konteksLainList[0]) ? '' : 'disabled' }}>
                                @endif
                            </td>

                            {{-- Kolom 3: Pendekatan --}}
                            <td>
                                <label style="cursor: pointer;">
                                    <input type="checkbox" name="pendekatan[]"
                                        value="{{ $row['pendekatan'] }}"
                                        {{ in_array($row['pendekatan'], (array)$pendekatanSelected) ? 'checked' : '' }}>
                                    {{ $row['pendekatan'] }}
                                </label>
                            </td>
                        </tr>
                        @endforeach

                        {{-- Baris akhir: Tujuan lain (kol 1) | Konteks lain (kol 2, input kedua) | Mengkaji Bukti-bukti (kol 3) --}}
                        <tr>
                            <td>
                                <label style="cursor: pointer;">
                                    <input type="checkbox" id="tujuanLainCheck" {{ !empty($tujuanLainVal) ? 'checked' : '' }}>
                                </label>
                                <input type="text" class="form-control mt-1"
                                    name="tujuan_lain" id="tujuanLainInput"
                                    placeholder="Masukkan Tujuan lain"
                                    value="{{ $tujuanLainVal }}"
                                    {{ !empty($tujuanLainVal) ? '' : 'disabled' }}>
                            </td>

                            <td>
                                {{-- Input konteks_lain kedua berada di sini (sejajar dengan Tujuan lain) --}}
                                <label style="cursor: pointer;">
                                    <input type="checkbox" class="check-konteks" data-target="konteksLain2"
                                        {{ !empty($konteksLainList[1]) ? 'checked' : '' }}>
                                </label>
                                <input type="text" class="form-control mt-1"
                                    name="konteks_lain[]" id="konteksLain2"
                                    placeholder="Masukkan Konteks lain"
                                    value="{{ $konteksLainList[1] ?? '' }}"
                                    {{ !empty($konteksLainList[1]) ? '' : 'disabled' }}>
                            </td>

                            <td>
                                <label style="cursor: pointer;">
                                    <input type="checkbox" name="pendekatan[]"
                                        value="Mengkaji Bukti-bukti"
                                        {{ in_array('Mengkaji Bukti-bukti', (array)$pendekatanSelected) ? 'checked' : '' }}>
                                    Mengkaji Bukti-bukti
                                </label>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- SCRIPT CHECKBOX OTOMATIS ENABLE/DISABLE INPUT --}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // enable/disable untuk semua checkbox yang punya class .check-konteks
            document.querySelectorAll('.check-konteks').forEach(function(cb) {
                cb.addEventListener('change', function() {
                    var targetId = this.dataset.target;
                    var target = document.getElementById(targetId);
                    if (!target) return;
                    target.disabled = !this.checked;
                    if (!this.checked) target.value = '';
                });
            });

            // tujuan_lain enable/disable
            var tujuanCheck = document.getElementById('tujuanLainCheck');
            var tujuanInput = document.getElementById('tujuanLainInput');
            if (tujuanCheck && tujuanInput) {
                tujuanCheck.addEventListener('change', function() {
                    tujuanInput.disabled = !this.checked;
                    if (!this.checked) tujuanInput.value = '';
                });
            }
        });
        </script>

        <!-- 2. Orang yang Relevan -->
        <div class="card-box mb-4">
            <div class="judul-box">
                <div class="judul-header">Orang yang Relevan</div>
            </div>

            @foreach($orangRelevanData as $id => $checked)
            @php
                $labelMap = [
                    'asesorCheckbox' => 'Asesor Kompetensi (wajib)',
                    'leadCheckbox' => 'Lead Asesor [Ketua TUK]',
                    'managerCheckbox' => 'Manager, Supervisor',
                    'ahliCheckbox' => 'Tenaga Ahli di bidangnya',
                    'koordinatorCheckbox' => 'Koordinator Pelatihan',
                    'anggotaCheckbox' => 'Anggota Asosiasi Industry Profesi'
                ];
                $label = $labelMap[$id] ?? $id;
                $details = $orangRelevanDetail[$id] ?? [];
            @endphp

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input toggle-section" type="checkbox" 
                        id="{{ $id }}" name="orangRelevan[]" value="{{ $id }}"
                        data-target="{{ $id }}Form"
                        {{ $checked ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="{{ $id }}">{{ $label }}</label>
                </div>

                <div id="{{ $id }}Form" class="mt-2" style="display: {{ $checked ? 'block' : 'none' }};">
                    @if(!empty($details))
                        @foreach($details as $detail)
                            <div class="input-group mb-2">
                                <input type="text" name="{{ $id }}_nama[]" class="form-control" placeholder="Nama"
                                    value="{{ $detail['nama'] }}">
                                <button class="btn btn-danger removeNama" type="button">Hapus</button>
                            </div>
                        @endforeach
                    @else
                        <div class="input-group mb-2">
                            <input type="text" name="{{ $id }}_nama[]" class="form-control" placeholder="Nama">
                            <button class="btn btn-danger removeNama" type="button">Hapus</button>
                        </div>
                    @endif
                    <button type="button" class="btn btn-primary btn-sm addNama">Tambah</button>
                </div>
            </div>
        @endforeach
            <hr>
            <div class="mb-3">
                <label class="fw-semibold d-block mb-2">Hasil Diskusi</label>
                <textarea name="hasil_diskusi_global" class="form-control" rows="3" placeholder="Tulis hasil diskusi di sini...">{{ $hasilDiskusiGlobal ?? '' }}</textarea>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function(){

            // Toggle container input orang relevan
            document.querySelectorAll(".toggle-section").forEach(checkbox => {
                const target = document.getElementById(checkbox.dataset.target);
                if(checkbox.checked) target.style.display='block';
                checkbox.addEventListener("change", function(){
                    target.style.display = this.checked ? 'block' : 'none';
                });
            });

            // Tambah/hapus input nama dinamis
            document.addEventListener("click", function(e){
                if(e.target.classList.contains("addNama")){
                    const container = e.target.closest("div[id$='Form']");
                    const idPrefix = container.id.replace('Form','');
                    const newInput = document.createElement("div");
                    newInput.classList.add("input-group","mb-2");
                    newInput.innerHTML = `
                        <input type="text" name="${idPrefix}_nama[]" class="form-control" placeholder="Nama">
                        <button class="btn btn-danger removeNama" type="button">Hapus</button>
                    `;
                    container.insertBefore(newInput, e.target);
                }

                if(e.target.classList.contains("removeNama")){
                    e.target.closest(".input-group").remove();
                }
            });

        });
        </script>

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

                        <!-- Standar Kompetensi -->
                        <tr>
                            <td>
                                <input type="checkbox" name="acuan[]" value="Standar Kompetensi (SKKNI/SKKK/SKI)"
                                    {{ in_array("Standar Kompetensi (SKKNI/SKKK/SKI)", $acuanDipilih) ? 'checked' : '' }}>
                                Standar Kompetensi (SKKNI/SKKK/SKI)
                            </td>
                            <td>
                                <input type="checkbox" name="dokumen[]" value="Perangkat Asesmen"
                                    {{ in_array("Perangkat Asesmen", $dokumenDipilih) ? 'checked' : '' }}>
                                Perangkat Asesmen
                            </td>
                        </tr>

                        <!-- Skema Sertifikasi -->
                        <tr>
                            <td>
                                <input type="checkbox" name="acuan[]" value="Skema Sertifikasi"
                                    {{ in_array("Skema Sertifikasi", $acuanDipilih) ? 'checked' : '' }}>
                                Skema Sertifikasi
                            </td>
                            <td>
                                <input type="checkbox" name="dokumen[]" value="Peraturan / Pedoman"
                                    {{ in_array("Peraturan / Pedoman", $dokumenDipilih) ? 'checked' : '' }}>
                                Peraturan / Pedoman
                            </td>
                        </tr>

                        <!-- SOP/IK -->
                        <tr>
                            <td>
                                <input type="checkbox" name="acuan[]" value="SOP/IK"
                                    {{ in_array("SOP/IK", $acuanDipilih) ? 'checked' : '' }}>
                                SOP/IK
                            </td>
                            <td>
                                <input type="checkbox" class="toggleInput" data-target="dokumenLain1Input"
                                    {{ $dokumenLain1 ? 'checked' : '' }}>
                                <input type="text" class="form-control mt-1" id="dokumenLain1Input"
                                    name="dokumen_lain[1]" placeholder="Masukkan dokumen lain"
                                    value="{{ $dokumenLain1 }}"
                                    {{ $dokumenLain1 ? '' : 'disabled' }}>
                            </td>
                        </tr>

                        <!-- Manual Instruction / Book Manual -->
                        <tr>
                            <td>
                                <input type="checkbox" name="acuan[]" value="Manual Instruction / Book Manual"
                                    {{ in_array("Manual Instruction / Book Manual", $acuanDipilih) ? 'checked' : '' }}>
                                Manual Instruction / Book Manual
                            </td>
                            <td>
                                <input type="checkbox" class="toggleInput" data-target="dokumenLain2Input"
                                    {{ $dokumenLain2 ? 'checked' : '' }}>
                                <input type="text" class="form-control mt-1" id="dokumenLain2Input"
                                    name="dokumen_lain[2]" placeholder="Masukkan dokumen lain"
                                    value="{{ $dokumenLain2 }}"
                                    {{ $dokumenLain2 ? '' : 'disabled' }}>
                            </td>
                        </tr>

                        <!-- Standar Kinerja -->
                        <tr>
                            <td>
                                <input type="checkbox" name="acuan[]" value="Standar Kinerja"
                                    {{ in_array("Standar Kinerja", $acuanDipilih) ? 'checked' : '' }}>
                                Standar Kinerja
                            </td>
                            <td>
                                <input type="checkbox" class="toggleInput" data-target="dokumenLain3Input"
                                    {{ $dokumenLain3 ? 'checked' : '' }}>
                                <input type="text" class="form-control mt-1" id="dokumenLain3Input"
                                    name="dokumen_lain[3]" placeholder="Masukkan dokumen lain"
                                    value="{{ $dokumenLain3 }}"
                                    {{ $dokumenLain3 ? '' : 'disabled' }}>
                            </td>
                        </tr>

                        <!-- Acuan Lain & Dokumen Lain4 -->
                        <tr>
                            <td>
                                <input type="checkbox" class="toggleInput" data-target="acuanLainInput"
                                    {{ $acuanLain ? 'checked' : '' }}>
                                <input type="text" class="form-control mt-1" id="acuanLainInput"
                                    name="acuan_lain[]" placeholder="Masukkan acuan lain"
                                    value="{{ $acuanLain }}"
                                    {{ $acuanLain ? '' : 'disabled' }}>
                            </td>
                            <td>
                                <input type="checkbox" class="toggleInput" data-target="dokumenLain4Input"
                                    {{ $dokumenLain4 ? 'checked' : '' }}>
                                <input type="text" class="form-control mt-1" id="dokumenLain4Input"
                                    name="dokumen_lain[4]" placeholder="Masukkan dokumen lain"
                                    value="{{ $dokumenLain4 }}"
                                    {{ $dokumenLain4 ? '' : 'disabled' }}>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

        <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".toggleInput").forEach(cb => {
                cb.addEventListener("change", function() {
                    let target = document.getElementById(this.dataset.target);
                    if (this.checked) {
                        target.disabled = false;
                    } else {
                        target.disabled = true;
                        target.value = "";
                    }
                });
            });
        });
        </script>


        <!-- 3. Memberikan Kontribusi (Keterangan & Keterampilan) -->
        <div class="card-box mb-4">
            <div class="judul-box"><div class="judul-header">Memberikan Kontribusi dalam Proses Validasi</div></div>
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
                            <td>
                                Keterampilan komunikasi yang digunakan dalam kegiatan validasi :
                            </td>
                            <td>
                                @php
                                    $skills = ['Pro Aktif','Active Listening','Empati'];
                                    $selectedSkills = old('keterampilan', $selectedSkills ?? []);
                                @endphp
                                @foreach($skills as $skill)
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input"
                                            id="skill_{{ $loop->index }}"
                                            name="keterampilan[]"
                                            value="{{ $skill }}"
                                            {{ in_array($skill, (array)$selectedSkills) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="skill_{{ $loop->index }}">{{ $skill }}</label>
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
                1 => 'Rencana Asesmen',
                2 => 'Interpretasi Standar Kompetensi',
                3 => 'Interpretasi Acuan Pembanding lainnya',
                4 => 'Proses Asesmen',
                5 => 'Penyeleksian dan Penerapan Metode Asesmen',
                6 => 'Penyeleksian dan Penerapan Perangkat Asesmen',
                7 => 'Bukti-bukti yang Dikumpulkan',
                8 => 'Pengambilan Keputusan'
            ];
            $periodeAktif = $periode ?? request('periode');
            if ($periodeAktif === 'sebelum') {
                $aspekAktif = [1,2,3];
            } elseif ($periodeAktif === 'saat') {
                $aspekAktif = [4,5,6];
            } elseif ($periodeAktif === 'sesudah') {
                $aspekAktif = [7,8];
            } else {
                $aspekAktif = [];
            }
            $disabledCells = [[7,7],[8,7]]; // kalau masih perlu di UI
            $aspekData = old('aspek', $aspekData ?? []);
        @endphp

        <div class="card-box mb-4">
            <div class="judul-header">Aspek dalam Kegiatan</div>
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead class="table-title">
                        <tr>
                            <th rowspan="2" class="text-center align-middle">No</th>
                            <th rowspan="2" class="text-center align-middle">
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
                        @foreach($aspek as $no => $item)
                            <tr>
                                <td class="text-center">{{ $no }}</td>
                                <td>{{ $item }}</td>

                                {{-- kolom 1..8 --}}
                                @for($j = 1; $j <= 8; $j++)
                                    <td class="text-center">
                                        @php $isAktif = in_array($no, $aspekAktif); @endphp

                                        @if(!$isAktif || in_array([$no,$j], $disabledCells))
                                            <input type="checkbox" class="custom-checkbox red-disabled" disabled>
                                        @else
                                            {{-- Note: gunakan key aspek[<nomor aspek>][<posisi kolom>] --}}
                                            <input type="checkbox"
                                                name="aspek[{{ $no }}][{{ $j }}]"
                                                class="custom-checkbox"
                                                {{ isset($aspekData[$no][$j]) && $aspekData[$no][$j] ? 'checked' : '' }}>
                                        @endif
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <button type="submit" class="simpan-btn"><span>Simpan dan Lanjut</span></button>
    </form>
</div>

<!-- JS Toggle -->
<script>
document.addEventListener("DOMContentLoaded", function(){

    // Toggle input teks “lain-lain” tanpa disable checkbox lain
    function toggleInput(checkId, inputSelector){
        const check = document.getElementById(checkId);
        const input = document.querySelector(inputSelector);
        if(check && input){
            input.disabled = !check.checked;
            check.addEventListener("change", function(){
                input.disabled = !this.checked;
                if(!this.checked) input.value = "";
            });
        }
    }

    toggleInput("tujuanLainCheck", "input[name='tujuan_lain']");
    toggleInput("konteksLainCheck", "input[name='konteks_lain']");
    toggleInput("konteksLain2Check", "input[name='konteks_lain2']");
    toggleInput("acuanLain1Check", "#acuanLain1Input");
    toggleInput("dokumenLain1Check", "#dokumenLain1Input");
    toggleInput("dokumenLain2Check", "#dokumenLain2Input");
    toggleInput("dokumenLain3Check", "#dokumenLain3Input");
    toggleInput("dokumenLain4Check", "#dokumenLain4Input");

    // Toggle container input orang relevan
    document.querySelectorAll(".toggle-section").forEach(checkbox=>{
        const target = document.getElementById(checkbox.dataset.target);
        if(checkbox.checked) target.style.display='block';
        checkbox.addEventListener("change", function(){
            target.style.display = this.checked ? 'block':'none';
        });
    });
});
</script>
@endsection
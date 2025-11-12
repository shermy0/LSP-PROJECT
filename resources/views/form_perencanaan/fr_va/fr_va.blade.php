@extends('master')

@section('konten')
<div class="card-box">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan.index') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item"><a href="{{ route('form_perencanaan.fr_va', ['periode' => $periode]) }}">FR.VA {{ $periode }}</a></li>
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
                       value="{{ old('tanggalAsesmen', $hasilValidasi->tanggal ?? date('Y-m-d')) }}">
            </div>
        </div>

        <!-- 1. Menyiapkan Proses Validasi -->
        <div class="card-box mb-4">
            <div class="judul-box"><div class="judul-header">1. Menyiapkan Proses Validasi</div></div>
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
                            $tujuanSelected = old('tujuan', $tujuan ?? []);
                            $konteksSelected = old('konteks', $konteks ?? []);
                            $pendekatanSelected = old('pendekatan', $pendekatan ?? []);
                        @endphp
                        @foreach([
                            ['tujuan'=>'Bagian dari Proses Penjaminan Mutu Organisasi','konteks'=>'Internal Organisasi','pendekatan'=>'Internal Organisasi'],
                            ['tujuan'=>'Mengantisipasi Risiko','konteks'=>'Eksternal Organisasi','pendekatan'=>'Pertemuan Moderasi'],
                            ['tujuan'=>'Memenuhi Persyaratan BNSP','konteks'=>'Proses Lisensi / Re-Lisensi','pendekatan'=>'Mengkaji Perangkat Asesmen'],
                            ['tujuan'=>'Memastikan Kesesuaian Bukti','konteks'=>'Dengan Kolega Asesor','pendekatan'=>'Acuan Pembanding'],
                            ['tujuan'=>'Meningkatkan Kualitas Asesmen','konteks'=>'Kolega dari Organisasi Pelatihan atau Asesmen','pendekatan'=>'Pengujian lapangan dan uji coba perangkat asesmen'],
                            ['tujuan'=>'Mengevaluasi Kualitas Perangkat Asesmen','konteks'=>'','pendekatan'=>'Umpan Balik dari Klien']
                        ] as $idx => $row)
                        <tr>
                            <td><input type="checkbox" name="tujuan[]" value="{{ $row['tujuan'] }}" {{ in_array($row['tujuan'],$tujuanSelected)?'checked':'' }}> {{ $row['tujuan'] }}</td>
                            <td>
                                @if($row['konteks'])
                                    <input type="checkbox" name="konteks[]" value="{{ $row['konteks'] }}" {{ in_array($row['konteks'],$konteksSelected)?'checked':'' }}> {{ $row['konteks'] }}
                                @else
                                    <input type="checkbox" id="konteksLainCheck" {{ $konteksLain ? 'checked':'' }}>
                                    <input type="text" class="form-control" name="konteks_lain" placeholder="Masukkan Konteks lain" value="{{ $konteksLain ?? '' }}">
                                @endif
                            </td>
                            <td>
                                <input type="checkbox" name="pendekatan[]" value="{{ $row['pendekatan'] }}" {{ in_array($row['pendekatan'],$pendekatanSelected)?'checked':'' }}> {{ $row['pendekatan'] }}
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>
                                <input type="checkbox" id="tujuanLainCheck" {{ $tujuanLain ? 'checked':'' }}>
                                <input type="text" class="form-control" name="tujuan_lain" placeholder="Masukkan Tujuan lain" value="{{ $tujuanLain ?? '' }}">
                            </td>
                            <td>
                                <input type="checkbox" id="konteksLain2Check" {{ $konteksLain2 ? 'checked':'' }}>
                                <input type="text" class="form-control" name="konteks_lain2" placeholder="Masukkan Konteks lain" value="{{ $konteksLain2 ?? '' }}">
                            </td>
                            <td>
                                <input type="checkbox" name="pendekatan[]" value="Mengkaji Bukti-bukti" {{ in_array('Mengkaji Bukti-bukti',$pendekatanSelected)?'checked':'' }}> Mengkaji Bukti-bukti
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
            <div class="form-check">
                <input class="form-check-input toggle-section" type="checkbox" 
                       id="{{ $id }}" name="orangRelevan[]" value="{{ $id }}" 
                       data-target="{{ $id }}Form">
                <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
            </div>

            <!-- Container input awal -->
            <div id="{{ $id }}Form" class="mt-2" style="display:none;">
                <div class="input-group mb-2">
                    <input type="text" name="{{ $id }}_nama[]" class="form-control" placeholder="Nama Asesor">
                    <input type="text" name="{{ $id }}_diskusi[]" class="form-control" placeholder="Hasil Diskusi">
                    <button class="btn btn-danger removeNama" type="button">Hapus</button>
                </div>

                <!-- Tombol tambah, hanya muncul saat checkbox dicentang -->
                <button type="button" class="btn btn-primary btn-sm addNama">Tambah</button>
            </div>
        </div>
    @endforeach
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){

    // Toggle container + tombol tambah
    document.querySelectorAll(".toggle-section").forEach(checkbox=>{
        checkbox.addEventListener("change", function(){
            const target = document.getElementById(this.dataset.target);
            target.style.display = this.checked ? "block" : "none";
            if(!this.checked){
                // Reset isi container, hanya 1 input
                target.innerHTML = `
                    <div class="input-group mb-2">
                        <input type="text" name="${this.id}_nama[]" class="form-control" placeholder="Nama Asesor">
                        <input type="text" name="${this.id}_diskusi[]" class="form-control" placeholder="Hasil Diskusi">
                        <button class="btn btn-danger removeNama" type="button">Hapus</button>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm addNama">Tambah</button>`;
            }
        });
    });

    // Tambah input baru (delegasi karena button bisa dibuat ulang)
    document.addEventListener("click", function(e){
        if(e.target.classList.contains("addNama")){
            const container = e.target.closest("#"+e.target.parentNode.id);
            const idPrefix = e.target.parentNode.id.replace('Form','');
            const div = document.createElement("div");
            div.classList.add("input-group","mb-2");
            div.innerHTML = `
                <input type="text" name="${idPrefix}_nama[]" class="form-control" placeholder="Nama Asesor">
                <input type="text" name="${idPrefix}_diskusi[]" class="form-control" placeholder="Hasil Diskusi">
                <button class="btn btn-danger removeNama" type="button">Hapus</button>`;
            container.insertBefore(div, e.target); // tambah sebelum tombol
        }

        // Hapus input
        if(e.target.classList.contains("removeNama")){
            e.target.closest(".input-group").remove();
        }
    });

});
</script>



        <!-- 2. Acuan Pembanding & Dokumen -->
<div class="card-box mb-4">
    <div class="judul-box"><div class="judul-header">2. Acuan Pembanding & Dokumen</div></div>
    <div class="table-responsive mt-4">
        <table class="table custom-table">
            <thead class="table-title">
                <tr>
                    <th class="text-center">Acuan Pembanding</th>
                    <th class="text-center">Dokumen Terkait dan Bahan-bahan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" name="acuan[]" value="Standar Kompetensi (SKKNI/SKKK/SKI)"> Standar Kompetensi (SKKNI/SKKK/SKI)</td>
                    <td><input type="checkbox" name="dokumen[]" value="Perangkat Asesmen"> Perangkat Asesmen</td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="acuan[]" value="Skema Sertifikasi"> Skema Sertifikasi</td>
                    <td><input type="checkbox" name="dokumen[]" value="Peraturan / Pedoman"> Peraturan / Pedoman</td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="acuan[]" value="SOP/IK"> SOP/IK</td>
                    <td><input type="checkbox" name="dokumen[]" value="Bukti-bukti hasil asesmen"> Bukti-bukti hasil asesmen</td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="acuan[]" value="Manual Instruction / Book Manual"> Manual Instruction / Book Manual</td>
                    <td>
                        <input type="checkbox" id="dokumenLain1Check"> 
                        <input type="text" class="form-control" id="dokumenLain1Input" name="dokumen[]" placeholder="Masukkan dokumen lain" disabled>
                    </td>
                </tr>
                <tr>
                    <td><input type="checkbox" name="acuan[]" value="Standar Kinerja"> Standar Kinerja</td>
                    <td>
                        <input type="checkbox" id="dokumenLain2Check"> 
                        <input type="text" class="form-control" id="dokumenLain2Input" name="dokumen[]" placeholder="Masukkan dokumen lain" disabled>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function(){
    function toggleDokumen(checkId, inputId){
        const check = document.getElementById(checkId);
        const input = document.getElementById(inputId);
        if(check && input){
            check.addEventListener("change", function(){
                input.disabled = !this.checked;
                if(!this.checked) input.value = "";
            });
        }
    }

    toggleDokumen("dokumenLain1Check","dokumenLain1Input");
    toggleDokumen("dokumenLain2Check","dokumenLain2Input");
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
                            Keterampilan komunikasi yang digunakan dalam kegiatan validasi :                            </td>
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
                                               {{ in_array($skill,$selectedSkills)?'checked':'' }}>
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
                'Rencana Asesmen',
                'Interpretasi Standar Kompetensi',
                'Interpretasi Acuan Pembanding lainnya',
                'Proses Asesmen',
                'Penyeleksian dan Penerapan Metode Asesmen',
                'Penyeleksian dan Penerapan Perangkat Asesmen',
                'Bukti-bukti yang Dikumpulkan',
                'Pengambilan Keputusan'
            ];
            $disabledCells = [[7,7],[8,7]];
            $aspekData = old('aspek', $aspekData ?? []);
        @endphp
        <div class="card-box mb-4">
            <div class="judul-header">Aspek dalam Kegiatan</div>
            <div class="table-responsive">
                <table class="table custom-table">
                    <thead class="table-title">
                        <tr>
                            <th rowspan="3" class="text-center align-middle">No</th>
                            <th rowspan="3" class="text-center align-middle">Aspek dalam Kegiatan Validasi <br>(Meninjau, Membandingkan, Mengevaluasi)</th>
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
                                <td class="text-center">{{ $i+1 }}</td>
                                <td>{{ $item }}</td>
                                @for($j=1;$j<=8;$j++)
                                    <td class="text-center">
                                        @if(in_array([$i+1,$j], $disabledCells))
                                            <input type="checkbox" class="custom-checkbox red-disabled" disabled>
                                        @else
                                            <input type="checkbox" name="aspek[{{ $i }}][{{ $j }}]" class="custom-checkbox"
                                            {{ isset($aspekData[$i][$j]) && $aspekData[$i][$j] ? 'checked':'' }}>
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
    toggleInput("dokumenLain1Check", "input[name='dokumen[]']");
    toggleInput("dokumenLain2Check", "input[name='dokumen[]']");

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
@extends('master')
@section('konten')
<link rel="stylesheet" href="{{ asset('assets/css/mapa01.css') }}">

<div class="card mapa-card">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.index') }}">Daftar Skema</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('formperencanaan.show', $skema->id_skema) }}">Form Perencanaan</a>
            </li>
            <li class="breadcrumb-item active">
                FR.AK.06 – Ninjau Asesmen Asesor
            </li>
        </ol>
    </nav>

    <div class="container mt-4">
        <!-- Header -->
        <div class="text-center mb-4">
            <div class="mapa-logo"></div>
            <h3 class="fw-bold">FR.AK.06 – Meninjau Proses Asesmen</h3>
            <p class="text-muted">Peninjauan Proses Asesmen</p>
        </div>

        <!-- FORM UTAMA - SEMUA INPUT HARUS DI DALAM FORM INI -->
        <form action="{{ route('form_perencanaan.ninjau_asesmen_asesor.store', ['id_skema' => $skema->id_skema]) }}" method="POST">            @csrf
            <input type="hidden" name="skema_id" value="{{ $skema->id_skema }}">
            <input type="hidden" name="id_asesmen" value="{{ $skema->id_skema }}-{{ date('YmdHis') }}">
            
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="mapa-box">
                        <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                        <div class="jenis-skema">
                            <input type="radio" id="kkni" name="skema_type" class="form-check-input me-2"
                                   value="KKNI"
                                   @if($skema->jenjang == 'KKNI') checked @endif disabled>
                            <label for="kkni">KKNI</label>

                            <input type="radio" id="okupasi" name="skema_type" class="form-check-input me-2"
                                   value="Okupasi"
                                   @if($skema->jenjang == 'Okupasi') checked @endif disabled>
                            <label for="okupasi">Okupasi</label>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mapa-box">
                        <label class="fw-semibold d-block mb-2">Nomor Skema</label>
                        <input type="text" class="form-control" value="{{ $skema->kode_skema }}" readonly>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="mapa-box">
                        <label for="nama_asesor" class="form-label">Nama Asesor</label>
                        <select class="form-control" id="nama_asesor" name="asesor_id" >
                            <option value="">-- Pilih Asesor --</option>
                            @foreach($asesors as $asesor)
                            <option value="{{ $asesor->id_asesor }}"
                                {{ old('asesor_id', $meninjau->asesor_id ?? '') == $asesor->id_asesor ? 'selected' : '' }}>
                                    {{ $asesor->nama_asesor }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mapa-box">
                        <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                        <input type="date" class="form-control" id="tanggalAsesmen"
                        name="tanggal_asesmen"
                        value="{{ old('tanggal_asesmen', $meninjau->tanggal_asesmen ?? '') }}">
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-12">
                    <div class="mapa-box">
                        <label class="form-label fw-semibold d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
                        <div class="d-flex justify-content-start gap-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tuk_atas" id="tukSewaktuAtas" value="Sewaktu">
                                <label class="form-check-label" for="tukSewaktuAtas">Sewaktu</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tuk_atas" id="tukTempatKerjaAtas" value="Tempat Kerja">
                                <label class="form-check-label" for="tukTempatKerjaAtas">Tempat Kerja</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="tuk_atas" id="tukMandiriAtas" value="Mandiri" checked>
                                <label class="form-check-label" for="tukMandiriAtas">Mandiri</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penjelasan -->
            <div class="card-box mb-4">
                <div class="penjelasan-box">
                    <div class="penjelasan-header">Penjelasan</div>
                    <ol class="penjelasan-list">
                        <li>Peninjauan dapat dilakukan oleh lead asesor atau asesor yang melaksanakan asesmen.</li>
                        <li>Peninjauan dapat dilakukan secara terpadu dalam skema sertifikasi dan / atau peserta kelompok yang homogen.</li>
                        <li>Isilah pemenuhan dimensi kompetensi dengan menuliskan jenis bukti dan instrumen yang digunakan.</li>
                    </ol>
                </div>
            </div>

            @php
                $prinsip = [
                        'valid' => 'Validitas',
                        'reliabel' => 'Reliabel',
                        'fleksibel' => 'Fleksibel',
                        'adil' => 'Adil'
                    ];
                $aspek = [
                    'rencana' => [1, 1, 1, 1],
                    'persiapan' => [1, 1, 1, 1],
                    'implementasi' => [1, 1, 1, 1],
                    'keputusan' => [1, 1, 0, 1],
                    'umpan' => [1, 1, 0, 1],
                ];
            @endphp

            <!-- Kesesuaian dengan Asesmen -->
            <div class="card-box mb-4">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered custom-table">
                        <thead class="table-title">
                            <tr>
                                <th rowspan="2" class="text-center align-middle">Aspek yang Ditinjau</th>
                                <th colspan="{{ count($prinsip) }}" class="text-center">Kesesuaian dengan Prinsip Asesmen</th>
                            </tr>
                            <tr>
                                @foreach($prinsip as $p)
                                <th class="text-center">{{ $p }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($aspek as $prefix => $cols)
                        <tr>
                            <td>{{ ucfirst($prefix) }} asesmen</td>

                            @foreach(array_keys($prinsip) as $key)
                            <td class="text-center">
                                <input type="checkbox"
                                name="{{ $prefix }}_{{ $key }}"
                                value="1"
                                {{ old($prefix.'_'.$key, $meninjau->{$prefix.'_'.$key} ?? false) ? 'checked' : '' }}>
                            </td>
                            @endforeach

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rekomendasi Peningkatan 1 -->
            <div class="card-box mb-4">
                <label for="rekomendasi1" class="fw-semibold mb-1 d-block">Rekomendasi 1</label>
                <textarea id="rekomendasi1" name="rekomendasi1" class="form-control mt-1" rows="3" placeholder="Masukkan teks">{{ old('rekomendasi1', $meninjau->rekomendasi1 ?? '') }}</textarea>
            </div>

            @php
                $options = ['L','CL','T','DPT'];
                $aspekDimensi = [
                    'konsistensi' => 'Konsistensi keputusan asesmen',
                    'bukti' => 'Bukti dari berbagai asesmen diperiksa untuk konsistensi dimensi kompetensi'
                ];
            @endphp

            <!-- Pemenuhan Dimensi Kompetensi -->
            <div class="card-box mb-4">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered custom-table text-center align-middle">
                        <thead class="table-title">
                            <tr>
                                <th rowspan="2" class="align-middle">Aspek yang Ditinjau</th>
                                <th colspan="5">Pemenuhan dimensi kompetensi</th>
                            </tr>
                            <tr>
                                <th>Task Skills</th>
                                <th>Task Management Skills</th>
                                <th>Contingency Management Skills</th>
                                <th>Job Role/Environment Skills</th>
                                <th>Transfer Skills</th>
                            </tr>
                        </thead>
                        <tbody class="option">
                            @foreach ($aspekDimensi as $prefix => $judul)
                            <tr>
                                <td>{{ $judul }}</td>
                                <td>
                                    @foreach ($options as $opt)
                                    <label><input type="checkbox"name="{{ $prefix }}_task[]"value="{{ $opt }}"{{ in_array($opt, explode(',', $meninjau->{$prefix.'_task'} ?? '')) ? 'checked' : '' }}></label><br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($options as $opt)
                                    <label><input type="checkbox" name="{{ $prefix }}_task_mgmt[]"value="{{ $opt }}"{{ in_array($opt, explode(',', $meninjau->{$prefix.'_task_mgmt'} ?? '')) ? 'checked' : '' }}></label><br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($options as $opt)
                                    <label><input type="checkbox" name="{{ $prefix }}_contingency[]" value="{{ $opt }}"{{ in_array($opt, explode(',', $meninjau->{$prefix.'_contingency'} ?? '')) ? 'checked' : '' }}></label><br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($options as $opt)
                                    <label><input type="checkbox" name="{{ $prefix }}_jobrole[]" value="{{ $opt }}"{{ in_array($opt, explode(',', $meninjau->{$prefix.'_contingency'} ?? '')) ? 'checked' : '' }}></label><br>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach ($options as $opt)
                                    <label><input type="checkbox" name="{{ $prefix }}_transfer[]" value="{{ $opt }}"{{ in_array($opt, explode(',', $meninjau->{$prefix.'_contingency'} ?? '')) ? 'checked' : '' }}></label><br>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Rekomendasi Peningkatan 2 -->
            <div class="card-box mb-4">
                <label for="rekomendasi2" class="fw-semibold mb-1 d-block">Rekomendasi 2</label>
                <textarea id="rekomendasi2" name="rekomendasi2" class="form-control mt-1" rows="3" placeholder="Masukkan teks">{{ old('rekomendasi2', $meninjau->rekomendasi2 ?? '') }}</textarea>
            </div>

            <!-- Simpan dan Lanjut -->
            <button type="submit" class="simpan-btn mt-3">
                <span>Simpan dan Lanjut</span>
            </button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const asesorSelect = document.getElementById('nama_asesor');
    const tanggalInput = document.getElementById('tanggalAsesmen');
    
    // Validasi sebelum submit - SAMA SEPERTI DI LAPORAN
    form.addEventListener('submit', function(e) {
        const asesorValue = asesorSelect.value;
        const tanggalValue = tanggalInput.value;
        
        // Cek apakah asesor belum dipilih
        if (!asesorValue || asesorValue === '') {
            e.preventDefault(); // Cegah submit HANYA kalau validasi gagal
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: 'Silakan pilih Nama Asesor terlebih dahulu.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
            return;
        }
        
        // Cek apakah tanggal belum diisi
        if (!tanggalValue || tanggalValue === '') {
            e.preventDefault(); // Cegah submit HANYA kalau validasi gagal
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: 'Silakan isi Tanggal Asesmen terlebih dahulu.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#d33'
            });
            return;
        }
        
        // Jika lolos validasi, biarkan form submit secara normal (tidak perlu form.submit() manual)
    });
});
</script>
@endsection
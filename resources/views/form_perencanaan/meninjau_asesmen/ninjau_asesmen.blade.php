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
            <li class="breadcrumb-item active" aria-current="page">FR.AK.06</li>
        </ol>
    </nav>

    <div class="container mt-4">
    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.06 – Meninjau Proses Asesmen</h3>
        <p class="text-muted">Peninjauan Proses Asesmen</p>
    </div>

    <!-- skema -->
    <div class="skema-container">
        <div class="skema-group">
            <span class="skema-label">SKEMA:</span>
            <span class="skema-select">{{ $skema->nama_skema }}</span>
        </div>
    </div>

    <!-- FORM UTAMA -->
<!-- FORM UTAMA -->
<form action="{{ route('meninjau_asesmen.store') }}" method="POST">
    @csrf
    <div class="row g-3 mb-4">
        <!-- Baris 1: Skema Sertifikasi & Nomor Skema -->
        <div class="col-md-6">
            <div class="mapa-box">
                <label class="fw-semibold d-block mb-2">Skema Sertifikasi</label>
                <div class="jenis-skema">
                    <input type="radio" id="kkni" name="skema" class="form-check-input me-2"
                           value="KKNI"
                           @if($skema->jenjang == 'KKNI') checked @endif disabled>
                    <label for="kkni">KKNI</label>

                    <input type="radio" id="okupasi" name="skema" class="form-check-input me-2"
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

    <div class="row g-3">
        <div class="col-md-6">
            <div class="mapa-box">
                <label for="namaAsesor" class="form-label">Nama Asesor</label>
                <select class="form-control" id="namaAsesor" name="asesor_id">
                    <option value="">-- Pilih Asesor --</option>
                    @foreach($asesors as $asesor)
                        <option value="{{ $asesor->id_asesor }}">
                            {{ $asesor->nama_asesor }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mapa-box">
                <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                <input type="date" class="form-control" id="tanggalAsesmen">
            </div>
        </div>
    </div>
    <!-- TUK -->
    <div class="col-12 text-center mt-3">
        <label class="form-label fw-semibold d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
        <div class="d-flex justify-content-center gap-4">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukSewaktu" value="Sewaktu" disabled>
                <label class="form-check-label" for="tukSewaktu">Sewaktu</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukTempatKerja" value="Tempat Kerja" disabled>
                <label class="form-check-label" for="tukTempatKerja">Tempat Kerja</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tuk" id="tukMandiri" value="Mandiri" checked>
                <label class="form-check-label" for="tukMandiri">Mandiri</label>
            </div>
        </div>
    </div>
</div>
</form>

    </div>
        <br>

        <!-- Penjelasan -->
        <div class="card-box">
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
            $prinsip = ['Validitas', 'Reliabel', 'Fleksibel', 'Adil'];
            $aspek = [
                'rencana' => [1, 1, 1, 1],
                'persiapan' => [1, 1, 1, 1],
                'implementasi' => [1, 1, 1, 1],
                'keputusan' => [1, 1, 0, 1],
                'umpan' => [1, 1, 0, 1],
            ];
        @endphp

        <!-- Kesesuaian dengan Asesmen -->
        <div class="card-box">
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
                                @foreach($cols as $i => $enabled)
                                    <td class="text-center">
                                        <input type="checkbox" name="{{ $prefix }}_{{ strtolower($prinsip[$i]) }}" value="1" {{ $enabled ? '' : 'disabled' }}>
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Rekomendasi Peningkatan -->
        <div class="card-box">
            <textarea name="rekomendasi1" class="form-control mt-2" rows="3" placeholder="Masukkan teks"></textarea>
        </div>

        @php
            $options = ['L','CL','T','DPT'];
            $aspekDimensi = [
                'konsistensi' => 'Konsistensi keputusan asesmen',
                'bukti' => 'Bukti dari berbagai asesmen diperiksa untuk konsistensi dimensi kompetensi'
            ];
        @endphp

        <!-- Pemenuhan Dimensi Kompetensi -->
        <div class="card-box">
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
                          <label><input type="radio" name="{{ $prefix }}_task" value="{{ $opt }}"> {{ $opt }}</label><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($options as $opt)
                          <label><input type="radio" name="{{ $prefix }}_task_mgmt" value="{{ $opt }}"> {{ $opt }}</label><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($options as $opt)
                          <label><input type="radio" name="{{ $prefix }}_contingency" value="{{ $opt }}"> {{ $opt }}</label><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($options as $opt)
                          <label><input type="radio" name="{{ $prefix }}_jobrole" value="{{ $opt }}"> {{ $opt }}</label><br>
                        @endforeach
                    </td>
                    <td>
                        @foreach ($options as $opt)
                          <label><input type="radio" name="{{ $prefix }}_transfer" value="{{ $opt }}"> {{ $opt }}</label><br>
                        @endforeach
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <!-- Rekomendasi Peningkatan -->
        <div class="card-box">
            <textarea name="rekomendasi2" class="form-control mt-2" rows="3" placeholder="Masukkan teks"></textarea>
        </div>

        <!-- Simpan dan Lanjut -->
        <form action="{{ route('ninjau_asesmen_asesor') }}" method="POST">
            @csrf
            ...
            <button type="submit" class="simpan-btn mt-3">
                <span>Simpan dan Lanjut</span>
            </button>
        </form>
    </form>
</div>

<script>
        document.getElementById('skema_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let kode = selected.getAttribute('data-kode');
        let jenjang = selected.getAttribute('data-jenjang');
        let skemaId = this.value;

        // isi nomor otomatis
        document.getElementById('nomor').value = kode || '';

        // pilih radio otomatis sesuai skemanya
        if (jenjang) {
            if (jenjang.toLowerCase().includes("kkni")) {
                document.getElementById('skema1').checked = true;
            } else if (jenjang.toLowerCase().includes("okupasi")) {
                document.getElementById('skema2').checked = true;
            }
        }

        // Ambil asesor berdasarkan skema
        if(skemaId) {
            fetch(`/get-asesor/${skemaId}`)
                .then(response => response.json())
                .then(data => {
                    let selectAsesor = document.getElementById('namaAsesor');
                    selectAsesor.innerHTML = '<option value="">-- Pilih Asesor --</option>';
                    data.forEach(asesor => {
                        selectAsesor.innerHTML += `<option value="${asesor.id_asesor}">${asesor.nama_asesor}</option>`;
                    });
                });
        }
    });
</script>
@endsection
@extends('master')
@section('konten')
<div class="container mt-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
            <li class="breadcrumb-item active" aria-current="page">FR.AK.06</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="text-center mb-4">
        <div class="mapa-logo"></div>
        <h3 class="fw-bold">FR.AK.06 – Meninjau Proses Asesmen</h3>
        <p class="text-muted">Peninjauan Proses Asesmen</p>
    </div>

    <!-- Skema -->
    <div class="skema-container">
        <div class="skema-group">
            <span class="skema-label">SKEMA:</span>
            <select name="skema_id" id="skema_id" class="skema-select">
                <option value="">-- Pilih Skema --</option>
                @foreach($skemas as $skema)
                    <option value="{{ $skema->id_skema }}"
                            data-kode="{{ $skema->kode_skema }}"
                            data-jenjang="{{ $skema->jenjang }}">
                        {{ $skema->nama_skema }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- FORM UTAMA -->
    <form action="{{ route('meninjau_asesmen.store') }}" method="POST">
        @csrf
        <div class="row g-3 mb-4">
            <!-- Skema Sertifikasi -->
            <div class="col-md-6">
                <div class="card-field">
                    <label class="form-label">Skema Sertifikasi</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="skema" id="skema1" value="KKNI">
                            <label class="form-check-label" for="skema1">KKNI</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="skema" id="skema2" value="Okupasi">
                            <label class="form-check-label" for="skema2">Okupasi</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Nomor -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="nomor" class="form-label">Nomor</label>
                    <input type="text" class="form-control" id="nomor" name="nomor" readonly>
                </div>
            </div>

            <!-- Nama Asesor -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="namaAsesor" class="form-label">Nama Asesor</label>
                    <select id="namaAsesor" name="asesor_id" class="form-control">
                        <option value="">-- Pilih Asesor --</option>
                    </select>
                </div>
            </div>

            <!-- Tanggal Asesmen -->
            <div class="col-md-6">
                <div class="card-field">
                    <label for="tanggalAsesmen" class="form-label">Tanggal Asesmen</label>
                    <input type="date" class="form-control" id="tanggalAsesmen" name="tanggal_asesmen">
                </div>
            </div>
        </div>

        <!-- TUK -->
        <div class="col-12 text-center">
            <label class="form-label fw-semibold d-block mb-2">TUK (Tempat Uji Kompetensi) SMKN 11 Bandung:</label>
            <div class="d-flex justify-content-center gap-4">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukSewaktu" value="Sewaktu">
                    <label class="form-check-label" for="tukSewaktu">Sewaktu</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukTempatKerja" value="Tempat Kerja">
                    <label class="form-check-label" for="tukTempatKerja">Tempat Kerja</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="tuk" id="tukMandiri" value="Mandiri">
                    <label class="form-check-label" for="tukMandiri">Mandiri</label>
                </div>
            </div>
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
        <button type="submit" class="simpan-btn">
            <span>Simpan dan Lanjut</span>
        </button>
    </form>
</div>

<script>
    document.getElementById('skema_id').addEventListener('change', function() {
        let selected = this.options[this.selectedIndex];
        let kode = selected.getAttribute('data-kode');
        let jenjang = selected.getAttribute('data-jenjang');
        let skemaId = this.value;

        document.getElementById('nomor').value = kode || '';

        if (jenjang) {
            if (jenjang.toLowerCase().includes("kkni")) {
                document.getElementById('skema1').checked = true;
            } else if (jenjang.toLowerCase().includes("okupasi")) {
                document.getElementById('skema2').checked = true;
            }
        }

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

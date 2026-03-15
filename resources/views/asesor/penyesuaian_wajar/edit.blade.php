@extends('master')

@section('title', 'FR.AK.07 - Edit Penyesuaian Wajar')

@section('konten')
<div class="container-fluid px-4 py-4">
    <form action="{{ route('asesor.penyesuaian_wajar.update', $penyesuaian->id_penyesuaian) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        <input type="hidden" name="id_permohonan" value="{{ $permohonan->id_permohonan }}">

        <!-- Header -->
        <div class="text-center mb-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
            </div>
            <h1 class="display-6 fw-bold text-dark">Edit Penyesuaian Wajar dan Beralasan</h1>
            <p class="text-secondary">FR.AK.07 – Ubah data sesuai kebutuhan asesi</p>
        </div>

        <!-- Informasi Skema dan Asesi -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-info-circle text-primary" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Informasi Sertifikasi</h5>
                        <p class="text-secondary mb-0 small">Data skema, asesi, dan asesor</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Skema Sertifikasi (KKNI/Okupasi/Klaster)</label>
                        <input type="text" class="form-control" value="{{ $permohonan->skema->nama_skema }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Judul</label>
                        <input type="text" class="form-control" value="{{ $permohonan->skema->judul_skema ?? $permohonan->skema->nama_skema }}" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nomor</label>
                        <input type="text" class="form-control" value="{{ $permohonan->skema->kode_skema }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">TUK</label>
                        <input type="text" class="form-control" value="{{ $permohonan->persetujuan->tuk->nama_tuk ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Asesor</label>
                        <input type="text" class="form-control" value="{{ $penyesuaian->asesor->user->name ?? $penyesuaian->asesor->nama_asesor ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Nama Asesi</label>
                        <input type="text" class="form-control" value="{{ $penyesuaian->asesi->user->name ?? $penyesuaian->asesi->nama_asesi ?? '-' }}" readonly>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Tanggal</label>
                        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                </div>
            </div>
        </div>

        <!-- Potensi Asesi -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-check text-primary" viewBox="0 0 16 16">
                            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7zm1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.708l.547.548 1.17-1.951a.5.5 0 1 1 .858.514zM11 5a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Potensi Asesi</h5>
                        <p class="text-secondary mb-0 small">Pilih potensi yang sesuai</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                @php
                    $potensiList = [
                        'Hasil pelatihan dan / atau pendidikan, dimana Kurikulum dan fasilitas praktek mampu telusur terhadap standar kompetensi',
                        'Hasil pelatihan dan / atau pendidikan, dimana kurikulum belum berbasis kompetensi.',
                        'Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya mampu telusur dengan standar kompetensi',
                        'Pekerja berpengalaman, dimana berasal dari industri/tempat kerja yang dalam operasionalnya belum berbasis kompetensi.',
                        'Pelatihan / belajar mandiri atau otodidak.'
                    ];
                    $selectedPotensi = $penyesuaian->potensi->pluck('teks_potensi')->toArray();
                @endphp
                @foreach($potensiList as $index => $text)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" name="potensi[{{ $text }}]" value="1" id="potensi{{ $index }}" {{ in_array($text, $selectedPotensi) ? 'checked' : '' }}>
                        <label class="form-check-label" for="potensi{{ $index }}">
                            {{ $text }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tabel Modifikasi (Item 1-8) -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-list-check text-primary" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3.854 2.146a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 3.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708L2 7.293l1.146-1.147a.5.5 0 0 1 .708 0zm0 4a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Mengidentifikasi Persyaratan Modifikasi dan Kontekstualisasi</h5>
                        <p class="text-secondary mb-0 small">Isi sesuai karakteristik asesi</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:30%">Mengidentifikasi</th>
                                <th style="width:15%">Diperlukan penyesuaian?**</th>
                                <th>Keterangan (pilih yang sesuai, boleh lebih dari satu)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $itemLabels = [
                                    1 => 'Keterbatasan asesi terhadap persyaratan bahasa, literasi, numerasi.',
                                    2 => 'Penyediaan dukungan pembaca, penerjemah, pelayan, penulis.',
                                    3 => 'Penggunaan teknologi adaptif atau peralatan khusus. (Tidak dapat menggunakan teknologi adaptif (misal: mengoperasikan komputer dan printer, peralatan digital dsb).',
                                    4 => 'Pelaksanaan asesmen secara fleksibel karena alasan keletihan atau keperluan pengobatan.',
                                    5 => 'Penyediaan peralatan asesmen berupa braille, audio/video-tape.',
                                    6 => 'Penyesuaian tempat fisik/lingkungan asesmen',
                                    7 => 'Pertimbangan umur/usia lanjut/gender asesi. (Adanya perbedaan usia dengan asesor yang lebih muda).',
                                    8 => 'Pertimbangan budaya/tradisi/agama.',
                                ];
                                $items = $penyesuaian->items->keyBy('nomor_item');
                            @endphp

                            <!-- Item 1 -->
                            <tr>
                                <td class="align-middle text-center">1</td>
                                <td class="align-middle">{{ $itemLabels[1] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(1); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[1][dipilih]" value="1" id="item1_ya" data-item="1" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item1_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[1][dipilih]" value="0" id="item1_tidak" data-item="1" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item1_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-1">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[1][keterangan][]" value="Memerlukan dukungan pembaca, penerjemah, pelayan, penulis. untuk merekam jawaban asesi." id="item1_ket1" {{ in_array('Memerlukan dukungan pembaca, penerjemah, pelayan, penulis. untuk merekam jawaban asesi.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item1_ket1">Memerlukan dukungan pembaca, penerjemah, pelayan, penulis. untuk merekam jawaban asesi.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[1][keterangan][]" value="Melakukan asesmen verbal (gunakan pertanyaan lisan/pertanyaan wawancara) dengan dilengkapi gambar diagram dan bentuk-bentuk visual." id="item1_ket2" {{ in_array('Melakukan asesmen verbal (gunakan pertanyaan lisan/pertanyaan wawancara) dengan dilengkapi gambar diagram dan bentuk-bentuk visual.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item1_ket2">Melakukan asesmen verbal (gunakan pertanyaan lisan/pertanyaan wawancara) dengan dilengkapi gambar diagram dan bentuk-bentuk visual.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[1][keterangan][]" value="Menggunakan Hasil produksi" id="item1_ket3" {{ in_array('Menggunakan Hasil produksi', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item1_ket3">Menggunakan Hasil produksi</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[1][keterangan][]" value="Mengunakan Ceklis observasi/demonstrasi." id="item1_ket4" {{ in_array('Mengunakan Ceklis observasi/demonstrasi.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item1_ket4">Mengunakan Ceklis observasi/demonstrasi.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[1][keterangan][]" value="Menggunakan daftar instruksi terstruktur." id="item1_ket5" {{ in_array('Menggunakan daftar instruksi terstruktur.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item1_ket5">Menggunakan daftar instruksi terstruktur.</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[1][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 2 -->
                            <tr>
                                <td class="align-middle text-center">2</td>
                                <td class="align-middle">{{ $itemLabels[2] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(2); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[2][dipilih]" value="1" id="item2_ya" data-item="2" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item2_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[2][dipilih]" value="0" id="item2_tidak" data-item="2" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item2_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-2">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[2][keterangan][]" value="Menggunakan pertanyaan lisan dengan dilengkapi gambar diagram dan bentuk-bentuk visual." id="item2_ket1" {{ in_array('Menggunakan pertanyaan lisan dengan dilengkapi gambar diagram dan bentuk-bentuk visual.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item2_ket1">Menggunakan pertanyaan lisan dengan dilengkapi gambar diagram dan bentuk-bentuk visual.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[2][keterangan][]" value="Menggunakan pertanyaan wawancara dengan dilengkapi gambar diagram dan bentuk-bentuk visual." id="item2_ket2" {{ in_array('Menggunakan pertanyaan wawancara dengan dilengkapi gambar diagram dan bentuk-bentuk visual.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item2_ket2">Menggunakan pertanyaan wawancara dengan dilengkapi gambar diagram dan bentuk-bentuk visual.</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[2][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 3 -->
                            <tr>
                                <td class="align-middle text-center">3</td>
                                <td class="align-middle">{{ $itemLabels[3] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(3); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[3][dipilih]" value="1" id="item3_ya" data-item="3" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item3_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[3][dipilih]" value="0" id="item3_tidak" data-item="3" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item3_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-3">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[3][keterangan][]" value="Ceklis observasi/demonstrasi Demonstrasi." id="item3_ket1" {{ in_array('Ceklis observasi/demonstrasi Demonstrasi.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item3_ket1">Ceklis observasi/demonstrasi Demonstrasi.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[3][keterangan][]" value="Pertanyaan lisan" id="item3_ket2" {{ in_array('Pertanyaan lisan', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item3_ket2">Pertanyaan lisan</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[3][keterangan][]" value="Pertanyaan tertulis." id="item3_ket3" {{ in_array('Pertanyaan tertulis.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item3_ket3">Pertanyaan tertulis.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[3][keterangan][]" value="Pertanyaan wawancara." id="item3_ket4" {{ in_array('Pertanyaan wawancara.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item3_ket4">Pertanyaan wawancara.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[3][keterangan][]" value="Daftar instruksi terstruktur." id="item3_ket5" {{ in_array('Daftar instruksi terstruktur.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item3_ket5">Daftar instruksi terstruktur.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[3][keterangan][]" value="Ceklis verifikasi portofolio." id="item3_ket6" {{ in_array('Ceklis verifikasi portofolio.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item3_ket6">Ceklis verifikasi portofolio.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[3][keterangan][]" value="Menggunakan dukungan operator komputer." id="item3_ket7" {{ in_array('Menggunakan dukungan operator komputer.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item3_ket7">Menggunakan dukungan operator komputer.</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[3][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 4 -->
                            <tr>
                                <td class="align-middle text-center">4</td>
                                <td class="align-middle">{{ $itemLabels[4] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(4); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[4][dipilih]" value="1" id="item4_ya" data-item="4" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item4_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[4][dipilih]" value="0" id="item4_tidak" data-item="4" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item4_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-4">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[4][keterangan][]" value="Menggunakan juru tulis." id="item4_ket1" {{ in_array('Menggunakan juru tulis.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item4_ket1">Menggunakan juru tulis.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[4][keterangan][]" value="Menggunakan kamaramen perekam vidio/ataudio." id="item4_ket2" {{ in_array('Menggunakan kamaramen perekam vidio/ataudio.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item4_ket2">Menggunakan kamaramen perekam vidio/ataudio.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[4][keterangan][]" value="Memperbolehkan periode waktu yang lebih panjang untuk menyelesaikan tugas pekrejaan dalam asesmen." id="item4_ket3" {{ in_array('Memperbolehkan periode waktu yang lebih panjang untuk menyelesaikan tugas pekrejaan dalam asesmen.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item4_ket3">Memperbolehkan periode waktu yang lebih panjang untuk menyelesaikan tugas pekrejaan dalam asesmen.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[4][keterangan][]" value="Melakukan tugas pekerjaan dalam asesmen dengan waktu lebih pendek." id="item4_ket4" {{ in_array('Melakukan tugas pekerjaan dalam asesmen dengan waktu lebih pendek.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item4_ket4">Melakukan tugas pekerjaan dalam asesmen dengan waktu lebih pendek.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[4][keterangan][]" value="Menggunakan instruksi-instruksi spesifik pada proyek yang dapat dilakukan pada berbagai tingkatan." id="item4_ket5" {{ in_array('Menggunakan instruksi-instruksi spesifik pada proyek yang dapat dilakukan pada berbagai tingkatan.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item4_ket5">Menggunakan instruksi-instruksi spesifik pada proyek yang dapat dilakukan pada berbagai tingkatan.</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[4][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 5 -->
                            <tr>
                                <td class="align-middle text-center">5</td>
                                <td class="align-middle">{{ $itemLabels[5] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(5); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[5][dipilih]" value="1" id="item5_ya" data-item="5" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item5_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[5][dipilih]" value="0" id="item5_tidak" data-item="5" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item5_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-5">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[5][keterangan][]" value="Menggunakan pertanyaan lisan." id="item5_ket1" {{ in_array('Menggunakan pertanyaan lisan.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item5_ket1">Menggunakan pertanyaan lisan.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[5][keterangan][]" value="Menggunakan pertanyaan wawancara." id="item5_ket2" {{ in_array('Menggunakan pertanyaan wawancara.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item5_ket2">Menggunakan pertanyaan wawancara.</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[5][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 6 -->
                            <tr>
                                <td class="align-middle text-center">6</td>
                                <td class="align-middle">{{ $itemLabels[6] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(6); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[6][dipilih]" value="1" id="item6_ya" data-item="6" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item6_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[6][dipilih]" value="0" id="item6_tidak" data-item="6" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item6_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-6">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[6][keterangan][]" value="Pertanyaan lisan." id="item6_ket1" {{ in_array('Pertanyaan lisan.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item6_ket1">Pertanyaan lisan.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[6][keterangan][]" value="Pertanyaan tulis." id="item6_ket2" {{ in_array('Pertanyaan tulis.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item6_ket2">Pertanyaan tulis.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[6][keterangan][]" value="Pertanyaan wawancara." id="item6_ket3" {{ in_array('Pertanyaan wawancara.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item6_ket3">Pertanyaan wawancara.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[6][keterangan][]" value="Ceklis Verifikasi portofolio." id="item6_ket4" {{ in_array('Ceklis Verifikasi portofolio.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item6_ket4">Ceklis Verifikasi portofolio.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[6][keterangan][]" value="Ceklis reviu produk." id="item6_ket5" {{ in_array('Ceklis reviu produk.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item6_ket5">Ceklis reviu produk.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[6][keterangan][]" value="Daftar instruksi terstruktur." id="item6_ket6" {{ in_array('Daftar instruksi terstruktur.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item6_ket6">Daftar instruksi terstruktur.</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[6][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 7 -->
                            <tr>
                                <td class="align-middle text-center">7</td>
                                <td class="align-middle">{{ $itemLabels[7] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(7); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[7][dipilih]" value="1" id="item7_ya" data-item="7" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item7_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[7][dipilih]" value="0" id="item7_tidak" data-item="7" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item7_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-7">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[7][keterangan][]" value="Menggunakan studi kasus/daftar instruksi terstrukut" id="item7_ket1" {{ in_array('Menggunakan studi kasus/daftar instruksi terstrukut', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item7_ket1">Menggunakan studi kasus/daftar instruksi terstrukut</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[7][keterangan][]" value="Menggunakan instrumen asesmen dengan huruf normal jangan terlalu kecil." id="item7_ket2" {{ in_array('Menggunakan instrumen asesmen dengan huruf normal jangan terlalu kecil.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item7_ket2">Menggunakan instrumen asesmen dengan huruf normal jangan terlalu kecil.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[7][keterangan][]" value="Menggunakan asesor dengan jenis kelamin yang sama dengan asesi." id="item7_ket3" {{ in_array('Menggunakan asesor dengan jenis kelamin yang sama dengan asesi.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item7_ket3">Menggunakan asesor dengan jenis kelamin yang sama dengan asesi.</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[7][keterangan][]" value="Menggunakan instrumen asesmen yang sama walaupun berbeda jenis kelamin (tidak boleh memberi tanda tambahan)." id="item7_ket4" {{ in_array('Menggunakan instrumen asesmen yang sama walaupun berbeda jenis kelamin (tidak boleh memberi tanda tambahan).', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item7_ket4">Menggunakan instrumen asesmen yang sama walaupun berbeda jenis kelamin (tidak boleh memberi tanda tambahan).</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[7][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Item 8 -->
                            <tr>
                                <td class="align-middle text-center">8</td>
                                <td class="align-middle">{{ $itemLabels[8] }}</td>
                                <td class="align-middle">
                                    @php $item = $items->get(8); @endphp
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[8][dipilih]" value="1" id="item8_ya" data-item="8" {{ $item && $item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item8_ya">Ya</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input item-radio" type="radio" name="items[8][dipilih]" value="0" id="item8_tidak" data-item="8" {{ !$item || !$item->dipilih ? 'checked' : '' }}>
                                        <label class="form-check-label" for="item8_tidak">Tidak</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="row" id="keterangan-8">
                                        @php
                                            $keteranganDipilih = $item ? $item->keteranganItems->where('is_lainnya', false)->pluck('keterangan')->toArray() : [];
                                            $keteranganLain = $item ? $item->keteranganItems->where('is_lainnya', true)->pluck('keterangan')->first() : '';
                                        @endphp
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[8][keterangan][]" value="Menggunakan studi kasus daftar instruksi terstrukut" id="item8_ket1" {{ in_array('Menggunakan studi kasus daftar instruksi terstrukut', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item8_ket1">Menggunakan studi kasus daftar instruksi terstrukut</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[8][keterangan][]" value="Menggunakan asesor tanpa pertimbangan budaya/tradisi/agama." id="item8_ket2" {{ in_array('Menggunakan asesor tanpa pertimbangan budaya/tradisi/agama.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item8_ket2">Menggunakan asesor tanpa pertimbangan budaya/tradisi/agama.</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input item-checkbox" type="checkbox" name="items[8][keterangan][]" value="Menggunakan instrumen asesmen yang sama walaupun berbeda budaya/tradisi/agama." id="item8_ket3" {{ in_array('Menggunakan instrumen asesmen yang sama walaupun berbeda budaya/tradisi/agama.', $keteranganDipilih) ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="item8_ket3">Menggunakan instrumen asesmen yang sama walaupun berbeda budaya/tradisi/agama.</label>
                                            </div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <div class="input-group">
                                                <span class="input-group-text">Lainnya:</span>
                                                <input type="text" class="form-control item-text" name="items[8][keterangan_lain]" placeholder="Isi keterangan lain..." value="{{ $keteranganLain }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Hasil Penyesuaian -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white border-0 pt-4 pb-0">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check2-circle text-primary" viewBox="0 0 16 16">
                            <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                            <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0">Hasil Penyesuaian yang wajar dan beralasan disepakati menggunakan</h5>
                        <p class="text-secondary mb-0 small">Isi hasil kesepakatan</p>
                    </div>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="mb-3">
                    <label class="form-label">1) Acuan Pembanding Asesmen</label>
                    <textarea name="acuan_pembanding" class="form-control" rows="2" placeholder="Isi acuan pembanding...">{{ $penyesuaian->acuan_pembanding }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">2) Metode Asesmen</label>
                    <textarea name="metode_asesmen" class="form-control" rows="2" placeholder="Isi metode asesmen...">{{ $penyesuaian->metode_asesmen }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">3) Instrumen Asesmen</label>
                    <textarea name="instrumen_asesmen" class="form-control" rows="2" placeholder="Isi instrumen asesmen...">{{ $penyesuaian->instrumen_asesmen }}</textarea>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi -->
        <div class="button-group mt-4">
            <a href="{{ route('asesor.penyesuaian_wajar.show', $penyesuaian->id_penyesuaian) }}" class="btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                </svg>
                Batal
            </a>
            <button type="submit" class="btn-next">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save me-2" viewBox="0 0 16 16">
                    <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v4.5h2V2h2v12H2V2h2v4.5h2V2a1 1 0 0 0-1-1H2z"/>
                </svg>
                Update Draf
            </button>
        </div>
    </form>
</div>

<style>
    /* ===== VARIABEL & RESET dengan warna utama #0b2f7c ===== */
    :root {
        --primary: #0b2f7c;
        --primary-dark: #08205c;
        --primary-light: #1a3e9c;
        --secondary: #6c757d;
        --success: #198754;
        --danger: #dc3545;
        --light: #f8f9fa;
        --dark: #212529;
        --font-sans: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
    }

    body {
        font-family: var(--font-sans);
        background-color: #f1f4f9;
    }

    .container-fluid {
        max-width: 1280px;
        margin: 0 auto;
    }

    /* ===== FORM CARD & INPUT ===== */
    .card {
        border-radius: 1.25rem;
        overflow: hidden;
        transition: all 0.2s ease;
        background: #ffffff;
    }

    .card:hover {
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.08) !important;
    }

    .card-header {
        background: transparent;
        padding-bottom: 0;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.9rem;
        color: #1e293b;
        margin-bottom: 0.3rem;
    }

    .form-control, .form-select {
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background-color: #fff;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
        outline: none;
    }

    /* ===== WARNA UTAMA #0b2f7c ===== */
    .bg-primary {
        background-color: var(--primary) !important;
    }

    .bg-primary.bg-gradient {
        background: linear-gradient(145deg, var(--primary), var(--primary-dark)) !important;
    }

    .bg-primary.bg-opacity-10 {
        background-color: rgba(11,47,124,0.1) !important;
    }

    .text-primary {
        color: var(--primary) !important;
    }

    /* Tombol Next & Back */
    .btn-next {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        color: #fff;
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(11,47,124,0.3);
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-next:hover {
        background: linear-gradient(135deg, var(--primary-dark), #061944);
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(11,47,124,0.35);
        color: #fff;
    }

    .btn-back {
        background-color: #fff;
        color: var(--secondary);
        padding: 0.7rem 1.8rem;
        border-radius: 2rem;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        border: 1.5px solid #dee2e6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }

    .btn-back:hover {
        background-color: #f1f3f5;
        color: #495057;
        border-color: #ced4da;
    }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }

    .card-body ul {
        padding-left: 1.5rem;
        list-style-type: disc;
    }
    .card-body li {
        margin-bottom: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .button-group {
            justify-content: center;
        }
    }
</style>

<!-- Script untuk toggle keterangan (salin dari create) -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.item-radio');

        function toggleKeterangan(itemId, isYa) {
            const keteranganDiv = document.getElementById('keterangan-' + itemId);
            if (keteranganDiv) {
                const checkboxes = keteranganDiv.querySelectorAll('.item-checkbox');
                checkboxes.forEach(cb => {
                    cb.disabled = !isYa;
                });
                const textInputs = keteranganDiv.querySelectorAll('.item-text');
                textInputs.forEach(inp => {
                    inp.disabled = !isYa;
                });
            }
        }

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                const itemId = this.dataset.item;
                const isYa = (this.value === '1');
                toggleKeterangan(itemId, isYa);
            });
        });

        // Inisialisasi
        for (let i = 1; i <= 8; i++) {
            const radioYa = document.querySelector(`input[name="items[${i}][dipilih]"][value="1"]`);
            const radioTidak = document.querySelector(`input[name="items[${i}][dipilih]"][value="0"]`);
            if (radioTidak && radioTidak.checked) {
                toggleKeterangan(i, false);
            } else if (radioYa && radioYa.checked) {
                toggleKeterangan(i, true);
            }
        }
    });
</script>
@endsection
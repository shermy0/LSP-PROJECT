@extends('master')

@section('title', 'Detail Persetujuan Asesmen')

@section('konten')
<div class="container-fluid px-4 py-4">
    <!-- Header dengan ikon lingkaran gradient -->
    <div class="text-center mb-5">
        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle mb-3" style="width: 70px; height: 70px; box-shadow: 0 10px 20px rgba(11,47,124,0.3);">
            <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
            </svg>
        </div>
        <h1 class="display-6 fw-bold text-dark">Detail Persetujuan Asesmen</h1>
        <p class="text-secondary">FR.AK.01 – Informasi lengkap persetujuan asesmen</p>
    </div>

    <!-- Card Informasi Skema dan Status -->
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
                    <h5 class="fw-bold mb-0">Informasi Persetujuan</h5>
                    <p class="text-secondary mb-0 small">Detail persetujuan asesmen</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <div>
                        @if($persetujuan->status == 'draf')
                            <span class="badge bg-warning text-dark px-3 py-2 fs-6">Draf (Menunggu Tanda Tangan Asesi)</span>
                        @elseif($persetujuan->status == 'menunggu_asesor')
                            <span class="badge bg-info text-white px-3 py-2 fs-6">Menunggu Tanda Tangan Asesor</span>
                        @elseif($persetujuan->status == 'selesai')
                            <span class="badge bg-success px-3 py-2 fs-6">Selesai</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Informasi Skema -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-text text-primary" viewBox="0 0 16 16">
                        <path d="M5 4a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm-.5 2.5A.5.5 0 0 1 5 6h6a.5.5 0 0 1 0 1H5a.5.5 0 0 1-.5-.5zM5 8a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"/>
                        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Informasi Skema</h5>
                    <p class="text-secondary mb-0 small">Skema sertifikasi yang diajukan</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Skema Sertifikasi (KKNI/Okupasi/Klaster)</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->permohonan->skema->nama_skema }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Judul</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->permohonan->skema->judul_skema ?? $persetujuan->permohonan->skema->nama_skema }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nomor</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->permohonan->skema->kode_skema }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Asesor & Asesi -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-people text-primary" viewBox="0 0 16 16">
                        <path d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.978-1A.261.261 0 0 1 7 12.996c.001-.264.167-1.03.76-1.72C8.312 10.629 9.282 10 11 10c1.717 0 2.687.63 3.24 1.276.593.69.758 1.457.76 1.72l-.008.002a.274.274 0 0 1-.014.002H7.022zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10A5.493 5.493 0 0 0 4 13H1c0-.26.164-1.03.76-1.724.545-.636 1.492-1.256 3.16-1.275zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Asesor & Asesi</h5>
                    <p class="text-secondary mb-0 small">Informasi asesor dan asesi</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Nama Asesor</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->asesor->nama_asesor }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Nama Asesi</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->permohonan->asesi->nama_lengkap }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Card TUK -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-building text-primary" viewBox="0 0 16 16">
                        <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-6 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-6 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                        <path d="M1 2a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2zm2-1a1 1 0 0 0-1 1v12h12V2a1 1 0 0 0-1-1H3z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Tempat Uji Kompetensi (TUK)</h5>
                    <p class="text-secondary mb-0 small">Lokasi pelaksanaan asesmen</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label">Nama TUK</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->tuk->nama_tuk ?? '-' }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Bukti yang akan dikumpulkan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-file-earmark-check text-primary" viewBox="0 0 16 16">
                        <path d="M10.854 7.854a.5.5 0 0 0-.708-.708L7.5 9.793 6.354 8.646a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z"/>
                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Bukti yang akan dikumpulkan</h5>
                    <p class="text-secondary mb-0 small">Bukti yang dipilih</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            @if($persetujuan->buktiTerpilih->count() > 0)
                <ul class="list-group list-group-flush">
                    @foreach($persetujuan->buktiTerpilih as $bukti)
                        <li class="list-group-item px-0">
                            {{ $bukti->jenisBukti->nama_bukti ?? '-' }}
                            @if($bukti->deskripsi)
                                <br><small class="text-muted">{{ $bukti->deskripsi }}</small>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">Tidak ada bukti yang dipilih</p>
            @endif
        </div>
    </div>

    <!-- Card Jadwal Pelaksanaan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-calendar-check text-primary" viewBox="0 0 16 16">
                        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Pelaksanaan asesmen disepakati pada:</h5>
                    <p class="text-secondary mb-0 small">Tanggal, waktu, dan lokasi</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Hari / Tanggal</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->tgl_pelaksanaan ? \Carbon\Carbon::parse($persetujuan->tgl_pelaksanaan)->format('d M Y') : '-' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Waktu</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->waktu ?? '-' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Lokasi</label>
                    <input type="text" class="form-control" value="{{ $persetujuan->lokasi ?? '-' }}" readonly>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Pernyataan -->
    <div class="card border-0 shadow-sm bg-light mb-4">
        <div class="card-body">
            <p class="fw-semibold">Asesi :</p>
            <p class="mb-3">Bahwa saya telah mendapatkan penjelasan terkait hak dan prosedur banding asesmen dari asesor.</p>
            <p class="fw-semibold">Asesor :</p>
            <p class="mb-3">Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan saya sebagai Asesor dalam pekerjaan Asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai Asesor yang ditugaskan oleh LSP.</p>
            <p class="fw-semibold">Asesi :</p>
            <p>Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan profesional dan hanya dapat diakses oleh orang tertentu saja.</p>
        </div>
    </div>

    <!-- Card Setuju Asesmen -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle text-primary" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Setuju Asesmen</h5>
                    <p class="text-secondary mb-0 small">Konfirmasi persetujuan</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" disabled {{ $persetujuan->setuju_asesmen ? 'checked' : '' }}>
                <label class="form-check-label">
                    Saya setuju dengan pelaksanaan asesmen ini
                </label>
            </div>
        </div>
    </div>

    <!-- Card Tanda Tangan -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 pt-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-pen text-primary" viewBox="0 0 16 16">
                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                    </svg>
                </div>
                <div>
                    <h5 class="fw-bold mb-0">Tanda Tangan</h5>
                    <p class="text-secondary mb-0 small">Tanda tangan asesi dan asesor</p>
                </div>
            </div>
        </div>
        <div class="card-body pt-3">
            <div class="row g-4">
                <!-- Tanda tangan Asesi -->
                <div class="col-md-6">
                    <label class="form-label">Tanda Tangan Asesi</label>
                    @if($persetujuan->ttd && $persetujuan->ttd->ttd_asesi)
                        <div class="border rounded p-3 text-center bg-light">
                            <img src="{{ Storage::url($persetujuan->ttd->ttd_asesi) }}" alt="TTD Asesi" class="img-fluid" style="max-height:150px;">
                            <p class="mt-2">Tanggal: {{ $persetujuan->ttd->tgl_ttd_asesi ? \Carbon\Carbon::parse($persetujuan->ttd->tgl_ttd_asesi)->format('d M Y') : '-' }}</p>
                        </div>
                    @else
                        @if(Auth::user()->role == 'asesi' && $persetujuan->status == 'draf')
                            <form method="POST" action="{{ route('asesi.persetujuan_asesmen.signature', $persetujuan->id_persetujuan) }}">
                                @csrf
                                <div class="canvas-wrapper mb-2">
                                    <canvas id="ttd-asesi" class="ttd-canvas" width="400" height="160"></canvas>
                                    <span class="canvas-placeholder">Tanda tangan di sini</span>
                                </div>
                                <input type="hidden" name="ttd_asesi" id="ttd-asesi-input" required>
                                <input type="hidden" name="tgl_ttd_asesi" value="{{ date('Y-m-d') }}">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCanvas('ttd-asesi')">Hapus</button>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan Tanda Tangan</button>
                            </form>
                        @else
                            <p class="text-muted">Belum ditandatangani</p>
                        @endif
                    @endif
                </div>

                <!-- Tanda tangan Asesor -->
                <div class="col-md-6">
                    <label class="form-label">Tanda Tangan Asesor</label>
                    @if($persetujuan->ttd && $persetujuan->ttd->ttd_asesor)
                        <div class="border rounded p-3 text-center bg-light">
                            <img src="{{ Storage::url($persetujuan->ttd->ttd_asesor) }}" alt="TTD Asesor" class="img-fluid" style="max-height:150px;">
                            <p class="mt-2">Tanggal: {{ $persetujuan->ttd->tgl_ttd_asesor ? \Carbon\Carbon::parse($persetujuan->ttd->tgl_ttd_asesor)->format('d M Y') : '-' }}</p>
                        </div>
                    @else
                        @if(Auth::user()->role == 'asesor' && $persetujuan->status == 'menunggu_asesor')
                            <form method="POST" action="{{ route('asesor.persetujuan_asesmen.signature', $persetujuan->id_persetujuan) }}">
                                @csrf
                                <div class="canvas-wrapper mb-2">
                                    <canvas id="ttd-asesor" class="ttd-canvas" width="400" height="160"></canvas>
                                    <span class="canvas-placeholder">Tanda tangan di sini</span>
                                </div>
                                <input type="hidden" name="ttd_asesor" id="ttd-asesor-input" required>
                                <input type="hidden" name="tgl_ttd_asesor" value="{{ date('Y-m-d') }}">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearCanvas('ttd-asesor')">Hapus</button>
                                <button type="submit" class="btn btn-sm btn-primary">Simpan Tanda Tangan</button>
                            </form>
                        @else
                            <p class="text-muted">Belum ditandatangani</p>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="button-group mt-4">
        <a href="{{ Auth::user()->role == 'asesor' ? route('asesor.persetujuan_asesmen.index') : route('asesi.persetujuan_asesmen.index') }}" class="btn-back">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left me-2" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
            </svg>
            Kembali
        </a>
    </div>
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

    .form-control {
        border: 1.5px solid #e2e8f0;
        border-radius: 0.75rem;
        padding: 0.6rem 1rem;
        font-size: 0.95rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background-color: #fff;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(11,47,124,0.15);
        outline: none;
    }

    .form-control:read-only {
        background-color: #f8f9fa;
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

    /* Tombol Back (outline) */
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

    /* Badge styling */
    .badge {
        font-weight: 500;
        border-radius: 2rem;
        padding: 0.5rem 1rem;
    }

    /* Canvas wrapper */
    .canvas-wrapper {
        position: relative;
        width: 100%;
        background: white;
        border-radius: 1rem;
        overflow: hidden;
        border: 2px dashed #d0d9e8;
    }

    .ttd-canvas {
        display: block;
        width: 100%;
        height: 160px;
        background: #ffffff;
        cursor: crosshair;
        touch-action: none;
    }

    .canvas-placeholder {
        position: absolute;
        bottom: 10px;
        left: 50%;
        transform: translateX(-50%);
        color: #9aa9b9;
        font-size: 0.9rem;
        background: rgba(255,255,255,0.7);
        padding: 4px 12px;
        border-radius: 40px;
        pointer-events: none;
        backdrop-filter: blur(2px);
    }

    .btn-outline-danger,
    .btn-outline-success,
    .btn-primary {
        border-width: 1.5px;
        border-radius: 2rem;
        font-weight: 500;
        transition: all 0.2s;
    }

    .btn-outline-danger:hover {
        background-color: var(--danger);
        color: white;
    }

    .btn-outline-success:hover {
        background-color: var(--success);
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        border: none;
        box-shadow: 0 8px 18px rgba(11,47,124,0.3);
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, var(--primary-dark), #061944);
        transform: translateY(-2px);
        box-shadow: 0 12px 22px rgba(11,47,124,0.35);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .button-group {
            justify-content: center;
        }
    }
</style>

<script>
    // Fungsi untuk inisialisasi canvas (sama seperti di form)
    function initSignature(canvasId, inputId) {
        const canvas = document.getElementById(canvasId);
        if (!canvas) return;
        const ctx = canvas.getContext('2d');
        let drawing = false;
        const VISIBLE_HEIGHT = 160;

        function resizeCanvas() {
            const container = canvas.parentElement;
            const cssWidth = container.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);

            canvas.width = Math.round(cssWidth * ratio);
            canvas.height = Math.round(cssHeight * ratio);

            ctx.setTransform(1, 0, 0, 1, 0, 0);
            ctx.scale(ratio, ratio);

            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);

            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.strokeStyle = '#000';
        }

        function getPointerPos(evt) {
            const rect = canvas.getBoundingClientRect();
            let clientX, clientY;
            if (evt.touches && evt.touches.length > 0) {
                clientX = evt.touches[0].clientX;
                clientY = evt.touches[0].clientY;
            } else {
                clientX = evt.clientX;
                clientY = evt.clientY;
            }
            return {
                x: (clientX - rect.left) * (canvas.width / rect.width),
                y: (clientY - rect.top) * (canvas.height / rect.height)
            };
        }

        function startDrawing(evt) {
            evt.preventDefault();
            drawing = true;
            const pos = getPointerPos(evt);
            ctx.beginPath();
            ctx.moveTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
        }

        function drawMove(evt) {
            if (!drawing) return;
            evt.preventDefault();
            const pos = getPointerPos(evt);
            ctx.lineTo(pos.x / (canvas.width / canvas.clientWidth), pos.y / (canvas.height / canvas.clientHeight));
            ctx.stroke();
        }

        function stopDrawing() {
            drawing = false;
            ctx.beginPath();
        }

        canvas.addEventListener('mousedown', startDrawing);
        canvas.addEventListener('mousemove', drawMove);
        canvas.addEventListener('mouseup', stopDrawing);
        canvas.addEventListener('mouseleave', stopDrawing);

        canvas.addEventListener('touchstart', startDrawing, { passive: false });
        canvas.addEventListener('touchmove', drawMove, { passive: false });
        canvas.addEventListener('touchend', stopDrawing);

        window.addEventListener('resize', resizeCanvas);
        resizeCanvas();

        window.clearCanvas = function(id) {
            const c = document.getElementById(id);
            if (!c) return;
            const ctx = c.getContext('2d');
            const container = c.parentElement;
            const cssWidth = container.clientWidth;
            const cssHeight = VISIBLE_HEIGHT;
            const ratio = Math.max(window.devicePixelRatio || 1, 1);
            c.width = Math.round(cssWidth * ratio);
            c.height = Math.round(cssHeight * ratio);
            ctx.setTransform(1,0,0,1,0,0);
            ctx.scale(ratio, ratio);
            ctx.fillStyle = "#ffffff";
            ctx.fillRect(0, 0, cssWidth, cssHeight);
            document.getElementById(inputId).value = '';
        };
    }

    // Inisialisasi canvas jika ada
    document.addEventListener('DOMContentLoaded', function() {
        initSignature('ttd-asesi', 'ttd-asesi-input');
        initSignature('ttd-asesor', 'ttd-asesor-input');

        // Simpan base64 ke input sebelum submit
        document.querySelectorAll('form canvas').forEach(canvas => {
            const form = canvas.closest('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const inputId = canvas.id + '-input';
                    const input = document.getElementById(inputId);
                    if (input) {
                        input.value = canvas.toDataURL('image/png');
                    }
                });
            }
        });
    });
</script>
@endsection
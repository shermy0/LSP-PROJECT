@extends('master')

@section('title', 'Form Asesmen - Asesor')

@section('konten')
<div class="container-fluid mt-4 mb-5">
    <div class="bg-white border rounded-3 shadow-sm p-4">

        <!-- Panduan Bagi Asesor -->
        <div class="asesmen-card">
            <div class="asesmen-header">
                <span class="header-line"></span>
                <h5>Panduan Bagi Asesor</h5>
            </div>
            <div class="asesmen-body">
                @php
                    $panduan = [
                        'Pastikan data yang diisi oleh Asesi sudah lengkap dan sesuai dokumen pendukung.',
                        'Verifikasi kebenaran data identitas Asesi, latar belakang pendidikan, serta pengalaman kerja.',
                        'Tandai hasil pemeriksaan dengan √ pada kotak yang tersedia sesuai kondisi.',
                        'Jika ada catatan khusus, tuliskan pada kolom keterangan.'
                    ];
                @endphp
                @foreach($panduan as $i => $text)
                    <div class="panduan-item">
                        <div class="panduan-number">{{ $i+1 }}</div>
                        <div class="panduan-text">{{ $text }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Data Asesi -->
        <div class="asesmen-card">
            <div class="asesmen-header">
                <span class="header-line"></span>
                <h5>Data Asesi</h5>
            </div>
            <div class="asesmen-body">
                <table class="table table-bordered asesmen-table mb-0">
                    <tbody>
                        <tr><th>Nama Lengkap</th><td>{{ $asesi->nama ?? '-' }}</td></tr>
                        <tr><th>NIK</th><td>{{ $asesi->nik ?? '-' }}</td></tr>
                        <tr><th>Tempat / Tanggal Lahir</th><td>{{ $asesi->tempat_lahir ?? '-' }}, {{ $asesi->tanggal_lahir ?? '-' }}</td></tr>
                        <tr><th>Pendidikan Terakhir</th><td>{{ $asesi->pendidikan ?? '-' }}</td></tr>
                        <tr><th>Alamat</th><td>{{ $asesi->alamat ?? '-' }}</td></tr>
                        <tr><th>No. Telepon / HP</th><td>{{ $asesi->telepon ?? '-' }}</td></tr>
                        <tr><th>Email</th><td>{{ $asesi->email ?? '-' }}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Verifikasi Asesor -->
        <div class="asesmen-card mb-4">
            <div class="asesmen-header">
                <span class="header-line"></span>
                <h5>Hasil Verifikasi Asesor</h5>
            </div>
            <div class="asesmen-body p-0">
                <table class="table table-bordered asesmen-table mb-0 align-middle">
                    <thead class="text-center bg-primary text-white">
                        <tr>
                            <th style="width:40px;">No</th>
                            <th style="width:300px;">Aspek yang Diverifikasi</th>
                            <th style="width:200px;">Sesuai</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $aspek = [
                                'Identitas Asesi sesuai dengan dokumen resmi (KTP/Paspor).',
                                'Data pendidikan terakhir sesuai dengan ijazah/sertifikat.',
                                'Pengalaman kerja sesuai dengan bukti pendukung (paklaring, surat tugas, dsb).',
                                'Kompetensi yang diajukan relevan dengan skema sertifikasi.'
                            ];
                        @endphp
                        @foreach($aspek as $i => $item)
                        <tr>
                            <td class="text-center">{{ $i+1 }}</td>
                            <td>{{ $item }}</td>
                            <td class="text-center">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aspek{{ $i }}" id="ya{{ $i }}" value="ya">
                                    <label class="form-check-label" for="ya{{ $i }}">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="aspek{{ $i }}" id="tidak{{ $i }}" value="tidak">
                                    <label class="form-check-label" for="tidak{{ $i }}">Tidak</label>
                                </div>
                            </td>
                            <td><input type="text" class="form-control form-control-sm" placeholder="Catatan..."></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Tombol Selanjutnya -->
    <div class="d-flex justify-content-end mt-3">
        <a href="{{ route('asesor.wajar_alasan.form2') }}" class="btn btn-primary px-4 shadow-sm">
            Selanjutnya <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
</div>

<!-- CSS Khusus -->
<style>
.container-fluid { max-width: 95% !important; }
.asesmen-card {
    border: 1px solid #d1d1d1;
    border-radius: 10px;
    background: #fff;
    margin-bottom: 24px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
}
.asesmen-header {
    background: #eaf1ff;
    padding: 10px 16px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    position: relative;
    display: flex;
    align-items: center;
}
.header-line {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 5px;
    background: #2874c9;
    border-top-left-radius: 10px;
    border-bottom-left-radius: 10px;
}
.asesmen-header h5 {
    margin: 0 0 0 12px;
    font-size: 14px;
    font-weight: 600;
    color: #333;
}
.asesmen-body { padding: 16px 20px; }
.panduan-item { display:flex; align-items:flex-start; margin-bottom:10px; }
.panduan-number {
    background:#2874c9; color:#fff; border-radius:50%;
    width:24px; height:24px; text-align:center; line-height:24px;
    margin-right:12px; font-size:12px; font-weight:600;
}
.panduan-text { font-size:13px; line-height:1.6; }
.asesmen-table { font-size:13px; }
.asesmen-table th, .asesmen-table td { vertical-align: middle; }
.asesmen-table th { font-weight:600; font-size:13px; }
</style>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h4 class="mb-4 text-center">FR.AK.03 UMPAN BALIK DAN CATATAN ASESMEN</h4>

    <!-- Form -->
    <form action="{{ route('umpan-balik.store') }}" method="POST" class="simpan-form">
        @csrf

        <!-- Identitas Asesi -->
        <div class="card mb-4">
            <div class="card-header">Identitas Asesi</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Nama Asesi</label>
                    <input type="text" name="nama_asesi" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Skema Sertifikasi</label>
                    <input type="text" name="skema" class="form-control" required>
                </div>
            </div>
        </div>

        <!-- Bagian Pertanyaan -->
        <div class="card mb-4">
            <div class="card-header">Pertanyaan Umpan Balik</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">1. Apakah proses asesmen sudah dijelaskan dengan jelas?</label>
                    <select name="q1" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">2. Apakah Anda diberi kesempatan untuk bertanya?</label>
                    <select name="q2" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">3. Apakah Anda puas dengan proses asesmen?</label>
                    <select name="q3" class="form-select" required>
                        <option value="">-- Pilih --</option>
                        <option value="Ya">Ya</option>
                        <option value="Tidak">Tidak</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Catatan Tambahan -->
        <div class="card mb-4">
            <div class="card-header">Catatan / Komentar</div>
            <div class="card-body">
                <textarea name="catatan" class="form-control" rows="4" placeholder="Tulis catatan atau komentar Anda di sini..."></textarea>
            </div>
        </div>

        <!-- Tombol -->
        <div class="d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">Simpan dan Lanjut</button>
        </div>
    </form>
</div>
@endsection

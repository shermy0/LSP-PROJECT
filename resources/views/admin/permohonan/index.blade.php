@extends('master')

@section('title', 'Daftar Form1 Asesi')

@section('konten')
<div class="container my-5">

    <!-- Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-primary">📋 Daftar Permohonan FR.APL.01</h2>
        <p class="text-muted">Berikut adalah daftar asesi yang telah mengajukan Formulir FR.APL.01</p>
        <hr class="mx-auto" style="width:80px; height:3px; background:#0d6efd; opacity:1; border-radius:4px;">
    </div>

    <!-- Card Table -->
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-4">

            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-primary text-center">
                        <tr>
                            <th>ID Asesi</th>
                            <th>Nama Lengkap</th>
                            <th>NIK</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Terakhir Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($asesi as $a)
                            <tr>
                                <td class="fw-semibold text-center">{{ $a->id_asesi }}</td>
                                <td>{{ $a->nama_lengkap }}</td>
                                <td>{{ $a->nik }}</td>
                                <td>{{ $a->email }}</td>
                                <td>{{ $a->telepon }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->updated_at)->format('d M Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.permohonan.show', $a->id_asesi) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        🔍 Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <span style="font-size:2rem;">📭</span>
                                        <p class="mt-2">Belum ada data Form1</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

{{-- Style tambahan --}}
<style>
    .card {
        transition: transform .2s ease, box-shadow .2s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    table thead th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.9rem;
    }
    table tbody tr:hover {
        background: #f8f9fa;
    }
</style>
@endsection

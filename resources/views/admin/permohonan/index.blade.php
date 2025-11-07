@extends('master')

@section('title', 'Daftar Form Pra Asesmen')

@section('konten')
<div class="container-fluid px-4 py-4">

    {{-- HEADER --}}
    <div class="text-center mb-4">
        <div class="header-icon mx-auto mb-2">
            <i class="bi bi-journal-check"></i>
        </div>
        <h2 class="fw-bold text-dark mb-1">Daftar Form Pra Asesmen</h2>
        <p class="text-muted">Berikut daftar pengajuan FR.APL.01 oleh Asesi</p>
        <div class="line mx-auto"></div>
    </div>

    <!-- Pencarian -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div>
            <p class="fw-semibold mb-1 text-dark">Cari Data Asesi</p>
            <small class="text-muted">Ketik nama, email, atau NIK untuk memfilter tabel</small>
        </div>
        <div class="position-relative">
            <i class="bi bi-search position-absolute" 
               style="top: 10px; left: 12px; color: #6c757d;"></i>
            <input type="text" id="searchInput" class="form-control shadow-sm ps-5"
                   placeholder="Cari asesi..." style="max-width: 280px; border-radius: 10px;">
        </div>
    </div>

    <!-- Box tabel -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle table-hover" id="asesiTable">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
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
                                <td class="text-center fw-semibold">{{ $a->id_asesi }}</td>
                                <td>{{ $a->nama_lengkap }}</td>
                                <td>{{ $a->nik }}</td>
                                <td>{{ $a->email }}</td>
                                <td>{{ $a->telepon ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($a->updated_at)->format('d M Y H:i') }}</td>
                                <td class="text-center">
                                    <a href="{{ route('admin.permohonan.show', $a->id_asesi) }}" 
                                       class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    Belum ada data asesi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ================== STYLE ================== --}}
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8f9fb;
    }

    .header-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: #E9F1FF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
        color: #041562;
    }

    .line {
        width: 70px;
        height: 3px;
        background: #041562;
        border-radius: 2px;
        margin-top: 10px;
    }

    h2 {
        color: #041562;
        font-size: 1.5rem;
    }

    .card {
        background: #fff;
        transition: box-shadow 0.2s ease;
        border-radius: 12px;
    }

    .card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.07);
    }

    table thead {
        background-color: #E9F1FF;
        color: #041562;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, 0.05);
    }

    table tbody tr:hover {
        background: #f6f9ff;
    }

    table td {
        vertical-align: middle;
        font-size: 0.9rem;
        color: #333;
    }

    #searchInput {
        border: 1px solid #ccc;
        padding-left: 36px;
        transition: all .2s ease;
    }

    #searchInput:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }

    .btn-outline-primary {
        font-weight: 500;
        transition: all .2s ease;
    }

    .btn-outline-primary:hover {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
    }
</style>

{{-- ================== SCRIPT PENCARIAN ================== --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('asesiTable');
    const rows = table.querySelectorAll('tbody tr');

    searchInput.addEventListener('keyup', () => {
        const keyword = searchInput.value.toLowerCase();
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(keyword) ? '' : 'none';
        });
    });
});
</script>
@endsection

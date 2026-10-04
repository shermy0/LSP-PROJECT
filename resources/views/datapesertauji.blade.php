@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">Data Peserta Uji</h4>

    {{-- Pencarian peserta --}}
    <form method="GET" action="{{ route('datapesertauji') }}" id="filterForm" class="row g-2 mb-3">
        <div class="col-md-4">
            <input type="text" name="search" id="searchInput" class="form-control" placeholder="Cari nama..."
                value="{{ request('search') }}">
        </div>
    </form>

    {{-- Tabel Data --}}
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peserta as $index => $p)
            <tr>
                <td>{{ $loop->iteration + ($peserta->currentPage()-1)*$peserta->perPage() }}</td>
                <td>{{ $p->nama_lengkap }}</td>
                <td>{{ $p->jurusan->nama_jurusan ?? '-' }}</td>
                <td>
                    <a href="{{ route('peserta.show', $p->id_asesi) }}" class="btn btn-info btn-sm">
                        Detail
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada peserta yang ditugaskan ke akun asesor ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination --}}
    <div>
        {{ $peserta->links() }}
    </div>
</div>

{{-- Script untuk filter realtime --}}
<script>
    const searchInput = document.getElementById('searchInput');
    const filterForm = document.getElementById('filterForm');

    // Realtime search (submit setelah user berhenti ketik 0.5 detik)
    let timer;
    searchInput.addEventListener('keyup', function() {
        clearTimeout(timer);
        timer = setTimeout(() => {
            filterForm.submit();
        }, 500);
    });
</script>
@endsection

@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center">Daftar Rekaman Asesmen</h4>
    <p class="text-center text-muted">
        Skema Sertifikasi: <span class="fw-bold">{{ $skema->nama_skema }}</span>
    </p>

    <div class="text-end mb-3">
        <a href="{{ route('rekaman.create', $skema->id_skema) }}" class="btn btn-primary">
            + Tambah Rekaman Baru
        </a>
    </div>

    @if ($rekamans->isEmpty())
        <div class="alert alert-info text-center">Belum ada rekaman asesmen untuk skema ini.</div>
    @else
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr class="text-center">
                    <th>No</th>
                    <th>Asesi</th>
                    <th>Asesor</th>
                    <th>Hasil</th>
                    <th>Tindak Lanjut</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekamans as $index => $rekaman)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $rekaman->asesi->nama_lengkap ?? '-' }}</td>
<td>{{ $rekaman->asesor->name ?? '-' }}</td>
<td class="text-center">
    <span class="badge 
        bg-{{ $rekaman->hasil === 'K' ? 'success' : 'danger' }}">
        {{ $rekaman->hasil }}
    </span>
</td>

                    <td>{{ $rekaman->tindak_lanjut ?? '-' }}</td>
                    <td class="text-center">
                        <a href="{{ route('rekaman.show', $rekaman->id_rekaman) }}" class="btn btn-sm btn-info">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection

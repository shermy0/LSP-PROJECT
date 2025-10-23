@extends('master')

@section('konten')
<div class="container">
    <h2>Daftar Asesi</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Asesi</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($asesi as $a)
                <tr>
                    <td>{{ $a->nama_lengkap ?? '-' }}</td>
                    <td>{{ $a->email ?? '-' }}</td>
                    <td>
                        <a href="{{ route('asesor.asesmen_mandiri.show', $a->id_asesi) }}" 
                           class="btn btn-primary btn-sm">
                           Lihat
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada data asesi.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

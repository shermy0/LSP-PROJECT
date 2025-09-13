@extends('master')

@section('title', 'Daftar Form1 Asesi')

@section('konten')
<div class="container mt-4">
    <h2 class="mb-4">Daftar Formulir FR.APL.01 (Asesi)</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
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
                    <td>{{ $a->id_asesi }}</td>
                    <td>{{ $a->nama_lengkap }}</td>
                    <td>{{ $a->nik }}</td>
                    <td>{{ $a->email }}</td>
                    <td>{{ $a->telepon }}</td>
                    <td>{{ $a->updated_at }}</td>
                    <td>
                        <a href="{{ route('admin.form1.show', $a->id_asesi) }}" 
                           class="btn btn-sm btn-primary">Lihat</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">Belum ada data Form1</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

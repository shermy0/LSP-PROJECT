@extends('master')

@section('konten')
<div class="container mt-4">
    {{-- Header --}}
    <div class="p-3 mb-4 rounded shadow-sm" style="background-color:#041562; color:white;">
        <h4 class="fw-bold mb-0">
            FR.PMO – Daftar Pertanyaan PMO
            <span class="fw-normal" style="font-size:0.9rem;">
                (PMO: {{ $pmo->nama_pmo ?? 'Tanpa Nama' }})
            </span>
        </h4>
    </div>

    {{-- Pesan sukses/error --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @forelse($pertanyaanList as $id_unit => $list)
        <h6 class="fw-bold mt-3">
            {{ $unitList->firstWhere('id_unit', $id_unit)->judul_unit ?? 'Unit tidak ditemukan' }}
        </h6>

        @foreach($list as $p)
            <div class="card mb-3">
                <div class="card-body">
                    <p>{{ $p->pertanyaan }}</p>
                    @if($p->deskripsi_pertanyaan)
                        <p class="text-muted">{{ $p->deskripsi_pertanyaan }}</p>
                    @endif

                    <div class="d-flex gap-2">
                        <a href="{{ route('pmo.pertanyaan.edit', [$pmo->id_pmo, $p->id_pmo_pertanyaan]) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('pmo.pertanyaan.destroy', [$pmo->id_pmo, $p->id_pmo_pertanyaan]) }}" method="POST" onsubmit="return confirm('Yakin mau hapus pertanyaan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @empty
        <p class="text-muted">Belum ada pertanyaan pada PMO ini.</p>
    @endforelse
</div>
@endsection

@extends('master')

@section('konten')
<div class="container mt-4">
    {{-- Header --}}
    <div class="p-3 mb-4 rounded shadow-sm" style="background-color:#041562; color:white;">
        <h4 class="fw-bold mb-0">
            FR.IA.07 – Daftar Pertanyaan Lisan
            <span class="fw-normal" style="font-size:0.9rem;">
                (Skema: {{ $skema->nama_skema ?? 'Belum ada skema' }})
            </span>
        </h4>
    </div>  

    {{-- Tampilkan pertanyaan kelompok tertentu --}}
    @isset($kelompok)
        <div class="mb-4">
            {{-- Nama kelompok --}}
            <h5 class="fw-bold text-primary">{{ $kelompok->nama_kelompok ?? 'Belum ada nama kelompok' }}</h5>

            {{-- List pertanyaan --}}
            @forelse($kelompok->pertanyaan as $index => $p)
                <div class="card mb-3 shadow-sm">
                <div class="card-body">
                        <h6 class="fw-bold">{{ $index + 1 }}. Pertanyaan:</h6>
                        <p>{{ $p->isi_pertanyaan }}</p>

                        @if($p->kunci_jawaban)
                            <p class="text-success"><strong>Kunci Jawaban:</strong> {{ $p->kunci_jawaban }}</p>
                        @else
                            <p class="text-muted"><em>Belum ada kunci jawaban</em></p>
                        @endif

                        {{-- Tombol Edit & Hapus --}}
                        <div class="d-flex gap-2 mt-3">
                            <a href="{{ route('lisan.edit', $p->id_pertanyaan) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('lisan.destroy', $p->id_pertanyaan) }}" method="POST" onsubmit="return confirm('Yakin mau hapus pertanyaan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Belum ada pertanyaan di kelompok ini.</p>
            @endforelse
        </div>
    @endisset
@endsection
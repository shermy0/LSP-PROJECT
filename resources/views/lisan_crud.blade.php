@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – Daftar Pertanyaan Lisan (Skema: {{ $skema->nama_skema }})</h4>

    @foreach($pertanyaan as $index => $p)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">{{ $index+1 }}. Pertanyaan:</h6>
                <p>{{ $p->isi_pertanyaan }}</p>

                {{-- tampilkan kunci jawaban jika ada --}}
                @if($p->kunci_jawaban)
                    <p class="text-success"><strong>Kunci Jawaban:</strong> {{ $p->kunci_jawaban }}</p>
                @else
                    <p class="text-muted"><em>Belum ada kunci jawaban</em></p>
                @endif

                <div class="d-flex">
                    {{-- Edit --}}
                    <a href="{{ route('lisan.edit', $p->id_pertanyaan) }}" 
                       class="btn btn-sm btn-dark me-2">Edit</a>

                    {{-- Hapus --}}
                    <form action="{{ route('lisan.destroy', $p->id_pertanyaan) }}" 
                          method="POST" 
                          onsubmit="return confirm('Hapus pertanyaan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

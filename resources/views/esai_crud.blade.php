@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – DPL – Daftar Pertanyaan Esai</h4>

    @foreach($pertanyaan as $index => $p)
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h6 class="fw-bold">{{ $index+1 }}. Pertanyaan:</h6>
                <p>{{ $p->isi_pertanyaan }}</p>

                @if($p->file_path)
                    <p><strong>Lampiran:</strong> 
                        <a href="{{ asset('storage/'.$p->file_path) }}" target="_blank">Lihat File</a>
                    </p>

                    {{-- Tampilkan gambar jika file berupa jpg, jpeg, png --}}
                    @if(in_array($p->file_type, ['jpg','jpeg','png']))
                        <img src="{{ asset('storage/'.$p->file_path) }}" alt="Gambar Pertanyaan" class="img-fluid mb-2" style="max-width:200px;">
                    @endif
                @endif

                <p class="text-primary"><strong>Kunci Jawaban:</strong> {{ $p->kunci_jawaban }}</p>

                <div class="d-flex">
                    {{-- Edit --}}
                    <a href="{{ route('pertanyaan.esai.edit', $p->id_pertanyaan) }}" class="btn btn-sm btn-dark me-2">Edit</a>

                    {{-- Hapus --}}
                    <form action="{{ route('pertanyaan.esai.destroy', $p->id_pertanyaan) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?')">
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

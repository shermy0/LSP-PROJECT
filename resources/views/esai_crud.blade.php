@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – DPL – Daftar Pertanyaan Esai</h4>

    @if($pertanyaan->isEmpty())
        <div class="alert alert-warning">Belum ada pertanyaan esai untuk pembuatan ini.</div>
    @else
        @foreach($pertanyaan as $index => $p)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">{{ $index+1 }}. Pertanyaan Esai:</h6>
                    <p>{{ $p->isi_pertanyaan }}</p>

                    @if($p->file_path)
                        <p><strong>Lampiran:</strong>
                            <a href="{{ asset('storage/'.$p->file_path) }}" target="_blank">Lihat File</a>
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    @endif

    {{-- Tombol Tanda Tangan --}}
    @if($pembuatan_pertanyaan)
        <a href="{{ route('tanda.tangan.asesmen', [
    'id_skema' => $skema->id_skema, 
    'id_pembuatan_pertanyaan' => $pembuatan_pertanyaan->id_pembuatan_pertanyaan
]) }}" 
class="btn btn-primary mb-3">
    Tanda Tangan Asesmen
</a>

    @endif

</div>
@endsection

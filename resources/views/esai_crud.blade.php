@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold">FR.IA.07 – DPL – Daftar Pertanyaan Esai</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

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

                    {{-- Tombol Edit & Hapus --}}
                    <div class="d-flex gap-2 mt-2">
                        <a href="{{ route('pertanyaan.esai.edit', $p->id_pertanyaan) }}"
                           class="btn btn-warning btn-sm">
                            <i class="fa fa-edit"></i> Edit
                        </a>

                        <!-- ✅ GANTI JADI INI -->
<!-- ✅ BENAR -->
<form action="{{ route('pertanyaan.esai.delete', $p->id_pertanyaan) }}"
      method="POST"
      onsubmit="return confirm('Yakin ingin menghapus?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="fa fa-trash"></i> Hapus
    </button>
</form>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
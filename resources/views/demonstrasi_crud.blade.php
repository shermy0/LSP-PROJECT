@extends('master')

@section('konten')
<div class="container mt-4">
    {{-- Header --}}
    <div class="p-3 mb-4 rounded shadow-sm" style="background-color:#041562; color:white;">
        <h4 class="fw-bold mb-0">
            FR.IA.06 – Daftar Tugas Praktik Demonstrasi
            <span class="fw-normal" style="font-size:0.9rem;">
                (Skema: {{ $skema->nama_skema ?? 'Belum ada skema' }})
            </span>
        </h4>
    </div>

    {{-- List Tugas Demonstrasi --}}
    <div class="mb-4">
        <h5 class="fw-bold text-primary">Kelompok Pekerjaan ID: {{ $id_kelompok }}</h5>

        @forelse($tugas as $index => $t)
            <div class="card mb-3 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-bold">{{ $index + 1 }}. Pertanyaan Demonstrasi</h6>
                    <p>{{ $t->isi_pertanyaan_demonstrasi }}</p>

                    @if($t->deskripsi_pertanyaan)
                        <p class="text-muted"><strong>Deskripsi:</strong> {{ $t->deskripsi_pertanyaan }}</p>
                    @endif

                    @if($t->kunci_jawaban)
                        <p class="text-success"><strong>Kunci Jawaban:</strong> {{ $t->kunci_jawaban }}</p>
                    @else
                        <p class="text-muted"><em>Belum ada kunci jawaban</em></p>
                    @endif

                    @if($t->file_path)
                        <p><strong>Lampiran:</strong> 
                            <a href="{{ asset('storage/'.$t->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                Lihat File
                            </a>
                        </p>
                    @endif

                    <p><strong>Jenis Pertanyaan:</strong> {{ $t->file_type ?? 'Teks' }}</p>

                    {{-- Tombol Edit & Hapus --}}
                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('demonstrasi.edit', $t->id_tugas) }}" class="btn btn-sm btn-warning">Edit</a>

<form action="{{ route('demonstrasi.destroy', $t->id_tugas) }}" method="POST" onsubmit="return confirm('Yakin mau hapus tugas ini?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
</form>

                        
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada tugas demonstrasi pada kelompok ini.</p>
        @endforelse
    </div>

    {{-- Tombol Tambah Tugas Baru --}}
    <div class="text-center mt-4">
        <a href="{{ route('demonstrasi.createTugas', [
                'id_skema' => $skema->id_skema, 
                'kelompok_id' => $id_kelompok
            ]) }}" 
           class="btn btn-primary fw-bold">
            + Tambah Tugas Baru
        </a>
    </div>
</div>
@endsection

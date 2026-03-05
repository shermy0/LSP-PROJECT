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

    @php $no = 1; @endphp

    @forelse($pertanyaanList as $pertanyaan => $list)
        @php
            // Ambil satu record utama
            $p = $list->first();

            // Gabungkan semua unit yang terkait dengan pertanyaan ini
            $namaUnit = $list->map(function ($item) use ($unitList) {
                $unit = $unitList->firstWhere('id_unit', $item->id_unit);
                return $unit ? $unit->judul_unit : 'Unit tidak ditemukan';
            })->implode(', ');
        @endphp

        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-body">
                <p class="mb-1">
                    <strong>{{ $no++ }}. Pertanyaan:</strong> {{ $p->pertanyaan }}
                </p>

                @if($p->deskripsi_pertanyaan)
                    <p class="text-success mb-1"><strong>Deskripsi:</strong> {{ $p->deskripsi_pertanyaan }}</p>
                @endif

                <p class="text-primary mb-2"><strong>Unit:</strong> {{ $namaUnit }}</p>

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
    @empty
        <p class="text-muted">Belum ada pertanyaan pada PMO ini.</p>
    @endforelse
</div>

<a href="{{ route('pertanyaan.pmo.kelompok', ['id_skema' => $pmo->id_skema]) }}" 
   class="btn btn-secondary fw-bold" 
   style="position: fixed; bottom: 20px; right: 20px; z-index: 999;">
   &laquo; Kembali ke Kelompok Pekerjaan
</a>
@endsection

@extends('master')

@section('konten')
<div class="container mt-4 mb-5">
    <!-- Header Section -->
    <div class="header-section mb-4">
        <h2 class="fw-bold mb-3">
            <i class="fas fa-clipboard-check text-primary"></i> Detail Jawaban
        </h2>
        <div class="filter-badge d-inline-flex align-items-center gap-2 p-3 bg-light rounded-3 shadow-sm">
            <span class="text-muted">Filter:</span>
            <span class="badge bg-primary fs-6">{{ $skema }}</span>
            <span class="badge bg-info fs-6 text-capitalize">
                {{ str_replace('_', ' ', $jenis) }}
            </span>
        </div>
    </div>

    <!-- Cards Container -->
    <div class="cards-container">
        @forelse($dataPeserta as $index => $peserta)
            <div class="answer-card shadow-sm mb-4">
                <!-- Card Header -->
                <div class="card-header-custom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="question-number">{{ $index + 1 }}</div>
                        <h5 class="mb-0 fw-semibold">Pertanyaan {{ $index + 1 }}</h5>
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="status-badge">
                        @if(is_null($peserta->pencapaian))
                            <span class="badge-custom badge-secondary">
                                <i class="fas fa-clock"></i> Belum dinilai
                            </span>
                        @elseif($peserta->pencapaian == 1)
                            <span class="badge-custom badge-success">
                                <i class="fas fa-check-circle"></i> Benar
                            </span>
                        @elseif($peserta->pencapaian == 0)
                            <span class="badge-custom badge-danger">
                                <i class="fas fa-times-circle"></i> Salah
                            </span>
                        @else
                            <span class="badge-custom badge-info">{{ $peserta->pencapaian }}</span>
                        @endif
                    </div>
                </div>

                <!-- Card Body -->
                <div class="card-body-custom">
                    <!-- Question Section -->
                    <div class="question-section mb-4">
                        <h6 class="section-title">
                            <i class="fas fa-question-circle text-primary"></i> Pertanyaan
                        </h6>
                        <div class="question-content">
                            {{ $peserta->isi_pertanyaan }}
                        </div>
                        
                        @if($peserta->file_path && Str::contains(strtolower($peserta->file_type), ['png','jpg','jpeg','gif','webp','image/']))
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $peserta->file_path) }}" 
                                     alt="Gambar pertanyaan" 
                                     class="img-content"
                                     oncontextmenu="return false;">
                            </div>
                        @endif
                    </div>

                    <!-- Answer Section -->
                    <div class="answer-section">
                        <h6 class="section-title">
                            <i class="fas fa-edit text-success"></i> Jawaban
                        </h6>
                        
                        @if($jenis === 'pilihan_ganda')
                            <!-- Multiple Choice Options -->
                            <div class="options-grid">
                                @foreach($peserta->semua_opsi as $opsi)
                                    <div class="option-card 
                                        {{ $opsi->id_opsi == $peserta->jawaban_opsi_id ? 'selected' : '' }}
                                        {{ $opsi->benar ? 'correct' : '' }}">
                                        
                                        <div class="option-header">
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="option-letter">{{ $opsi->kode_opsi }}</div>
                                                <div class="option-badges">
                                                    @if($opsi->id_opsi == $peserta->jawaban_opsi_id)
                                                        <span class="mini-badge badge-selected">
                                                            <i class="fas fa-check"></i> Dipilih
                                                        </span>
                                                    @endif
                                                    @if($opsi->benar)
                                                        <span class="mini-badge badge-correct">
                                                            <i class="fas fa-star"></i> Jawaban Benar
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="option-content">
                                            @if(Str::contains(strtolower($opsi->isi_opsi), ['.jpg','.jpeg','.png','.gif','.webp','storage/','uploads/']))
                                                @php
                                                    $opsiFilePath = $opsi->isi_opsi;
                                                    if (!Str::startsWith($opsiFilePath, ['http://','https://'])) {
                                                        $opsiFilePath = asset('storage/' . $opsi->isi_opsi);
                                                    }
                                                @endphp
                                                <img src="{{ $opsiFilePath }}" 
                                                     alt="Gambar opsi {{ $opsi->kode_opsi }}" 
                                                     class="img-option"
                                                     oncontextmenu="return false;">
                                            @else
                                                {{ $opsi->isi_opsi }}
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                        @elseif($peserta->jawaban_text)
                            <div class="answer-content">
                                @if(Str::contains(strtolower($peserta->jawaban_text), ['.jpg','.jpeg','.png','.gif','.webp','storage/','uploads/']))
                                    @php
                                        $jawabanFilePath = $peserta->jawaban_text;
                                        if (!Str::startsWith($jawabanFilePath, ['http://','https://'])) {
                                            $jawabanFilePath = asset('storage/' . $peserta->jawaban_text);
                                        }
                                    @endphp
                                    <img src="{{ $jawabanFilePath }}" 
                                         alt="Gambar jawaban" 
                                         class="img-content"
                                         oncontextmenu="return false;">
                                @else
                                    <div class="text-answer">{{ $peserta->jawaban_text }}</div>
                                @endif
                            </div>
                        
                        @elseif($peserta->isi_opsi)
                            <div class="answer-content">
                                @if(Str::contains(strtolower($peserta->isi_opsi), ['.jpg','.jpeg','.png','.gif','.webp','storage/','uploads/']))
                                    @php
                                        $filePath = $peserta->isi_opsi;
                                        if (!Str::startsWith($filePath, ['http://','https://'])) {
                                            $filePath = asset('storage/' . $peserta->isi_opsi);
                                        }
                                    @endphp
                                    <img src="{{ $filePath }}" 
                                         alt="Gambar jawaban" 
                                         class="img-content"
                                         oncontextmenu="return false;">
                                @else
                                    <div class="text-answer">{{ $peserta->isi_opsi }}</div>
                                @endif
                            </div>
                        
                        @else
                            <div class="no-answer">
                                <i class="fas fa-minus-circle"></i> Tidak ada jawaban
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-inbox"></i>
                </div>
                <h5 class="mt-3">Belum Ada Data Jawaban</h5>
                <p class="text-muted">Data jawaban peserta akan muncul di sini</p>
            </div>
        @endforelse
    </div>

    <!-- Back Button -->
    <div class="text-start mt-4">
        <a href="{{ route('data.peserta.uji') }}" class="btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
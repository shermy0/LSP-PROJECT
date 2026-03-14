@extends('master')

@section('konten')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');

    :root {
        --primary: #041562;
        --primary-light: #0a2a9e;
        --primary-glow: rgba(4, 21, 98, 0.10);
        --accent-gold: #e8b84b;
        --text-main: #0d1b4b;
        --text-muted: #6b7fb5;
    }

    body, .container {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .jawaban-wrapper {
        min-height: 100vh;
        background: linear-gradient(160deg, #eef2ff 0%, #f8faff 50%, #e8eeff 100%);
        padding: 3.5rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .jawaban-wrapper::before {
        content: '';
        position: absolute;
        top: -140px; right: -140px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(4,21,98,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        border: 2px solid var(--primary);
        color: var(--primary);
        background: transparent;
        font-weight: 600;
        font-size: 0.88rem;
        text-decoration: none;
        transition: all 0.25s ease;
    }

    .btn-back:hover {
        background: var(--primary);
        color: #fff;
        transform: translateX(-3px);
    }

    .page-header { margin-bottom: 2rem; }

    .header-badge {
        display: inline-block;
        background: var(--primary-glow);
        color: var(--primary);
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 0.75rem;
        border: 1px solid rgba(4,21,98,0.18);
    }

    .page-header h2 {
        font-size: 1.7rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.25rem;
        line-height: 1.25;
    }

    .page-header p {
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0;
    }

    .header-divider {
        width: 50px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent-gold));
        border-radius: 4px;
        margin-top: 1rem;
    }

    .main-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 24px rgba(4,21,98,0.07);
        overflow: hidden;
        animation: fadeUp 0.45s ease both;
    }

    .main-card-header {
        background: var(--primary);
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .main-card-header .header-icon {
        width: 42px;
        height: 42px;
        background: rgba(255,255,255,0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        color: #fff;
        flex-shrink: 0;
    }

    .main-card-header h5 {
        color: #fff;
        font-weight: 700;
        font-size: 1rem;
        margin: 0 0 2px;
    }

    .main-card-header span {
        color: rgba(255,255,255,0.6);
        font-size: 0.78rem;
    }

    .main-card-body { padding: 2rem 1.75rem; }

    /* Question Block */
    .question-block {
        background: #fff;
        border: 1.5px solid rgba(4,21,98,0.08);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.25rem;
        transition: box-shadow 0.2s ease;
        animation: fadeUp 0.4s ease both;
    }

    .question-block:hover {
        box-shadow: 0 6px 24px rgba(4,21,98,0.08);
    }

    .question-text {
        font-weight: 700;
        color: var(--text-main);
        font-size: 0.95rem;
        line-height: 1.5;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 1.1rem;
    }

    .question-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        background: var(--primary);
        color: #fff;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    .question-img {
        border-radius: 10px;
        max-height: 200px;
        margin-bottom: 1rem;
        border: 1px solid rgba(4,21,98,0.1);
        display: block;
    }

    .section-label {
        font-size: 0.72rem;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.8px;
        margin-bottom: 8px;
    }

    /* Options */
    .options-list {
        display: flex;
        flex-direction: column;
        gap: 8px;
        margin-bottom: 1rem;
    }

    .option-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1.5px solid rgba(4,21,98,0.08);
        background: #f8faff;
        font-size: 0.88rem;
        color: var(--text-main);
        font-weight: 500;
        transition: background 0.2s;
    }

    .option-item.is-correct {
        background: rgba(22,163,74,0.07);
        border-color: rgba(22,163,74,0.3);
        color: #15803d;
        font-weight: 700;
    }

    .option-item.is-selected:not(.is-correct) {
        background: rgba(4,21,98,0.07);
        border-color: rgba(4,21,98,0.25);
    }

    .option-dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid rgba(4,21,98,0.25);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        align-self: center;  /* ← tambah ini, hapus margin-top */
    }

    .option-dot.checked {
        background: var(--primary);
        border-color: var(--primary);
    }

    .option-dot.checked::after {
        content: '';
        width: 8px;
        height: 8px;
        background: #fff;
        border-radius: 50%;
    }

    .correct-dot {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #15803d;
        border: 2px solid #15803d;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        align-self: center;  /* ← tambah ini, hapus margin-top */
    }

    .correct-dot::after {
        content: '';
        width: 8px;
        height: 8px;
        background: #fff;
        border-radius: 50%;
    }

    .option-content { flex: 1; }

    .option-img {
        margin-top: 8px;
        max-height: 100px;
        border-radius: 8px;
        border: 1px solid rgba(4,21,98,0.1);
        display: block;
    }

    /* Result badges */
    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 13px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        margin-top: 8px;
    }

    .result-benar {
        background: rgba(22,163,74,0.1);
        color: #15803d;
        border: 1px solid rgba(22,163,74,0.25);
    }

    .result-salah {
        background: rgba(220,38,38,0.08);
        color: #b91c1c;
        border: 1px solid rgba(220,38,38,0.2);
    }

    .result-belum {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        color: var(--text-muted);
        font-size: 0.82rem;
        font-style: italic;
        margin-top: 6px;
    }

    /* Kunci box */
    .kunci-box {
        display: inline-flex;
        align-items: flex-start;
        gap: 8px;
        margin-top: 12px;
        padding: 8px 14px;
        background: var(--primary-glow);
        border: 1px solid rgba(4,21,98,0.15);
        border-radius: 10px;
        font-size: 0.82rem;
        max-width: 100%;
    }

    .kunci-label {
        color: var(--text-muted);
        font-weight: 600;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .kunci-value {
        color: var(--primary);
        font-weight: 800;
    }

    /* Esai / Lisan */
    .jawaban-text-box {
        background: #f5f7ff;
        border: 1.5px solid rgba(4,21,98,0.1);
        border-radius: 10px;
        padding: 14px 16px;
        font-size: 0.88rem;
        color: var(--text-main);
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .jawaban-text-box.belum {
        color: var(--text-muted);
        font-style: italic;
    }

    /* Pencapaian toggle */
    .pencapaian-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 12px;
    }

    .pencapaian-label {
        font-weight: 700;
        color: var(--text-main);
        font-size: 0.88rem;
    }

    .pencapaian-option { display: none; }

    .pencapaian-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 18px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.2s ease;
        user-select: none;
    }

    .pencapaian-btn.ya {
        background: rgba(22,163,74,0.08);
        color: #15803d;
        border-color: rgba(22,163,74,0.25);
    }

    .pencapaian-btn.tidak {
        background: rgba(220,38,38,0.07);
        color: #b91c1c;
        border-color: rgba(220,38,38,0.2);
    }

    .pencapaian-option:checked + .pencapaian-btn.ya {
        background: #15803d;
        color: #fff;
        border-color: #15803d;
        box-shadow: 0 3px 10px rgba(22,163,74,0.3);
    }

    .pencapaian-option:checked + .pencapaian-btn.tidak {
        background: #b91c1c;
        color: #fff;
        border-color: #b91c1c;
        box-shadow: 0 3px 10px rgba(220,38,38,0.25);
    }

    .pencapaian-disabled {
        opacity: 0.35;
        cursor: default;
        pointer-events: none;
    }

    /* Save Button */
    .btn-save {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 28px;
        border-radius: 12px;
        background: var(--primary);
        color: #fff;
        font-weight: 700;
        font-size: 0.92rem;
        border: none;
        box-shadow: 0 4px 18px rgba(4,21,98,0.25);
        cursor: pointer;
        transition: all 0.25s ease;
    }

    .btn-save:hover {
        background: var(--primary-light);
        box-shadow: 0 6px 24px rgba(4,21,98,0.35);
        transform: translateY(-2px);
    }

    .section-card {
        background: #fff;
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 24px rgba(4,21,98,0.07);
        overflow: hidden;
        margin-bottom: 1.5rem;
        animation: fadeUp 0.45s ease both;
    }
    .section-card-header {
        background: var(--primary);
        padding: 1.1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .section-card-header .hicon {
        width: 38px; height: 38px;
        background: rgba(255,255,255,0.15);
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
        color: #fff;
    }
    .section-card-header h6 {
        color: #fff; font-weight: 700; font-size: 0.92rem; margin: 0;
    }
    .section-card-body { padding: 1.5rem; }
    .field-label {
        font-size: 0.72rem; font-weight: 700; color: var(--text-muted);
        text-transform: uppercase; letter-spacing: 0.8px; margin-bottom: 6px; display: block;
    }
    .textarea-custom {
        width: 100%; padding: 12px 14px; border-radius: 10px;
        border: 1.5px solid rgba(4,21,98,0.12); font-size: 0.88rem;
        background: #f8faff; resize: vertical;
    }
    .btn-clear-sig {
        display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px;
        border-radius: 8px; border: 1.5px solid rgba(217,119,6,0.4);
        background: rgba(217,119,6,0.07); color: #b45309; font-size: 0.8rem; font-weight: 700;
        cursor: pointer; transition: all 0.2s ease; margin-top: 10px;
    }
    .btn-clear-sig:hover {
        background: rgba(217,119,6,0.15); border-color: rgba(217,119,6,0.6);
    }
    #signature-pad {
        border: 2px dashed rgba(4,21,98,0.2); border-radius: 12px;
        background: #fff; cursor: crosshair; max-width: 100%;
    }
    .section-divider {
        border: none; border-top: 2px dashed rgba(4,21,98,0.15); margin: 2rem 0;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(22px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    
</style>

    <div class="container">
        <div class="mb-4">
            <a href="{{ route('asesor.skema.jenis.asesi', [$id_skema, $jenis]) }}" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <center>
        <div class="page-header">
            <span class="header-badge">Penilaian Jawaban</span>
            <h2>{{ $asesi->nama_lengkap }}</h2>
            <p>{{ ucwords(str_replace('_',' ',$jenisDb)) }} — review jawaban asesi di bawah ini.</p>
            <div class="header-divider"></div>
        </div>
        </center>

        <div class="main-card">
            <div class="main-card-header">
                <div class="header-icon">
                    <i class="bi bi-journal-text"></i>
                </div>
                <div>
                <h5>Jawaban {{ ucwords(str_replace('_', ' ', $jenisDb)) }}</h5>               
                <span>{{ count($pertanyaan) }} pertanyaan</span>
                </div>
            </div>

            <div class="main-card-body">
                <form action="{{ route('asesor.pencapaian.store') }}" method="POST" id="form-penilaian">
                    @csrf

                    <input type="hidden" name="id_skema" value="{{ $id_skema }}">
                    <input type="hidden" name="id_asesi" value="{{ $asesi->id_asesi }}">
                    <input type="hidden" name="jenis" value="{{ $jenis }}">

                    @foreach($pertanyaan as $q)
                        @php $jawaban = $jawabanRaw[$q->id_pertanyaan] ?? null; @endphp

                        <div class="question-block" style="animation-delay: {{ $loop->index * 0.06 }}s">

                            <div class="question-text">
                                <span class="question-number">{{ $loop->iteration }}</span>
                                <span>{{ $q->isi_pertanyaan }}</span>
                            </div>

                            {{-- Gambar soal --}}
                            @if(!empty($q->file_path))
                                <img src="{{ asset('storage/' . $q->file_path) }}" class="question-img img-fluid">
                            @endif

                            {{-- ====================================================== PILIHAN GANDA ====================================================== --}}
                            @if($jenisDb === 'pilihan_ganda')

                                <div class="options-list">
                                    @foreach($q->opsiJawaban as $opsi)
                                        @php
                                            $isCorrect  = (bool) $opsi->benar;
                                            $isSelected = $jawaban
                                                          && !empty($jawaban->jawaban_opsi)
                                                          && (int) $jawaban->jawaban_opsi === (int) $opsi->id_opsi;
                                        @endphp

                                        <div class="option-item {{ $isCorrect ? 'is-correct' : '' }} {{ $isSelected ? 'is-selected' : '' }}">

                                            @if($isCorrect)
                                                <div class="correct-dot"></div>
                                            @else
                                                <div class="option-dot {{ $isSelected ? 'checked' : '' }}"></div>
                                            @endif

                                            <div class="option-content">
                                                <span>{{ $opsi->kode_opsi }}.</span>
                                                
                                                @php
                                                    $isImage = !empty($opsi->isi_opsi) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $opsi->isi_opsi);
                                                @endphp

                                                @if($isImage)
                                                    <img src="{{ asset('storage/' . $opsi->isi_opsi) }}" 
                                                        class="option-img"
                                                        style="max-height:120px; border-radius:8px; border:1px solid rgba(4,21,98,0.1); display:block; margin-top:6px;">
                                                @else
                                                    <span>{{ $opsi->isi_opsi }}</span>
                                                @endif
                                            </div>

                                            @if($isCorrect)
                                                <i class="bi bi-check-circle-fill" style="color:#15803d; flex-shrink:0; margin-top:2px;"></i>
                                            @endif

                                        </div>
                                    @endforeach
                                </div>

                                {{-- Status benar / salah / belum --}}
                                @if($jawaban && !empty($jawaban->jawaban_opsi))
                                    @php
                                        $opsiDipilih  = $q->opsiJawaban->firstWhere('id_opsi', (int) $jawaban->jawaban_opsi);
                                        $jawabanBenar = $opsiDipilih && $opsiDipilih->benar;
                                    @endphp
                                    @if($jawabanBenar)
                                        <span class="result-badge result-benar"><i class="bi bi-check-circle-fill"></i> Benar</span>
                                    @else
                                        <span class="result-badge result-salah"><i class="bi bi-x-circle-fill"></i> Salah</span>
                                    @endif
                                @else
                                    <span class="result-belum"><i class="bi bi-dash-circle"></i> Belum dijawab</span>
                                @endif

                                {{-- Kunci jawaban --}}
                                @php 
                                    $kunciOpsi = $q->opsiJawaban->first(fn($o) => (bool) $o->benar === true);
                                    $kunciIsImage = $kunciOpsi && !empty($kunciOpsi->isi_opsi) && preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $kunciOpsi->isi_opsi);
                                @endphp
                                <div>
                                    <span class="kunci-box">
                                        <span class="kunci-label">Kunci:</span>
                                        <span class="kunci-value">
                                            @if($kunciOpsi)
                                                {{ $kunciOpsi->kode_opsi }}.
                                                @if($kunciIsImage)
                                                    <img src="{{ asset('storage/' . $kunciOpsi->isi_opsi) }}"
                                                        style="max-height:80px; border-radius:8px; border:1px solid rgba(4,21,98,0.1); display:block; margin-top:6px;">
                                                @else
                                                    {{ $kunciOpsi->isi_opsi }}
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </span>
                                </div>

                            {{-- ====================================================== ESAI & LISAN ====================================================== --}}
                            @else

                                <div class="section-label">Jawaban Asesi</div>

                                @if($jawaban && !empty($jawaban->jawaban_text))

                                    <div class="jawaban-text-box">
                                        {!! nl2br(e($jawaban->jawaban_text)) !!}
                                    </div>

                                    <div class="pencapaian-wrap">
                                        <span class="pencapaian-label">Pencapaian:</span>

                                        <input class="pencapaian-option"
                                               type="radio"
                                               id="ya_{{ $jawaban->id_jawaban }}"
                                               name="pencapaian[{{ $jawaban->id_jawaban }}]"
                                               value="1"
                                               {{ $jawaban->pencapaian == 1 ? 'checked' : '' }}>
                                        <label class="pencapaian-btn ya" for="ya_{{ $jawaban->id_jawaban }}">
                                            <i class="bi bi-check-lg"></i> Ya
                                        </label>

                                        <input class="pencapaian-option"
                                               type="radio"
                                               id="tidak_{{ $jawaban->id_jawaban }}"
                                               name="pencapaian[{{ $jawaban->id_jawaban }}]"
                                               value="0"
                                               {{ (string)$jawaban->pencapaian === '0' ? 'checked' : '' }}>
                                        <label class="pencapaian-btn tidak" for="tidak_{{ $jawaban->id_jawaban }}">
                                            <i class="bi bi-x-lg"></i> Tidak
                                        </label>
                                    </div>

                                @else

                                    {{-- Belum dijawab — kirim otomatis 0 --}}
                                    @if($jawaban)
                                        <input type="hidden" name="pencapaian[{{ $jawaban->id_jawaban }}]" value="0">
                                    @endif

                                    <div class="jawaban-text-box belum">Belum dijawab</div>

                                    <div class="pencapaian-wrap">
                                        <span class="pencapaian-label">Pencapaian:</span>
                                        <span class="pencapaian-btn ya pencapaian-disabled"><i class="bi bi-check-lg"></i> Ya</span>
                                        <span class="pencapaian-btn tidak" style="background:#b91c1c;color:#fff;border-color:#b91c1c;font-weight:700;">
                                            <i class="bi bi-x-lg"></i> Tidak
                                        </span>                                    
                                    </div>

                                @endif

                                {{-- Kunci jawaban --}}
                                @if(!empty($q->kunci_jawaban))
                                    <div>
                                        <span class="kunci-box">
                                            <span class="kunci-label">Kunci:</span>
                                            <span class="kunci-value">{{ $q->kunci_jawaban }}</span>
                                        </span>
                                    </div>
                                @endif

                            @endif

                        </div>
                    @endforeach
                </div>

                     @php
                    $umpanBalik = $persetujuan->umpan_balik ?? '';
                    $ttdAsesor = $persetujuan->ttd_asesor ?? null;
                    @endphp

                        {{-- Card Umpan Balik --}}
                        <div class="main-card">
                            <div class="main-card-header">
                                <div class="header-icon">
                                    <i class="bi bi-chat-dots"></i>
                                </div>
                                <h5>Umpan Balik</h5>
                            </div>
                            <div class="main-card-body">
                            <textarea name="umpan_balik" class="textarea-custom" rows="4" placeholder="Tuliskan umpan balik untuk asesi...">{{ $umpanBalik }}</textarea>                            </div>
                        </div>
                        <h5>&nbsp;</h5>
                        {{-- Card Tanda Tangan --}}
                        <div class="main-card">
                            <div class="main-card-header">
                                <div class="header-icon">
                                    <i class="bi bi-pen"></i>
                                </div>
                                <h5>Tanda Tangan</h5>
                            </div>
                            <div class="main-card-body signature-container">

                            <center>

                                {{-- tampilkan tanda tangan lama --}}
                                @if(!empty($ttdAsesor))
                                        <div id="ttd-view">
                                        <img src="{{ asset('storage/'.$ttdAsesor) }}" width="260" class="mb-3" style="border:1px solid #ddd;border-radius:8px;">
                                        <br>
                                        <button type="button" class="btn-clear-sig" id="btn-edit-ttd">
                                            <i class="bi bi-pen-fill"></i> Tanda Tangan Ulang
                                        </button>
                                    </div>
                                @endif

                                {{-- canvas untuk tanda tangan --}}
                                <div id="ttd-canvas-area" style="{{ !empty($ttdAsesor) ? 'display:none' : '' }}">                                    <canvas id="signature-pad" width="500" height="180"></canvas>
                                    <br>
                                    <button type="button" class="btn-clear-sig" id="clear-signature">
                                        <i class="bi bi-eraser-fill"></i> Hapus
                                    </button>
                                    {{-- tombol batal hanya muncul jika sudah pernah ttd --}}
                                    @if(!empty($persetujuan->ttd_asesor))
                                        <button type="button" class="btn-clear-sig" id="btn-batal-ttd">
                                            <i class="bi bi-arrow-left"></i> Batal
                                        </button>
                                    @endif
                                </div>

                            </center>

                            <input type="hidden" name="ttd_asesor" id="ttd_asesor">

                            </div>
                        </div>

                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn-save">
                                <i class="bi bi-floppy2-fill"></i> Simpan Penilaian
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
<script>
document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('signature-pad');
    const clearBtn = document.getElementById('clear-signature');
    const form = document.getElementById('form-penilaian');
    const ttdInput = document.getElementById('ttd_asesor');

    const btnEdit = document.getElementById('btn-edit-ttd');
    const btnBatal = document.getElementById('btn-batal-ttd');
    const viewArea = document.getElementById('ttd-view');
    const canvasArea = document.getElementById('ttd-canvas-area');

    // cek apakah sudah ada ttd lama
    const ttdLama = {!! !empty($ttdAsesor) ? 'true' : 'false' !!};
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let drawing = false;

    // =============================
    // DRAW SIGNATURE
    // =============================

    canvas.addEventListener('mousedown', (e) => {
        drawing = true;
        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mousemove', (e) => {
        if (!drawing) return;

        ctx.lineWidth = 2;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();

        ctx.beginPath();
        ctx.moveTo(e.offsetX, e.offsetY);
    });

    canvas.addEventListener('mouseup', () => drawing = false);
    canvas.addEventListener('mouseleave', () => drawing = false);

    // =============================
    // CLEAR SIGNATURE
    // =============================

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
        });
    }

    // =============================
    // EDIT SIGNATURE
    // =============================

    if (btnEdit) {
        btnEdit.addEventListener('click', function () {
            viewArea.style.display = "none";
            canvasArea.style.display = "block";
        });
    }

    // =============================
    // CANCEL EDIT SIGNATURE
    // =============================

    if (btnBatal) {
        btnBatal.addEventListener('click', function () {

            canvasArea.style.display = "none";
            viewArea.style.display = "block";

            ctx.clearRect(0, 0, canvas.width, canvas.height);

        });
    }

    // =============================
    // FORM SUBMIT
    // =============================

    form.addEventListener('submit', function (e) {

        const blank = document.createElement('canvas');
        blank.width = canvas.width;
        blank.height = canvas.height;

        const isCanvasEmpty = canvas.toDataURL() === blank.toDataURL();

        // jika belum ada ttd lama dan canvas kosong
        if (!ttdLama && isCanvasEmpty) {

            Swal.fire({
                icon: 'warning',
                title: 'Tanda Tangan Belum Diisi',
                text: 'Silakan isi tanda tangan terlebih dahulu sebelum menyimpan.',
                confirmButtonColor: '#041562'
            });

            e.preventDefault();
            return;
        }

        // jika ada gambar baru dari canvas
        if (!isCanvasEmpty) {
            ttdInput.value = canvas.toDataURL('image/png');
        }

    });

});
</script>
@endsection
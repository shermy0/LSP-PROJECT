@extends('master')

@section('konten')
<div class="container mt-4">

    {{-- ===== HEADER ===== --}}
    <div class="border rounded p-3 bg-light mb-4">
        <div class="text-center mb-4">
            <div class="mapa-logo"></div>
            <h3 class="fw-bold">FR.IA.05.C. LEMBAR JAWABAN PILIHAN GANDA</h3>
            <p class="text-muted">Proses Asesmen</p>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="fw-semibold d-block mb-2">Nama Lengkap</label>
                <input type="text" class="form-control form-control-lg rounded-3"
                       value="{{ $asesi->nama_lengkap ?? '-' }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="fw-semibold d-block mb-2">Tanggal</label>
                <input type="text" class="form-control form-control-lg rounded-3"
                       value="{{ date('d-m-Y') }}" readonly>
            </div>
        </div>

        <div class="row g-3 mt-2">
            <div class="col-md-6">
                <label class="fw-semibold d-block mb-2">Judul Skema</label>
                <input type="text" class="form-control form-control-lg rounded-3"
                       value="{{ $skema->nama_skema ?? '-' }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="fw-semibold d-block mb-2">Kode Skema</label>
                <input type="text" class="form-control form-control-lg rounded-3"
                       value="{{ $skema->kode_skema ?? '-' }}" readonly>
            </div>
        </div>
    </div>

    {{-- ===== TIMER ===== --}}
    @if($timer > 0)
        <div class="alert alert-info text-center">
            Waktu Tersisa: <span id="countdown" class="fw-bold"></span>
        </div>
    @else
        <div class="alert alert-danger text-center">
            Waktu sudah habis. Jawaban akan otomatis tersimpan.
        </div>
    @endif

    {{-- ===== PESAN ===== --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ===== SOAL ===== --}}
    @if(isset($pertanyaan) && $pertanyaan->count() > 0)
        <form id="jawabanForm" action="{{ route('jawaban.store') }}" method="POST" onsubmit="return validateForm(event)">
            @csrf
            <input type="hidden" name="id_skema" value="{{ $id_skema }}">
            <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $id_pembuatan_pertanyaan }}">
            <input type="hidden" name="jenis" value="pilihan_ganda">
            <input type="hidden" name="ttd_asesi" id="ttd_asesi_data">
            <input type="hidden" name="tgl_ttd_asesi" id="tgl_ttd_asesi_data">

            {{-- Navigasi Nomor Soal --}}
            <div class="mb-3 bg-white py-2 navigasi-wrapper border rounded" id="soal-navigation-container">
                <div class="d-flex flex-wrap justify-content-center" id="soal-navigation" style="gap:5px;">
                    @foreach($pertanyaan as $index => $p)
                        <button type="button"
                            class="btn btn-outline-primary btn-sm soal-nav mb-1 mx-1"
                            data-index="{{ $index }}">
                            {{ $index+1 }}
                        </button>
                        @if(($index+1) % 10 == 0)
                            <div style="flex-basis: 100%; height: 0;"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            {{-- Container Soal --}}
            <div class="border rounded p-3 bg-light soal-wrapper">
                <div class="main-header">Pertanyaan</div>

                @foreach($pertanyaan as $index => $p)
                    @php
                        $jawabanUser = $jawaban[$p->id_pertanyaan] ?? null;
                    @endphp

                    <div class="soal-item" data-index="{{ $index }}" style="{{ $index == 0 ? '' : 'display:none;' }}">
                        <div class="soal-content mb-3">
                            <label class="fw-bold soal-number">{{ $index+1 }}.</label>
                            <label class="soal-text">{!! nl2br(e($p->isi_pertanyaan)) !!}</label>

                            {{-- Gambar pertanyaan --}}
                            @if($p->file_path && in_array(strtolower(pathinfo($p->file_path, PATHINFO_EXTENSION)), ['jpg','jpeg','png']))
                                <div class="mt-2 text-center">
                                    <img src="{{ asset('storage/'.$p->file_path) }}" 
                                         alt="Gambar Pertanyaan" 
                                         class="img-fluid rounded border" 
                                         style="max-height:250px;">
                                </div>
                            @endif
                        </div>

                        {{-- Opsi Jawaban --}}
                        @foreach($p->opsiJawaban as $opsi)
                            <div class="form-check mt-2">
                                <input type="radio"
                                    name="jawaban[{{ $p->id_pertanyaan }}]"
                                    value="{{ $opsi->id_opsi }}"
                                    {{ $jawabanUser == $opsi->id_opsi ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $opsi->kode_opsi }}.
                                    @if(Str::contains($opsi->isi_opsi, 'uploads/opsi_jawaban'))
                                        <img src="{{ asset('storage/'.$opsi->isi_opsi) }}" 
                                            alt="Opsi {{ $opsi->kode_opsi }}" 
                                            class="img-thumbnail ms-2" 
                                            style="max-height:100px;">
                                    @else
                                        {{ $opsi->isi_opsi }}
                                    @endif
                                </label>
                            </div>
                        @endforeach

                        {{-- Navigasi antar soal --}}
                        <div class="mt-4 d-flex justify-content-between navigation-buttons">
                            @if($index > 0)
                                <button type="button" class="btn btn-secondary prev-btn">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </button>
                            @else
                                <div></div>
                            @endif

                            @if($index < $pertanyaan->count()-1)
                                <button type="button" class="btn btn-primary next-btn">
                                    Lanjut <i class="fas fa-arrow-right ms-1"></i>
                                </button>
                            @else
                                <button type="button" class="btn btn-primary next-to-signature-btn">
                                    Ke Tanda Tangan <i class="fas fa-signature ms-1"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- ===== TANDA TANGAN ===== --}}
            <div class="mt-5 border rounded p-3 bg-light" id="signature-section" style="display:none;">
                <div class="main-header">Tanda Tangan Asesi</div>
                <div class="card">
                    <div class="card-title">Asesi</div>
                    <div class="mb-2">
                        <label>Nama Lengkap</label>
                        <input type="text" class="form-control" value="{{ $asesi->nama_lengkap }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Tanggal</label>
                        <input type="date" id="tanggal-asesi" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label>Tanda Tangan <span class="text-danger">*</span></label>
                        <canvas id="ttd-asesi" width="400" height="150" style="border: 2px solid #ddd; border-radius: 8px; width: 100%; background: white; cursor: crosshair;"></canvas>
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Gambar tanda tangan Anda di kotak di atas</small>
                    </div>
                    <div class="btns">
                        <button type="button" class="btn btn-danger clear" onclick="clearCanvas()">
                            <i class="fas fa-eraser me-1"></i> Hapus
                        </button>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="button" class="btn btn-success" id="submitWithConfirmation">
                        <i class="fas fa-check me-1"></i> Kirim Jawaban
                    </button>
                    <button type="button" class="btn btn-secondary ms-2" id="backToQuestionsBtn">
                        <i class="fas fa-arrow-left me-1"></i> Kembali ke Soal
                    </button>
                </div>
            </div>
        </form>
    @else
        <div class="alert alert-warning text-center mt-4">
            <strong>Belum ada pertanyaan pilihan ganda yang tersedia.</strong>
        </div>
    @endif

</div>

@if($timer > 0)
<script>
document.addEventListener("DOMContentLoaded", function() {
    let totalSeconds = {{ $timer * 60 }};
    let countdownEl = document.getElementById("countdown");
    let form = document.getElementById("jawabanForm");
    let timeUpShown = false;

    // Fungsi deteksi canvas kosong (loop manual pixel)
    function isCanvasBlank(canvas) {
        const ctx = canvas.getContext('2d');
        const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
        const data = imageData.data;
        for (let i = 0; i < data.length; i += 4) {
            // Jika ada pixel yang tidak putih (RGB ≠ 255 semua), maka tidak kosong
            if (data[i] !== 255 || data[i+1] !== 255 || data[i+2] !== 255) {
                return false;
            }
        }
        return true; // semua putih = kosong
    }

    // Simpan tanda tangan hanya jika tidak kosong
    function saveSignatureFromTimer() {
        const canvas = document.getElementById('ttd-asesi');
        if (!isCanvasBlank(canvas)) {
            document.getElementById('ttd_asesi_data').value = canvas.toDataURL();
            document.getElementById('tgl_ttd_asesi_data').value = document.getElementById('tanggal-asesi').value;
            return true;
        }
        return false;
    }

    function updateCountdown() {
        let minutes = Math.floor(totalSeconds / 60);
        let seconds = totalSeconds % 60;
        countdownEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        totalSeconds--;

        if (totalSeconds < 0 && !timeUpShown) {
            timeUpShown = true;
            clearInterval(timerInterval);

            const mainCanvas = document.getElementById('ttd-asesi');
            const isSigned = !isCanvasBlank(mainCanvas);

            if (!isSigned) {
                // Tampilkan pop-up dengan canvas
                Swal.fire({
                    title: '⏰ WAKTU HABIS!',
                    html: `
                        <div style="text-align: left; max-width: 450px; margin: 0 auto;">
                            <p class="mb-3 text-danger fw-bold">⚠️ Anda BELUM menandatangani lembar jawaban!</p>
                            <label class="fw-semibold mb-2">Nama Lengkap</label>
                            <input type="text" class="form-control mb-3" value="{{ $asesi->nama_lengkap }}" readonly>
                            
                            <label class="fw-semibold mb-2">Tanggal</label>
                            <input type="date" id="popup-tanggal-asesi" class="form-control mb-3" value="{{ date('Y-m-d') }}" readonly>
                            
                            <label class="fw-semibold mb-2">Tanda Tangan <span class="text-danger">*</span></label>
                            <canvas id="popup-ttd-asesi" width="400" height="150" style="border: 2px solid #dc3545; border-radius: 8px; width: 100%; background: white; cursor: crosshair; display: block;"></canvas>
                            
                            <button type="button" class="btn btn-sm btn-danger mt-2 w-100" onclick="clearPopupCanvas()">
                                <i class="fas fa-eraser"></i> Hapus Tanda Tangan
                            </button>
                            <p class="text-muted mt-2 small"><i class="fas fa-info-circle"></i> Gambar tanda tangan Anda di kotak putih di atas</p>
                        </div>
                    `,
                    icon: 'warning',
                    showCancelButton: false,
                    confirmButtonText: '<i class="fas fa-paper-plane"></i> Kirim Jawaban Sekarang',
                    confirmButtonColor: '#198754',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    width: '600px',
                    didOpen: () => {
                        initPopupCanvas();
                    },
                    preConfirm: () => {
                        const popupCanvas = document.getElementById('popup-ttd-asesi');
                        if (isCanvasBlank(popupCanvas)) {
                            Swal.showValidationMessage('❌ Tanda tangan belum diisi!');
                            return false;
                        }
                        return true;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Salin tanda tangan dari pop-up ke canvas utama
                        const popupCanvas = document.getElementById('popup-ttd-asesi');
                        const mainCanvas = document.getElementById('ttd-asesi');
                        const mainCtx = mainCanvas.getContext('2d');
                        mainCtx.clearRect(0, 0, mainCanvas.width, mainCanvas.height);
                        mainCtx.fillStyle = '#ffffff';
                        mainCtx.fillRect(0, 0, mainCanvas.width, mainCanvas.height);
                        mainCtx.drawImage(popupCanvas, 0, 0);
                        
                        document.getElementById('tanggal-asesi').value = document.getElementById('popup-tanggal-asesi').value;
                        
                        // Simpan dan submit
                        saveSignatureFromTimer();
                        form.submit();
                    }
                });
                
            } else {
                // Sudah tanda tangan, langsung submit
                saveSignatureFromTimer();
                Swal.fire({
                    title: 'Waktu Habis!',
                    text: 'Jawaban Anda akan otomatis dikirim.',
                    icon: 'info',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    form.submit();
                });
            }
        }
    }

    // Inisialisasi canvas pop-up
    window.initPopupCanvas = function() {
        const popupCanvas = document.getElementById('popup-ttd-asesi');
        if (!popupCanvas) return;
        
        const popupCtx = popupCanvas.getContext('2d');
        popupCtx.fillStyle = '#ffffff';
        popupCtx.fillRect(0, 0, popupCanvas.width, popupCanvas.height);
        popupCtx.lineWidth = 2;
        popupCtx.lineCap = 'round';
        popupCtx.strokeStyle = '#000';
        
        let isDrawing = false;
        let lastX = 0, lastY = 0;

        function startDrawing(e) {
            isDrawing = true;
            const rect = popupCanvas.getBoundingClientRect();
            lastX = e.clientX - rect.left;
            lastY = e.clientY - rect.top;
        }

        function draw(e) {
            if (!isDrawing) return;
            const rect = popupCanvas.getBoundingClientRect();
            const currentX = e.clientX - rect.left;
            const currentY = e.clientY - rect.top;
            
            popupCtx.beginPath();
            popupCtx.moveTo(lastX, lastY);
            popupCtx.lineTo(currentX, currentY);
            popupCtx.stroke();
            
            lastX = currentX;
            lastY = currentY;
        }

        function stopDrawing() {
            isDrawing = false;
        }

        popupCanvas.addEventListener('mousedown', startDrawing);
        popupCanvas.addEventListener('mousemove', draw);
        popupCanvas.addEventListener('mouseup', stopDrawing);
        popupCanvas.addEventListener('mouseout', stopDrawing);

        popupCanvas.addEventListener('touchstart', e => {
            e.preventDefault();
            const touch = e.touches[0];
            const rect = popupCanvas.getBoundingClientRect();
            isDrawing = true;
            lastX = touch.clientX - rect.left;
            lastY = touch.clientY - rect.top;
        });

        popupCanvas.addEventListener('touchmove', e => {
            e.preventDefault();
            if (!isDrawing) return;
            const touch = e.touches[0];
            const rect = popupCanvas.getBoundingClientRect();
            const currentX = touch.clientX - rect.left;
            const currentY = touch.clientY - rect.top;
            
            popupCtx.beginPath();
            popupCtx.moveTo(lastX, lastY);
            popupCtx.lineTo(currentX, currentY);
            popupCtx.stroke();
            
            lastX = currentX;
            lastY = currentY;
        });

        popupCanvas.addEventListener('touchend', e => {
            e.preventDefault();
            stopDrawing();
        });
    };

    window.clearPopupCanvas = function() {
        const popupCanvas = document.getElementById('popup-ttd-asesi');
        if (!popupCanvas) return;
        const popupCtx = popupCanvas.getContext('2d');
        popupCtx.clearRect(0, 0, popupCanvas.width, popupCanvas.height);
        popupCtx.fillStyle = '#ffffff';
        popupCtx.fillRect(0, 0, popupCanvas.width, popupCanvas.height);
    };

    const timerInterval = setInterval(updateCountdown, 1000);
    updateCountdown();
});
</script>
@endif

<script>
// =========================================================
// Fungsi Validasi Form Utama
// =========================================================
function validateForm(event) {
    // Cek soal yang belum dijawab
    const allQuestions = document.querySelectorAll('.soal-item');
    let unanswered = [];
    
    allQuestions.forEach((soal, index) => {
        if (!soal.querySelector('input[type="radio"]:checked')) {
            unanswered.push(index + 1);
        }
    });
    
    if (unanswered.length > 0) {
        event.preventDefault();
        Swal.fire({
            title: 'Ada Soal Belum Dijawab!',
            html: `<b>${unanswered.length}</b> soal belum dijawab.<br>Lengkapi dulu sebelum kirim.`,
            icon: 'warning',
            confirmButtonText: 'Kembali ke Soal',
            confirmButtonColor: '#0d6efd'
        });
        return false;
    }
    
    // Cek tanda tangan dengan metode yang akurat
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imageData.data;
    
    let isCanvasEmpty = true;
    for (let i = 0; i < data.length; i += 4) {
        // Cek pixel yang bukan putih (nilai RGB tidak 255 semua)
        if (data[i] !== 255 || data[i+1] !== 255 || data[i+2] !== 255) {
            isCanvasEmpty = false;
            break;
        }
    }
    
    if (isCanvasEmpty) {
        event.preventDefault();
        Swal.fire({
            title: 'Tanda Tangan Belum Diisi!',
            text: 'Silakan isi tanda tangan sebelum mengirim.',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd'
        });
        return false;
    }
    
    // Simpan tanda tangan ke hidden input
    saveSignature();
    return true;
}

// =========================================================
// Navigasi dan Soal
// =========================================================
document.addEventListener('DOMContentLoaded', function () {
    const soalItems = document.querySelectorAll('.soal-item');
    const navButtons = document.querySelectorAll('.soal-nav');
    const signatureSection = document.getElementById('signature-section');

    function showSoal(index) {
        soalItems.forEach((item, i) => item.style.display = (i === index) ? '' : 'none');
        window.scrollTo({ top: 0, behavior: 'smooth' });
        updateNavigationStatus();
    }

    function showSignatureSection() {
        const soalWrapper = document.querySelector('.soal-wrapper');
        if (soalWrapper) soalWrapper.style.display = 'none';
        signatureSection.style.display = '';
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function showSoalContainer() {
        signatureSection.style.display = 'none';
        const soalWrapper = document.querySelector('.soal-wrapper');
        if (soalWrapper) soalWrapper.style.display = '';
        showSoal(soalItems.length - 1);
    }

    soalItems.forEach((item, index) => {
        const nextBtn = item.querySelector('.next-btn');
        const prevBtn = item.querySelector('.prev-btn');
        const nextToSignatureBtn = item.querySelector('.next-to-signature-btn');
        if (nextBtn) nextBtn.addEventListener('click', () => showSoal(index + 1));
        if (prevBtn) prevBtn.addEventListener('click', () => showSoal(index - 1));
        if (nextToSignatureBtn) nextToSignatureBtn.addEventListener('click', showSignatureSection);
    });

    document.getElementById('backToQuestionsBtn').addEventListener('click', showSoalContainer);

    navButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            signatureSection.style.display = 'none';
            document.querySelector('.soal-wrapper').style.display = '';
            showSoal(index);
        });
    });

    function updateNavigationStatus() {
        navButtons.forEach((btn, index) => {
            const checked = soalItems[index].querySelector('input[type="radio"]:checked');
            if (checked) {
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-success');
            } else {
                btn.classList.add('btn-outline-primary');
                btn.classList.remove('btn-success');
            }
        });
    }

    document.querySelectorAll('input[type="radio"]').forEach(radio => 
        radio.addEventListener('change', updateNavigationStatus)
    );
    updateNavigationStatus();
});

// =========================================================
// Tanda Tangan
// =========================================================
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('ttd-asesi');
    if (!canvas) return;
    
    const ctx = canvas.getContext('2d');
    
    // Set background putih
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    
    let isDrawing = false;
    let lastX = 0, lastY = 0;

    function startDrawing(e) {
        isDrawing = true;
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }
    
    function draw(e) {
        if (!isDrawing) return;
        
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }
    
    function stopDrawing() {
        isDrawing = false;
    }

    // Desktop
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Mobile
    canvas.addEventListener('touchstart', e => {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        startDrawing({ offsetX: touch.clientX - rect.left, offsetY: touch.clientY - rect.top });
    });
    
    canvas.addEventListener('touchmove', e => {
        e.preventDefault();
        const touch = e.touches[0];
        const rect = canvas.getBoundingClientRect();
        draw({ offsetX: touch.clientX - rect.left, offsetY: touch.clientY - rect.top });
    });
    
    canvas.addEventListener('touchend', e => {
        e.preventDefault();
        stopDrawing();
    });
});

function saveSignature() {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
    const data = imageData.data;
    
    // Cek apakah canvas benar-benar kosong
    let isCanvasEmpty = true;
    for (let i = 0; i < data.length; i += 4) {
        if (data[i] !== 255 || data[i+1] !== 255 || data[i+2] !== 255) {
            isCanvasEmpty = false;
            break;
        }
    }
    
    if (!isCanvasEmpty) {
        document.getElementById('ttd_asesi_data').value = canvas.toDataURL();
        document.getElementById('tgl_ttd_asesi_data').value = document.getElementById('tanggal-asesi').value;
        return true;
    }
    return false;
}

function clearCanvas() {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

// =========================================================
// Tombol Submit dengan Konfirmasi
// =========================================================
document.addEventListener('DOMContentLoaded', function() {
    const submitBtn = document.getElementById('submitWithConfirmation');
    const form = document.getElementById('jawabanForm');
    
    if (submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Cek soal yang belum dijawab
            const allQuestions = document.querySelectorAll('.soal-item');
            let unanswered = [];
            
            allQuestions.forEach((soal, index) => {
                if (!soal.querySelector('input[type="radio"]:checked')) {
                    unanswered.push(index + 1);
                }
            });
            
            if (unanswered.length > 0) {
                Swal.fire({
                    title: 'Ada Soal Belum Dijawab!',
                    html: `<b>${unanswered.length}</b> soal belum dijawab.<br>Lengkapi dulu sebelum kirim.`,
                    icon: 'warning',
                    confirmButtonText: 'Kembali ke Soal',
                    confirmButtonColor: '#0d6efd'
                });
                return;
            }
            
            // Cek tanda tangan dengan metode yang lebih akurat
            const canvas = document.getElementById('ttd-asesi');
            const ctx = canvas.getContext('2d');
            const imageData = ctx.getImageData(0, 0, canvas.width, canvas.height);
            const data = imageData.data;
            
            let isCanvasEmpty = true;
            for (let i = 0; i < data.length; i += 4) {
                // Cek pixel yang bukan putih (nilai RGB tidak 255 semua)
                if (data[i] !== 255 || data[i+1] !== 255 || data[i+2] !== 255) {
                    isCanvasEmpty = false;
                    break;
                }
            }
            
            if (isCanvasEmpty) {
                Swal.fire({
                    title: 'Tanda Tangan Belum Diisi!',
                    text: 'Silakan isi tanda tangan sebelum mengirim.',
                    icon: 'warning',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#0d6efd'
                });
                return;
            }
            
            // Hitung jumlah soal yang sudah dijawab
            const totalSoal = allQuestions.length;
            const terjawab = totalSoal - unanswered.length;
            
            // Tampilkan konfirmasi sebelum submit
            Swal.fire({
                title: 'Konfirmasi Pengiriman',
                html: `
                    <div style="text-align: left;">
                        <p class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Semua soal telah dijawab: <b>${terjawab}/${totalSoal}</b></p>
                        <p class="mb-2"><i class="fas fa-signature text-success me-2"></i>Tanda tangan sudah diisi</p>
                        <p class="mb-3 text-muted">Pastikan semua jawaban Anda sudah benar sebelum mengirim.</p>
                    </div>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-paper-plane me-1"></i> Ya, Kirim Jawaban',
                cancelButtonText: '<i class="fas fa-times me-1"></i> Batal',
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Simpan signature
                    saveSignature();
                    
                    // Tampilkan loading
                    Swal.fire({
                        title: 'Mengirim Jawaban...',
                        html: 'Mohon tunggu sebentar...',
                        icon: 'info',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit form
                    setTimeout(() => {
                        form.submit();
                    }, 500);
                }
            });
        });
    }
});

// Mencegah submit via tombol Enter
document.addEventListener('keypress', function(e) {
    if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA' && e.target.tagName !== 'INPUT') {
        e.preventDefault();
    }
});
</script>

{{-- Style --}}
<style>
#soal-navigation-container {
    z-index: 100;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    top: 0;
}
.soal-nav {
    min-width: 40px;
    transition: all 0.2s ease;
}
.soal-nav.btn-success {
    background-color: #198754;
    border-color: #198754;
    color: white;
}
.soal-container {
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    min-height: 300px;
}
.soal-number {
    color: #0d6efd;
    margin-right: 5px;
}
.soal-text {
    color: #333;
    line-height: 1.6;
}
.main-header {
    background: #eaf2ff;
    border-left: 6px solid #0284C7;
    padding: 12px 15px;
    border-radius: 6px;
    font-weight: bold;
    margin-bottom: 20px;
    font-size: 1.2rem;
}
.card {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    padding: 25px;
    max-width: 500px;
    margin: 20px auto;
}
.card-title {
    font-weight: bold;
    margin-bottom: 15px;
    font-size: 1.1rem;
    color: #333;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
}
.card canvas {
    border: 2px solid #999;
    border-radius: 6px;
    width: 100%;
    height: 150px;
    background-color: #fff;
    cursor: crosshair;
}
.btns {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}
.btns .btn {
    flex: 1;
    font-weight: 500;
}
.navigation-buttons button {
    min-width: 120px;
}
.img-thumbnail {
    object-fit: contain;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 3px;
    background-color: #fff;
}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.querySelector(".toggle-btn");

    if (sidebar) {
        sidebar.style.display = "none";
    }
    if (toggleBtn) {
        toggleBtn.style.display = "none";
    }

    const mainContent = document.getElementById("main-content");
    if (mainContent) {
        mainContent.style.marginLeft = "0";
        mainContent.style.width = "100%";
    }
});
</script>
@endpush
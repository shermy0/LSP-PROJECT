@extends('master')

@section('konten')
<div class="container mt-4">

    {{-- ===== HEADER ===== --}}
    <div class="border rounded p-3 bg-light mb-4">
        <div class="text-center mb-4">
            <div class="mapa-logo"></div>
            <h3 class="fw-bold">FR.IA.06.A. LEMBAR JAWABAN ESAI</h3>
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
        <form id="jawabanForm" action="{{ route('jawaban.store') }}" method="POST" onsubmit="return validateAndSaveSignature()">
            @csrf
            <input type="hidden" name="id_skema" value="{{ $id_skema }}">
            <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $id_pembuatan_pertanyaan }}">
            <input type="hidden" name="jenis" value="esai">
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
                        $jawabanUser = $jawaban[$p->id_pertanyaan] ?? '';
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

                            {{-- Textarea untuk jawaban esai --}}
                            <textarea 
                                name="jawaban[{{ $p->id_pertanyaan }}]" 
                                class="form-control jawaban-textarea mt-3" 
                                rows="5" 
                                placeholder="Tulis jawaban Anda di sini...">{{ old("jawaban.$p->id_pertanyaan", $jawabanUser) }}</textarea>
                        </div>

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
                        <label>Tanda Tangan</label>
                        <canvas id="ttd-asesi" width="400" height="150"></canvas>
                    </div>
                    <div class="btns">
                        <button type="button" class="btn btn-danger clear" onclick="clearCanvas()">Hapus</button>
                    </div>
                </div>

                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-success">
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
            <strong>Belum ada pertanyaan esai yang tersedia.</strong>
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

    function isCanvasBlank(canvas) {
        const ctx = canvas.getContext('2d');
        const pixelBuffer = new Uint32Array(
            ctx.getImageData(0, 0, canvas.width, canvas.height).data.buffer
        );
        return !pixelBuffer.some(color => color !== 0 && color !== 0xFFFFFFFF);
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

            console.log('Waktu habis! Status tanda tangan:', isSigned); // Debug

            if (!isSigned) {
                // BELUM TANDA TANGAN - TAMPILKAN POP-UP
                Swal.fire({
                    title: 'Waktu Habis!',
                    html: `
                        <p class="mb-3 text-danger fw-bold">⚠️ Anda harus tanda tangan terlebih dahulu sebelum mengirim jawaban!</p>
                        <div style="text-align: left; max-width: 450px; margin: 0 auto;">
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
                        console.log('Pop-up terbuka, inisialisasi canvas...'); // Debug
                        initPopupCanvas();
                    },
                    preConfirm: () => {
                        const popupCanvas = document.getElementById('popup-ttd-asesi');
                        
                        // Validasi apakah sudah tanda tangan
                        if (isCanvasBlank(popupCanvas)) {
                            Swal.showValidationMessage('❌ Tanda tangan belum diisi! Silakan gambar tanda tangan Anda.');
                            return false;
                        }
                        return true;
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('Tanda tangan valid, memproses...'); // Debug
                        
                        // Salin tanda tangan dari popup ke canvas utama
                        const popupCanvas = document.getElementById('popup-ttd-asesi');
                        const mainCanvas = document.getElementById('ttd-asesi');
                        const mainCtx = mainCanvas.getContext('2d');
                        
                        // Clear dan copy
                        mainCtx.clearRect(0, 0, mainCanvas.width, mainCanvas.height);
                        mainCtx.fillStyle = '#ffffff';
                        mainCtx.fillRect(0, 0, mainCanvas.width, mainCanvas.height);
                        mainCtx.drawImage(popupCanvas, 0, 0);
                        
                        // Salin tanggal
                        document.getElementById('tanggal-asesi').value = document.getElementById('popup-tanggal-asesi').value;
                        
                        // Simpan signature
                        saveSignature();
                        
                        // Tampilkan loading dan submit
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
                        
                        // Submit form setelah delay singkat
                        setTimeout(() => {
                            console.log('Mengirim form...'); // Debug
                            form.submit();
                        }, 500);
                    }
                });
                
            } else {
                // SUDAH TANDA TANGAN - LANGSUNG KIRIM
                console.log('Sudah tanda tangan, langsung kirim'); // Debug
                saveSignature();
                
                Swal.fire({
                    title: 'Waktu Habis!',
                    text: 'Jawaban Anda akan otomatis dikirim.',
                    icon: 'info',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false
                }).then(() => {
                    form.submit();
                });
            }
        }
    }

    // Fungsi untuk inisialisasi canvas di pop-up
    window.initPopupCanvas = function() {
        const popupCanvas = document.getElementById('popup-ttd-asesi');
        if (!popupCanvas) {
            console.error('Canvas popup tidak ditemukan!');
            return;
        }
        
        const popupCtx = popupCanvas.getContext('2d');
        
        // Set background putih
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
            console.log('Mulai menggambar:', lastX, lastY); // Debug
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
            if (isDrawing) {
                console.log('Berhenti menggambar'); // Debug
            }
            isDrawing = false;
        }

        // Desktop events
        popupCanvas.addEventListener('mousedown', startDrawing);
        popupCanvas.addEventListener('mousemove', draw);
        popupCanvas.addEventListener('mouseup', stopDrawing);
        popupCanvas.addEventListener('mouseout', stopDrawing);

        // Mobile events
        popupCanvas.addEventListener('touchstart', e => {
            e.preventDefault();
            const touch = e.touches[0];
            const rect = popupCanvas.getBoundingClientRect();
            isDrawing = true;
            lastX = touch.clientX - rect.left;
            lastY = touch.clientY - rect.top;
            console.log('Touch start:', lastX, lastY); // Debug
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
        
        console.log('Canvas popup berhasil diinisialisasi!'); // Debug
    };

    // Fungsi untuk hapus canvas di pop-up
    window.clearPopupCanvas = function() {
        const popupCanvas = document.getElementById('popup-ttd-asesi');
        if (!popupCanvas) return;
        
        const popupCtx = popupCanvas.getContext('2d');
        popupCtx.clearRect(0, 0, popupCanvas.width, popupCanvas.height);
        popupCtx.fillStyle = '#ffffff';
        popupCtx.fillRect(0, 0, popupCanvas.width, popupCanvas.height);
        console.log('Canvas popup dihapus'); // Debug
    };

    const timerInterval = setInterval(updateCountdown, 1000);
    updateCountdown();
});
</script>
@endif

<script>
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

    // Tombol navigasi
    soalItems.forEach((item, index) => {
        const nextBtn = item.querySelector('.next-btn');
        const prevBtn = item.querySelector('.prev-btn');
        const nextToSignatureBtn = item.querySelector('.next-to-signature-btn');
        if (nextBtn) nextBtn.addEventListener('click', () => showSoal(index + 1));
        if (prevBtn) prevBtn.addEventListener('click', () => showSoal(index - 1));
        if (nextToSignatureBtn) nextToSignatureBtn.addEventListener('click', showSignatureSection);
    });

    document.getElementById('backToQuestionsBtn').addEventListener('click', showSoalContainer);

    // Klik nomor soal
    navButtons.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            signatureSection.style.display = 'none';
            document.querySelector('.soal-wrapper').style.display = '';
            showSoal(index);
        });
    });

    // Update status navigasi soal (warna tombol) - DIPERBARUI UNTUK ESAI
    function updateNavigationStatus() {
        navButtons.forEach((btn, index) => {
            // Cek apakah textarea sudah diisi (untuk esai)
            const textarea = soalItems[index].querySelector('textarea.jawaban-textarea');
            const isAnswered = textarea && textarea.value.trim() !== '';  // Trim untuk menghindari spasi kosong

            if (isAnswered) {
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-success');
            } else {
                btn.classList.add('btn-outline-primary');
                btn.classList.remove('btn-success');
            }
        });
    }

    // Event listener untuk textarea agar update real-time saat diketik
    document.querySelectorAll('textarea.jawaban-textarea').forEach(textarea => {
        textarea.addEventListener('input', updateNavigationStatus);  // Update saat mengetik
        textarea.addEventListener('change', updateNavigationStatus); // Update saat blur/fokus
    });

    // Panggil sekali saat load untuk status awal
    updateNavigationStatus();
});


// =========================================================
// Tanda Tangan
// =========================================================
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
    ctx.lineWidth = 2;
    ctx.lineCap = 'round';
    ctx.strokeStyle = '#000';
    let isDrawing = false, lastX = 0, lastY = 0;

    function startDrawing(e) { isDrawing = true; [lastX, lastY] = [e.offsetX, e.offsetY]; }
    function draw(e) {
        if (!isDrawing) return;
        ctx.beginPath();
        ctx.moveTo(lastX, lastY);
        ctx.lineTo(e.offsetX, e.offsetY);
        ctx.stroke();
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }
    function stopDrawing() { isDrawing = false; }

    // Desktop
    canvas.addEventListener('mousedown', startDrawing);
    canvas.addEventListener('mousemove', draw);
    canvas.addEventListener('mouseup', stopDrawing);
    canvas.addEventListener('mouseout', stopDrawing);

    // Mobile
    canvas.addEventListener('touchstart', e => {
        e.preventDefault();
        const t = e.touches[0], r = canvas.getBoundingClientRect();
        startDrawing({ offsetX: t.clientX - r.left, offsetY: t.clientY - r.top });
    });
    canvas.addEventListener('touchmove', e => {
        e.preventDefault();
        const t = e.touches[0], r = canvas.getBoundingClientRect();
        draw({ offsetX: t.clientX - r.left, offsetY: t.clientY - r.top });
    });
    canvas.addEventListener('touchend', e => { e.preventDefault(); stopDrawing(); });
});

function saveSignature() {
    const canvas = document.getElementById('ttd-asesi');
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;
    if (canvas.toDataURL() !== blank.toDataURL()) {
        document.getElementById('ttd_asesi_data').value = canvas.toDataURL();
        document.getElementById('tgl_ttd_asesi_data').value = document.getElementById('tanggal-asesi').value;
    } else {
        document.getElementById('ttd_asesi_data').value = ''; // biar gak kirim kosong
    }
}

function clearCanvas() {
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = '#ffffff';
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

// =========================================================
// Validasi Soal & TTD sebelum submit
// =========================================================
function validateAndSaveSignature() {
    const allQuestions = document.querySelectorAll('.soal-item');
    let unanswered = [];

    // cek soal yang belum dijawab
    allQuestions.forEach((soal, index) => {
    const textarea = soal.querySelector('textarea.jawaban-textarea');

    if (!textarea || textarea.value.trim() === '') {
        unanswered.push(index + 1);
    }
});

    if (unanswered.length > 0) {
        Swal.fire({
            title: 'Ada Soal Belum Dijawab!',
            html: `Nomor: <b>${unanswered.join(', ')}</b> belum dijawab.<br>Lengkapi dulu sebelum kirim.`,
            icon: 'warning',
            confirmButtonText: 'Kembali ke Soal',
            confirmButtonColor: '#0d6efd'
        });
        return false;
    }

    // cek tanda tangan
    const canvas = document.getElementById('ttd-asesi');
    const blank = document.createElement('canvas');
    blank.width = canvas.width;
    blank.height = canvas.height;

    if (canvas.toDataURL() === blank.toDataURL()) {
        Swal.fire({
            title: 'Tanda Tangan Belum Diisi!',
            text: 'Silakan isi tanda tangan sebelum mengirim.',
            icon: 'warning',
            confirmButtonText: 'OK',
            confirmButtonColor: '#0d6efd'
        });
        return false;
    }

    saveSignature();
    return true;
}
</script>


{{-- Style --}}
<style>
#soal-navigation-container{z-index:100;box-shadow:0 2px 10px rgba(0,0,0,0.1);top:0;}
.soal-nav{min-width:40px;transition:all 0.2s ease;}
.soal-container{box-shadow:0 0 15px rgba(0,0,0,0.05);min-height:300px;}
.soal-number{color:#0d6efd;margin-right:5px;}
.soal-text{color:#333;line-height:1.6;}
.main-header{background:#eaf2ff;border-left:6px solid #0284C7;padding:12px 15px;border-radius:6px;font-weight:bold;margin-bottom:20px;font-size:1.2rem;}
.card{background:#fff;border:1px solid #ddd;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.08);padding:25px;max-width:500px;margin:20px auto;}
.card-title{font-weight:bold;margin-bottom:15px;font-size:1.1rem;color:#333;border-bottom:1px solid #eee;padding-bottom:10px;}
.card canvas{border:1px solid #999;border-radius:6px;width:100%;height:150px;background-color:#fff;cursor:crosshair;}
.btns{display:flex;justify-content:space-between;gap:10px;}
.btns .btn{flex:1;font-weight:500;}
.navigation-buttons button{min-width:120px;}
.img-thumbnail{object-fit:contain;border:1px solid #ddd;border-radius:8px;padding:3px;background-color:#fff;}
</style>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebar = document.getElementById("sidebar");
    const toggleBtn = document.querySelector(".toggle-btn");

    // Sembunyikan sidebar dan tombolnya di halaman lembar jawaban
    if (sidebar) {
        sidebar.style.display = "none";
    }
    if (toggleBtn) {
        toggleBtn.style.display = "none";
    }

    // Biar area konten penuh layar
    const mainContent = document.getElementById("main-content");
    if (mainContent) {
        mainContent.style.marginLeft = "0";
        mainContent.style.width = "100%";
    }
});
</script>
@endpush
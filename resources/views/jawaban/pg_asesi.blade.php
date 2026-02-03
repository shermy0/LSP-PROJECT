@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center mb-4">Jawaban – Pilihan Ganda</h4>

    {{-- Timer --}}
    @if($timer > 0)
        <div class="alert alert-info text-center">
            Waktu Tersisa: <span id="countdown" class="fw-bold"></span>
        </div>
    @else
        <div class="alert alert-danger text-center">
            Waktu sudah habis. Jawaban akan otomatis tersimpan.
        </div>
    @endif

    {{-- Pesan sukses --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Pesan error --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($pertanyaan->count() > 0)
    <form id="jawabanForm" action="{{ route('jawaban.store') }}" method="POST" onsubmit="saveSignature()">
        @csrf
        <input type="hidden" name="id_skema" value="{{ $id_skema }}">
        <input type="hidden" name="id_pembuatan_pertanyaan" value="{{ $id_pembuatan_pertanyaan }}">
        <input type="hidden" name="jenis" value="pilihan_ganda">
        <input type="hidden" name="ttd_asesi" id="ttd_asesi_data">
        <input type="hidden" name="tgl_ttd_asesi" id="tgl_ttd_asesi_data">

        {{-- Navigasi Soal --}}
        <div class="mb-3 bg-white py-2 border rounded" id="soal-navigation-container">
            <div class="d-flex flex-wrap justify-content-center" id="soal-navigation" style="gap:5px;">
                @foreach($pertanyaan as $index => $p)
                    <button type="button"
                        class="btn btn-outline-primary btn-sm soal-nav mb-1 mx-1"
                        style="min-width:40px;"
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
        <div class="soal-container border rounded p-3 bg-light">
            <div class="main-header">Pertanyaan</div>
            @foreach($pertanyaan as $index => $p)
                @php
                    $jawabanUser = $jawaban[$p->id_pertanyaan] ?? null;
                @endphp
                <div class="soal-item" data-index="{{ $index }}" style="{{ $index == 0 ? '' : 'display:none;' }}">
                    <div class="soal-content">
                        <label class="fw-bold soal-number">{{ $index+1 }}.</label>
                        <label class="soal-text">{{ $p->isi_pertanyaan }}</label>

                        {{-- Foto pertanyaan jika ada --}}
                        @if($p->file_path && in_array(strtolower($p->file_type), ['jpg','jpeg','png']))
                            <div class="mt-2">
                                <img src="{{ asset('storage/'.$p->file_path) }}" 
                                    alt="Foto Pertanyaan" 
                                    class="img-fluid rounded border" 
                                    style="max-height:250px;">
                            </div>
                        @endif
                        
                        {{-- Opsi Jawaban --}}
                        @foreach($p->opsiJawaban as $opsi)
                            <div class="form-check mt-2">
                                <input type="radio"
                                    name="jawaban[{{ $p->id_pertanyaan }}]"
                                    value="{{ $opsi->id_opsi }}"
                                    {{ $jawabanUser == $opsi->id_opsi ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $opsi->kode_opsi }}. 
                                    @if(str_contains($opsi->isi_opsi, 'uploads/opsi_jawaban'))
                                        <img src="{{ asset('storage/'.$opsi->isi_opsi) }}" 
                                             alt="Opsi {{ $opsi->kode_opsi }}" 
                                             class="img-thumbnail" 
                                             style="max-height:100px;">
                                    @else
                                        {{ $opsi->isi_opsi }}
                                    @endif
                                </label>
                            </div>
                        @endforeach
                    </div>

                    {{-- Navigasi --}}
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
                            <button type="button" class="btn btn-info next-to-signature-btn">
                                Ke Tanda Tangan <i class="fas fa-signature ms-1"></i>
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tanda Tangan --}}
        <div class="mt-5 soal-container border rounded p-3 bg-light" id="signature-section" style="display:none;">
            <div class="main-header">Tanda Tangan Asesi</div>
            <div class="card">
                <div class="card-title">Asesi</div>
                <div class="mb-2">
                    <label for="nama-asesi">Nama Lengkap</label>
                    <input type="text" id="nama-asesi" class="form-control" value="{{ $asesi->nama_lengkap }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="tanggal-asesi">Tanggal</label>
                    <input type="date" id="tanggal-asesi" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                </div>
                <div class="mb-3">
                    <label for="ttd-asesi">Tanda Tangan</label>
                    <canvas id="ttd-asesi" width="400" height="150"></canvas>
                </div>
                <div class="btns">
                    <button type="button" class="btn btn-danger clear" onclick="clearCanvas()">Hapus</button>
                    <button type="button" class="btn btn-primary download" onclick="downloadTTD()">Unduh</button>
                </div>
            </div>

            {{-- Submit --}}
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
        <p class="text-muted text-center py-4">Belum ada pertanyaan pilihan ganda.</p>
    @endif
</div>

{{-- Timer Script --}}
@if($timer > 0)
<script>
let totalSeconds = {{ $timer * 60 }};
let countdownEl = document.getElementById("countdown");
let form = document.getElementById("jawabanForm");

function updateCountdown() {
    let minutes = Math.floor(totalSeconds / 60);
    let seconds = totalSeconds % 60;
    countdownEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

    if (totalSeconds <= 0) {
        clearInterval(timerInterval);
        saveSignature();
        Swal.fire({
            title: 'Waktu Habis!',
            text: 'Jawaban Anda akan otomatis disimpan.',
            icon: 'warning',
            allowOutsideClick: false,
            allowEscapeKey: false,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        }).then(() => form.submit());
    }
    totalSeconds--;
}
updateCountdown();
let timerInterval = setInterval(updateCountdown, 1000);
</script>
@endif

<script>
// Navigasi Soal
document.addEventListener('DOMContentLoaded', function () {
    const soalItems = document.querySelectorAll('.soal-item');
    const navButtons = document.querySelectorAll('.soal-nav');
    const signatureSection = document.getElementById('signature-section');
    const soalContainer = document.querySelector('.soal-container');

    function showSoal(index) {
        soalItems.forEach((item, i) => item.style.display = (i===index)?'':'none');
        window.scrollTo({ top:0, behavior:'smooth' });
        updateNavigationStatus();
    }

    function showSignatureSection() {
        saveSignature();
        soalContainer.style.display='none';
        signatureSection.style.display='';
        window.scrollTo({ top:0, behavior:'smooth' });
    }

    function showSoalContainer() {
        signatureSection.style.display='none';
        soalContainer.style.display='';
        showSoal(soalItems.length-1);
    }

    soalItems.forEach((item,index)=>{
        const nextBtn = item.querySelector('.next-btn');
        const prevBtn = item.querySelector('.prev-btn');
        const nextToSignatureBtn = item.querySelector('.next-to-signature-btn');
        if(nextBtn) nextBtn.addEventListener('click',()=>showSoal(index+1));
        if(prevBtn) prevBtn.addEventListener('click',()=>showSoal(index-1));
        if(nextToSignatureBtn) nextToSignatureBtn.addEventListener('click', showSignatureSection);
    });

    document.getElementById('backToQuestionsBtn').addEventListener('click', showSoalContainer);

    navButtons.forEach((btn,index)=>btn.addEventListener('click',()=>showSoal(index)));

    function updateNavigationStatus() {
        navButtons.forEach((btn, index) => {
            const soal = soalItems[index];
            const checked = soal.querySelector('input[type="radio"]:checked');
            if (checked) {
                btn.classList.remove('btn-outline-primary');
                btn.classList.add('btn-success');
            } else {
                btn.classList.add('btn-outline-primary');
                btn.classList.remove('btn-success');
            }
        });
    }

    document.querySelectorAll('input[type="radio"]').forEach(radio=>radio.addEventListener('change',updateNavigationStatus));
    updateNavigationStatus();
});

// Tanda tangan
document.addEventListener('DOMContentLoaded',function(){
    const canvas = document.getElementById('ttd-asesi');
    const ctx = canvas.getContext('2d');
    ctx.fillStyle='#ffffff';
    ctx.fillRect(0,0,canvas.width,canvas.height);
    ctx.lineWidth=2;
    ctx.lineCap='round';
    ctx.lineJoin='round';
    ctx.strokeStyle='#000';
    let isDrawing=false,lastX=0,lastY=0;

    function startDrawing(e){isDrawing=true;[lastX,lastY]=[e.offsetX,e.offsetY];}
    function draw(e){if(!isDrawing)return;ctx.beginPath();ctx.moveTo(lastX,lastY);ctx.lineTo(e.offsetX,e.offsetY);ctx.stroke();[lastX,lastY]=[e.offsetX,e.offsetY];}
    function stopDrawing(){isDrawing=false;}

    canvas.addEventListener('mousedown',startDrawing);
    canvas.addEventListener('mousemove',draw);
    canvas.addEventListener('mouseup',stopDrawing);
    canvas.addEventListener('mouseout',stopDrawing);

    canvas.addEventListener('touchstart', function(e){
        e.preventDefault();
        const touch=e.touches[0];
        const rect=canvas.getBoundingClientRect();
        const offsetX=touch.clientX-rect.left;
        const offsetY=touch.clientY-rect.top;
        startDrawing({offsetX,offsetY});
    });
    canvas.addEventListener('touchmove', function(e){
        e.preventDefault();
        const touch=e.touches[0];
        const rect=canvas.getBoundingClientRect();
        const offsetX=touch.clientX-rect.left;
        const offsetY=touch.clientY-rect.top;
        draw({offsetX,offsetY});
    });
    canvas.addEventListener('touchend',function(e){e.preventDefault();stopDrawing();});
});

// Simpan tanda tangan
function saveSignature(){
    const canvas=document.getElementById('ttd-asesi');
    const dataURL=canvas.toDataURL();
    document.getElementById('ttd_asesi_data').value=dataURL;
    document.getElementById('tgl_ttd_asesi_data').value=document.getElementById('tanggal-asesi').value;
}

function clearCanvas(){
    const canvas=document.getElementById('ttd-asesi');
    const ctx=canvas.getContext('2d');
    ctx.clearRect(0,0,canvas.width,canvas.height);
    ctx.fillStyle='#ffffff';
    ctx.fillRect(0,0,canvas.width,canvas.height);
}

function downloadTTD(){
    const canvas=document.getElementById('ttd-asesi');
    const nama=document.getElementById('nama-asesi').value||'User';
    const tanggal=document.getElementById('tanggal-asesi').value||new Date().toISOString().split('T')[0];
    if(nama.trim()===''){Swal.fire({title:'Nama Harus Diisi',text:'Isi nama lengkap terlebih dahulu',icon:'warning'});return;}
    const link=document.createElement('a');
    link.download=`${nama}_${tanggal}_tanda_tangan.png`;
    link.href=canvas.toDataURL();
    link.click();
}
</script>

{{-- Style --}}
<style>
#soal-navigation-container{z-index:100;box-shadow:0 2px 10px rgba(0,0,0,0.1);position:sticky;top:0;}
.soal-nav{min-width:40px;transition:all 0.2s ease;}
.soal-container{box-shadow:0 0 15px rgba(0,0,0,0.05);min-height:300px;}
.soal-number{color:#0d6efd;margin-right:5px;}
.soal-text{color:#333;line-height:1.6;}
.main-header{background:#eaf2ff;border-left:6px solid #0284C7;padding:12px 15px;border-radius:6px;font-weight:bold;margin-bottom:20px;font-size:1.2rem;}
.card{background:#fff;border:1px solid #ddd;border-radius:12px;box-shadow:0 4px 10px rgba(0,0,0,0.08);padding:25px;max-width:500px;margin:20px auto;}
.card-title{font-weight:bold;margin-bottom:15px;font-size:1.1rem;color:#333;border-bottom:1px solid #eee;padding-bottom:10px;}
.card canvas{border:1px solid #999;border-radius:6px;width:100%;height:150px;background-color:#fff;cursor:crosshair;}
.btns{display:flex;justify-content:space-between;gap:10px;}
.btns button{padding:10px 20px;border:none;border-radius:6px;cursor:pointer;font-size:14px;flex:1;}
.btns .clear{background:#dc3545;color:white;}
.btns .download{background:#0d6efd;color:white;}
.btns button:hover{opacity:0.9;transform:translateY(-2px);transition:all 0.2s;}
@media(max-width:768px){.container{padding-left:10px;padding-right:10px;}.soal-nav{min-width:35px;padding:0.25rem 0.4rem;font-size:0.8rem;}.card{padding:20px 15px;}.btns{flex-direction:column;}}
</style>
@endsection

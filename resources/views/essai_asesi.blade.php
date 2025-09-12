@extends('master')

@section('konten')
<div class="container mt-4">
    <h4 class="fw-bold text-center mb-4">Jawaban Pertanyaan Esai</h4>

    {{-- Timer --}}
    @if($timer > 0)
        <div class="alert alert-info text-center">
            Waktu Tersisa: <span id="countdown" class="fw-bold"></span>
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

    <form id="jawabanForm" action="{{ route('jawaban.store') }}" method="POST">
        @csrf
        <input type="hidden" name="id_skema" value="{{ $id_skema }}">

        @forelse($pertanyaan as $p)
            <div class="mb-3">
                <label class="fw-bold">{{ $loop->iteration }}. {{ $p->isi_pertanyaan }}</label>
                <textarea 
                    name="jawaban[{{ $p->id_pertanyaan }}]" 
                    class="form-control" 
                    rows="3"
                >{{ old("jawaban.$p->id_pertanyaan", $jawaban[$p->id_pertanyaan] ?? '') }}</textarea>
            </div>
        @empty
            <p class="text-muted">Belum ada pertanyaan esai.</p>
        @endforelse

        @if($pertanyaan->count() > 0)
            <button type="submit" class="btn btn-primary">Simpan Jawaban</button>
        @endif
    </form>
</div>

@if($timer > 0)
<script>
    let totalSeconds = {{ $timer * 60 }}; // Timer dari database (menit ke detik)
    let countdownEl = document.getElementById("countdown");
    let form = document.getElementById("jawabanForm");

    function updateCountdown() {
        let minutes = Math.floor(totalSeconds / 60);
        let seconds = totalSeconds % 60;
        countdownEl.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

        if (totalSeconds <= 0) {
            clearInterval(timerInterval);

            // Submit otomatis via AJAX
            let formData = new FormData(form);

            fetch(form.action, {
                method: "POST",
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }).then(response => {
                if (response.ok) {
                    // Redirect setelah sukses
                    window.location.href = "{{ route('dashboard') }}";
                } else {
                    alert("Terjadi kesalahan saat menyimpan jawaban.");
                }
            }).catch(() => {
                alert("Gagal mengirim jawaban.");
            });
        }

        totalSeconds--;
    }

    updateCountdown();
    let timerInterval = setInterval(updateCountdown, 1000);
</script>
@endif
@endsection

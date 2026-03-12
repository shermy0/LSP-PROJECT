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

    .skema-wrapper {
        min-height: 100vh;
        background: linear-gradient(160deg, #eef2ff 0%, #f8faff 50%, #e8eeff 100%);
        padding: 4rem 0 5rem;
        position: relative;
        overflow: hidden;
    }

    .skema-wrapper::before {
        content: '';
        position: absolute;
        top: -140px; right: -140px;
        width: 450px; height: 450px;
        background: radial-gradient(circle, rgba(4,21,98,0.07) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .skema-wrapper::after {
        content: '';
        position: absolute;
        bottom: -100px; left: -100px;
        width: 350px; height: 350px;
        background: radial-gradient(circle, rgba(4,21,98,0.05) 0%, transparent 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    /* Header */
    .page-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .header-badge {
        display: inline-block;
        background: var(--primary-glow);
        color: var(--primary);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        padding: 6px 16px;
        border-radius: 50px;
        margin-bottom: 1rem;
        border: 1px solid rgba(4,21,98,0.18);
    }

    .page-header h2 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--primary);
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }

    .page-header p {
        color: var(--text-muted);
        font-size: 0.97rem;
        font-weight: 500;
    }

    .header-divider {
        width: 56px;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--accent-gold));
        border-radius: 4px;
        margin: 1.1rem auto 0;
    }

    /* Skema Card */
    .skema-card {
        background: #ffffff;
        border-radius: 20px;
        border: 1.5px solid rgba(4,21,98,0.08);
        box-shadow: 0 4px 20px rgba(4,21,98,0.07);
        padding: 2.2rem 1.75rem 2rem;
        text-align: center;
        height: 100%;
        transition: transform 0.3s ease, box-shadow 0.3s ease, border-color 0.3s ease;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
    }

    /* Top accent bar */
    .skema-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #1a3fbf);
        border-radius: 20px 20px 0 0;
        transition: height 0.3s ease;
    }

    /* Subtle bottom glow on hover */
    .skema-card::after {
        content: '';
        position: absolute;
        bottom: 0; left: 0; right: 0;
        height: 0;
        background: linear-gradient(0deg, rgba(4,21,98,0.04) 0%, transparent 100%);
        transition: height 0.3s ease;
        border-radius: 0 0 20px 20px;
    }

    .skema-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 52px rgba(4,21,98,0.13);
        border-color: rgba(4,21,98,0.18);
    }

    .skema-card:hover::before { height: 6px; }
    .skema-card:hover::after  { height: 60px; }

    /* Icon */
    .skema-icon {
        width: 72px;
        height: 72px;
        background: var(--primary-glow);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.9rem;
        color: var(--primary);
        margin: 0.5rem auto 1.3rem;
        transition: transform 0.3s ease, background 0.3s ease;
        border: 1.5px solid rgba(4,21,98,0.1);
        position: relative;
        z-index: 1;
    }

    .skema-card:hover .skema-icon {
        transform: scale(1.1) rotate(-4deg);
        background: rgba(4,21,98,0.15);
    }

    /* Kode Badge */
    .kode-badge {
        display: inline-block;
        background: var(--primary-glow);
        color: var(--primary);
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        padding: 5px 14px;
        border-radius: 50px;
        margin-bottom: 0.9rem;
        border: 1px solid rgba(4,21,98,0.15);
        position: relative;
        z-index: 1;
    }

    .card-title {
        font-size: 0.97rem;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0;
        line-height: 1.45;
        flex: 1;
        position: relative;
        z-index: 1;
    }

    /* Divider inside card */
    .card-divider {
        width: 36px;
        height: 3px;
        background: linear-gradient(90deg, var(--primary), var(--accent-gold));
        border-radius: 4px;
        margin: 1rem auto;
        position: relative;
        z-index: 1;
    }

    /* CTA Button */
    .btn-cta {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 22px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.85rem;
        text-decoration: none;
        letter-spacing: 0.3px;
        background: var(--primary);
        color: #fff;
        border: none;
        box-shadow: 0 4px 14px rgba(4,21,98,0.22);
        transition: all 0.25s ease;
        margin-top: 1.4rem;
        position: relative;
        z-index: 1;
    }

    .btn-cta:hover {
        background: var(--primary-light);
        color: #fff;
        box-shadow: 0 6px 22px rgba(4,21,98,0.32);
        transform: translateY(-2px);
    }

    .btn-cta i {
        transition: transform 0.2s ease;
    }

    .btn-cta:hover i {
        transform: translateX(3px);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: #fff;
        border-radius: 20px;
        border: 1.5px dashed rgba(4,21,98,0.18);
    }

    .empty-icon {
        width: 80px;
        height: 80px;
        background: var(--primary-glow);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.2rem;
        color: var(--primary);
        margin: 0 auto 1.5rem;
    }

    .empty-state h5 {
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--text-muted);
        font-size: 0.92rem;
    }

    /* Stagger animation */
    .col-skema {
        animation: fadeUp 0.5s ease both;
    }

    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(28px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    #main-content {
        padding-top: 50px;
    }

</style>

    <div class="container">
        <div class="page-header">
            <h2>Pilih Skema Sertifikasi</h2>
            <p>Silakan pilih skema untuk melihat jawaban asesi.</p>
            <div class="header-divider"></div>
        </div>

        <div class="row justify-content-center g-4">
            @forelse($skemaList as $index => $skema)
                <div class="col-md-6 col-lg-4 col-skema" style="animation-delay: {{ $index * 0.1 }}s">
                    <div class="skema-card">
                        <div class="skema-icon">
                            <i class="bi bi-patch-check"></i>
                        </div>
                        <span class="kode-badge">{{ $skema->kode_skema }}</span>
                        <div class="card-divider"></div>
                        <h5 class="card-title">{{ $skema->nama_skema }}</h5>
                        <a href="{{ route('asesor.skema.jenis', $skema->id_skema) }}" class="btn-cta">
                            Pilih Jenis Asesmen <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-inbox"></i>
                        </div>
                        <h5>Belum Ada Skema</h5>
                        <p>Anda belum memiliki skema sertifikasi yang tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection
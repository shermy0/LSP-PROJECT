<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LSP 11</title>

    {{-- Tambah CSRF Token untuk semua request POST --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('assets/css/master.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">
        <img src="{{ asset('assets/poto/potta.png') }}" alt="Potta" class="img-fluid" style="width: 30px; height: 30px; border-radius: 50%;">
        <div class="toggle-left" style="display: flex; align-items: center; gap: 10px;">
            <div style="display: flex; flex-direction: column; line-height: 1.1;">
                <span class="lsp-title">LSP 11</span>
                <span class="lsp-subtitle">Solusi Digital Asesmen</span>
            </div>
        </div>
        <i class="fas fa-bars"></i>
    </button>

    <div class="menu">
        <ul>
            @if(Auth::user()->role == 'admin')
                <li><i class="bi bi-house-door-fill"></i><a href="#">Dashboard</a></li>
            @endif

            @if(Auth::user()->role == 'asesor')
                <li><i class="bi bi-house-door-fill"></i><a href="{{ route('dashboard.asesor') }}">Dashboard</a></li>
                <li><i class="bi bi-journal-album"></i><a href="{{ route('formasesmen') }}">Form Asesmen</a></li>
                <li><i class="bi bi-people-fill"></i><a href="#">Data Peserta Uji</a></li>
                <li><i class="bi bi-pencil-square"></i><a href="{{ route('formperencanaan') }}">Form Perencanaan</a></li>
                <li><i class="bi bi-journal-album"></i><a href="#">Rekap Asesmen</a></li>
            @endif

            @if(Auth::user()->role == 'asesi')
                <li><i class="bi bi-house-door-fill"></i><a href="#">Dashboard</a></li>
                <li><i class="bi bi-pencil-square"></i><a href="#">Form Asesmen </a></li>
                <li><i class="bi bi-journal-album"></i><a href="#">Rekap Asesmen</a></li>
            @endif
        </ul>
    </div>
<div class="sidebar-footer">
    @if(Auth::user()->role == 'asesor')
        <a href="{{ route('profile.show') }}" style="text-decoration: none; color: inherit;">
            <div class="avatar">
                <div class="avatar-img">
                    <img src="{{ asset('assets/poto/potta.png') }}" alt="Potta" class="img-fluid">
                </div>
                <div class="user-info">
                    <span class="username">{{ Auth::user()->name }}</span>
                    <span class="role">{{ ucfirst(Auth::user()->role) }}</span>
                </div>
            </div>
        </a>
    @else
        <div class="avatar">
            <div class="avatar-img">
                <img src="{{ asset('assets/poto/potta.png') }}" alt="Potta" class="img-fluid">
            </div>
            <div class="user-info">
                <span class="username">{{ Auth::user()->name }}</span>
                <span class="role">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
        </div>
    @endif

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="button" id="logout-btn" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </button>
    </form>
</div>
</div>

<!-- Main content -->
<main id="main-content">
    @yield('konten')
</main>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        sidebar.classList.toggle("collapsed");
    }

    document.addEventListener("DOMContentLoaded", function () {
        const logoutBtn = document.getElementById("logout-btn");
        const logoutForm = document.getElementById("logout-form");

        logoutBtn.addEventListener("click", function () {
            Swal.fire({
                title: 'Yakin mau keluar?',
                text: "Kamu akan logout dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    logoutForm.submit();
                }
            });
        });
    });
</script>
</body>
</html>

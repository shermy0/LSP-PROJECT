<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LSP 11</title>
<link rel="stylesheet" href="{{ asset('assets/css/master.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">
    <img src="#" alt="">
        <div class="toggle-left">
            <span class="lsp-title">LSP 11</span>
            <span class="lsp-subtitle">Solusi Digital Asesmen</span>
        </div>
        <i class="fas fa-bars"></i>
    </button>

    <div class="menu">
        <ul>
            <li><i class="fas fa-home"></i> <span>Dashboard</span></li>
            <li><i class="fas fa-users"></i> <span>Data Peserta Uji</span></li>
            <li><i class="fas fa-edit"></i> <span>Form Perencanaan</span></li>
            <li><i class="fas fa-file-alt"></i> <span>Rekan Asesmen</span></li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <div class="avatar">
            <div class="avatar-img">
                <img src="{{ asset('assets/poto/potta.png') }}" alt="Potta" class="img-fluid">
                <span class="status-dot"></span>
            </div>
            <div class="user-info">
                <span class="username">
                    {{ Session::get('user.name', 'irma') }}
                </span>
                <span class="role">
                    {{ Session::get('user.role', 'Asesor') }}
                </span>
            </div>
        </div>
        <button class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Logout</span>
        </button>
    </div>
</div>

<main>
    @yield('konten')
</main>

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");
        sidebar.classList.toggle("collapsed");
        content.style.marginLeft = sidebar.classList.contains("collapsed") ? "70px" : "240px";
    }
</script>

</body>
</html>

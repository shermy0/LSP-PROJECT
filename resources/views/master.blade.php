<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sidebar Collapsible</title>
<link rel="stylesheet" href="{{ asset('master.css') }}?v={{ time() }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<div class="sidebar" id="sidebar">
    <button class="toggle-btn" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>

    <div class="logo">
        <span>LSP 11</span>
    </div>

    <div class="menu">
        <ul>
            <li><i class="fas fa-home"></i> <span>Dashboard</span></li>
            <li><i class="fas fa-users"></i> <span>Data Peserta Uji</span></li>
            <li><i class="fas fa-edit"></i> <span>Form Perencanaan</span></li>
            <li><i class="fas fa-file-alt"></i> <span>Rekan Asesmen</span></li>
        </ul>
    </div>

    <div class="sidebar-footer">
        <div class="avatar"></div>
        <div class="role">Assesor</div>
        <button class="logout-btn">Logout</button>
    </div>
</div>

<div style="margin-left:240px; padding:20px; transition: margin-left 0.3s ease;" id="content">
    <h1>Pra Perencanaan</h1>
    <p>....</p>
</div>

<script>
    function toggleSidebar() {
        document.getElementById("sidebar").classList.toggle("collapsed");
        document.getElementById("content").style.marginLeft =
            document.getElementById("sidebar").classList.contains("collapsed") ? "70px" : "240px";
    }
</script>

</body>
</html>

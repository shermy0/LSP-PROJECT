<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/global.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/asesmen.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Konten utama --}}
    <div style="margin-left:240px; padding:20px; transition: margin-left 0.3s ease;" id="content">
        @yield('content')
    </div>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    <script>
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("collapsed");
            document.getElementById("content").style.marginLeft =
                document.getElementById("sidebar").classList.contains("collapsed") ? "70px" : "240px";
        }
    </script>
</body>
</html>

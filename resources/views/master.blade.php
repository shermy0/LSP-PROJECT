<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>LSP 11</title>

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- INTERNAL CSS -->
    <style>
        :root {
            --blue-900: #041562;
            --blue-800: #0b2f7c;
            --muted: #97a6c0;
            --sidebar-w: 260px;
            --sidebar-collapsed-w: 76px;
            --radius: 10px;
            --danger: #dc3545;
            --danger-dark: #b02a37;
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            font-family: "Poppins", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial;
            margin: 0;
            color: #0f1724;
            background: #f6f8fb;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: var(--sidebar-w);
            background: linear-gradient(180deg, var(--blue-900), var(--blue-800));
            color: #fff;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            box-shadow: 6px 0 20px rgba(4, 21, 98, 0.14);
            transition: width .26s ease, padding .26s ease;
            z-index: 1050;
            overflow: visible;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-w);
            padding: 12px 8px;
        }

        /* Brand (top) - avatar + titles + toggle inside brand */
        .brand {
            display: flex;
            gap: 12px;
            align-items: center;
            user-select: none;
            position: relative;
        }

        .brand .avatar {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.12);
            background: #fff;
        }

        /* use uploaded image path for preview/test */
        .brand .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block
        }

        .brand .titles {
            display: flex;
            flex-direction: column;
            line-height: 1
        }

        .brand .title {
            font-weight: 700;
            font-size: 16px
        }

        .brand .subtitle {
            font-size: 12px;
            color: var(--muted)
        }

        /* hide brand titles and avatar when collapsed (avatar-bottom kept) */
        .sidebar.collapsed .titles {
            display: none
        }

        .sidebar.collapsed .brand .avatar {
            display: none
        }

        /* Toggle wrapper INSIDE brand so when expanded it's at right of titles,
           and when collapsed we reposition it to center over menu icons */
        .toggle-wrapper {
            margin-left: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-btn {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            border: 0;
            background: rgba(255, 255, 255, 0.06);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 6px 18px rgba(2, 8, 23, 0.12);
            transition: background .12s, transform .08s;
        }

        .toggle-btn:hover {
            background: rgba(255, 255, 255, 0.10);
            transform: translateY(-2px)
        }

        /* When collapsed: move toggle below brand and center-aligned with menu icons */
        .sidebar.collapsed .toggle-wrapper {
            position: relative;
            margin-left: 0;
            justify-content: center;
        }

        /* additional offset to align with first menu icon visually */
        .sidebar.collapsed .toggle-wrapper {
            margin-top: 10px;
            margin-bottom: 2px;
        }

        /* MENU */
        nav.menu {
            flex: 1;
            overflow: auto;
            padding-right: 6px;
            padding-top: 6px;
            margin-top: 4px
        }

        nav.menu ul {
            list-style: none;
            padding: 6px 0;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        nav.menu li {
            position: relative
        }

        nav.menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            color: rgba(255, 255, 255, 0.98);
            text-decoration: none;
            border-radius: 10px;
            transition: background .12s, transform .12s;
            font-weight: 500;
            font-size: 14px;
        }

        nav.menu a .iicon {
            min-width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.04);
            font-size: 18px;
        }

        nav.menu a:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(4px)
        }

        nav.menu a.active {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.10), rgba(255, 255, 255, 0.04));
            box-shadow: inset 4px 0 0 rgba(255, 255, 255, 0.12);
        }

        /* collapsed: hide labels & center icons */
        .sidebar.collapsed nav.menu a .label {
            display: none
        }

        .sidebar.collapsed nav.menu a {
            justify-content: center;
            padding: 10px 6px
        }

        .sidebar.collapsed nav.menu a .iicon {
            min-width: 40px;
            height: 40px;
            border-radius: 8px
        }

        /* FOOTER: keep bottom avatar unchanged when collapsed */
        .sidebar-footer {
            padding-top: 10px;
            border-top: 1px solid rgba(255, 255, 255, 0.04);
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: auto;
        }

        .user-row {
            display: flex;
            align-items: center;
            gap: 12px
        }

        .user-row .avatar-sm {
            width: 46px;
            height: 46px;
            border-radius: 8px;
            overflow: hidden;
            flex-shrink: 0
        }

        .user-row .avatar-sm img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .user-info {
            display: flex;
            flex-direction: column
        }

        .user-info .name {
            font-weight: 600
        }

        .user-info .role {
            font-size: 12px;
            color: var(--muted)
        }

        /* Keep bottom avatar shape unchanged on collapse */
        .sidebar.collapsed .user-info {
            display: none
        }

        /* LOGOUT */
        .logout-btn {
            width: 100%;
            background: var(--danger);
            border: 1px solid rgba(0, 0, 0, 0.12);
            color: #fff;
            padding: 10px 12px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            cursor: pointer;
            font-weight: 600;
            transition: background .12s, transform .08s;
        }

        .logout-btn i {
            font-size: 16px
        }

        .logout-btn:hover {
            background: var(--danger-dark);
            transform: translateY(-1px);
        }

        .sidebar.collapsed .logout-btn span {
            display: none
        }

        .sidebar.collapsed .logout-btn {
            padding: 10px 6px
        }

        /* MAIN CONTENT */
        main#main-content {
            margin-left: var(--sidebar-w);
            padding: 24px;
            transition: margin-left .26s ease, width .26s ease;
            min-height: 100vh;
        }

        .sidebar.collapsed~main#main-content {
            margin-left: var(--sidebar-collapsed-w);
        }

        /* mobile */
        @media (max-width:900px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed
            }

            .sidebar.open {
                transform: translateX(0)
            }

            main#main-content {
                margin-left: 0;
                padding: 16px
            }

            #sidebar-off {
                position: fixed;
                inset: 0;
                z-index: 1040
            }

            .sidebar.open .titles {
                display: flex
            }

            .sidebar.open .brand .avatar {
                display: block
            }

            .sidebar.open .user-info {
                display: flex
            }
        }

        /* utilities */
        .small-muted {
            font-size: 13px;
            color: var(--muted)
        }

        ::-webkit-scrollbar {
            height: 8px;
            width: 8px
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.12);
            border-radius: 8px
        }
    </style>

    @stack('head')
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar" aria-label="Sidebar navigation">
        <!-- Brand (top) -->
        <div class="brand">
            <div class="avatar">
                <!-- use uploaded image for preview/testing; change to {{ asset('...') }} in production -->
                <img src="{{ asset('assets/poto/potta.png') }}" alt="LSP 11 Logo">
            </div>

            <div class="titles">
                <div class="title">LSP 11</div>
                <div class="subtitle">Solusi Digital Asesmen</div>
            </div>

            <!-- Toggle wrapper INSIDE brand: when expanded appears to the right of titles -->
            <div class="toggle-wrapper">
                <button class="toggle-btn" id="toggle-btn" aria-label="Toggle sidebar">
                    <i class="fas fa-bars" aria-hidden="true"></i>
                </button>
            </div>
        </div>

        <!-- NAVIGATION -->
        <nav class="menu" aria-label="Main menu">
            <ul>

                {{-- ===================== ADMIN ===================== --}}
                @if(Auth::user()->role == 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" title="Dashboard"
                            data-label="Dashboard">
                            <span class="iicon"><i class="bi bi-house-door-fill"></i></span>
                            <span class="label">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.permohonan.index') }}"
                            class="{{ request()->routeIs('admin.permohonan.*') ? 'active' : '' }}" title="Daftar Permohonan"
                            data-label="Daftar Permohonan">
                            <span class="iicon"><i class="bi bi-person-lines-fill"></i></span>
                            <span class="label">Daftar Permohonan</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.asesor.index') }}"
                            class="{{ request()->routeIs('admin.asesor.*') ? 'active' : '' }}" title="Daftar Permohonan"
                            data-label="Daftar Asesor">
                            <span class="iicon"><i class="bi bi-person-vcard-fill"></i></span>
                            <span class="label">Daftar Asesor</span>
                        </a>
                    </li>
                @endif



                {{-- ===================== ASESOR ===================== --}}
                @if(Auth::user()->role == 'asesor')

                    <li>
                        <a href="{{ route('asesor.dashboard') }}"
                            class="{{ request()->routeIs('asesor.dashboard') ? 'active' : '' }}" title="Dashboard"
                            data-label="Dashboard">
                            <span class="iicon"><i class="bi bi-house-door-fill"></i></span>
                            <span class="label">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('form_pra_assesmen') }}"
                            class="{{ request()->routeIs('form_pra_assesmen') ? 'active' : '' }}" title="Form Pra Asesmen"
                            data-label="Form Pra Asesmen">
                            <span class="iicon"><i class="bi bi-file-earmark-text-fill"></i></span>
                            <span class="label">Form Pra Asesmen</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('formasesmen') }}" class="{{ request()->routeIs('formasesmen') ? 'active' : '' }}"
                            title="Form Asesmen" data-label="Form Asesmen">
                            <span class="iicon"><i class="bi bi-journal-album"></i></span>
                            <span class="label">Form Asesmen</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="{{ request()->is('asesor/peserta*') ? 'active' : '' }}" title="Data Peserta Uji"
                            data-label="Data Peserta Uji">
                            <span class="iicon"><i class="bi bi-people-fill"></i></span>
                            <span class="label">Data Peserta Uji</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('formperencanaan') }}"
                            class="{{ request()->routeIs('formperencanaan') ? 'active' : '' }}" title="Form Perencanaan"
                            data-label="Form Perencanaan">
                            <span class="iicon"><i class="bi bi-pencil-square"></i></span>
                            <span class="label">Form Perencanaan</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="{{ request()->is('asesor/rekap*') ? 'active' : '' }}" title="Rekap Asesmen"
                            data-label="Rekap Asesmen">
                            <span class="iicon"><i class="bi bi-journal-album"></i></span>
                            <span class="label">Rekap Asesmen</span>
                        </a>
                    </li>

                @endif




                {{-- ===================== ASESI ===================== --}}
                @if(Auth::user()->role == 'asesi')

                    <li>
                        <a href="{{ route('asesi.dashboard') }}"
                            class="{{ request()->routeIs('asesi.dashboard') ? 'active' : '' }}" title="Dashboard"
                            data-label="Dashboard">
                            <span class="iicon"><i class="bi bi-house-door-fill"></i></span>
                            <span class="label">Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('form_pra_assesmen') }}"
                            class="{{ request()->routeIs('form_pra_assesmen') ? 'active' : '' }}" title="Form Pra Asesmen"
                            data-label="Form Pra Asesmen">
                            <span class="iicon"><i class="bi bi-file-earmark-text-fill"></i></span>
                            <span class="label">Form Pra Asesmen</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="{{ request()->is('asesi/formasesmen*') ? 'active' : '' }}" title="Form Asesmen"
                            data-label="Form Asesmen">
                            <span class="iicon"><i class="bi bi-pencil-square"></i></span>
                            <span class="label">Form Asesmen</span>
                        </a>
                    </li>

                    <li>
                        <a href="#" class="{{ request()->is('asesi/rekap*') ? 'active' : '' }}" title="Rekap Asesmen"
                            data-label="Rekap Asesmen">
                            <span class="iicon"><i class="bi bi-journal-album"></i></span>
                            <span class="label">Rekap Asesmen</span>
                        </a>
                    </li>

                @endif

            </ul>
        </nav>


        <!-- FOOTER (user + logout) -->
        <div class="sidebar-footer">
            <div class="user-row">
                <div class="avatar-sm">
                    <img src="{{ asset('assets/poto/potta.png') }}" alt="{{ Auth::user()->name }}">
                </div>
                <div class="user-info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">{{ ucfirst(Auth::user()->role) }}</div>
                </div>
            </div>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-flex">
                @csrf
                <button type="button" id="logout-btn" class="logout-btn" aria-label="Logout">
                    <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main id="main-content">
        @yield('konten')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

    <!-- JS (toggle, mobile, logout) -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggle-btn');

        // restore collapsed preference
        document.addEventListener('DOMContentLoaded', () => {
            try {
                const collapsed = localStorage.getItem('lsp_sidebar_collapsed') === 'true';
                if (collapsed) sidebar.classList.add('collapsed');
            } catch (e) { /* ignore */ }
        });

        function toggleSidebar() {
            sidebar.classList.toggle('collapsed');
            try { localStorage.setItem('lsp_sidebar_collapsed', sidebar.classList.contains('collapsed')); } catch (e) { }
        }

        // wire toggle button
        toggleBtn.addEventListener('click', toggleSidebar);

        // mobile toggle (if using a mobile button)
        function mobileToggle() {
            if (window.innerWidth <= 900) {
                sidebar.classList.toggle('open');
                if (sidebar.classList.contains('open')) {
                    const off = document.createElement('div');
                    off.id = 'sidebar-off';
                    off.style.position = 'fixed';
                    off.style.inset = '0';
                    off.style.zIndex = '1040';
                    off.addEventListener('click', () => { sidebar.classList.remove('open'); off.remove(); });
                    document.body.appendChild(off);
                } else {
                    const existing = document.getElementById('sidebar-off');
                    if (existing) existing.remove();
                }
            } else {
                toggleSidebar();
            }
        }

        // logout confirmation
        document.getElementById('logout-btn').addEventListener('click', function () {
            Swal.fire({
                title: 'Yakin mau keluar?',
                text: "Kamu akan logout dari sistem.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#041562',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>
</body>

</html>
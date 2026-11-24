<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SIAKAD TK Al-Ikhlas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f4f6f9;
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* ================= SIDEBAR ================= */

        .sidebar {
            width: 260px;
            height: 100vh;
            height: 100dvh;
            position: fixed;
            top: 0;
            left: 0;
            background: #198754;
            display: flex;
            flex-direction: column;
            box-shadow: 3px 0 12px rgba(0,0,0,.12);
            z-index: 1045;
            transition: transform 0.28s ease;
        }

        .brand {
            padding: 18px 16px;
            color: #fff;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,.15);
            position: relative;
        }

        .brand img {
            width: 64px;
            margin-bottom: 8px;
        }

        .brand h5 {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .btn-close-sidebar {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255,255,255,.15);
            border: none;
            color: #fff;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-close-sidebar:hover {
            background: rgba(255,255,255,.28);
        }

        /* Menu bisa discroll */
        .sidebar-menu {
            flex: 1;
            overflow-y: auto;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,.25);
            border-radius: 10px;
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,.92);
            padding: 11px 16px;
            margin: 3px 10px;
            border-radius: 8px;
            transition: .2s;
            font-size: 0.95rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255,255,255,.2);
            color: #fff;
            font-weight: 600;
        }

        .sidebar small {
            display: block;
            padding-left: 18px;
            margin-top: 10px;
            margin-bottom: 6px;
            color: rgba(255,255,255,.65);
            font-size: 11.5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .logout-box {
            padding: 14px;
            border-top: 1px solid rgba(255,255,255,.15);
        }

        /* Backdrop untuk layar HP/Tablet */
        .sidebar-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            z-index: 1040;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }

        .sidebar-backdrop.show {
            opacity: 1;
            visibility: visible;
        }

        /* ================= MAIN ================= */

        .main-content {
            margin-left: 260px;
            padding: 22px;
            min-height: 100vh;
            transition: margin-left 0.28s ease;
        }

        /* Ketika sidebar disembunyikan di Desktop */
        body.sidebar-collapsed .sidebar {
            transform: translateX(-100%);
        }

        body.sidebar-collapsed .main-content {
            margin-left: 0;
        }

        .topbar {
            background: #fff;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .btn-toggle-sidebar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            color: #198754;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            cursor: pointer;
            flex-shrink: 0;
            transition: .15s;
        }

        .btn-toggle-sidebar:hover,
        .btn-toggle-sidebar:active {
            background: #198754;
            color: #fff;
            border-color: #198754;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 .125rem .5rem rgba(0,0,0,.06);
        }

        .table thead {
            background: #198754;
            color: white;
        }

        .table thead th {
            border: none;
        }

        .btn {
            border-radius: 8px;
        }

        footer {
            margin-top: 40px;
            text-align: center;
            color: #777;
            font-size: 13.5px;
        }

        /* ================= RESPONSIVE MOBILE / ANDROID ================= */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            body.sidebar-mobile-open .sidebar {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
                padding: 12px;
            }

            .topbar {
                padding: 12px 14px;
                margin-bottom: 14px;
            }

            .topbar h4 {
                font-size: 1.05rem;
            }
        }
    </style>

</head>

<body>

<!-- Overlay Backdrop (Mobile) -->
<div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeMobileSidebar()"></div>

<div class="sidebar" id="appSidebar">

    <!-- Logo -->
    <div class="brand">
        <button type="button" class="btn-close-sidebar" onclick="toggleSidebar()" title="Sembunyikan Menu">
            <i class="bi bi-x-lg"></i>
        </button>

        <i class="bi bi-mortarboard-fill fs-1"></i>

        <h5>TK Al-Ikhlas</h5>

        <small class="p-0 m-0 text-white-50">Taliwang</small>
    </div>

    <!-- MENU -->
    <div class="sidebar-menu">
        <nav class="nav flex-column">
            @include('layouts.sidebar')
        </nav>
    </div>

    <!-- LOGOUT -->
    <div class="logout-box">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-light w-100">
                <i class="bi bi-box-arrow-right me-1"></i>
                Logout
            </button>
        </form>
    </div>

</div>


<div class="main-content">

    <div class="topbar d-flex justify-content-between align-items-center gap-2">

        <div class="d-flex align-items-center gap-2 gap-md-3">
            <button type="button" class="btn-toggle-sidebar" onclick="toggleSidebar()" title="Tampilkan / Sembunyikan Menu">
                <i class="bi bi-list"></i>
            </button>

            <div>
                <h4 class="fw-bold mb-0">
                    @yield('title')
                </h4>
                <small class="text-muted d-none d-sm-inline">
                    Sistem Informasi Akademik TK Al-Ikhlas Taliwang
                </small>
            </div>
        </div>

        <div class="text-end">
            <div class="fw-semibold small">
                <i class="bi bi-person-circle text-success"></i>
                <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                <span class="d-inline d-md-none">{{ \Illuminate\Support\Str::words(auth()->user()->name, 2, '') }}</span>
            </div>

            <small class="text-muted" style="font-size: 0.75rem;">
                {{ ucfirst(auth()->user()->role) }}
                <span class="d-none d-sm-inline">• {{ now()->format('d M Y') }}</span>
            </small>
        </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <strong>Perhatian:</strong>
            <ul class="mb-0 mt-1">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')

    <footer>
        © {{ date('Y') }} SIAKAD TK Al-Ikhlas Taliwang
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const isMobileView = () => window.innerWidth < 992;
    const backdrop = document.getElementById('sidebarBackdrop');

    // Pulihkan state sidebar di desktop bila sebelumnya disembunyikan
    if (!isMobileView() && localStorage.getItem('siakad_sidebar_collapsed') === '1') {
        document.body.classList.add('sidebar-collapsed');
    }

    function toggleSidebar() {
        if (isMobileView()) {
            const isOpen = document.body.classList.toggle('sidebar-mobile-open');
            backdrop.classList.toggle('show', isOpen);
        } else {
            const isCollapsed = document.body.classList.toggle('sidebar-collapsed');
            localStorage.setItem('siakad_sidebar_collapsed', isCollapsed ? '1' : '0');
        }
    }

    function closeMobileSidebar() {
        document.body.classList.remove('sidebar-mobile-open');
        backdrop.classList.remove('show');
    }

    window.addEventListener('resize', () => {
        if (!isMobileView()) {
            closeMobileSidebar();
        }
    });

    // Bungkus otomatis tabel yang belum memiliki .table-responsive agar nyaman di-scroll di HP
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.main-content table.table').forEach((tbl) => {
            if (!tbl.closest('.table-responsive')) {
                const wrapper = document.createElement('div');
                wrapper.className = 'table-responsive';
                tbl.parentNode.insertBefore(wrapper, tbl);
                wrapper.appendChild(tbl);
            }
        });
    });
</script>

</body>
</html>

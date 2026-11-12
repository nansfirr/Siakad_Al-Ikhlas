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
        body{
            margin:0;
            background:#f4f6f9;
            font-family:'Segoe UI',sans-serif;
            overflow-x:hidden;
        }

        /* ================= SIDEBAR ================= */

        .sidebar{
            width:250px;
            height:100vh;
            position:fixed;
            top:0;
            left:0;
            background:#198754;
            display:flex;
            flex-direction:column;
            box-shadow:3px 0 10px rgba(0,0,0,.08);
        }

        .brand{
            padding:22px;
            color:#fff;
            text-align:center;
            border-bottom:1px solid rgba(255,255,255,.15);
        }

        .brand img{
            width:70px;
            margin-bottom:10px;
        }

        .brand h5{
            font-weight:bold;
            margin-bottom:2px;
        }

        /* Menu bisa discroll */
        .sidebar-menu{
            flex:1;
            overflow-y:auto;
            padding-top:12px;
        }

        .sidebar-menu::-webkit-scrollbar{
            width:6px;
        }

        .sidebar-menu::-webkit-scrollbar-thumb{
            background:rgba(255,255,255,.25);
            border-radius:10px;
        }

        .sidebar .nav-link{
            color:rgba(255,255,255,.9);
            padding:11px 18px;
            margin:3px 10px;
            border-radius:8px;
            transition:.2s;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active{
            background:rgba(255,255,255,.18);
            color:#fff;
        }

        .sidebar small{
            display:block;
            padding-left:18px;
            margin-top:10px;
            margin-bottom:8px;
            color:rgba(255,255,255,.6);
            font-size:12px;
            text-transform:uppercase;
        }

        .logout-box{
            padding:15px;
            border-top:1px solid rgba(255,255,255,.15);
        }

        /* ================= MAIN ================= */

        .main-content{
            margin-left:250px;
            padding:25px;
        }

        .topbar{
            background:#fff;
            border-radius:12px;
            padding:18px 22px;
            margin-bottom:25px;
            box-shadow:0 2px 10px rgba(0,0,0,.05);
        }

        .card{
            border:none;
            border-radius:12px;
            box-shadow:0 .125rem .5rem rgba(0,0,0,.06);
        }

        .table thead{
            background:#198754;
            color:white;
        }

        .table thead th{
            border:none;
        }

        .btn{
            border-radius:8px;
        }

        footer{
            margin-top:40px;
            text-align:center;
            color:#777;
            font-size:14px;
        }
    </style>

</head>

<body>

<div class="sidebar">

    <!-- Logo -->
    <div class="brand">

        {{-- Ganti dengan logo sekolah jika ada --}}
        {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo"> --}}

        <i class="bi bi-mortarboard-fill fs-1"></i>

        <h5>TK Al-Ikhlas</h5>

        <small>Taliwang</small>

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

    <div class="topbar d-flex justify-content-between align-items-center">

        <div>

            <h4 class="fw-bold mb-0">

                @yield('title')

            </h4>

            <small class="text-muted">

                Sistem Informasi Akademik TK Al-Ikhlas Taliwang

            </small>

        </div>

        <div class="text-end">

            <div class="fw-semibold">

                <i class="bi bi-person-circle"></i>

                {{ auth()->user()->name }}

            </div>

            <small class="text-muted">

                {{ ucfirst(auth()->user()->role) }}

                •

                {{ now()->format('d M Y') }}

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

    @yield('content')

    <footer>

        © {{ date('Y') }} SIAKAD TK Al-Ikhlas Taliwang

    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
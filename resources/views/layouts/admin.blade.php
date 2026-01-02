<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin - Lhyna Collection</title>

    {{-- 1. FONTS & ICONS --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- 2. BOOTSTRAP 5 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- 3. CSS CUSTOM ADMIN --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f8fb;
            overflow-x: hidden;
        }

        /* === SIDEBAR HITAM MODERN === */
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin .25s ease-out;
            background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
            color: #fff;
            box-shadow: 4px 0 20px rgba(0,0,0,0.1);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1.25rem;
            font-size: 1.2rem;
            font-weight: bold;
            color: #60a5fa;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            letter-spacing: 1px;
        }

        #sidebar-wrapper .list-group { width: 15rem; }

        .list-group-item {
            border: none;
            background-color: transparent;
            color: #cbd5e1;
            padding: 15px 25px;
            font-weight: 500;
            transition: all 0.3s;
            border-left: 4px solid transparent;
        }

        .list-group-item:hover {
            background-color: rgba(255, 255, 255, 0.05);
            color: #fff;
            padding-left: 25px; 
        }

        .list-group-item.active {
            background-color: rgba(96, 165, 250, 0.1);
            color: #60a5fa;
            font-weight: 700;
            border-left: 4px solid #60a5fa;
        }
        
        .list-group-item i { margin-right: 10px; }

        /* === KONTEN UTAMA === */
        #page-content-wrapper {
            min-width: 100vw;
            transition: margin .25s ease-out;
        }

        @media (min-width: 768px) {
            #sidebar-wrapper { margin-left: 0; }
            #page-content-wrapper { min-width: 0; width: 100%; }
        }

        /* Toggle Sidebar */
        #wrapper.toggled #sidebar-wrapper { margin-left: 0; }
        @media (min-width: 768px) {
            #wrapper.toggled #sidebar-wrapper { margin-left: -15rem; }
        }

        .admin-navbar {
            background: #fff;
            box-shadow: 0 2px 15px rgba(0,0,0,0.05);
            padding: 15px 30px;
        }

        .card {
            border: none;
            border-radius: 15px;
            background: #fff;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        /* === CSS GRADASI DASHBOARD (WAJIB ADA) === */
        .bg-gradient-purple { 
            background: linear-gradient(45deg, #6a11cb 0%, #2575fc 100%) !important; 
            color: white !important; 
        }
        .bg-gradient-teal { 
            background: linear-gradient(45deg, #11998e 0%, #38ef7d 100%) !important; 
            color: white !important; 
        }
        .bg-gradient-orange { 
            background: linear-gradient(45deg, #f093fb 0%, #f5576c 100%) !important; 
            color: white !important; 
        }

        /* Memastikan teks di kartu gradasi berwarna putih */
        .card.text-white h2, .card.text-white h6, .card.text-white i {
            color: white !important;
        }

        /* TABEL SOFT UI */
        .table thead th {
            background-color: #f8f9fa; border: none;
            color: #6c757d; font-weight: 600; text-transform: uppercase; font-size: 0.85rem;
        }
        .table td { vertical-align: middle; padding: 15px; border-bottom: 1px solid #f0f0f0; }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        
        {{-- 1. SIDEBAR --}}
        <div id="sidebar-wrapper">
            <div class="sidebar-heading text-center">
                <i class="bi bi-scissors"></i> ADMIN LHYNA
            </div>
            <div class="list-group list-group-flush mt-3">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
                <a href="{{ route('admin.pesanan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pesanan*') ? 'active' : '' }}">
                    <i class="bi bi-cart-check"></i> Kelola Pesanan
                </a>
                <a href="{{ route('admin.pelanggan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pelanggan*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Data Pelanggan
                </a>
                <a href="{{ route('admin.portofolio.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.portofolio*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i> Manajemen Portofolio
                </a>
                <a href="{{ route('admin.pesankontak.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pesankontak*') ? 'active' : '' }}">
                    <i class="bi bi-envelope"></i> Kotak Masuk
                </a>
                <a href="{{ route('admin.profil.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.profil*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Profil Usaha
                </a>
                <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger mt-5"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>

        {{-- 2. KONTEN UTAMA --}}
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light admin-navbar border-bottom">
                <div class="container-fluid">
                    {{-- TOMBOL MENU --}}
                    <button class="btn btn-outline-primary btn-sm" id="menu-toggle">
                        <i class="bi bi-list"></i> Menu
                    </button>
                    
                    <div class="ms-auto d-flex align-items-center">
                        <span class="me-2 text-muted small">Halo, Admin</span>
                        <div class="fw-bold">{{ Auth::user()?->name ?? 'Admin' }}</div>
                        <img src="https://ui-avatars.com/api/?name={{ Auth::user()?->name ?? 'Admin' }}&background=0d6efd&color=fff" class="rounded-circle ms-3" width="40">
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4 px-4">
                @yield('content')
            </div>
        </div>
    </div>

    {{-- 4. BOOTSTRAP 5 JS BUNDLE --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Script untuk Toggle Sidebar --}}
    <script>
        window.addEventListener('DOMContentLoaded', event => {
            const sidebarToggle = document.body.querySelector('#menu-toggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', event => {
                    event.preventDefault();
                    document.body.querySelector('#wrapper').classList.toggle('toggled');
                });
            }
        });
    </script>
</body>
</html>
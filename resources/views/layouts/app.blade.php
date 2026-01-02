<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Lhyna Collection') }}</title>

    {{-- Fonts --}}
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    {{-- 1. FONT KEREN DARI GOOGLE FONTS (Poppins) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    {{-- 2. BOOTSTRAP ICONS (Wajib untuk ikon tombol) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    {{-- 3. CSS CUSTOM LENGKAP (Animasi, Gradasi, dll) --}}
    <style>
        /* === GLOBAL STYLE === */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f8fb;
            background-image: linear-gradient(120deg, #fdfbfb 0%, #ebedee 100%); 
            color: #444;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* === NAVBAR KEREN (Efek Kaca) === */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            border-bottom: 2px solid #e3f2fd;
        }

        .navbar-brand {
            letter-spacing: 1px;
            color: #0d6efd !important;
        }

        .navbar-nav .nav-link {
            position: relative;
            color: #555;
            font-weight: 500;
            transition: color 0.3s ease;
            padding-bottom: 5px;
        }

        /* Efek Garis Bawah Hanya Muncul di Desktop agar Navigasi HP tetap bersih */
        @media (min-width: 768px) {
            .navbar-nav .nav-link::after {
                content: '';
                position: absolute;
                width: 0;
                height: 3px;
                bottom: 0;
                left: 50%;
                background-color: #0d6efd;
                transition: all 0.3s ease-in-out;
                transform: translateX(-50%);
                border-radius: 10px;
            }

            .navbar-nav .nav-link:hover::after,
            .navbar-nav .nav-link.active::after {
                width: 80%;
            }
        }

        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active {
            color: #0d6efd;
        }

        /* === KARTU (CARD) RESPONSIVE === */
        .card {
            border: none;
            border-radius: 15px;
            background: #ffffff;
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(13, 110, 253, 0.1);
        }

        /* === TOMBOL UTAMA (RESPONSIVE & GLOW) === */
        .btn-primary {
            background-image: linear-gradient(to right, #0d6efd 0%, #4facfe 51%, #0d6efd 100%);
            padding: 10px 30px;
            transition: 0.5s;
            background-size: 200% auto;
            color: white;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background-position: right center;
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3);
            color: #fff;
        }

        /* === RESPONSIVE UTILITIES (Media Queries) === */
        @media (max-width: 768px) {
            .navbar-brand { font-size: 1.1rem; }
            
            /* Tombol jadi lebar penuh di HP agar mudah diklik */
            .btn-primary, .btn-danger, .btn-outline-primary {
                width: 100%;
                margin: 5px 0;
            }

            /* Kurangi padding kontainer di layar kecil */
            .container { padding-left: 15px; padding-right: 15px; }
            
            /* Spasi antar menu di mobile */
            .navbar-nav .nav-item { padding: 5px 0; }
        }

        /* Gradasi Warna Dashboard */
        .bg-gradient-blue { background: linear-gradient(45deg, #4099ff, #73b4ff); color: white; }
        .bg-gradient-yellow { background: linear-gradient(45deg, #FFB64D, #ffcb80); color: white; }
        .bg-gradient-green { background: linear-gradient(45deg, #2ed8b6, #59e0c5); color: white; }
    </style>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div id="app" class="flex-grow-1">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
                    Lhyna Collection
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    {{-- MENU KIRI --}}
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('portofolio.index') ? 'active' : '' }}" href="{{ route('portofolio.index') }}">Portofolio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('kontak.create') }}">Kontak Kami</a>
                        </li>

                        @auth
                            @if(Auth::user()->role == 'customer')
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pesanan.create') ? 'active' : '' }}" href="{{ route('pesanan.create') }}">Buat Pesanan Baru</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('pesanan.index') ? 'active' : '' }}" href="{{ route('pesanan.index') }}">Status Pesanan</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('customer.pesan.index') }}">Pesan Saya</a>
                                </li>
                            @endif
                        @endauth
                    </ul>

                    {{-- MENU KANAN --}}
                    <ul class="navbar-nav ms-auto mt-2 mt-md-0">
                        @guest
                            <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Masuk</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end shadow border-0" style="border-radius: 12px;">
                                    @if(Auth::user()->role == 'admin')
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard Admin</a>
                                    @else
                                        <a class="dropdown-item" href="{{ route('customer.dashboard') }}">Dashboard Saya</a>
                                    @endif

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
        
        <footer class="text-center py-4 text-muted border-top bg-white mt-auto">
            <small>&copy; {{ date('Y') }} Lhyna Collection. Digitalisasi Proses Bisnis.</small>
        </footer>
    </div>
</body>
</html>
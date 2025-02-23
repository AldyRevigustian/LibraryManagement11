<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="/assets/extensions/swiper/swiper-bundle.min.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="/assets/css/main/app.css" />

    <style>
        ::-webkit-scrollbar {
            width: 20px;
        }

        ::-webkit-scrollbar-track {
            background-color: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #d6dee1;
            border-radius: 20px;
            border: 6px solid transparent;
            background-clip: content-box;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #a8bbbf;
        }

        .section-header {
            border-left: 4px solid #435ebe;
            padding-left: 1rem;
        }
    </style>
    @stack('style')
</head>

<body>
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active d-flex flex-column min-vh-100">
            <div class="sidebar-header position-relative">
                <div class="logo text-center">
                    <img src="/assets/images/lkc.png" style="width: 150px; height: 80px; " alt="Logo">
                </div>
            </div>
            <div class="sidebar-menu flex-grow-1">
                <ul class="menu mt-2">
                    <form class="d-flex mx-0" style="width: 100%;" action="{{ route('guest.search_buku') }}"
                        method="GET">
                        <div class="input-group">
                            <div class="position-relative w-100">
                                <input class="form-control py-2 ps-4 pe-5" type="search" name="search"
                                    placeholder="Cari Judul / ISBN..." aria-label="Search"
                                    style="border-color: rgba(209,213,219, 1); background-color: rgb(249,250,251); border-width: 1px; border-radius: .5rem;"
                                    value="{{ request()->query('search') }}">
                                <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                    <button type="submit" style="border: none; background: none;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="#6b7280" class="bi bi-search" viewBox="0 0 16 16">
                                            <path
                                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>


                    <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }} mt-4">
                        <a href="/" class='sidebar-link'>
                            <i class="bi bi-house-fill"></i>
                            <span class="mt-1">Beranda</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('buku*') ? 'active' : '' }}">
                        <a href="{{ route('guest.search_buku') }}" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span class="mt-1">Koleksi</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('kategori*') ? 'active' : '' }}">
                        <a href="{{ route('guest.kategori_buku') }}" class='sidebar-link'>
                            <i class="bi bi-tags-fill"></i>
                            <span class="mt-1">Kategori</span>
                        </a>
                    </li>
                    {{-- <li class="sidebar-item disabled"> --}}
                    <li class="sidebar-item {{ request()->is('anggota/favorit*') ? 'active' : '' }}">
                        <a href="{{ route('anggota.favorite') }}" class='sidebar-link'>
                            <i class="bi bi-bookmark-fill"></i>
                            <span class="mt-1">Buku Favorit</span>
                        </a>
                    </li>

                    <li class="sidebar-item {{ request()->is('anggota/transaksi*') ? 'active' : '' }}">
                        <a href="{{ route('guest.kategori_buku') }}" class='sidebar-link'>
                            <i class="bi bi-file-earmark-text-fill"></i>
                            <span class="mt-1">Transaksi</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-bottom mt-auto">
                <ul class="menu mt-0">
                    @if (Auth::guard('anggota')->check())
                        <li class="sidebar-item">
                            <a href="{{ route('anggota.logout') }}"
                                onclick="event.preventDefault();
        document.getElementById('logout-form').submit();"
                                class='sidebar-link'>
                                <i class="bi bi-box-arrow-in-left"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('anggota.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <li class="sidebar-item">
                            <a href="{{ route('anggota.login') }}" class='sidebar-link'>
                                <i class="bi bi-door-open-fill"></i>
                                <span class="mt-1">Login Anggota</span>
                            </a>
                        </li>
                </ul>
                @endif
            </div>
            {{-- @dd(Auth::check()) --}}
        </div>
    </div>
    <div id="main" class='layout-navbar navbar-fixed'>
        <div id="main-content" class="pt-0" style="min-height: 80vh">
            @yield('content')
        </div>

    </div>

    <script src="/assets/extensions/swiper/swiper-bundle.min.js"></script>
    @stack('script')
</body>

</html>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
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

        .book-card {
            position: relative;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .book-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-overlay {
            width: 100%;
            height: 35%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            justify-content: start;
            color: white;
            text-align: center;
        }

        .book-overlay-container {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
        }

        .book-category {
            align-self: center;
            background-color: rgba(6, 58, 118, 0.5);
            color: white;
            padding: 4px 12px;
            font-size: .7rem;
            font-weight: 600;
            border-radius: 6px;
            max-width: 100%;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .book-title {
            font-size: 14px;
            font-weight: bold;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            margin-top: 5px;
        }

        .book-author {
            font-size: 12px;
            opacity: 0.8;
            max-height: 1.4em;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .swiper {
            width: 100%;
            padding: 20px 0;
        }

        .swiper-slide {
            display: flex;
            height: 320px;
            justify-content: center;
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 45px;
            /* Ukuran lingkaran */
            height: 45px;
            border-radius: 50%;
            /* Membuat tombol bulat */
            background-color: rgba(0, 0, 0, 0.5);
            /* Warna latar belakang semi-transparan */
            color: white;
            /* Warna ikon */
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        /* Hover Effect */
        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(0, 0, 0, 0.8);
            /* Warna lebih gelap saat hover */
        }

        /* Menghilangkan default ikon Swiper */
        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px;
            /* Ukuran ikon */
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active d-flex flex-column min-vh-100">
            <div class="sidebar-header position-relative">
                <div class="logo text-center">
                    <img src="assets/images/lkc.png" style="width: 150px; height: 80px; " alt="Logo">
                </div>
            </div>
            <div class="sidebar-menu flex-grow-1">
                <ul class="menu mt-2">
                    <form class="d-flex mx-0" style="width: 100%;">
                        <div class="input-group">
                            <div class="position-relative w-100">
                                <input class="form-control py-2 ps-4 pe-5" type="search" placeholder="Cari buku..."
                                    aria-label="Search"
                                    style="border-color: rgba(209,213,219, 1); background-color: rgb(249,250,251); border-width: 1px; border-radius: .5rem;">
                                <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6b7280"
                                        class="bi bi-search" viewBox="0 0 16 16">
                                        <path
                                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </form>
                    <li class="sidebar-item {{ request()->is('/') ? 'active' : '' }} mt-4">
                        <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                            <i class="bi bi-house-fill"></i>
                            <span class="mt-1">Beranda</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('/koleksi') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                            <i class="bi bi-collection-fill"></i>
                            <span class="mt-1">Koleksi</span>
                        </a>
                    </li>
                    <li class="sidebar-item {{ request()->is('/kategori') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class='sidebar-link'>
                            <i class="bi bi-tags-fill"></i>
                            <span class="mt-1">Kategori</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="sidebar-bottom mt-auto border-top">
                {{-- <div class="px-3 py-2 bg-light rounded-3 mx-3 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-moon-fill me-3 text-muted"></i>
                            <span class="text-muted">Dark Mode</span>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                        </div>
                    </div>
                </div>

                <div class="px-3 mb-3">

                </div> --}}
                <ul class="menu mt-0">
                    <li class="sidebar-item">
                        <a class='sidebar-link d-flex'>
                            <i class="bi bi-moon-fill"></i>
                            <span class="mt-1">Dark Mode</span>
                            <div class="form-check form-switch ms-auto mt-1">
                                <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                            </div>
                        </a>
                    </li>
                </ul>

                <ul class="menu mt-0">
                    <li class="sidebar-item">
                        <a href="{{ route('login') }}" class='sidebar-link'>
                            <i class="bi bi-door-open-fill"></i>
                            <span class="mt-1">Admin Login</span>
                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    <div id="main" class='layout-navbar navbar-fixed'>
        <div id="main-content" class="pt-0" style="min-height: 80vh">
            <div class="container">
                <div class="rekomendasi mt-5">
                    <h5 class="text-start mb-0">Rekomendasi Buku</h5>
                    <p class="text-start mb-0">Pilihan buku terbaik dari berbagai kategori khusus untuk kamu</p>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($bukus as $buku)
                                <div class="swiper-slide">
                                    <div class="book-card">
                                        <img src="{{ $buku->foto }}" alt="">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>

                <div class="fiksi mt-5">
                    <h5 class="text-start mb-0">Buku Fiksi</h5>
                    <p class="text-start mb-0">Jelajahi dunia imajinasi dengan kisah-kisah menarik dan karakter yang
                        menginspirasi</p>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($fiksis as $buku)
                                <div class="swiper-slide">
                                    <div class="book-card">
                                        <img src="{{ $buku->foto }}" alt="">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
                <div class="komik mt-5">
                    <h5 class="text-start mb-0">Buku Komik</h5>
                    <p class="text-start mb-0">Nikmati cerita bergambar dengan karakter ikonik dan petualangan seru</p>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($komiks as $buku)
                                <div class="swiper-slide">
                                    <div class="book-card">
                                        <img src="{{ $buku->foto }}" alt="">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
                <div class="pengembangan mt-5">
                    <h5 class="text-start mb-0">Buku Pengembangan Diri</h5>
                    <p class="text-start mb-0">Temukan tips dan strategi untuk mengembangkan potensi dan menjadi versi
                        terbaik
                        dirimu</p>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($pengembangans as $buku)
                                <div class="swiper-slide">
                                    <div class="book-card">
                                        <img src="{{ $buku->foto }}" alt="">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>

                </div>
                <div class="komputer mt-5">
                    <h5 class="text-start mb-0">Buku Komputer</h5>
                    <p class="text-start mb-0">Pelajari teknologi terkini dengan panduan praktis tentang pemrograman,
                        jaringan,
                        dan komputasi</p>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($komputers as $buku)
                                <div class="swiper-slide">
                                    <div class="book-card">
                                        <img src="{{ $buku->foto }}" alt="">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>

                <div class="bisnis mt-5">
                    <h5 class="text-start mb-0">Buku Bisnis</h5>
                    <p class="text-start mb-0">Dapatkan wawasan dari para ahli untuk mengembangkan karir dan membangun
                        bisnis
                        sukses</p>

                    <div class="swiper mySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($bisnises as $buku)
                                <div class="swiper-slide">
                                    <div class="book-card">
                                        <img src="{{ $buku->foto }}" alt="">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20, // Jarak antar buku
            loop: true, // Looping carousel
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                }, // Tambahkan koma di sini ✅
                480: {
                    slidesPerView: 1
                },
                640: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 4
                },
                1280: {
                    slidesPerView: 5
                }
            }

        });
    </script>
</body>

</html>

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
        /* Jumbotron Styling */
        .jumbotron {
            position: relative;
            background-image: url('assets/images/anggrek.jpg');
            background-size: cover;
            background-position: center;
            height: 400px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .jumbotron::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0));
            z-index: 1;
        }

        .jumbotron-container {
            position: relative;
            z-index: 2;
            padding: 2rem;
            color: white;
            width: 100%;
            text-align: center;
        }

        .jumbotron-container h1 {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .jumbotron-container p {
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
        }

        /* Responsive Jumbotron */
        @media (max-width: 768px) {
            .jumbotron-container h1 {
                font-size: 2rem;
            }

            .jumbotron-container p {
                font-size: 1rem;
            }

            .jumbotron-container .btn {
                font-size: 0.875rem;
                padding: 0.5rem 1.5rem;
            }
        }

        .active {
            color: #435ebe !important;
            font-weight: bold;
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
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-3 sticky-top">
        <div class="container">
            <!-- Logo Perpustakaan di kiri -->
            <a class="navbar-brand d-flex align-items-center" href="/">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#063A76"
                    class="bi bi-book-half me-2" viewBox="0 0 16 16">
                    <path
                        d="M8.5 2.687c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                </svg>
                <span class="fw-bold text-primary">Perpustakaan Digital</span>
            </a>

            <!-- Tombol untuk mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Content -->
            <div class="collapse navbar-collapse" id="navbarContent">
                <form class="d-flex mx-3" style="width: 30%;">
                    <div class="input-group">
                        <div class="position-relative w-100">
                            <input class="form-control rounded-pill py-2 ps-4 pe-5" type="search"
                                placeholder="Cari buku..." aria-label="Search">
                            <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#063A76"
                                    class="bi bi-search" viewBox="0 0 16 16">
                                    <path
                                        d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Menu di kanan search bar -->
                <div class="ms-auto d-flex align-items-center">
                    <ul class="navbar-nav me-2 mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="/">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Koleksi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Kategori</a>
                        </li>
                    </ul>

                    <a class="btn btn-primary rounded-pill px-4" href="#">Admin</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        {{-- Jumbotron --}}
        <div class="jumbotron mt-5">
            <div class="jumbotron-container">
                <h1 class="display-4 text-white">💡 Knowledge Starts Here! </h1>
                <p class="lead">Raih keunggulan akademik dengan akses ke 1.000+ buku teks, jurnal, dan materi. </p>
            </div>
        </div>

        {{-- Penerbit --}}
        <div class="penerbit py-5">
            <div class="swiper mySwiper2">
                <div class="swiper-wrapper bg-primary" style="width: 100%">
                    @foreach ($penerbits as $penerbit)
                        <div class="bg-light p-4 rounded h-100">
                            <h5 class="text-primary">{{ $penerbit->nama }}</h5>
                            <div class="mb-3">
                                <div>Gromedia Ristoka</div>
                                <div>Urama</div>
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="swiper-button-next-2"></div>
                <div class="swiper-button-prev-2"></div>
            </div>

        </div>

        {{-- Buku --}}
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
            <p class="text-start mb-0">Temukan tips dan strategi untuk mengembangkan potensi dan menjadi versi terbaik
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
            <p class="text-start mb-0">Pelajari teknologi terkini dengan panduan praktis tentang pemrograman, jaringan,
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
            <p class="text-start mb-0">Dapatkan wawasan dari para ahli untuk mengembangkan karir dan membangun bisnis
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

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 20, // Jarak antar buku
            loop: true, // Looping carousel
            autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                }, // Tambahkan koma di sini ✅
                480: {
                    slidesPerView: 2
                },
                640: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 4
                },
                1024: {
                    slidesPerView: 5
                },
                1280: {
                    slidesPerView: 6
                }
            }

        });

        var swiper2 = new Swiper(".mySwiper2", {
            slidesPerView: 1,
            spaceBetween: 20, // Jarak antar buku
            loop: true, // Looping carousel
            autoplay: {
                delay: 3000,
            },
            navigation: {
                nextEl: ".swiper-button-next-2",
                prevEl: ".swiper-button-prev-2",
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                }, // Tambahkan koma di sini ✅
                480: {
                    slidesPerView: 2
                },
                640: {
                    slidesPerView: 3
                },
                768: {
                    slidesPerView: 4
                },
                1024: {
                    slidesPerView: 5
                },
                1280: {
                    slidesPerView: 6
                }
            }

        });
    </script>
</body>

</html>

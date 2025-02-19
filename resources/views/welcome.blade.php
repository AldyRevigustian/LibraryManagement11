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
    <div class="container">
        <div class="rekomendasi mt-5">
            <h5 class="text-start mb-0">Rekomendasi Buku</h5>
            <p class="text-start mb-0">Temukan inspirasi baca kamu!</p>

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
            <p class="text-start mb-0">Temukan inspirasi baca kamu!</p>

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
            <p class="text-start mb-0">Temukan inspirasi baca kamu!</p>

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
            <p class="text-start mb-0">Temukan inspirasi baca kamu!</p>

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
            <p class="text-start mb-0">Temukan inspirasi baca kamu!</p>

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
            <p class="text-start mb-0">Temukan inspirasi baca kamu!</p>

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
    </script>
</body>

</html>

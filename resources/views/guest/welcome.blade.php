@extends('layouts.guest')

@push('style')
    <style>
        .book-card {
            position: relative;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .book-card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
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
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0));
        }

        .book-category {
            align-self: center;
            background-color: rgba(6, 58, 118, 0.7);
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
            transition: opacity 0.3s ease;
        }

        .swiper-slide {
            display: flex;
            height: 320px;
            justify-content: center;
        }

        .swiper-button-next,
        .swiper-button-prev {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            transition: background-color 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background-color: rgba(0, 0, 0, 0.8);
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px;
            font-weight: bold;
        }

        .swiper-container-wrapper {
            position: relative;
            min-height: 352px;
            margin-bottom: 20px;
        }

        .swiper-loading {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 10;
            border-radius: 8px;
        }

        .swiper.loaded {
            opacity: 1;
        }

        .swiper:not(.loaded) {
            opacity: 0;
        }

        a[style="text-decoration: underline;"] {
            color: #063A76;
            font-weight: 600;
            text-decoration: none !important;
            position: relative;
            transition: color 0.4s ease;
        }

        a[style="text-decoration: underline;"]:hover {
            color: #0a51a9;
        }

        a[style="text-decoration: underline;"] p {
            position: relative;
            display: inline-block;
            margin: 0;
            padding: 2px 0;
        }

        a[style="text-decoration: underline;"] p::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            bottom: -2px;
            left: 0;
            background-color: #063A76;
            transform: scaleX(0.3);
            opacity: 0.7;
            transform-origin: right;
            transition: transform 0.5s ease, opacity 0.4s ease;
        }

        a[style="text-decoration: underline;"]:hover p::after {
            transform: scaleX(1);
            opacity: 1;
            transform-origin: right;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="mt-5"
            style="height: 250px; width: 1140px; background-image: url('{{ asset('assets/images/banner.png') }}'); background-size: cover; background-position: center; border-radius: 10px; display: flex; justify-content: center; align-items: center; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);">
        </div>


        <div class="rekomendasi mt-5">
            <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: flex-end;">
                <div class="section-header">
                    <h5 class="text-start mb-0">Rekomendasi Buku</h5>
                    <p class="text-start mb-0">Pilihan buku terbaik dari berbagai kategori khusus untuk kamu</p>
                </div>
                <div>
                    <a href="/buku/" style="text-decoration: underline;">
                        <p class="mb-0">Lihat Semua</p>
                    </a>
                </div>
            </div>
            <div class="swiper-container-wrapper">
                <div class="swiper-loading" id="loading-rekomendasi">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="swiper mySwiper" id="swiper-rekomendasi">
                    <div class="swiper-wrapper">
                        @foreach ($bukus as $buku)
                            <div class="swiper-slide">
                                <div class="book-card">
                                    <a href="/buku/detail/{{ $buku->id }}">
                                        <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image"
                                            data-category="rekomendasi">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </a>
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

        <div class="fiksi mt-4">
            <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: flex-end;">
                <div class="section-header">
                    <h5 class="text-start mb-0">Buku Fiksi</h5>
                    <p class="text-start mb-0">Jelajahi dunia imajinasi dengan kisah-kisah menarik
                        dan karakter yang menginspirasi</p>
                </div>
                <div>
                    <a href="/kategori/2" style="text-decoration: underline;">
                        <p class="mb-0">Lihat Semua</p>
                    </a>
                </div>
            </div>

            <div class="swiper-container-wrapper">
                <div class="swiper-loading" id="loading-fiksi">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="swiper mySwiper" id="swiper-fiksi">
                    <div class="swiper-wrapper">
                        @foreach ($fiksis as $buku)
                            <div class="swiper-slide">
                                <div class="book-card">
                                    <a href="/buku/detail/{{ $buku->id }}">
                                        <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image"
                                            data-category="fiksi">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </a>
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

        <div class="komik mt-4">
            <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: flex-end;">
                <div class="section-header">
                    <h5 class="text-start mb-0">Buku Komik</h5>
                    <p class="text-start mb-0">Nikmati cerita bergambar dengan karakter ikonik dan petualangan seru</p>
                </div>
                <div>
                    <a href="/kategori/21" style="text-decoration: underline;">
                        <p class="mb-0">Lihat Semua</p>
                    </a>
                </div>
            </div>

            <div class="swiper-container-wrapper">
                <div class="swiper-loading" id="loading-komik">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="swiper mySwiper" id="swiper-komik">
                    <div class="swiper-wrapper">
                        @foreach ($komiks as $buku)
                            <div class="swiper-slide">
                                <div class="book-card">
                                    <a href="{{ route('guest.detail_buku', $buku->id) }}">
                                        <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image"
                                            data-category="komik">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </a>
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

        <div class="pengembangan mt-4">
            <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: flex-end;">
                <div class="section-header">
                    <h5 class="text-start mb-0">Buku Pengembangan Diri</h5>
                    <p class="text-start mb-0">Temukan tips dan strategi untuk mengembangkan potensi dan menjadi versi
                        terbaik dirimu</p>
                </div>
                <div>
                    <a href="/kategori/8" style="text-decoration: underline;">
                        <p class="mb-0">Lihat Semua</p>
                    </a>
                </div>
            </div>

            <div class="swiper-container-wrapper">
                <div class="swiper-loading" id="loading-pengembangan">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="swiper mySwiper" id="swiper-pengembangan">
                    <div class="swiper-wrapper">
                        @foreach ($pengembangans as $buku)
                            <div class="swiper-slide">
                                <div class="book-card">
                                    <a href="/buku/detail/{{ $buku->id }}">
                                        <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image"
                                            data-category="pengembangan">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </a>
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

        <div class="bisnis mt-4">
            <div style="display: flex; flex-direction: row; justify-content: space-between; align-items: flex-end;">
                <div class="section-header">
                    <h5 class="text-start mb-0">Buku Bisnis</h5>
                    <p class="text-start mb-0">Dapatkan wawasan dari para ahli untuk mengembangkan karir dan membangun
                        bisnis sukses</p>
                </div>
                <div>
                    <a href="/kategori/13" style="text-decoration: underline;">
                        <p class="mb-0">Lihat Semua</p>
                    </a>
                </div>
            </div>

            <div class="swiper-container-wrapper">
                <div class="swiper-loading" id="loading-bisnis">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <div class="swiper mySwiper" id="swiper-bisnis">
                    <div class="swiper-wrapper">
                        @foreach ($bisnises as $buku)
                            <div class="swiper-slide">
                                <div class="book-card">
                                    <a href="/buku/detail/{{ $buku->id }}">
                                        <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image"
                                            data-category="bisnis">
                                        <div class="book-overlay-container">
                                            <div class="book-overlay">
                                                <div class="book-category">{{ $buku->kategori->nama }}</div>
                                                <div class="book-title">{{ $buku->judul }}</div>
                                                <div class="book-author">{{ $buku->kontributor }}</div>
                                            </div>
                                        </div>
                                    </a>
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
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Daftar semua kategori buku
            const categories = ['rekomendasi', 'fiksi', 'komik', 'pengembangan', 'komputer', 'bisnis'];

            // Untuk setiap kategori, inisialisasi Swiper setelah gambar dimuat
            categories.forEach(category => {
                initializeCategory(category);
            });

            function initializeCategory(category) {
                const images = document.querySelectorAll(`.book-image[data-category="${category}"]`);
                const loadingElement = document.getElementById(`loading-${category}`);
                const swiperElement = document.getElementById(`swiper-${category}`);

                let imagesLoaded = 0;
                const totalImages = images.length;

                // Function untuk menginisialisasi Swiper dan menampilkan konten
                function initSwiper() {
                    // Sembunyikan loading
                    if (loadingElement) loadingElement.style.display = 'none';

                    // Tampilkan Swiper
                    if (swiperElement) {
                        swiperElement.classList.add('loaded');

                        // Inisialisasi Swiper untuk kategori ini
                        new Swiper(`#swiper-${category}`, {
                            slidesPerView: 1,
                            spaceBetween: 20,
                            loop: true,
                            navigation: {
                                nextEl: `#swiper-${category} .swiper-button-next`,
                                prevEl: `#swiper-${category} .swiper-button-prev`,
                            },
                            breakpoints: {
                                320: {
                                    slidesPerView: 1
                                },
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
                    }
                }

                if (totalImages === 0) {
                    initSwiper();
                    return;
                }

                images.forEach(img => {
                    if (img.complete) {
                        imagesLoaded++;
                        if (imagesLoaded === totalImages) {
                            initSwiper();
                        }
                    } else {
                        img.addEventListener('load', () => {
                            imagesLoaded++;
                            if (imagesLoaded === totalImages) {
                                initSwiper();
                            }
                        });

                        img.addEventListener('error', () => {
                            imagesLoaded++;
                            if (imagesLoaded === totalImages) {
                                initSwiper();
                            }
                        });
                    }
                });

                setTimeout(() => {
                    if (!swiperElement.classList.contains('loaded')) {
                        initSwiper();
                    }
                }, 5000);
            }
        });
    </script>
@endpush

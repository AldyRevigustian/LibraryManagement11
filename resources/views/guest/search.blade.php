@extends('layouts.guest')
@push('style')
    <style>
        .book-card {
            position: relative;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            height: 320px;
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

        .books-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            margin-top: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .books-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 992px) {
            .books-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .books-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .books-grid {
                grid-template-columns: 1fr;
            }
        }

        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
        }

        .books-grid.loading {
            display: none;
        }

        .pagination {
            margin-top: 30px;
        }

        .page-item.active .page-link {
            background-color: #063A76;
            border-color: #063A76;
        }

        .page-link {
            color: #063A76;
        }

        .page-link:hover {
            color: #042858;
        }

        .pagination-info {
            text-align: center;
            margin-top: 10px;
            color: #6c757d;
            font-size: 0.9rem;
        }

        #error {
            background-color: #ebf3ff;
            min-height: 100vh;
            padding: 2rem 0;
        }

        .img-error {
            height: 435px;
            -o-object-fit: contain;
            object-fit: contain;
            padding: 3rem 0;
        }

        .error-title {
            margin-top: 10px;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="rekomendasi mt-5">
            <div>
                <div class="section-header">
                    @if ($query == 'ALL')
                        <h4 class="text-start mb-0">Menampilkan Semua Buku</h4>
                        <p class="text-start mb-0">Tingkatkan literasi membacamu hari ini!</p>
                    @else
                        <h4 class="text-start mb-0">Menampilkan hasil untuk "{{ $query }}"</h4>
                        <p class="text-start mb-0">Tingkatkan literasi membacamu hari ini!</p>
                    @endif
                </div>
            </div>

            <div id="loadingSpinner" class="loading-container">
                <div class="spinner-border text-primary loading-spinner" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            @if (count($bukus) == 0)
                <div class="d-flex justify-content-center align-items-center flex-column" style="min-height: 70vh;">
                    <img class="img-error" src="/assets/images/samples/error-500.svg" alt="Not Found" />
                    <h3 class="error-title">Buku Tidak Ditemukan 😓</h3>
                </div>
            @endif
            <div id="booksGrid" class="books-grid loading">
                @foreach ($bukus as $buku)
                    <div class="book-card">
                        <a href="/buku/detail/{{ $buku->id }}">
                            <img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image">
                            <div class="book-overlay-container">
                                <div class="book-overlay">
                                    <div class="book-category">{{ $buku->kategori->nama }}</div>
                                    <div class="book-title">{{ $buku->judul }}</div>
                                    <div class="book-author">{{ $buku->kontributor }}</div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $bukus->withQueryString()->links('pagination::bootstrap-5') }}
            </div>

            <!-- Informasi showing results di bawah pagination -->
            <div class="pagination-info mt-2">
                Showing {{ $bukus->firstItem() }} to {{ $bukus->lastItem() }} of {{ $bukus->total() }} results
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const loadingSpinner = document.getElementById('loadingSpinner');
            const booksGrid = document.getElementById('booksGrid');
            const bookImages = document.querySelectorAll('.book-image');

            let imagesLoaded = 0;
            const totalImages = bookImages.length;

            function showBooks() {
                loadingSpinner.style.display = 'none';
                booksGrid.classList.remove('loading');
            }

            if (totalImages === 0) {
                showBooks();
            } else {
                bookImages.forEach(img => {
                    if (img.complete) {
                        imagesLoaded++;
                        if (imagesLoaded === totalImages) {
                            showBooks();
                        }
                    } else {
                        img.addEventListener('load', () => {
                            imagesLoaded++;
                            if (imagesLoaded === totalImages) {
                                showBooks();
                            }
                        });

                        img.addEventListener('error', () => {
                            imagesLoaded++;
                            if (imagesLoaded === totalImages) {
                                showBooks();
                            }
                        });
                    }
                });
                setTimeout(showBooks, 5000);
            }
        });
    </script>
@endpush

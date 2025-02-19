<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .book-card {
            position: relative;
            width: 100%;
            height: 320px;
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

        @media (min-width: 1200px) {
            .col-xl-5th {
                flex: 0 0 20%;
                max-width: 20%;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <h2 class="text-center mb-4">Daftar Buku</h2>
        <div class="row">
            @foreach ($bukus as $buku)
                <div class="col-6 col-sm-4 col-md-2 col-lg-2 col-xl-5th mb-4">
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

    </div>
</body>

</html>

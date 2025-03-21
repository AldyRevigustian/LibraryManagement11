@extends('layouts.guest')

@push('style')
    <style>
        .penerbit-card {
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            background: white;
            position: relative;
        }

        .penerbit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .penerbit-img-container {
            height: 100px;
            overflow: hidden;
            position: relative;
        }

        .penerbit-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .penerbit-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            align-items: center;
            justify-content: start;
            padding: 1rem;
        }

        .penerbit-name {
            color: white;
            font-weight: bold;
            width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        @media (min-width: 1200px) {
            .col-lg-1-6 {
                flex: 0 0 16.6667%;
                max-width: 16.6667%;
            }
        }

        .kategori-header {
            border-left: 4px solid #dc3545;
            padding-left: 1rem;
        }

        .card {
            height: 70px;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            transition: all 0.3s ease;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            background: white;
            position: relative;
            border-left: 10px solid #198754;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }
    </style>
@endpush

@section('content')
    <div class="container ">
        <div class="penerbit-section mt-5">
            <div class="section-header">
                <h4 class="text-start mb-0">Penerbit Terkenal</h4>
                <p class="text-start mb-0">Tingkatkan literasi membacamu hari ini!</p>
            </div>

            <div class="row mt-4">
                @foreach ($penerbits as $penerbit)
                    <div class="col-lg-1-7 col-md-3 col-sm-6 col-12 mb-4">
                        <a href="/kategori/penerbit/{{ $penerbit->id }}">
                            <div class="penerbit-card">
                                <div class="penerbit-img-container">
                                    <img src="{{ $penerbit->logo }}"
                                    {{-- <img src="{{ asset('assets/images/' . $penerbit->id . '.jpg') }}" --}}
                                        alt="{{ $penerbit->nama }}" class="img-fluid">
                                    <div class="penerbit-overlay">
                                        <div class="kategori-header">
                                            <div class="penerbit-name">
                                                {{ $penerbit->nama }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="kategori-section mt-4">
            <div class="section-header">
                <h4 class="text-start mb-0">Kategori</h4>
                <p class="text-start mb-0">Tingkatkan literasi membacamu hari ini!</p>
            </div>

            <div class="row mt-4">
                @foreach ($kategoris as $kategori)
                    <div class="col-lg-1-6 col-md-3 col-sm-6 col-12 mb-4">
                        <a href="/kategori/{{ $kategori->id }}">
                            <div class="card p-3 text-start fw-bold text-dark mb-0" style="font-size: 16px;">
                                {{ $kategori->nama }}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

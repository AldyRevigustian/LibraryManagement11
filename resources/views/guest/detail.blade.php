@extends('layouts.guest')

@push('style')
@endpush

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4">
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <img src="{{ $buku->foto }}" alt="Cover Buku" class="img-fluid rounded"
                        style="object-fit: cover; height: 100%; max-height: 400px;">
                </div>
                <div class="col-md-8">
                    <h1 class="fw-bold">{{ $buku->judul }}</h1>
                    <h5 class="text-muted">Oleh: {{ $buku->kontributor }}</h5>
                    <hr>
                    <p><strong>Penerbit:</strong> {{ $buku->penerbit->nama }}</p>
                    <p><strong>Kategori:</strong> {{ $buku->kategori->nama }}</p>
                    <p><strong>ISBN:</strong> {{ $buku->isbn }}</p>
                    <p><strong>Stok:</strong> {{ $buku->stok }}</p>
                    <p><strong>Tahun Terbit:</strong> {{ $buku->tahun_terbit }}</p>
                    <p><strong>Deskripsi Fisik:</strong> {{ $buku->deskripsi_fisik }}</p>
                    <p><strong>Deskripsi:</strong> {{ $buku->deskripsi }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush

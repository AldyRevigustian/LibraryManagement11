@extends('layouts.guest')

@push('style')
@endpush

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm p-4">
            <table class="table table-bordered" style="border-width: 2px;">
                <tbody>
                    <tr>
                        <td rowspan="7" class="text-center p-3 bg-light"
                            style="width: 30%; vertical-align: middle; border: 2px solid #dee2e6;">
                            <img src="{{ $buku->foto }}" alt="Cover Buku" class="img-fluid rounded"
                                style="object-fit: cover; height: 100%; max-height: 400px;">
                        </td>
                        <td colspan="2" style="border: 2px solid #dee2e6; padding: 20px !important;">
                            <h1 class="fw-bold mb-0">{{ $buku->judul }}</h1>
                            <h5 class="text-muted">{{ $buku->kontributor }}</h5>
                            <a href="" class="text-decoration-none">
                                <div
                                    class="badge bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center p-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" class="me-2" style="stroke-width: 1.5;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"></path>
                                    </svg>
                                    <span class="text-capitalize"
                                        style="font-size: 18px;">{{ $buku->kategori->nama }}</span>
                                </div>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th style="border: 2px solid #dee2e6; vertical-align: middle;">ISBN</th>
                        <td style="border: 2px solid #dee2e6;">{{ $buku->ISBN }}</td>
                    </tr>
                    <tr>
                        <th style="border: 2px solid #dee2e6; vertical-align: middle;">Penerbit</th>
                        <td style="border: 2px solid #dee2e6;"><a href="">{{ $buku->penerbit->nama }}</a></td>
                    </tr>
                    <tr>
                        <th style="border: 2px solid #dee2e6; vertical-align: middle;">Kategori</th>
                        <td style="border: 2px solid #dee2e6;">{{ $buku->kategori->nama }}</td>
                    </tr>
                    <tr>
                        <th style="border: 2px solid #dee2e6; vertical-align: middle;">Stok di LKC</th>
                        <td style="border: 2px solid #dee2e6;">{{ $buku->stok }}</td>
                    </tr>
                    <tr>
                        <th style="border: 2px solid #dee2e6; vertical-align: middle;">Tahun Terbit</th>
                        <td style="border: 2px solid #dee2e6;">{{ $buku->tahun_terbit }}</td>
                    </tr>
                    <tr>
                        <th style="border: 2px solid #dee2e6; vertical-align: middle;">Deskripsi Fisik</th>
                        <td style="border: 2px solid #dee2e6;">{{ $buku->deskripsi_fisik }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="px-5 py-4" style="border: 2px solid #dee2e6;">
                            <h5 style="color: #607080;">Deskripsi</h5>
                            {!! nl2br(e($buku->deskripsi)) !!}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('script')
@endpush

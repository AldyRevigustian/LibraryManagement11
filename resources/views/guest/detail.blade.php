@extends('layouts.guest')
@push('style')
    <style>
        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        .content-wrapper {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 300px;
            right: 0;
            overflow-y: scroll;
            padding-bottom: 70px;
        }

        .scroll-content {
            position: relative;
            min-height: 100%;
        }

        .container {
            max-width: 100%;
            padding: 0 24px;
        }

        .sticky-footer {
            position: fixed;
            bottom: 0;
            left: 300px;
            right: 0;
            background: white;
            padding: 12px 24px;
            border-top: 2px solid #e5e7eb;
            z-index: 1000;
            display: flex;
            gap: 12px;
            margin-right: 0;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 12px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .share-btn {
            flex: 1;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .share-btn:hover {
            background: #f3f4f6;
        }

        .save-btn {
            flex: 1;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .save-btn:hover {
            background: #f3f4f6;
        }

        .borrow-btn {
            flex: 2;
        }

        @media (max-width: 768px) {
            .content-wrapper {
                left: 0;
            }

            .sticky-footer {
                left: 0;
                padding: 12px 16px;
            }

            .container {
                padding: 0 16px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="scroll-content">
            <div class="container mt-4">
                <div class="card shadow-sm p-4">
                    <table class="table table-bordered" style="border-width: 2px;">
                        <tbody>
                            <tr>
                                <td rowspan="7" class="text-center p-3 bg-light"
                                    style="width: 35%; vertical-align: middle; border: 2px solid #dee2e6;">
                                    <img src="{{ $buku->foto }}" alt="Cover Buku" class="img-fluid rounded"
                                        style="object-fit: cover; height: 100%; max-height: 400px;">
                                </td>
                                <td colspan="2" style="border: 2px solid #dee2e6; padding: 20px !important;">
                                    <h2 class="fw-bold mb-0">{{ $buku->judul }}</h2>
                                    <h6 class="text-muted">{{ $buku->kontributor }}</h6>
                                    <a href="/kategori/{{ $buku->kategori_id }}" class="text-decoration-none">
                                        <div
                                            class="badge bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center p-2 rounded">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-2"
                                                style="stroke-width: 1.5;">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 6h.008v.008H6V6Z"></path>
                                            </svg>
                                            <span class="text-capitalize"
                                                style="font-size: 14px;">{{ $buku->kategori->nama }}</span>
                                        </div>
                                        </>
                                </td>
                            </tr>
                            <tr>
                                <th style="border: 2px solid #dee2e6; vertical-align: middle;">ISBN</th>
                                <td style="border: 2px solid #dee2e6;">{{ $buku->ISBN }}</td>
                            </tr>
                            <tr>
                                <th style="border: 2px solid #dee2e6; vertical-align: middle;">Penerbit</th>
                                <td style="border: 2px solid #dee2e6;"><a
                                        href="/kategori/penerbit/{{ $buku->penerbit_id }}">{{ $buku->penerbit->nama }}</a>
                                </td>
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
        </div>
        <div class="sticky-footer">
            <button class="action-btn share-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
                Bagikan buku ini
            </button>

            <button class="action-btn save-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                </svg>
                Simpan
            </button>

            <button class="action-btn borrow-btn btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Pinjam buku ini
            </button>
        </div>
    </div>
@endsection

@push('script')
@endpush

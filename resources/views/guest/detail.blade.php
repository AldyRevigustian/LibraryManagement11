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
            /* background: white; */
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
            flex: 1 !important;
            border: 1px solid #e5e7eb;
            color: #374151;
        }

        .save-btn-active {
            flex: 1 !important;
            background-color: #435EBE;
            color: white;
            border: 0;
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

        .modal-dialog {
            max-width: 600px;
            margin: 1.75rem auto;
        }

        @media (max-width: 576px) {
            .modal-dialog {
                max-width: 90%;
                margin: 1rem auto;
            }
        }

        .social-icon {
            width: 48px;
            height: 48px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .social-icon:hover {
            transform: scale(1.1);
        }

        .copy-link {
            background-color: #f8f9fa;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 14px;
        }

        .copy-button {
            background-color: #f8f9fa;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        form {
            display: contents !important;
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
                                    <h6 class="text-muted mt-2">{{ $buku->kontributor }}</h6>
                                    <a href="/kategori/{{ $buku->kategori_id }}" class="text-decoration-none">
                                        <div
                                            class="badge bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center p-2 rounded">
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
        <div class="sticky-footer bg-white">
            <button type="button" class="action-btn share-btn" data-bs-toggle="modal" data-bs-target="#shareModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                </svg>
                Bagikan buku ini
            </button>
            @if (Auth::guard('anggota')->check())
                @if ($is_favorite == true)
                    <form action="{{ route('anggota.favorite_delete', $buku->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <button class="action-btn save-btn-active" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            Tersimpan
                        </button>
                    </form>
                @else
                    <form action="{{ route('anggota.favorite_add', $buku->id) }}" method="POST">
                        @method('POST')
                        @csrf
                        <button class="action-btn save-btn" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                            </svg>
                            Simpan
                        </button>
                    </form>
                @endif
            @else
                <form action="{{ route('anggota.favorite_add', $buku->id) }}" method="POST">
                    @method('POST')
                    @csrf
                    <button class="action-btn save-btn" type="submit">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
                        </svg>
                        Simpan
                    </button>
                </form>
            @endif
            <button class="action-btn borrow-btn btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Pinjam buku ini
            </button>
        </div>
    </div>

    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-bottom pb-3">
                    <p class="modal-title d-flex align-items-center gap-2" id="shareModalLabel"
                        style="font-size: 14px; color: black;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Yuk, bagikan buku ini!
                    </p>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="d-flex justify-content-center gap-4 mb-4">
                        <div class="text-center">
                            <img src="https://perpustakaan.jakarta.go.id/assets/img/social-media/Whatsapp.svg"
                                alt="WhatsApp" class="social-icon mb-2">
                            <span class="d-block small">WhatsApp</span>
                        </div>
                        <div class="text-center">
                            <img src="https://perpustakaan.jakarta.go.id/assets/img/social-media/Facebook.svg"
                                alt="Facebook" class="social-icon mb-2">
                            <span class="d-block small">Facebook</span>
                        </div>
                        <div class="text-center">
                            <img src="https://perpustakaan.jakarta.go.id/assets/img/social-media/X.svg" alt="X"
                                class="social-icon mb-2">
                            <span class="d-block small">X</span>
                        </div>
                        <div class="text-center">
                            <img src="https://perpustakaan.jakarta.go.id/assets/img/social-media/Telegram.svg"
                                alt="Telegram" class="social-icon mb-2">
                            <span class="d-block small">Telegram</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="fw-medium mb-2">Salin tautan:</label>
                        <div class="d-flex gap-2">
                            <div class="copy-link flex-grow-1">
                                {{ url()->current() }}
                            </div>
                            <button class="copy-button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 01-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 011.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 00-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 01-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 00-3.375-3.375h-1.5a1.125 1.125 0 01-1.125-1.125v-1.5a3.375 3.375 0 00-3.375-3.375H9.75" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        // Add click handlers for social sharing
        function shareToSocialMedia(platform, title, url) {
            const text = encodeURIComponent(title);
            const shareUrl = encodeURIComponent(url);

            let shareLink = '';
            switch (platform) {
                case 'whatsapp':
                    shareLink = `https://wa.me/?text=${text}%20${shareUrl}`;
                    break;
                case 'facebook':
                    shareLink = `https://www.facebook.com/sharer/sharer.php?u=${shareUrl}`;
                    break;
                case 'x':
                    shareLink = `https://twitter.com/intent/tweet?text=${text}&url=${shareUrl}`;
                    break;
                case 'telegram':
                    shareLink = `https://t.me/share/url?url=${shareUrl}&text=${text}`;
                    break;
            }

            window.open(shareLink, '_blank');
        }

        // Add click handler for copy button
        document.querySelector('.copy-button').addEventListener('click', function() {
            const link = document.querySelector('.copy-link').textContent.trim();
            navigator.clipboard.writeText(link).then(() => {
                alert('Link copied to clipboard!');
            });
        });
    </script>
@endpush

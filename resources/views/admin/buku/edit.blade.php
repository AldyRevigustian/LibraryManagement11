@extends('layouts.admin')

@include('components.admin')

@push('style')
    <style>
        /* Modal styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 50px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.8);
            text-align: center;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 90%;
            width: auto;
            height: auto;
        }

        .close {
            position: absolute;
            top: 15px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: red;
        }

        .image-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        #imagePreview {
            width: 213px;
            height: 320px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            background-color: #f8f8f8;
        }
    </style>
@endpush

@section('content')
    <section class="section mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Buku</h5>
                    </div>
                    <hr class="mt-4 mb w-100">
                </div>
            </div>

            @include('components.message')
            <div class="card-body">
                <form class="form" action="{{ route('admin.buku_update', $buku->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="ISBN" class="form-label">ISBN</label>
                                <input type="text" id="ISBN"
                                    class="form-control @error('ISBN') is-invalid @enderror" placeholder="ISBN"
                                    name="ISBN" value="{{ $buku->ISBN }}" required autocomplete="ISBN">
                                @error('ISBN')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="judul-column" class="form-label">Judul</label>
                                <input type="text" id="judul-column"
                                    class="form-control @error('judul') is-invalid @enderror" placeholder="Judul"
                                    name="judul" value="{{ $buku->judul }}" required autocomplete="judul">
                                @error('judul')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="kontributor-column" class="form-label">Kontributor</label>
                                <input type="text" id="kontributor-column"
                                    class="form-control @error('kontributor') is-invalid @enderror"
                                    placeholder="Kontributor" name="kontributor" value="{{ $buku->kontributor }}" required
                                    autocomplete="kontributor">
                                @error('kontributor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="stok-column" class="form-label">Stok</label>
                                <input type="number" id="stok-column"
                                    class="form-control @error('stok') is-invalid @enderror" placeholder="Stok"
                                    name="stok" value="{{ $buku->stok }}" required autocomplete="stok">
                                @error('stok')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="tahun_terbit-column" class="form-label">Tahun terbit</label>
                                <input type="text" id="tahun_terbit-column"
                                    class="form-control @error('tahun_terbit') is-invalid @enderror"
                                    placeholder="Tahun terbit" name="tahun_terbit" value="{{ $buku->tahun_terbit }}"
                                    required autocomplete="tahun_terbit">
                                @error('tahun_terbit')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="kategori-column" class="form-label">Kategori</label>
                                <select name="kategori_id" class="choices form-select">
                                    <option value="" disabled>
                                        --Pilih Kategori--</option>
                                    @foreach ($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}"
                                            {{ $kategori->id == $buku->kategori_id ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="penerbit-column" class="form-label">Penerbit</label>
                                <select name="penerbit_id" class="choices form-select">
                                    <option value="" disabled>
                                        --Pilih Penerbit--</option>
                                    @foreach ($penerbits as $penerbit)
                                        <option value="{{ $penerbit->id }}"
                                            {{ $penerbit->id == $buku->penerbit_id ? 'selected' : '' }}>
                                            {{ $penerbit->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="deskripsi_fisik-column" class="form-label">Deskripsi Fisik</label>
                                <input type="text" id="deskripsi_fisik-column"
                                    class="form-control @error('deskripsi_fisik') is-invalid @enderror"
                                    placeholder="Deskripsi Fisik" name="deskripsi_fisik"
                                    value="{{ $buku->deskripsi_fisik }}" required autocomplete="deskripsi_fisik">
                                @error('deskripsi_fisik')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group mandatory">
                                <label for="deskripsi-column" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi-column" placeholder="Deskripsi"
                                    name="deskripsi" required autocomplete="deskripsi" rows="5">{{ $buku->deskripsi }}</textarea>
                                @error('deskripsi')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group mandatory">
                                <div class="form-group mandatory">
                                    <label for="inputGroupFile" class="form-label">Upload Cover</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                            id="inputGroupFile" name="foto" aria-describedby="inputGroupFileAddon04"
                                            aria-label="Upload" onchange="previewImage(event)" accept="image/*"
                                            value="{{ $buku->foto }}" />
                                        @error('foto')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="image-container mt-3">
                                        <img id="imagePreview" src="{{ $buku->foto }}" alt="Preview"
                                            onclick="openFullImage()" />
                                    </div>
                                </div>

                            </div>

                            <div id="imageModal" class="modal" onclick="closeFullImage()">
                                <span class="close">&times;</span>
                                <img class="modal-content" id="fullImagePreview">
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                    Reset
                                </button>
                                <button type="submit" class="btn btn-primary me-1 mb-1">
                                    Submit
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </section>

    @push('script')
        <script>
            function previewImage(event) {
                var input = event.target;
                var reader = new FileReader();

                reader.onload = function() {
                    var imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = reader.result;
                    imagePreview.style.display = 'block';
                };

                if (input.files && input.files[0]) {
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function openFullImage() {
                var modal = document.getElementById('imageModal');
                var fullImage = document.getElementById('fullImagePreview');
                var previewImage = document.getElementById('imagePreview');

                fullImage.src = previewImage.src;
                modal.style.display = "block";
            }

            function closeFullImage() {
                document.getElementById('imageModal').style.display = "none";
            }
        </script>
    @endpush
@endsection

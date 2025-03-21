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
            width: 270px;
            height: 100px;
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
                        <h5 class="mb-0">Edit Penerbit</h5>
                    </div>
                    <hr class="mt-4 mb w-100">
                </div>
            </div>

            @include('components.message')
            <div class="card-body">
                <form class="form" action="{{ route('admin.penerbit_update', $penerbit->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="form-group mandatory">
                                <label for="name-column" class="form-label">Nama Penerbit</label>
                                <input type="text" id="name-column"
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Penerbit"
                                    name="nama" value="{{ $penerbit->nama }}" required autocomplete="nama">
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="form-group mandatory">
                                <div class="form-group mandatory">
                                    <label for="inputGroupFile" class="form-label">Upload Logo</label>
                                    <div class="input-group">
                                        <input type="file" class="form-control @error('logo') is-invalid @enderror"
                                            id="inputGroupFile" name="logo" aria-describedby="inputGroupFileAddon04"
                                            aria-label="Upload" onchange="previewImage(event)" accept="image/*"
                                            value="{{ $penerbit->logo }}" />
                                        @error('logo')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="image-container mt-5">
                                        <img id="imagePreview" src="{{ $penerbit->logo }}" alt="Preview"
                                            onclick="openFullImage()" />
                                    </div>
                                </div>

                            </div>

                            <div id="imageModal" class="modal" onclick="closeFullImage()">
                                <span class="close">&times;</span>
                                <img class="modal-content" id="fullImagePreview">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                Reset
                            </button>
                            <button type="submit" class="btn btn-primary me-1 mb-1">
                                Update
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

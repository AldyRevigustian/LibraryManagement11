@extends('layouts.guest')

@push('style')
    <style>
        .readonly {
            background-color: #efefef;
            pointer-events: none;
        }

        th {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <div class="container mt-4">
        <div class="page-heading">
            <section class="section mt-3">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Profil Anggota</h5>
                            </div>
                            <hr class="mt-4 mb w-100">
                        </div>
                    </div>
                    @include('components.message')

                    <div class="card-body text-start">
                        @php
                            $user = Auth::guard('anggota')->user();
                        @endphp
                        <form action="{{ route('anggota.profile_update', $user->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="d-flex justify-content-center">
                                <img id="previewFoto" src="{{ asset($user->foto) }}" alt=""
                                    style="width: 200px;height: 200px;object-fit: cover; margin-bottom: 24px"
                                    class="rounded-circle" onchange="previewImage(event)">

                            </div>
                            <table class="table">
                                <tr>
                                    <th>Foto Profil</th>
                                    <td>
                                        <input type="file" accept="image/*" name="foto" class="form-control"
                                            id="uploadFoto">
                                    </td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>
                                        <input readonly class="form-control readonly" type="text"
                                            value="{{ $user->nim }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Nama</th>
                                    <td>
                                        <input readonly class="form-control readonly" type="text"
                                            value="{{ $user->nama }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>
                                        <input readonly class="form-control readonly" type="email"
                                            value="{{ $user->email }}">
                                    </td>
                                </tr>
                                <tr>
                                    <th>Password</th>
                                    <td>
                                        <input class="form-control" type="password" name="password"
                                            autocomplete="new-password">
                                    </td>
                                </tr>
                            </table>
                            <div class="card-footer text-center d-flex justify-content-center gap-2">
                                <button class="btn btn-primary" type="submit">
                                    Update
                                </button>
                        </form>
                        <form action="{{ route('anggota.logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger">Logout</button>
                        </form>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('uploadFoto').addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('previewFoto').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endpush

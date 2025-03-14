@extends('layouts.admin')

@include('components.admin')

@push('style')
@endpush

@section('content')
    <section class="section mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Edit Admin</h5>
                    </div>
                    <hr class="mt-4 mb w-100">
                </div>
            </div>

            @include('components.message')
            <div class="card-body">
                <form class="form" action="{{ route('admin.administrator_update', $admin->id) }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="nama-column" class="form-label">Nama Lengkap</label>
                                <input type="text" id="nama-column"
                                    class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Lengkap"
                                    name="nama" value="{{ $admin->nama }}" required autocomplete="nama">
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Email"
                                    name="email"  value="{{ $admin->email }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" id="password"
                                    class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                                    name="password" value="" autocomplete="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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
    @endpush
@endsection

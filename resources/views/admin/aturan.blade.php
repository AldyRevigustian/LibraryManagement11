@extends('layouts.admin')
@include('components.admin')

@push('style')
@endpush

@section('content')
    <div class="container mt-2">
        <div class="page-heading">
            <section class="section mt-3">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                        <div class="d-flex flex-column w-100">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Aturan Aplikasi</h5>
                            </div>
                            <hr class="mt-4 mb w-100">
                        </div>
                    </div>
                    @include('components.message')

                    <div class="card-body text-start">
                        @php
                            $aturan = App\Models\Aturan::first();
                        @endphp
                        <form action="{{ route('admin.aturan_update') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Maksimal Peminjaman Buku (Jumlah)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mb-2 bi bi-book-half"></i></span>
                                    <input class="form-control" type="number" name="maksimal_buku"
                                        value="{{ $aturan->maksimal_buku }}" required min="1">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Batas Pengembalian (Hari)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mb-2 bi bi-calendar"></i></span>
                                    <input class="form-control" type="number" name="batas_pengembalian"
                                        value="{{ $aturan->batas_pengembalian }}" required min="1">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">
                                    Denda (Per hari)
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="mb-2 bi bi-currency-dollar"></i></span>
                                    <input class="form-control" type="number" name="denda" value="{{ $aturan->denda }}"
                                        required min="0">
                                </div>
                            </div>

                            <div class="card-footer text-center pb-0 mb-0">
                                <button class="btn btn-primary" type="submit">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

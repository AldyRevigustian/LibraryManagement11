@extends('layouts.admin')

@include('components.admin')

@push('style')
    <style>
        #table1 td,
        #table1 th {
            vertical-align: middle;
        }
    </style>
@endpush

@section('content')
    <section class="section mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">List Penerbit</h5>
                        <a href="{{ route('admin.penerbit_add') }}" class="btn btn-primary text-light w-auto">
                            <i class="bi bi-plus-lg"></i> Add
                        </a>
                    </div>
                    <hr class="mt-4 mb w-100">
                </div>
            </div>

            @include('components.message')
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th class="col-1">No.</th>
                            <th style="width:160px !important;">Logo</th>
                            <th>Nama</th>
                            <th class="col-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($penerbits as $key => $penerbit)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td style="width:160px !important;"><img src="{{ $penerbit->logo }}"
                                        alt="{{ $penerbit->nama }}" class="img-fluid"
                                        style="height: 50px; width:135px; border: 2px solid #6c757d44; object-fit: cover;">
                                </td>
                                <td>{{ $penerbit->nama }}</td>
                                <td>
                                    <a href="{{ route('admin.penerbit_edit', $penerbit->id) }}"
                                        class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>
                                    <form class="d-inline" method="POST"
                                        action="{{ route('admin.penerbit_destroy', $penerbit->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn icon btn-danger"><i
                                                class="bi bi-trash-fill"></i></a>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @push('script')
    @endpush
@endsection

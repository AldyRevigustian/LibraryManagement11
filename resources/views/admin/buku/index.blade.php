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
                        <h5 class="mb-0">List Buku</h5>
                        <a href="{{ route('admin.buku_add') }}" class="btn btn-primary text-light w-auto">
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
                            <th>No.</th>
                            <th class="col-1">ISBN</th>
                            <th class="col-3">Judul</th>
                            <th class="col-2">Kontributor</th>
                            <th class="col-1">Penerbit</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Tahun Terbit</th>
                            <th class="col-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bukus as $key => $buku)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $buku->ISBN }}</td>
                                <td>{{ $buku->judul }}</td>
                                <td>{{ $buku->kontributor }}</td>
                                <td>{{ $buku->penerbit->nama }}</td>
                                <td>{{ $buku->kategori->nama }}</td>
                                <td>{{ $buku->stok }}</td>
                                <td>{{ $buku->tahun_terbit }}</td>
                                <td>
                                    <a href="{{ route('admin.buku_edit', $buku->id) }}"
                                        class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>
                                    <form class="d-inline" method="POST"
                                        action="{{ route('admin.buku_destroy', $buku->id) }}">
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

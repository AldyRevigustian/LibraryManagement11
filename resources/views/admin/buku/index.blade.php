@extends('layouts.admin')

@include('components.admin')

@push('style')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        #table1 {
            width: 100%;
            border-collapse: collapse;
        }

        #table1 th,
        #table1 td {
            vertical-align: middle;
            white-space: nowrap;
        }

        #table1 th:nth-child(4),
        #table1 td:nth-child(4){
            white-space: normal;
            min-width: 300px;
            max-width: 300px;
            word-wrap: break-word;
        }

        #table1 th:nth-child(1) { width: 50px; }
        #table1 th:nth-child(2) { width: 120px; }
        #table1 th:nth-child(3) { width: 80px; }
        #table1 th:nth-child(6) { width: 120px; }
        #table1 th:nth-child(7) { width: 100px; }
        #table1 th:nth-child(8) { width: 70px; }
        #table1 th:nth-child(9) { width: 100px; }
        #table1 th:nth-child(10) { width: 120px; }

        .book-image {
            border-radius: 4px;
            border: 1px solid #ddd;
        }
    </style>
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
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>ISBN</th>
                                <th>Cover</th>
                                <th>Judul</th>
                                <th>Kontributor</th>
                                <th>Penerbit</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Tahun Terbit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bukus as $key => $buku)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $buku->ISBN }}</td>
                                    <td><img src="{{ $buku->foto }}" alt="{{ $buku->judul }}" class="book-image" style="height: 96px; width: 63px; object-fit: cover;"></td>
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
                                                    class="bi bi-trash-fill"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new DataTable('#table1', {
                scrollX: true
            });
        });
    </script>
@endpush

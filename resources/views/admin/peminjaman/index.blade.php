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

        #table1 th, #table1 td {
            padding: 0.75rem;
            vertical-align: middle;
            white-space: nowrap;
        }

        #table1 th:nth-child(3),
        #table1 td:nth-child(3),
        #table1 th:nth-child(5),
        #table1 td:nth-child(5) {
            white-space: normal;
            min-width: 250px;
            max-width: 300px;
            word-wrap: break-word;
        }

        #table1 th:nth-child(1) { width: 50px; }
        #table1 th:nth-child(2) { width: 100px; }
        #table1 th:nth-child(4) { width: 130px; }
        #table1 th:nth-child(6) { width: 150px; }
        #table1 th:nth-child(7) { width: 120px; }
    </style>
@endpush

@section('content')
    <section class="section mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">List Peminjaman</h5>
                        <a href="{{ route('admin.peminjaman_add') }}" class="btn btn-primary text-light w-auto">
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
                                <th>NIM</th>
                                <th>Nama Peminjam</th>
                                <th>ISBN Buku</th>
                                <th>Buku</th>
                                <th>Tanggal Peminjaman</th>
                                <th>Maksimal Pengembalian</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $key => $peminjaman)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $peminjaman->anggota->nim }}</td>
                                    <td>{{ $peminjaman->anggota->nama }}</td>
                                    <td>{{ $peminjaman->buku->ISBN }}</td>
                                    <td>{{ $peminjaman->buku->judul }}</td>
                                    <td>{{ $peminjaman->tanggal_peminjaman }}</td>
                                    <td>{{ $peminjaman->batas_pengembalian }}</td>
                                    <td>
                                        <a href="{{ route('admin.peminjaman_edit', $peminjaman->id) }}"
                                            class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>
                                        <form class="d-inline" method="POST"
                                            action="{{ route('admin.peminjaman_destroy', $peminjaman->id) }}">
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

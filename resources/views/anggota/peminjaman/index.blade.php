@extends('layouts.guest')

@push('style')
    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css">
    <style>
        div.dataTable-top {
            padding: 5px 0;
        }
    </style>
@endpush

@section('content')
    <section class="section" style="margin-top: 80px;">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">List Peminjaman</h5>
                        <a href="{{ route('anggota.peminjaman_add') }}" class="btn btn-primary text-light w-auto">
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
                            <th>ISBN Buku</th>
                            <th>Buku</th>
                            <th>Tanggal Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $key => $peminjaman)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $peminjaman->buku->ISBN }}</td>
                                <td>{{ $peminjaman->buku->judul }}</td>
                                <td>{{ $peminjaman->tanggal_peminjaman }}</td>
                                <td>
                                    {{-- <a href="{{ route('peminjaman.peminjaman_edit', $peminjaman->id) }}"
                                        class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>
                                    <form class="d-inline" method="POST"
                                        action="{{ route('peminjaman.peminjamanistrator_destroy', $admin->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn icon btn-danger"><i
                                                class="bi bi-trash-fill"></i></a>
                                    </form> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @push('script')
        <script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
        <script src="/assets/js/pages/simple-datatables.js"></script>
    @endpush
@endsection

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
                        <h5 class="mb-0">List Anggota</h5>
                        <a href="{{ route('admin.anggota_add') }}" class="btn btn-primary text-light w-auto">
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
                            <th class="col-1">NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th class="col-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggotas as $key => $anggota)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $anggota->nim }}</td>
                                <td>{{ $anggota->nama }}</td>
                                <td>{{ $anggota->email }}</td>
                                <td>
                                    <a href="{{ route('admin.anggota_edit', $anggota->id) }}"
                                        class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>

                                    <x-modal
                                        :action="route('admin.anggota_destroy', $anggota->id)"
                                        :id="$anggota->id"
                                        title="Konfirmasi Hapus Anggota"
                                    />
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

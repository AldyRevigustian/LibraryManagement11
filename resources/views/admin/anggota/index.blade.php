@extends('layouts.app')

@include('components.admin')

@push('style')
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
                            <th>NIM</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th class="action-table">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggotas as $key => $anggota)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $anggota->nim }}</td>
                                <td>{{ $anggota->name }}</td>
                                <td>{{ $anggota->email }}</td>
                                <td>
                                    <a href="{{ route('admin.anggota_edit', $anggota->id) }}"
                                        class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>
                                    <form class="d-inline" method="POST"
                                        action="{{ route('admin.anggota_destroy', $anggota->id) }}">
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

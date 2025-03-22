@extends('layouts.admin')

@include('components.admin')

@push('style')
    <style>
        #table1 th,
        #table1 td {
            vertical-align: middle;
            white-space: nowrap;
        }
    </style>
@endpush

@section('content')
    <section class="section mt-3">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap pb-0">
                <div class="d-flex flex-column w-100">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">List Admin</h5>
                        <a href="{{ route('admin.administrator_add') }}" class="btn btn-primary text-light w-auto">
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
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th class="col-1">Role</th>
                            <th class="col-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($admins as $key => $admin)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $admin->nama }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <span class="badge text-bg-{{ $admin->role == 'superadmin' ? 'primary' : 'secondary' }}"
                                        style="min-width: 120px">
                                        {{ Str::ucfirst($admin->role) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.administrator_edit', $admin->id) }}"
                                        class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>
                                    <x-modal :action="route('admin.administrator_destroy', $admin->id)" :id="$admin->id" title="Konfirmasi Hapus Admin" />
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

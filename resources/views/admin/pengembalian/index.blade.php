@extends('layouts.admin')

@include('components.admin')

@push('style')
    <style>
        .table-responsive {
            overflow-x: auto;
        }

        #table1 th,
        #table1 td {
            white-space: nowrap;
            vertical-align: middle;

        }

        #table1 td:nth-child(3),
        #table1 th:nth-child(3),
        #table1 td:nth-child(5),
        #table1 th:nth-child(5) {
            white-space: normal;
            min-width: 250px;
        }

        .badge {
            min-width: 110px;
        }
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
                                <th class="">Tanggal Peminjaman</th>
                                <th class="">Tanggal Pengembalian</th>
                                <th class="">Status</th>
                                <th class="">Denda</th>
                                <th style="">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $key => $peminjaman)
                                @php
                                    $tanggal_pinjam = \Carbon\Carbon::parse(
                                        $peminjaman->tanggal_peminjaman,
                                    )->startOfDay();
                                    $tanggal_kembali = \Carbon\Carbon::parse(
                                        $peminjaman->tanggal_pengembalian,
                                    )->startOfDay();
                                    $batas_kembali = \Carbon\Carbon::parse(
                                        $peminjaman->batas_pengembalian,
                                    )->startOfDay();
                                    $selisih = $tanggal_kembali->diffInDays($batas_kembali, false);
                                    $isTelat = $selisih < 0;

                                    $formatPeminjaman = \Carbon\Carbon::parse(
                                        $peminjaman->tanggal_peminjaman,
                                    )->translatedFormat('d F Y');
                                    $formatKembali = \Carbon\Carbon::parse(
                                        $peminjaman->tanggal_pengembalian,
                                    )->translatedFormat('d F Y');
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $peminjaman->anggota->nim }}</td>
                                    <td>{{ $peminjaman->anggota->nama }}</td>
                                    <td>{{ $peminjaman->buku->ISBN }}</td>
                                    <td>{{ $peminjaman->buku->judul }}</td>
                                    <td>{{ $formatPeminjaman }}</td>
                                    <td>{{ $formatKembali }}</td>

                                    <td>
                                        @php
                                            if ($isTelat) {
                                                $badge = 'text-bg-danger';
                                                $text = 'Telat ' . abs($selisih) . ' hari';
                                            } else {
                                                $badge = 'text-bg-success';
                                                $text = 'Tepat Waktu';
                                            }
                                        @endphp
                                        <span class="badge rounded-pill {{ $badge }}">
                                            {{ $text }}
                                        </span>
                                    </td>

                                    <td>
                                        {{ $peminjaman->denda ? 'Rp' . number_format($peminjaman->denda, 0, ',', '.') : '-' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.peminjaman_edit', $peminjaman->id) }}"
                                            class="btn icon btn-warning text-light"><i class="bi bi-pencil-fill"></i></a>
                                        <form class="d-inline" method="POST"
                                            action="{{ route('admin.peminjaman_destroy', $peminjaman->id) }}">
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
        </div>
    </section>
    @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new DataTable('#table1', {
                    scrollX: true,
                });
            });
        </script>
    @endpush
@endsection

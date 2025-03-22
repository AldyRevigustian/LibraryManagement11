@extends('layouts.guest')

@push('style')
    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css">
    <style>
        div.dataTable-top {
            padding: 5px 0;
        }

        #table1 td,
        #table1 th {
            vertical-align: middle;
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
                        @php
                            $count = count($peminjamans);
                        @endphp
                        <a href="{{ route('anggota.peminjaman_add') }}"
                            class="btn btn-primary text-light w-auto {{ $count >= $rule->maksimal_buku ? 'disabled' : '' }}">
                            <i class="bi bi-plus-lg"></i> Pinjam Buku
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
                            <th class="">Tanggal Peminjaman</th>
                            <th class="">Max. Pengembalian</th>
                            <th class="">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $key => $peminjaman)
                            @php
                                $tanggal_pinjam = \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->startOfDay();
                                $batas_kembali = \Carbon\Carbon::parse($peminjaman->batas_pengembalian)->startOfDay();
                                $selisih = $tanggal_pinjam->diffInDays($batas_kembali, false);
                                $isTelat = $selisih < 0;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $peminjaman->buku->ISBN }}</td>
                                <td>{{ $peminjaman->buku->judul }}</td>
                                <td>{{ $tanggal_pinjam->translatedFormat('d F Y') }}</td>
                                <td>{{ $batas_kembali->translatedFormat('d F Y') }}</td>
                                <td>
                                    @php
                                        if ($isTelat) {
                                            $badge = 'text-bg-danger';
                                            $text = 'Telat ' . abs($selisih) . ' hari';
                                        } elseif ($selisih == 0) {
                                            $badge = 'text-bg-warning';
                                            $text = 'Segera kembalikan';
                                        } elseif ($selisih <= 2) {
                                            $badge = 'text-bg-warning';
                                            $text = $selisih . ' hari lagi';
                                        } else {
                                            $badge = 'text-bg-success';
                                            $text = $selisih . ' hari lagi';
                                        }
                                    @endphp
                                    <span class="badge rounded-pill {{ $badge }}">
                                        {{ $text }}
                                    </span>
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

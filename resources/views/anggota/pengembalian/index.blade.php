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
                        <h5 class="mb-0">History Peminjaman</h5>
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
                            <th class="">Tanggal Pengembalian</th>
                            <th class="">Status</th>
                            <th class="">Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $key => $peminjaman)
                            @php
                                $tanggal_pinjam = \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->startOfDay();
                                $tanggal_kembali = \Carbon\Carbon::parse(
                                    $peminjaman->tanggal_pengembalian,
                                )->startOfDay();
                                $batas_kembali = \Carbon\Carbon::parse($peminjaman->batas_pengembalian)->startOfDay();
                                $selisih = $tanggal_kembali->diffInDays($batas_kembali, false);
                                $isTelat = $selisih < 0;
                            @endphp
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $peminjaman->buku->ISBN }}</td>
                                <td>{{ $peminjaman->buku->judul }}</td>
                                <td>{{ $tanggal_pinjam->translatedFormat('d F Y') }}</td>
                                <td>{{ $tanggal_kembali->translatedFormat('d F Y') }}</td>

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

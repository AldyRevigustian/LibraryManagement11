@extends('layouts.app')

@include('components.admin')

@section('content')
    <div class="col">
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-4 d-flex justify-content-center">
                                            <div class="stats-icon blue mb-2">
                                                <i class="bi-book-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Jumlah Buku</h6>
                                            {{-- <h6 class="font-extrabold mb-0">{{ count($bukus) }}</h6> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-4 d-flex justify-content-center">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">
                                                Jumlah Anggota
                                            </h6>
                                            {{-- <h6 class="font-extrabold mb-0">{{ count($anggotas) }}</h6> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-4 d-flex justify-content-center">
                                            <div class="stats-icon red mb-2">
                                                <i class="bi-book-fill"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Stok Buku</h6>
                                            {{-- <h6 class="font-extrabold mb-0">{{ $stock }}</h6> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-4 d-flex justify-content-center">
                                            <div class="stats-icon green mb-2">
                                                <i class="bi-arrow-right"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Peminjaman</h6>
                                            {{-- <h6 class="font-extrabold mb-0">{{ count($peminjamans) }}</h6> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Jumlah Peminjaman Buku 2025</h4>
                </div>
                <div class="card-body">
                    <div id="chart-peminjaman"></div>
                </div>
            </div>
        </div>
    </div>
    @push('script')
        <script>
            var optionsProfileVisit = {
                annotations: {
                    position: "back",
                },
                dataLabels: {
                    enabled: false,
                },
                chart: {
                    type: "bar",
                    height: 300,
                },
                fill: {
                    opacity: 1,
                },
                plotOptions: {},
                series: [{
                    name: "sales",
                    data: [9, 20, 30, 20, 10, 20, 30, 20],
                }, ],
                colors: "#435ebe",
                xaxis: {
                    categories: [
                        "Januari",
                        "Februaru",
                        "Maret",
                        "April",
                        "Mei",
                        "Juni",
                        "Juli",
                        "Agustus",
                    ],
                },
            }

            var chartProfileVisit = new ApexCharts(
                document.querySelector("#chart-peminjaman"),
                optionsProfileVisit
            )

            chartProfileVisit.render()
        </script>
    @endpush
@endsection

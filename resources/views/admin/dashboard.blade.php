@extends('layouts.app')

@include('components.admin')

@push('style')
@endpush

@section('content')
    <div class="col">
        <div class="page-content">
            <div id="loadingSpinner" class="d-flex justify-content-center align-items-center" style="height: 100vh;">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

            <section class="row" id="dashboardContent" style="display: none;">
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
                                            <h6 class="font-extrabold mb-0">{{ $bukus }}</h6>
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
                                            <h6 class="font-extrabold mb-0">{{ $anggotas }}</h6>
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
                                            <h6 class="font-extrabold mb-0">{{ $stoks }}</h6>
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
                                            <h6 class="font-extrabold mb-0">{{ $peminjamans }}</h6>
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

    {{-- Dropdown Pilihan Tahun --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Jumlah Peminjaman Buku</h4>
                    <select id="tahunFilter" class="form-control w-auto">
                        @for ($i = 2022; $i <= now()->year; $i++)
                            <option value="{{ $i }}" {{ $i == $tahun ? 'selected' : '' }}>{{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="card-body">
                    <div id="chart-peminjaman"></div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            var chartProfileVisit;

            function loadChart(tahun) {
                $.ajax({
                    url: "{{ route('dashboard.chart') }}",
                    type: "GET",
                    data: {
                        tahun: tahun
                    },
                    success: function(response) {
                        var optionsProfileVisit = {
                            annotations: {
                                position: "back"
                            },
                            dataLabels: {
                                enabled: false
                            },
                            chart: {
                                type: "bar",
                                height: 300
                            },
                            fill: {
                                opacity: 1
                            },
                            series: [{
                                name: "Jumlah Peminjaman",
                                data: response.peminjamanChart
                            }],
                            colors: "#435ebe",
                            xaxis: {
                                categories: [
                                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                                ],
                            },
                        };

                        if (chartProfileVisit) {
                            chartProfileVisit.destroy();
                        }

                        chartProfileVisit = new ApexCharts(
                            document.querySelector("#chart-peminjaman"),
                            optionsProfileVisit
                        );

                        chartProfileVisit.render();
                    }
                });
            }

            $(document).ready(function() {
                loadChart($("#tahunFilter").val());

                $("#tahunFilter").change(function() {
                    loadChart($(this).val());
                });

                setTimeout(function() {
                    $("#loadingSpinner").fadeOut(300, function() {
                        $(this).remove(); // Menghapus spinner dari DOM
                        $("#dashboardContent").fadeIn(300).css("display", "block");
                    });
                }, 1000);
            });
        </script>
    @endpush
@endsection

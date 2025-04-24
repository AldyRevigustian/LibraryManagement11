@extends('layouts.admin')

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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Jumlah Peminjaman Buku</h4>
                    <select id="filterTahunan" class="form-control w-auto">
                        @for ($i = 2024; $i <= now()->year; $i++)
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
        <div class="col-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Buku Sering Dipinjam</h4>
                    <select id="filterBulanPinjaman" class="form-control" style="width: 100px; text-align: start;">
                        <option value="">Loading...</option>
                    </select>
                </div>
                <div class="card-body" id="card-sering">
                    <div id="list-sering">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Judul</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody id="popularData">
                                <tr>
                                    <td colspan="3" class="text-center">Loading data...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Top Kategori</h4>
                </div>
                <div class="card-body">
                    <div id="list-kategori"></div>
                </div>
            </div>
        </div>
    </div>

    @push('script')
        <script>
            let availableMonths = [];
            let chartProfileVisit = null;
            let chartPieKategori = null;
            let tableHeight = 519;

            function loadChart(tahun) {
                $.ajax({
                    url: "{{ route('dashboard.chart') }}",
                    type: "GET",
                    data: {
                        tahun: tahun
                    },
                    success: function(response) {
                        availableMonths = response.monthLabels || [
                            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember", "All"
                        ];

                        updateMonthDropdown();

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
                                categories: availableMonths,
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

                        if (availableMonths.length > 0) {
                            loadPopular(1, tahun);
                            loadKategori(1, tahun);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading chart data:", error);
                    }
                });
            }

            function updateMonthDropdown() {
                let dropdown = $('#filterBulanPinjaman');
                dropdown.empty();


                $.each(availableMonths, function(index, monthName) {
                    dropdown.append($('<option></option>')
                        .attr('value', index + 1)
                        .text(monthName));
                });


                if (availableMonths.length > 0) {
                    dropdown.val(1);
                }
            }

            function loadPopular(bulan, tahun) {
                if (availableMonths.length == bulan) {
                    bulan = null
                }

                $.ajax({
                    url: "{{ route('dashboard.popular') }}",
                    type: "GET",
                    data: {
                        bulan: bulan,
                        tahun: tahun
                    },
                    success: function(response) {
                        let html = '';
                        if (response.length > 0) {
                            response.forEach((item, index) => {
                                html += `<tr>
                                <td>${index + 1}</td>
                                <td>${item.judul}</td>
                                <td>${item.total}</td>
                            </tr>`;
                            });
                        } else {
                            html = '<tr><td colspan="3" class="text-center">Tidak ada data peminjaman</td></tr>';
                        }

                        $("#popularData").html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading frequently borrowed books:", error);
                        $("#popularData").html(
                            '<tr><td colspan="3" class="text-center">Error loading data</td></tr>');
                    }
                });
            }

            function loadKategori(bulan, tahun) {
                if (availableMonths.length == bulan) {
                    bulan = null
                }

                $.ajax({
                    url: "{{ route('dashboard.category') }}",
                    type: "GET",
                    data: {
                        bulan: bulan,
                        tahun: tahun
                    },
                    success: function(response) {
                        console.log(response);
                        $("#list-kategori").empty();
                        if (response.length > 0) {
                            const labels = response.map(item => item.kategori);
                            const series = response.map(item => item.total);

                            $("#list-kategori").css({
                                "background-color": "#f8f9fa",
                                "padding-bottom": "10px",
                            });
                            const optionsPieChart = {
                                chart: {
                                    type: 'pie',
                                    height: tableHeight,
                                    animations: {
                                        enabled: true,
                                        speed: 400,
                                    }
                                },
                                labels: labels,
                                series: series,
                                colors: [
                                    '#435ebe',
                                    '#ffbb33',
                                    '#00d1b2',
                                    '#6f42c1',
                                    '#ff5252',
                                ],

                                legend: {
                                    position: 'bottom'
                                },
                                responsive: [{
                                    breakpoint: 500,
                                    options: {
                                        chart: {
                                            width: 200
                                        },
                                        legend: {
                                            position: 'bottom'
                                        }
                                    }
                                }],
                                stroke: {
                                    show: true,
                                    width: 1,
                                    colors: ['#e9ecef']
                                }
                            };

                            if (chartPieKategori) {
                                chartPieKategori.destroy();
                            }

                            chartPieKategori = new ApexCharts(
                                document.querySelector("#list-kategori"),
                                optionsPieChart
                            );

                            chartPieKategori.render();
                        } else {

                            if (chartPieKategori) {
                                chartPieKategori.destroy();
                                chartPieKategori = null;
                            }

                            setTimeout(function() {
                                $("#list-kategori").css({
                                    "min-height": "105px",
                                    "height": "auto",
                                    "display": "flex",
                                    "justify-content": "center",
                                    "align-items": "center",
                                    "background-color": "rgba(0, 0, 0, 0.05)",
                                    "position": "relative",
                                    "z-index": "1"
                                });


                                $("#list-kategori").html(
                                    '<p class="mb-0" style="font-size: 16px; font-weight: 500; color:#607080">Tidak ada data</p>'
                                );


                                console.log("No data condition triggered - message should be visible");
                            }, 100);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error loading pie chart data:", error);

                        if (chartPieKategori) {
                            chartPieKategori.destroy();
                            chartPieKategori = null;
                        }
                        $("#list-kategori").empty().css({
                            "min-height": "200px",
                            "height": "auto",
                            "display": "flex",
                            "justify-content": "center",
                            "align-items": "center",
                            "background-color": "#ffffff",
                            "position": "relative",
                            "z-index": "1"
                        });

                        $("#list-kategori").html(
                            '<p class="text-danger" style="font-size: 16px; font-weight: 500;">Error loading data</p>'
                        );
                    }
                });
            }


            $(document).ready(function() {
                loadChart($("#filterTahunan").val());

                $("#filterBulanPinjaman").change(function() {
                    loadPopular($(this).val(), $("#filterTahunan").val());
                    loadKategori($(this).val(), $("#filterTahunan").val());
                });

                $("#filterTahunan").change(function() {
                    loadChart($(this).val());
                });

                setTimeout(function() {
                    $("#loadingSpinner").fadeOut(300, function() {
                        $(this).remove();
                        $("#dashboardContent").fadeIn(300).css("display", "block");
                    });
                }, 500);
            });
        </script>
    @endpush
@endsection

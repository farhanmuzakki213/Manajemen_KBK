@extends('admin.admin_master')

@section('styles')
    <style>
        .apexcharts-legend {
            display: flex;
            flex-wrap: nowrap;
            overflow: auto;
            justify-content: center;
            align-items: center;
        }

        .apexcharts-legend-series {
            display: flex;
            justify-content: center;
            align-items: center;
            padding-right: 50px;
        }

        .apexcharts-legend-series .apexcharts-legend-item {
            display: flex;
            align-items: center;
            margin-right: 15px;

        }

        .apexcharts-legend-series .apexcharts-legend-marker {
            width: 10px;
            height: 10px;
            margin-right: 5px;

        }
    </style>
@endsection

@section('admin')
    <div class="container-fluid">

        <div class="container-fluid">
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0">
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <h4>Chart RPS</h4>
                                        <div id="chart-rps" style="min-height: 350px;"></div>

                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Unggahan RPS</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_pengunggahan_rps['2023/2024-Genap'] ?? 0 }}</h4>

                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-clipboard fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Verifikasi RPS</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_verifikasi_rps['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-receipt fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Berita Acara RPS</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_berita_rps['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-school fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-4">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Unggahan UAS</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_pengunggahan_uas['2023/2024-Genap'] ?? 0 }}</h4>

                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-clipboard fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Verifikasi Soal UAS</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_verifikasi_uas['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-receipt fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                                <div class="col-lg-12 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Berita Acara UAS</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_berita_uas['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-school fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0">
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                        <h4>Chart UAS</h4>
                                        <div id="chart-uas" style="min-height: 350px;"></div>

                                    </div>
                                </div>
                            </div>
                        </div>





                        <div class="row my-3">
                            <div class="col-lg-12 d-flex flex-wrap">
                                <div class="col-lg-3 col-md-6" style="padding-right:20px;">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Diajukan</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_pengunggahan_uas['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-clipboard fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6" style="padding-right:20px;">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Ditolak</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_verifikasi_uas['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-success rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-receipt fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6" style="padding-right:20px;">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Direvisi</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_berita_uas['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-school fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6" style="padding-right:20px;">
                                    <div class="card mb-3">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Diterima</h5>
                                                    <h4 class="fw-semibold mb-9">
                                                        {{ $banyak_berita_uas['2023/2024-Genap'] ?? 0 }}</h4>
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-school fs-6"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="earning"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 d-flex align-items-stretch mt-3">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0"></div>
                                            <div></div>
                                        </div>
                                        <h4>Chart TA</h4>
                                        <div id="chart-ta" style="min-height: 350px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>

    </div>
    
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data for RPS Chart
            const banyak_pengunggahan_rps = @json($banyak_pengunggahan_rps);
            const banyak_verifikasi_rps = @json($banyak_verifikasi_rps);
            const banyak_berita_rps = @json($banyak_berita_rps);
            const semester_rps = @json($semester_rps);

            const chartRpsOptions = {
                series: [{
                        name: 'Pengunggahan',
                        data: Object.values(banyak_pengunggahan_rps)
                    },
                    {
                        name: 'Verifikasi',
                        data: Object.values(banyak_verifikasi_rps)
                    },
                    {
                        name: 'Berita Acara',
                        data: Object.values(banyak_berita_rps)
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    offsetX: -15,
                    toolbar: {
                        show: true
                    },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                },
                colors: ["#5D87FF", "#00E396", "#FEB019"],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "35%",
                        borderRadius: [6],
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'all'
                    },
                },
                markers: {
                    size: 0
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    floating: false,
                    offsetY: 10,
                    offsetX: 0,
                    itemMargin: {
                        horizontal: 2,
                        vertical: 15
                    },
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 5
                    },
                    formatter: function(seriesName, opts) {
                        return seriesName;
                    }
                },
                grid: {
                    borderColor: "rgba(0,0,0,0.1)",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },
                xaxis: {
                    type: "category",
                    categories: Object.keys(banyak_pengunggahan_rps),
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color"
                        },
                    },
                },
                yaxis: {
                    show: true,
                    min: 0,
                    max: Math.max(...Object.values(banyak_pengunggahan_rps), ...Object.values(
                        banyak_verifikasi_rps), ...Object.values(banyak_berita_rps)) + 5,
                    tickAmount: 4,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 3,
                    lineCap: "butt",
                    colors: ["transparent"],
                },
                tooltip: {
                    theme: "light"
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 3,
                            }
                        },
                    }
                }]
            };

            const chartRps = new ApexCharts(document.querySelector("#chart-rps"), chartRpsOptions);
            chartRps.render();


            // Data for UAS Chart
            const banyak_pengunggahan_uas = @json($banyak_pengunggahan_uas);
            const banyak_verifikasi_uas = @json($banyak_verifikasi_uas);
            const banyak_berita_uas = @json($banyak_berita_uas);
            const semester_uas = @json($semester_uas);

            const chartUasOptions = {
                series: [{
                        name: 'Pengunggahan',
                        data: Object.values(banyak_pengunggahan_uas)
                    },
                    {
                        name: 'Verifikasi',
                        data: Object.values(banyak_verifikasi_uas)
                    },
                    {
                        name: 'Berita Acara',
                        data: Object.values(banyak_berita_uas)
                    }
                ],
                chart: {
                    type: 'bar',
                    height: 350,
                    offsetX: -15,
                    toolbar: {
                        show: true
                    },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                },
                colors: ["#5D87FF", "#00E396", "#FEB019"],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "35%",
                        borderRadius: [6],
                        borderRadiusApplication: 'end',
                        borderRadiusWhenStacked: 'all'
                    },
                },
                markers: {
                    size: 0
                },
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center',
                    floating: false,
                    offsetY: 10,
                    offsetX: 0,
                    itemMargin: {
                        horizontal: 2,
                        vertical: 15
                    },
                    markers: {
                        width: 10,
                        height: 10,
                        radius: 5
                    },
                    formatter: function(seriesName, opts) {
                        return seriesName;
                    }
                },
                grid: {
                    borderColor: "rgba(0,0,0,0.1)",
                    strokeDashArray: 3,
                    xaxis: {
                        lines: {
                            show: false,
                        },
                    },
                },
                xaxis: {
                    type: "category",
                    categories: Object.keys(banyak_pengunggahan_uas),
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color"
                        },
                    },
                },
                yaxis: {
                    show: true,
                    min: 0,
                    max: Math.max(...Object.values(banyak_pengunggahan_uas), ...Object.values(
                        banyak_verifikasi_uas), ...Object.values(banyak_berita_uas)) + 5,
                    tickAmount: 4,
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color",
                        },
                    },
                },
                stroke: {
                    show: true,
                    width: 3,
                    lineCap: "butt",
                    colors: ["transparent"],
                },
                tooltip: {
                    theme: "light"
                },
                responsive: [{
                    breakpoint: 600,
                    options: {
                        plotOptions: {
                            bar: {
                                borderRadius: 3,
                            }
                        },
                    }
                }]
            };

            const chartUas = new ApexCharts(document.querySelector("#chart-uas"), chartUasOptions);
            chartUas.render();

            // Data for TA Chart
            const bulan = @json($bulan);
            const review = @json($review);
            const statuses = @json($statuses);
            const colors = ['#008FFB', '#FF4560', '#FEB019', '#00E396'];

            const seriesData = statuses.map((status, index) => ({
                name: status,
                data: review.map(monthData => monthData[status] || 0),
                color: colors[index]
            }));

            const chartTa = new ApexCharts(document.querySelector("#chart-ta"), {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: seriesData,
                xaxis: {
                    categories: bulan
                },
                yaxis: {
                    labels: {
                        formatter: function(value) {
                            return Math.round(value);
                        }
                    }
                }
            });

            chartTa.render();
        });
    </script>
@endsection

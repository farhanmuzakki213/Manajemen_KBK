@extends('admin.admin_master')

@section('styles')
    <style>
        .apexcharts-legend {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .apexcharts-legend-series {
            width: calc(50% - 10px);
            display: flex;
            justify-content: center;
            margin: 5px;
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
        <div class="card">
            <div class="container-fluid">
                <div class="container-fluid">
                    <div class="card-body">
                        <h3 class="fw-semibold text-center">Pengunggahan dan Verifikasi</h3>

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
                                        <div id="pengunggahanVerifikasiChart"></div>
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
                                                    <h4 class="fw-semibold mb-9">{{ $banyak_pengunggahan_rps }}</h4>
                                                    <div class="d-flex align-items-center pb-1"> 
                                                    </div>
                                                    <h5 class="card-title my-9 fw-semibold">Verifikasi RPS</h5>
                                                    <h4 class="fw-semibold">{{ $banyak_verifikasi_rps }}</h4>
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
                                                    <h5 class="card-title mb-9 fw-semibold">Unggahan Soal UAS</h5>
                                                <h4 class="fw-semibold mb-9">{{ $banyak_pengunggahan_uas }}</h4>
                                                <div class="d-flex align-items-center pb-1">
                                                </div>
                                                <h5 class="card-title my-9 fw-semibold">Verifikasi Soal UAS</h5>
                                                <h4 class="fw-semibold">{{ $banyak_verifikasi_uas }}</h4>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white rounded-circle p-6 d-flex align-items-center justify-content-center" style="background-color: #50B498;">
                                                            <i class="ti ti-receipt fs-6"></i>
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

                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- RPS Chart -->
                                    <div class="col-lg-6 chart-container">
                                        <h3 class="text-center">RPS</h3>
                                        <div id="chartRPS"></div>
                                    </div>

                                    <!-- UAS Chart -->
                                    <div class="col-lg-6 chart-container">
                                        <h3 class="text-center">UAS</h3>
                                        <div id="chartUAS"></div>
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
    <!-- Load ApexCharts Library -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> --}}
    {{-- <script src="{{ asset('backend/assets/js/apexchart.js') }}"></script> --}}
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Data from Blade variables
            var banyakPengunggahanRPS = @json($banyak_pengunggahan_rps);
            var banyakVerifikasiRPS = @json($banyak_verifikasi_rps);
            var banyakPengunggahanUas = @json($banyak_pengunggahan_uas);
            var banyakVerifikasiUas = @json($banyak_verifikasi_uas);
            var percentVerifiedRPS = @json($percentVerifiedRPS);
            var percentUploadedRPS = @json($percentUploadedRPS);
            var percentVerifiedUAS = @json($percentVerifiedUAS);
            var percentUploadedUAS = @json($percentUploadedUAS);

            var barChartOptions = {
                series: [{
                        name: "Pengunggahan RPS",
                        data: [banyakPengunggahanRPS]
                    },
                    {
                        name: "Veifikasi RPS",
                        data: [banyakVerifikasiRPS]
                    },
                    {
                        name: "Pengunggahan UAS",
                        data: [banyakPengunggahanUas]
                    },
                    {
                        name: "Veifikasi UAS",
                        data: [banyakVerifikasiUas]
                    }
                ],
                chart: {
                    type: "bar",
                    height: 400,
                    offsetX: -15,
                    toolbar: {
                        show: true
                    },
                    foreColor: "#adb0bb",
                    fontFamily: 'inherit',
                    sparkline: {
                        enabled: false
                    },
                },
                colors: ["#5D87FF", "#49BEFF", "#50B498", "#9CDBA6"],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "50%",
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
                    horizontalAlign: 'left',
                    floating: false,
                    offsetY: 10,
                    offsetX: 0,
                    itemMargin: {
                        horizontal: 2,
                        vertical: 5
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
                    categories: ["Data"],
                    labels: {
                        style: {
                            cssClass: "grey--text lighten-2--text fill-color"
                        },
                    },
                },
                yaxis: {
                    show: true,
                    min: 0,
                    max: Math.max(banyakPengunggahanRPS, banyakVerifikasiRPS, banyakPengunggahanUas,
                        banyakVerifikasiUas) + 25,
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

            // Render Bar Chart
            var barChart = new ApexCharts(document.querySelector("#pengunggahanVerifikasiChart"), barChartOptions);
            barChart.render();

            // Common options for both charts
            var commonOptionsRPS = {
                chart: {
                    type: 'donut',
                    height: 300,
                    width: '100%'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Data',
                                    formatter: function(w) {
                                        // return banyakVerifikasiRPS;
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value, {
                            seriesIndex
                        }) {
                            // Custom tooltip text based on the series index
                            if (seriesIndex === 0) {
                                return banyakPengunggahanRPS + ' data';
                            } else if (seriesIndex === 1) {
                                return banyakVerifikasiRPS + ' data';
                            }
                            return value + ' data';
                        }
                    }
                },
                legend: {
                    position: 'bottom'
                },
                colors: ["#5D87FF", "#49BEFF"]
            };

            // Options for RPS Chart
            var optionsRPS = {
                ...commonOptionsRPS,
                series: [banyakPengunggahanRPS, banyakVerifikasiRPS],
                labels: ['Unggahan', 'Verifikasi']
            };

            // Render RPS Chart
            var chartRPS = new ApexCharts(document.querySelector("#chartRPS"), optionsRPS);
            chartRPS.render();

            // Options for UAS Chart
            var commonOptionsUAS = {
                chart: {
                    type: 'donut',
                    height: 300,
                    width: '100%'
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total Data',
                                    formatter: function(w) {
                                        // return banyakVerifikasiUas;
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value, {
                            seriesIndex
                        }) {
                            // Custom tooltip text based on the series index
                            if (seriesIndex === 0) {
                                return banyakPengunggahanUas + ' data';
                            } else if (seriesIndex === 1) {
                                return banyakVerifikasiUas + ' data';
                            }
                            return value + ' data';
                        }
                    }
                },
                legend: {
                    position: 'bottom'
                },
                colors: [ "#50B498", "#9CDBA6"]
            };

            var optionsUAS = {
                ...commonOptionsUAS,
                series: [banyakPengunggahanUas, banyakVerifikasiUas],
                labels: ['Unggahan', 'Verifikasi']
            };

            // Render UAS Chart
            var chartUAS = new ApexCharts(document.querySelector("#chartUAS"), optionsUAS);
            chartUAS.render();
        });
    </script>
@endsection

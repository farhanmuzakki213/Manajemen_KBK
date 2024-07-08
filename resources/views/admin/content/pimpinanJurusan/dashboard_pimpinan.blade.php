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
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <form id="filterForm" action="{{ route('dashboard_pimpinan') }}" method="GET">
                                    <label for="prodiSelect" class="form-label">Pilih Prodi:</label>
                                    <select id="prodiSelect" class="form-select" name="prodi_id">
                                        <option value="">Semua Prodi</option>
                                        @foreach ($prodi as $single_prodi)
                                            <option value="{{ $single_prodi->id_prodi }}"
                                                {{ request('prodi_id') == $single_prodi->id_prodi ? 'selected' : '' }}>
                                                {{ $single_prodi->prodi }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>

                        @php
                            $selectedProdi = $prodi->firstWhere('id_prodi', request('prodi_id'));
                            $title = $selectedProdi ? $selectedProdi->prodi : 'Semua Prodi';
                        @endphp

                        <h2 class="text-center mb-5">{{ $title }}</h2>


                        {{-- <h3 class="fw-semibold text-center">Pengunggahan dan Verifikasi</h3> --}}

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
                                        <div id="kajurChart"></div>

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
                                                    <h4 class="fw-semibold mb-9">{{ $total_banyak_pengunggahan_rps }}</h4>
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                    <h5 class="card-title my-9 fw-semibold">Verifikasi RPS</h5>
                                                    <h4 class="fw-semibold">{{ $total_banyak_verifikasi_rps }}</h4>
                                                    
                                                    

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
                                                    <h4 class="fw-semibold mb-9">{{ $total_banyak_pengunggahan_uas }}</h4>
                                                    
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                    <h5 class="card-title my-9 fw-semibold">Verifikasi Soal UAS</h5>
                                                    <h4 class="fw-semibold">{{ $total_banyak_verifikasi_uas }}</h4>

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
                                <div class="col-lg-12 mt-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start">
                                                <div class="col-8">
                                                    <h5 class="card-title my-9 fw-semibold">Review Proposal TA</h5>
                                                    <h4 class="fw-semibold">{{ $total_jumlah_review_proposal }}</h4>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Load Axios Library for making HTTP requests -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var prodiSelect = document.getElementById('prodiSelect');
            var filterForm = document.getElementById('filterForm');

            prodiSelect.addEventListener('change', function() {
                filterForm.submit(); // Submit form on change
            });

            // Initial chart data
            var initialData = {
                total_banyak_pengunggahan_rps: {{ $total_banyak_pengunggahan_rps }},
                total_banyak_verifikasi_rps: {{ $total_banyak_verifikasi_rps }},
                total_banyak_pengunggahan_uas: {{ $total_banyak_pengunggahan_uas }},
                total_banyak_verifikasi_uas: {{ $total_banyak_verifikasi_uas }},
                total_jumlah_review_proposal: {{ $total_jumlah_review_proposal }}
            };

            // Bar Chart Options
            var barChartOptions = {
                series: [{
                        name: "Pengunggahan RPS",
                        data: [initialData.total_banyak_pengunggahan_rps]
                    },
                    {
                        name: "Verifikasi RPS",
                        data: [initialData.total_banyak_verifikasi_rps]
                    },
                    {
                        name: "Pengunggahan UAS",
                        data: [initialData.total_banyak_pengunggahan_uas]
                    },
                    {
                        name: "Verifikasi UAS",
                        data: [initialData.total_banyak_verifikasi_uas]
                    },
                    {
                        name: "Review Proposal TA",
                        data: [initialData.total_jumlah_review_proposal]
                    }
                ],
                chart: {
                    type: "bar",
                    height: 600,
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
                colors: ["#5D87FF", "#49BEFF", "#50B498", "#9CDBA6", "#FFC700"],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "70%",
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
                    max: Math.max(
                        initialData.total_banyak_pengunggahan_rps,
                        initialData.total_banyak_verifikasi_rps,
                        initialData.total_banyak_pengunggahan_uas,
                        initialData.total_banyak_verifikasi_uas,
                        initialData.total_jumlah_review_proposal
                    ) + 10,
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


            var barChart = new ApexCharts(document.querySelector("#kajurChart"), barChartOptions);
            barChart.render();


            var commonOptions = {
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
                                    formatter: function(w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(value) {
                            return value + ' data';
                        }
                    }
                },
                legend: {
                    position: 'bottom'
                },
                
            };


            var optionsRPS = {
                ...commonOptions,
                series: [initialData.total_banyak_pengunggahan_rps, initialData.total_banyak_verifikasi_rps],
                labels: ['Unggahan', 'Verifikasi'],
                colors: ["#008FFB", "#49BEFF"]
            };


            var chartRPS = new ApexCharts(document.querySelector("#chartRPS"), optionsRPS);
            chartRPS.render();


            var optionsUAS = {
                ...commonOptions,
                series: [initialData.total_banyak_pengunggahan_uas, initialData.total_banyak_verifikasi_uas],
                labels: ['Unggahan', 'Verifikasi'],
                colors: ["#50B498", "#9CDBA6"]
            };


            var chartUAS = new ApexCharts(document.querySelector("#chartUAS"), optionsUAS);
            chartUAS.render();


            var optionsTA = {
                ...commonOptions,
                series: [initialData.total_jumlah_proposal, initialData.total_jumlah_review_proposal],
                labels: ['Proposal', 'Review'],
                colors: ["#FFC700", "#FFF455"]
            };


            var chartTA = new ApexCharts(document.querySelector("#chartTA"), optionsTA);
            chartTA.render();
        });
    </script>
@endsection

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

                        {{-- <h3 class="fw-semibold text-center">Pengunggahan dan Verifikasi</h3> --}}

                        <div class="row">
                            <div class="col-lg-8 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0">
                                                <!-- Filter Type Dropdown -->
                                                <select id="filterType" class="form-select">
                                                    <option value="smt">Semester</option>
                                                    <option value="kbk">KBK</option>
                                                </select>
                                            </div>
                                            <div>
                                                <!-- Filter Value Dropdown -->
                                                <select id="filterValue" class="form-select">
                                                    <!-- Options will be populated dynamically based on filterType selection -->
                                                </select>
                                            </div>
                                        </div>
                                        <div id="kaprodiChart"></div>
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
                                                    @foreach ($data_rps['banyak_pengunggahan_smt'] as $data)
                                                        <h4 class="fw-semibold mb-9">{{ $data ?? 0}}</h4>
                                                    @endforeach
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                    <h5 class="card-title my-9 fw-semibold">Verifikasi RPS</h5>
                                                    @foreach ($data_rps['banyak_verifikasi_smt'] as $data)
                                                        <h4 class="fw-semibold mb-9">{{ $data ?? 0}}</h4>
                                                    @endforeach
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
                                                    @foreach ($data_uas['banyak_pengunggahan_smt'] as $data)
                                                        <h4 class="fw-semibold mb-9">{{ $data ?? 0 }}</h4>
                                                    @endforeach
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                    <h5 class="card-title my-9 fw-semibold">Verifikasi Soal UAS</h5>
                                                    @foreach ($data_uas['banyak_verifikasi_smt'] as $data)
                                                        <h4 class="fw-semibold">{{ $data ?? 0}}</h4>
                                                    @endforeach
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="text-white rounded-circle p-6 d-flex align-items-center justify-content-center"
                                                            style="background-color: #50B498;">
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
                                                    <h5 class="card-title my-9 fw-semibold">Penugasan Review Proposal TA</h5>
                                                    <h4 class="fw-semibold">{{ $data_ta['total_jumlah_proposal_smt'] }}</h4>
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                    <h5 class="card-title my-9 fw-semibold">Review Proposal TA</h5>
                                                    <h4 class="fw-semibold">{{ $data_ta['total_jumlah_review_proposal_smt'] }}</h4>

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
                                    <div class="col-lg-4 chart-container">
                                        <h3 class="text-center">RPS</h3>
                                        <div id="chartRPS"></div>
                                    </div>
                                    <!-- UAS Chart -->
                                    <div class="col-lg-4 chart-container">
                                        <h3 class="text-center">UAS</h3>
                                        <div id="chartUAS"></div>
                                    </div>

                                    <div class="col-lg-4 chart-container">
                                        <h3 class="text-center">UAS</h3>
                                        <div id="chartTA"></div>
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
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const dataRPS = @json($data_rps);
            const dataUAS = @json($data_uas);
            const dataTA = @json($data_ta);
    
            let chart, chartRPS, chartUAS, chartTA;
    
            function updateChart(type, value) {
                let labels = [];
                let pengunggahanDataRPS = [];
                let verifikasiDataRPS = [];
                let pengunggahanDataUAS = [];
                let verifikasiDataUAS = [];
                let penugasanDataTA = [];
                let reviewDataTA = [];
    
                if (type === 'smt') {
                    labels = Object.keys(dataRPS.banyak_pengunggahan_smt);
                    pengunggahanDataRPS = Object.values(dataRPS.banyak_pengunggahan_smt);
                    verifikasiDataRPS = Object.values(dataRPS.banyak_verifikasi_smt);
                    pengunggahanDataUAS = Object.values(dataUAS.banyak_pengunggahan_smt);
                    verifikasiDataUAS = Object.values(dataUAS.banyak_verifikasi_smt);
                    penugasanDataTA = [dataTA.total_jumlah_proposal_smt];
                    reviewDataTA = [dataTA.total_jumlah_review_proposal_smt];
                } else if (type === 'kbk') {
                    labels = Object.keys(dataTA.pengunggahan_rps_kbk);
                    pengunggahanDataRPS = Object.values(dataTA.pengunggahan_rps_kbk);
                    verifikasiDataRPS = Object.values(dataTA.verifikasi_rps_kbk);
                    pengunggahanDataUAS = Object.values(dataTA.pengunggahan_uas_kbk);
                    verifikasiDataUAS = Object.values(dataTA.verifikasi_uas_kbk);
                    penugasanDataTA = Object.values(dataTA.penugasan_kbk);
                    reviewDataTA = Object.values(dataTA.review_kbk);
                }
    
                const barOptions = {
                    series: [{
                            name: 'Banyak Pengunggahan RPS',
                            data: pengunggahanDataRPS
                        },
                        {
                            name: 'Banyak Verifikasi RPS',
                            data: verifikasiDataRPS
                        },
                        {
                            name: 'Banyak Pengunggahan UAS',
                            data: pengunggahanDataUAS
                        },
                        {
                            name: 'Banyak Verifikasi UAS',
                            data: verifikasiDataUAS
                        },
                        {
                            name: 'Penugasan Review Proposal TA',
                            data: penugasanDataTA
                        },
                        {
                            name: 'Review Proposal TA',
                            data: reviewDataTA
                        }
                    ],
                    chart: {
                        type: 'bar',
                        height: 500,
                        offsetX: -15,
                        toolbar: {
                            show: true
                        },
                        foreColor: "#adb0bb",
                        fontFamily: 'inherit',
                        sparkline: {
                            enabled: false
                        }
                    },
                    colors: ["#008FFB", "#49BEFF", "#50B498", "#9CDBA6", "#FFC700", "#ffd84d"],
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: "70%",
                            borderRadius: [6],
                            borderRadiusApplication: 'end',
                            borderRadiusWhenStacked: 'all'
                        }
                    },
                    markers: {
                        size: 0
                    },
                    dataLabels: {
                        enabled: false
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
                                show: false
                            }
                        }
                    },
                    xaxis: {
                        categories: labels,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color"
                            }
                        }
                    },
                    yaxis: {
                        title: {
                            text: 'Jumlah'
                        },
                        min: 0,
                        max: Math.max(
                            ...pengunggahanDataRPS,
                            ...verifikasiDataRPS,
                            ...pengunggahanDataUAS,
                            ...verifikasiDataUAS,
                            ...penugasanDataTA,
                            ...reviewDataTA
                        ) + 10,
                        tickAmount: 4,
                        labels: {
                            style: {
                                cssClass: "grey--text lighten-2--text fill-color"
                            },
                            formatter: function(value) {
                                return Number.isInteger(value) ? value : '';
                            }
                        }
                    },
                    stroke: {
                        show: true,
                        width: 3,
                        lineCap: "butt",
                        colors: ["transparent"]
                    },
                    tooltip: {
                        theme: "light",
                        y: {
                            formatter: function(val, { seriesIndex, dataPointIndex, w }) {
                                const seriesName = w.globals.seriesNames[seriesIndex];
                                if (seriesName.includes('RPS')) {
                                    return parseInt(val) + " RPS";
                                } else if (seriesName.includes('UAS')) {
                                    return parseInt(val) + " UAS";
                                } else {
                                    return parseInt(val) + " Proposal";
                                }
                            }
                        }
                    },
                    responsive: [{
                        breakpoint: 600,
                        options: {
                            plotOptions: {
                                bar: {
                                    borderRadius: 3
                                }
                            }
                        }
                    }]
                };
    
                if (chart) {
                    chart.updateOptions(barOptions);
                } else {
                    chart = new ApexCharts(document.querySelector("#kaprodiChart"), barOptions);
                    chart.render();
                }
                updateDonutCharts();
            }
    
            function updateDonutCharts() {
                const totalBanyakPengunggahanRPS = Object.values(dataRPS.banyak_pengunggahan_smt).reduce((a, b) => a + b, 0);
                const totalBanyakVerifikasiRPS = Object.values(dataRPS.banyak_verifikasi_smt).reduce((a, b) => a + b, 0);
                const totalBanyakPengunggahanUAS = Object.values(dataUAS.banyak_pengunggahan_smt).reduce((a, b) => a + b, 0);
                const totalBanyakVerifikasiUAS = Object.values(dataUAS.banyak_verifikasi_smt).reduce((a, b) => a + b, 0);
                const totalBanyakpenugasanDataTA = [dataTA.total_jumlah_proposal_smt].reduce((a, b) => a + b, 0);
                const totalBanyakreviewDataTA = [dataTA.total_jumlah_review_proposal_smt].reduce((a, b) => a + b, 0);
    
                chartRPS.updateOptions({
                    series: [totalBanyakPengunggahanRPS, totalBanyakVerifikasiRPS]
                });
    
                chartUAS.updateOptions({
                    series: [totalBanyakPengunggahanUAS, totalBanyakVerifikasiUAS]
                });
    
                chartTA.updateOptions({
                    series: [totalBanyakpenugasanDataTA, totalBanyakreviewDataTA]
                });
            }
    
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
                                        return w.globals.seriesTotals.reduce((a, b) => a);
                                    }
                                }
                            }
                        }
                    }
                },
                tooltip: {
                    y: {
                        formatter: value => value + ' data'
                    }
                },
                legend: {
                    position: 'bottom'
                }
            };
    
            chartRPS = new ApexCharts(document.querySelector("#chartRPS"), {
                ...commonOptions,
                series: [0, 0],
                labels: ['Unggahan', 'Verifikasi'],
                colors: ["#008FFB", "#49BEFF"]
            });
            chartRPS.render();
    
            chartUAS = new ApexCharts(document.querySelector("#chartUAS"), {
                ...commonOptions,
                series: [0, 0],
                labels: ['Unggahan', 'Verifikasi'],
                colors: ["#50B498", "#9CDBA6"]
            });
            chartUAS.render();
    
            chartTA = new ApexCharts(document.querySelector("#chartTA"), {
                ...commonOptions,
                series: [0, 0],
                labels: ['Penugasan', 'Review'],
                colors: ["#FFC700", "#FFF455"]
            });
            chartTA.render();
    
            document.getElementById('filterType').addEventListener('change', function() {
                const type = this.value;
                const filterValueSelect = document.getElementById('filterValue');
                filterValueSelect.innerHTML = '';

                let options = [];
                if (type === 'smt') {
                    options = dataRPS.semester;
                } else if (type === 'kbk') {
                    options = dataTA.jenis_kbk || [];
                }

                options.forEach(option => {
                    const opt = document.createElement('option');
                    opt.value = option;
                    opt.text = option;
                    filterValueSelect.add(opt);
                });

                updateChart(type, filterValueSelect.value);
            });

            document.getElementById('filterValue').addEventListener('change', function() {
                const type = document.getElementById('filterType').value;
                updateChart(type, this.value);
            });

            document.getElementById('filterType').dispatchEvent(new Event('change'));
        });
    </script>
    

@endsection

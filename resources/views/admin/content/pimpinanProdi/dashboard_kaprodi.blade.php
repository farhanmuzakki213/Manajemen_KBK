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
                                                        <h4 class="fw-semibold mb-9">{{ $data }}</h4>
                                                    @endforeach
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                    <h5 class="card-title my-9 fw-semibold">Verifikasi RPS</h5>
                                                    @foreach ($data_rps['banyak_verifikasi_smt'] as $data)
                                                        <h4 class="fw-semibold mb-9">{{ $data }}</h4>
                                                    @endforeach
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="text-white bg-primary rounded-circle p-6 d-flex align-items-center justify-content-center">
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
                                                        <h4 class="fw-semibold mb-9">{{ $data }}</h4>
                                                    @endforeach
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                    <h5 class="card-title my-9 fw-semibold">Verifikasi Soal UAS</h5>
                                                    @foreach ($data_uas['banyak_verifikasi_smt'] as $data)
                                                        <h4 class="fw-semibold">{{ $data }}</h4>
                                                    @endforeach
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="text-white rounded-circle p-6 d-flex align-items-center justify-content-center" style="background-color: #50B498;">
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
                                                    <h5 class="card-title mb-9 fw-semibold">Proposal TA</h5>
                                                    <h4 class="fw-semibold mb-9">{{ $jumlah_proposal }}</h4>
                                                    <div class="d-flex align-items-center pb-1"></div>
                                                    <h5 class="card-title my-9 fw-semibold">Review Proposal TA</h4>
                                                    <h4 class="fw-semibold">{{ $jumlah_review_proposal }}</h4>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div class="text-white bg-warning rounded-circle p-6 d-flex align-items-center justify-content-center">
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
                                    <!-- TA Chart -->
                                    <div class="col-lg-4 chart-container">
                                        <h3 class="text-center">Proposal TA</h3>
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
        const jumlahProposal = {{ $jumlah_proposal }};
        const jumlahReviewProposal = {{ $jumlah_review_proposal }};
        
        let chart, chartRPS, chartUAS, chartTA;

        function updateChart(type, value) {
            let labels = [];
            let pengunggahanData = [];
            let verifikasiData = [];
            let beritaData = [];
            let beritaDataVer = [];

            if (type === 'smt') {
                labels = Object.keys(dataRPS.banyak_pengunggahan_smt);
                pengunggahanData = Object.values(dataRPS.banyak_pengunggahan_smt);
                verifikasiData = Object.values(dataRPS.banyak_verifikasi_smt);
                beritaData = Object.values(dataRPS.banyak_berita_smt);
                beritaDataVer = Object.values(dataRPS.banyak_berita_ver_smt);
            } else if (type === 'kbk') {
                labels = Object.keys(dataRPS.banyak_pengunggahan_kbk);
                pengunggahanData = Object.values(dataRPS.banyak_pengunggahan_kbk);
                verifikasiData = Object.values(dataRPS.banyak_verifikasi_kbk);
                beritaData = Object.values(dataRPS.banyak_berita_kbk);
                beritaDataVer = Object.values(dataRPS.banyak_berita_ver_kbk);
            }

            const barOptions = {
                series: [
                    { name: 'Banyak Pengunggahan', data: pengunggahanData },
                    { name: 'Banyak Verifikasi', data: verifikasiData },
                    { name: 'Banyak Verifikasi RPS di Berita Acara', data: beritaDataVer },
                    { name: 'Banyak Pengunggahan Berita Acara', data: beritaData }
                ],
                chart: {
                    type: 'bar',
                    height: 600,
                    toolbar: { show: false }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '15%',
                        endingShape: 'rounded'
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: true, width: 2, colors: ['transparent'] },
                xaxis: { categories: labels },
                yaxis: {
                    title: { text: 'Jumlah' },
                    labels: {
                        formatter: function(value) {
                            return Number.isInteger(value) ? value : '';
                        }
                    }
                },
                fill: { opacity: 1 },
                tooltip: {
                    y: { formatter: val => parseInt(val) + " RPS" }
                }
            };

            if (chart) {
                chart.updateOptions(barOptions);
            } else {
                chart = new ApexCharts(document.querySelector("#kaprodiChart"), barOptions);
                chart.render();
            }

            // Update Donut Charts
            updateDonutCharts();
        }

        function updateDonutCharts() {
            const totalBanyakPengunggahanRPS = Object.values(dataRPS.banyak_pengunggahan_smt).reduce((a, b) => a + b, 0);
            const totalBanyakVerifikasiRPS = Object.values(dataRPS.banyak_verifikasi_smt).reduce((a, b) => a + b, 0);
            const totalBanyakPengunggahanUAS = Object.values(dataUAS.banyak_pengunggahan_smt).reduce((a, b) => a + b, 0);
            const totalBanyakVerifikasiUAS = Object.values(dataUAS.banyak_verifikasi_smt).reduce((a, b) => a + b, 0);

            // Ensure correct data is passed to the respective charts
            chartRPS.updateOptions({
                series: [totalBanyakPengunggahanRPS, totalBanyakVerifikasiRPS]
            });

            chartUAS.updateOptions({
                series: [totalBanyakPengunggahanUAS, totalBanyakVerifikasiUAS]
            });

            chartTA.updateOptions({
                series: [jumlahProposal, jumlahReviewProposal]
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
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: { formatter: value => value + ' data' }
            },
            legend: { position: 'bottom' }
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
            labels: ['Proposal', 'Review'],
            colors: ["#FFC700", "#FFF455"]
        });
        chartTA.render();

        // Event listeners
        document.getElementById('filterType').addEventListener('change', function() {
            const type = this.value;
            const filterValueSelect = document.getElementById('filterValue');
            filterValueSelect.innerHTML = '';

            let options = [];
            if (type === 'smt') {
                options = dataRPS.semester;
            } else if (type === 'kbk') {
                options = dataRPS.kbk;
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

        // Initial chart load
        document.getElementById('filterType').dispatchEvent(new Event('change'));
    });
</script>
@endsection

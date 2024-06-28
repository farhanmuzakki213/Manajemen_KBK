@extends('admin.admin_master')

@section('admin')
<div class="container py-5">
    <div class="charts-row py-5">
        <!-- RPS Chart -->
        <div class="chart-container">
            <h3 class="text-center">RPS</h3>
            <div id="chartRPS"></div>
            <div class="row justify-content-center text-center mt-3">
                <div class="col-md-5 mb-4">
                    <div class="card bg-primary text-white mx-auto h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Unggahan</h5>
                            <p class="card-text">{{ $banyak_pengunggahan_rps }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-4">
                    <div class="card bg-success text-white mx-auto h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Verifikasi</h5>
                            <p class="card-text">{{ $banyak_verifikasi_rps }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- UAS Chart -->
        <div class="chart-container">
            <h3 class="text-center">UAS</h3>
            <div id="chartUAS"></div>
            <div class="row justify-content-center text-center mt-3">
                <div class="col-md-5 mb-4">
                    <div class="card bg-primary text-white mx-auto h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Unggahan</h5>
                            <p class="card-text">{{ $banyak_pengunggahan_uas }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-4">
                    <div class="card bg-success text-white mx-auto h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Verifikasi</h5>
                            <p class="card-text">{{ $banyak_verifikasi_uas }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proposal TA Chart -->
        <div class="chart-container">
            <h3 class="text-center">Proposal TA</h3>
            <div id="chartTA"></div>
            <div class="row justify-content-center text-center mt-3">
                <div class="col-md-5 mb-4">
                    <div class="card bg-primary text-white mx-auto h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Proposal</h5>
                            <p class="card-text">{{ $jumlah_proposal }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-4">
                    <div class="card bg-success text-white mx-auto h-100">
                        <div class="card-body d-flex flex-column justify-content-center">
                            <h5 class="card-title">Review</h5>
                            <p class="card-text">{{ $jumlah_review_proposal }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Load ApexCharts Library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Define data from Blade variables
        var banyakPengunggahanRPS = @json($banyak_pengunggahan_rps);
        var banyakVerifikasiRPS = @json($banyak_verifikasi_rps);
        var banyakPengunggahanUas = @json($banyak_pengunggahan_uas);
        var banyakVerifikasiUas = @json($banyak_verifikasi_uas);
        var jumlahProposal = @json($jumlah_proposal);
        var jumlahReviewProposal = @json($jumlah_review_proposal);

        // Common chart options to ensure consistent appearance
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
                                label: 'Total',
                                formatter: function (w) {
                                    return w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return value + ' data';
                    }
                }
            },
            legend: {
                position: 'bottom'
            },
            colors: ['#008FFB', '#00E396']
        };

        // Options for RPS Chart
        var optionsRPS = {
            ...commonOptions,
            series: [banyakPengunggahanRPS, banyakVerifikasiRPS],
            labels: ['Unggahan', 'Verifikasi']
        };

        // Render RPS Chart
        var chartRPS = new ApexCharts(document.querySelector("#chartRPS"), optionsRPS);
        chartRPS.render();

        // Options for UAS Chart
        var optionsUAS = {
            ...commonOptions,
            series: [banyakPengunggahanUas, banyakVerifikasiUas],
            labels: ['Unggahan', 'Verifikasi']
        };

        // Render UAS Chart
        var chartUAS = new ApexCharts(document.querySelector("#chartUAS"), optionsUAS);
        chartUAS.render();

        // Options for Proposal TA Chart
        var optionsTA = {
            ...commonOptions,
            series: [jumlahProposal, jumlahReviewProposal],
            labels: ['Proposal', 'Review']
        };

        // Render Proposal TA Chart
        var chartTA = new ApexCharts(document.querySelector("#chartTA"), optionsTA);
        chartTA.render();
    });
</script>

<style>
    .charts-row {
        display: flex;
        justify-content: space-around; /* Distribute charts evenly */
        align-items: flex-start;
        gap: 20px; /* Space between charts */
        flex-wrap: wrap; /* Ensure charts remain neat on small screens */
    }

    .chart-container {
        flex: 1 1 30%; /* Each chart uses around 30% of the container's width */
        min-width: 300px; /* Minimum width to prevent charts from being too small */
        margin: 0 auto; /* Center align the chart container */
    }

    .chart-container h3 {
        margin-bottom: 20px; /* Space between heading and chart */
    }

    .card {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        min-height: 100px; /* Ensure cards have consistent height */
        margin: 0 auto; /* Center align the card */
    }

    #chartRPS, #chartUAS, #chartTA {
        width: 100%;
        height: 300px; /* Adequate height for charts */
    }
</style>
@endsection

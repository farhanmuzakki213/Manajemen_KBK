@extends('admin.admin_master')

@section('admin')
<div class="container py-5">
    <div class="charts-row py-5">
        <div class="chart-container">
            <h3 class="text-center">RPS</h3>
            <div id="chartRPS"></div>
            <div class="text-center mt-3">
                <p><strong>Unggahan:</strong> {{ $banyak_pengunggahan_rps }}</p>
                <p><strong>Verifikasi:</strong> {{ $banyak_verifikasi_rps }}</p>
            </div>
        </div>
        <div class="chart-container">
            <h3 class="text-center">UAS</h3>
            <div id="chartUAS"></div>
            <div class="text-center mt-3">
                <p><strong>Unggahan:</strong> {{ $banyak_pengunggahan_uas }}</p>
                <p><strong>Verifikasi:</strong> {{ $banyak_verifikasi_uas }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Load ApexCharts Library -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Data from Blade variables
        var banyakPengunggahanRPS = @json($banyak_pengunggahan_rps);
        var banyakVerifikasiRPS = @json($banyak_verifikasi_rps);
        var banyakPengunggahanUas = @json($banyak_pengunggahan_uas);
        var banyakVerifikasiUas = @json($banyak_verifikasi_uas);

        // Common options for both charts
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
    });
</script>

<style>
    .charts-row {
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        gap: 20px; /* Space between charts */
        flex-wrap: wrap; /* Ensure charts remain neat on small screens */
    }
    .chart-container {
        flex: 1 1 45%; /* Each chart uses around 45% of the container's width */
        min-width: 300px; /* Minimum width to prevent charts from being too small */
    }
    #chartRPS, #chartUAS {
        width: 100%;
        height: 300px; /* Adequate height for charts */
        margin: 0 auto; /* Center align charts */
    }
</style>
@endsection

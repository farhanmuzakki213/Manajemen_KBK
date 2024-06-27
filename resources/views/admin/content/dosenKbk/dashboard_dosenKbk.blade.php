@extends('admin.admin_master')
@section('admin')
<div class="container fluid">
    <div class="card">
        <div class="card-body">
            <div class="charts-row py-5">
                <div class="chart-container">
                <div class="chart-container">
                    <h3>Proposal TA</h3>
                    <div id="chartTA"></div>
                    <p><strong>Penugasan:</strong> {{ $jumlah_proposal }}</p>
                    <p><strong>Review:</strong> {{ $jumlah_review_proposal }}</p>
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
        var jumlahProposal = @json($jumlah_proposal); // Correct variable name
        var jumlahReviewProposal = @json($jumlah_review_proposal); // Correct variable name

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

        // Options for Proposal TA Chart
        var optionsTA = {
            ...commonOptions,
            series: [jumlahProposal, jumlahReviewProposal],
            labels: ['Proposal', 'Review'],
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
                        },
                        minAngleToShowLabel: 0, // Ensure small slices are visible
                        expandOnClick: true // Allow slices to expand on click for better visibility
                    }
                }
            }
        };

        // Render Proposal TA Chart
        var chartTA = new ApexCharts(document.querySelector("#chartTA"), optionsTA);
        chartTA.render();
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
    #chartRPS, #chartUAS, #chartTA {
        width: 100%;
        height: 300px; /* Adequate height for charts */
    }
    </style>
    @endsection

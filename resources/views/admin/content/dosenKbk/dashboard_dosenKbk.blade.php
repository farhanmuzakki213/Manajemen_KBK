@extends('admin.admin_master')
@section('styles')
<style>
    .charts-row {
        display: flex;
        justify-content: center; /* Center align the charts */
        align-items: flex-start;
        gap: 20px; /* Space between charts */
        flex-wrap: wrap; /* Ensure charts remain neat on small screens */
    }
    .chart-container {
        flex: 1 1 45%; /* Each chart uses around 45% of the container's width */
        min-width: 300px; /* Minimum width to prevent charts from being too small */
        margin: 0 auto; /* Center align the chart container */
    }
    #chartTA {
        width: 100%;
        height: 300px; /* Adequate height for charts */
    }
    .card {
        min-height: 100px; /* Minimum height for card consistency */
        margin: 0 auto; /* Center align the card */
    }
</style>
@endsection
@section('admin')
<div class="container py-5">
    <div class="charts-row py-5">
        <div class="chart-container">
            <h3 class="text-center">Proposal TA</h3>
            <div id="chartTA"></div>
            <div class="row justify-content-center text-center mt-3">
                <!-- Card for Penugasan -->
                <div class="col-md-2 mb-4">
                    <div class="card bg-primary text-white mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Penugasan</h5>
                            <p class="card-text">{{ $jumlah_proposal }}</p>
                        </div>
                    </div>
                </div>
                <!-- Card for Review -->
                <div class="col-md-2 mb-4">
                    <div class="card bg-success text-white mx-auto">
                        <div class="card-body">
                            <h5 class="card-title">Review</h5>
                            <p class="card-text">{{ $jumlah_review_proposal }}</p>
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
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        // Data from Blade variables
        var jumlahProposal = @json($jumlah_proposal); // Correct variable name
        var jumlahReviewProposal = @json($jumlah_review_proposal); // Correct variable name
        var percentProposalTA = @json($percentProposalTA);
        var percentReviewProposalTA = @json($percentReviewProposalTA);

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
                                label: 'Penugasan',
                                formatter: function (w) {
                                    return jumlahReviewProposal;
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (value, { seriesIndex }) {
                // Custom tooltip text based on the series index
                        if (seriesIndex === 0) {
                            return jumlahProposal + ' data';
                        } else if (seriesIndex === 1) {
                            return jumlahReviewProposal + ' data';
                        }
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
            series: [percentProposalTA, percentReviewProposalTA],
            labels: ['Penugasan', 'Review']
        };

        // Render Proposal TA Chart
        var chartTA = new ApexCharts(document.querySelector("#chartTA"), optionsTA);
        chartTA.render();
    });
</script>
@endsection
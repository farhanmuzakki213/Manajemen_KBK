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
                        <h3 class="fw-semibold text-center mb-3">Penugasan dan Review Proposal TA</h3>

                        <div class="row">

                            <div class="col-lg-8 d-flex align-items-stretch">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                                            <div class="mb-3 mb-sm-0">
                                                {{-- <h5 class="card-title fw-semibold">Data Penugasan dan Review Proposal TA</h5> --}}
                                            </div>
                                            <div>

                                            </div>
                                        </div>
                                        <div id="uploadReviewChart"></div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="col-lg-12">

                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row align-items-start" style="height: 122.5px">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Penugasan</h5>
                                                    <h4 class="fw-semibold mb-3">{{ $jumlah_proposal }}</h4>
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
                                            <div class="row align-items-start" style="height: 122.5px">
                                                <div class="col-8">
                                                    <h5 class="card-title mb-9 fw-semibold">Review</h5>
                                                    <h4 class="fw-semibold mb-3">{{ $jumlah_review_proposal }}</h4>
                                                    <div class="d-flex align-items-center pb-1">
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="d-flex justify-content-end">
                                                        <div
                                                            class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
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
                                    <div class="chart-container">
                                        {{-- <h3 class="text-center">Proposal TA</h3> --}}
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

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            // Data from Blade variables
            var jumlahProposal = @json($jumlah_proposal);
            var jumlahReviewProposal = @json($jumlah_review_proposal);
            var percentProposalTA = @json($percentProposalTA);
            var percentReviewProposalTA = @json($percentReviewProposalTA);

            // Bar Chart Configuration
            var barChartOptions = {
                series: [{
                        name: "Penugasan",
                        data: [jumlahProposal]
                    },
                    {
                        name: "Review",
                        data: [jumlahReviewProposal]
                    }
                ],
                chart: {
                    type: "bar",
                    height: 300,
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
                colors: ["#5D87FF", "#49BEFF"],
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
                    max: Math.max(jumlahProposal, jumlahReviewProposal) + 10,
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
            var barChart = new ApexCharts(document.querySelector("#uploadReviewChart"), barChartOptions);
            barChart.render();

            // Donut Chart Configuration (unchanged from your code)
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
                                    label: 'Total Data',
                                    formatter: function(w) {
                                        // return jumlahReviewProposal;
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
                colors: ['#008FFB', '#49BEFF']
            };

            // Options for Proposal TA Chart
            var optionsTA = {
                ...commonOptions,
                series: [jumlahProposal, jumlahReviewProposal],
                labels: ['Penugasan', 'Review']
            };

            // Render Proposal TA Chart
            var chartTA = new ApexCharts(document.querySelector("#chartTA"), optionsTA);
            chartTA.render();
        });
    </script>
@endsection

@extends('admin.admin_master')
@section('styles')
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
        min-height: 100px; /* Minimum height for card consistency */
        margin: 0 auto; /* Center align the card */
    }

    #chartRPS, #chartUAS, #chartTA {
        width: 100%;
        height: 300px; /* Adequate height for charts */
    }
</style>
@endsection
@section('admin')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 mb-3">
                <form id="filterForm" action="{{ route('dashboard_pimpinan') }}" method="GET">
                    <label for="prodiSelect" class="form-label">Pilih Prodi:</label>
                    <select id="prodiSelect" class="form-select" name="prodi_id">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodi as $single_prodi)
                            <option value="{{ $single_prodi->id_prodi }}" {{ request('prodi_id') == $single_prodi->id_prodi ? 'selected' : '' }}>
                                {{ $single_prodi->prodi }}
                            </option>
                        @endforeach
                    </select>
                    {{-- <button type="submit" class="btn btn-primary mt-3">Filter</button> --}}
                </form>
            </div>
        </div>

        @php
            $selectedProdi = $prodi->firstWhere('id_prodi', request('prodi_id'));
            $title = $selectedProdi ? $selectedProdi->prodi : 'Semua Prodi';
        @endphp

        <h2 class="text-center mt-5">{{ $title }}</h2>

        <div class="charts-row py-5">
            <!-- RPS Chart -->
            <div class="chart-container">
                <h3 class="text-center">RPS</h3>
                <div id="chartRPS"></div>
                <div class="row justify-content-center text-center mt-3">
                    <div class="col-md-5 mb-4">
                        <div class="card bg-primary text-white mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Unggahan</h5>
                                <p class="card-text" id="banyakPengunggahanRPS">{{ $total_banyak_pengunggahan_rps }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mb-4">
                        <div class="card bg-success text-white mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Verifikasi</h5>
                                <p class="card-text" id="banyakVerifikasiRPS">{{ $total_banyak_verifikasi_rps }}</p>
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
                        <div class="card bg-primary text-white mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Unggahan</h5>
                                <p class="card-text" id="banyakPengunggahanUAS">{{ $total_banyak_pengunggahan_uas }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mb-4">
                        <div class="card bg-success text-white mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Verifikasi</h5>
                                <p class="card-text" id="banyakVerifikasiUAS">{{ $total_banyak_verifikasi_uas }}</p>
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
                        <div class="card bg-primary text-white mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Proposal</h5>
                                <p class="card-text" id="jumlahProposal">{{ $total_jumlah_proposal }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 mb-4">
                        <div class="card bg-success text-white mx-auto">
                            <div class="card-body">
                                <h5 class="card-title">Review</h5>
                                <p class="card-text" id="jumlahReviewProposal">{{ $total_jumlah_review_proposal }}</p>
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
            var filterForm = document.getElementById('filterForm'); // Add form ID here

            prodiSelect.addEventListener('change', function() {
                filterForm.submit(); // Submit form on change
            });

            function updateTitle(prodiId) {
                var selectedProdi = prodiSelect.options[prodiSelect.selectedIndex].text;
                document.querySelector('.text-center.mt-5').textContent = 'Prodi ' + (selectedProdi || 'Semua Prodi');
            }

            // Function to update charts and text values
            function updateCharts(data) {
                chartRPS.updateSeries([data.total_banyak_pengunggahan_rps, data.total_banyak_verifikasi_rps]);
                chartUAS.updateSeries([data.total_banyak_pengunggahan_uas, data.total_banyak_verifikasi_uas]);
                chartTA.updateSeries([data.total_jumlah_proposal, data.total_jumlah_review_proposal]);

                document.getElementById('banyakPengunggahanRPS').textContent = data.total_banyak_pengunggahan_rps;
                document.getElementById('banyakVerifikasiRPS').textContent = data.total_banyak_verifikasi_rps;
                document.getElementById('banyakPengunggahanUAS').textContent = data.total_banyak_pengunggahan_uas;
                document.getElementById('banyakVerifikasiUAS').textContent = data.total_banyak_verifikasi_uas;
                document.getElementById('jumlahProposal').textContent = data.total_jumlah_proposal;
                document.getElementById('jumlahReviewProposal').textContent = data.total_jumlah_review_proposal;
            }

            // Initial chart data
            var initialData = {
                total_banyak_pengunggahan_rps: {{ $total_banyak_pengunggahan_rps }},
                total_banyak_verifikasi_rps: {{ $total_banyak_verifikasi_rps }},
                total_banyak_pengunggahan_uas: {{ $total_banyak_pengunggahan_uas }},
                total_banyak_verifikasi_uas: {{ $total_banyak_verifikasi_uas }},
                total_jumlah_proposal: {{ $total_jumlah_proposal }},
                total_jumlah_review_proposal: {{ $total_jumlah_review_proposal }}
            };

            // Common chart options
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
                                    label: 'Verifikasi',
                                    formatter: function(w) {
                                        // Mengembalikan jumlah verifikasi RPS
                                        return initialData.total_banyak_verifikasi_rps;
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
                colors: ['#008FFB', '#00E396']
            };

            // Options for RPS Chart
            var optionsRPS = {
                ...commonOptionsRPS,
                series: [initialData.total_banyak_pengunggahan_rps, initialData.total_banyak_verifikasi_rps],
                labels: ['Unggahan', 'Verifikasi']
            };

            // Render RPS Chart
            var chartRPS = new ApexCharts(document.querySelector("#chartRPS"), optionsRPS);
            chartRPS.render();

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
                                    label: 'Verifikasi',
                                    formatter: function(w) {
                                        // Mengembalikan jumlah verifikasi RPS
                                        return initialData.total_banyak_verifikasi_uas;
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
                colors: ['#008FFB', '#00E396']
            };

            // Options for UAS Chart
            var optionsUAS = {
                ...commonOptionsUAS,
                series: [initialData.total_banyak_pengunggahan_uas, initialData.total_banyak_verifikasi_uas],
                labels: ['Unggahan', 'Verifikasi']
            };

            // Render UAS Chart
            var chartUAS = new ApexCharts(document.querySelector("#chartUAS"), optionsUAS);
            chartUAS.render();

            // Options for Proposal TA Chart

            var commonOptionsTA = {
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
                                    label: 'Review',
                                    formatter: function(w) {
                                        // Mengembalikan jumlah verifikasi RPS
                                        return initialData.total_jumlah_review_proposal;
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
                colors: ['#008FFB', '#00E396']
            };

            var optionsTA = {
                ...commonOptionsTA,
                series: [initialData.total_jumlah_proposal, initialData.total_jumlah_review_proposal],
                labels: ['Proposal', 'Review']
            };

            // Render Proposal TA Chart
            var chartTA = new ApexCharts(document.querySelector("#chartTA"), optionsTA);
            chartTA.render();
        });
    </script>
@endsection
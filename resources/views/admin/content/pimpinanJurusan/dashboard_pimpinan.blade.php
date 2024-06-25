@extends('admin.admin_master')

@section('admin')
    <div class="container py-5">
        <div class="row">
            <div class="col-md-4 mb-3">
                <form action="{{ route('dashboard_pimpinan') }}" method="GET">
                    <label for="prodiSelect" class="form-label">Pilih Prodi:</label>
                    <select id="prodiSelect" class="form-select" name="prodi_id">
                        <option value="">Semua Prodi</option>
                        @foreach ($prodi as $single_prodi)
                            <option value="{{ $single_prodi->id_prodi }}" {{ request('prodi_id') == $single_prodi->id_prodi ? 'selected' : '' }}>{{ $single_prodi->prodi }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary mt-3">Filter</button>
                </form>
            </div>
        </div>
        
        @php
            $selectedProdi = $prodi->firstWhere('id_prodi', request('prodi_id'));
            $title = $selectedProdi ? $selectedProdi->prodi : 'Semua Prodi';
        @endphp

        <h2 class="text-center mt-5">{{ $title }}</h2>

        <div class="charts-row py-5">
            <div class="chart-container chart-container-center">
                <h3>RPS</h3>
                <div id="chartRPS"></div>
                <div class="text-center">
                    <p><strong>Unggahan:</strong> <span id="banyakPengunggahanRPS">{{ $total_banyak_pengunggahan_rps }}</span></p>
                    <p><strong>Verifikasi:</strong> <span id="banyakVerifikasiRPS">{{ $total_banyak_verifikasi_rps }}</span></p>
                </div>
            </div>
            <div class="chart-container chart-container-center">
                <h3>UAS</h3>
                <div id="chartUAS"></div>
                <div class="text-center">
                    <p><strong>Unggahan:</strong> <span id="banyakPengunggahanUAS">{{ $total_banyak_pengunggahan_uas }}</span></p>
                    <p><strong>Verifikasi:</strong> <span id="banyakVerifikasiUAS">{{ $total_banyak_verifikasi_uas }}</span></p>
                </div>
            </div>
            <div class="chart-container chart-container-center">
                <h3>Proposal TA</h3>
                <div id="chartTA"></div>
                <div class="text-center">
                    <p><strong>Proposal:</strong> <span id="jumlahProposal">{{ $total_jumlah_proposal }}</span></p>
                    <p><strong>Review:</strong> <span id="jumlahReviewProposal">{{ $total_jumlah_review_proposal }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Load ApexCharts Library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <!-- Load Axios Library for making HTTP requests -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            var prodiSelect = document.getElementById('prodiSelect');

            prodiSelect.addEventListener('change', function() {
                var prodiId = prodiSelect.value;
                axios.get('{{ route("dashboard_pimpinan") }}', {
                    params: {
                        prodi_id: prodiId
                    }
                })
                .then(function(response) {
                    var data = response.data;
                    updateCharts(data);
                    updateTitle(prodiId);
                })
                .catch(function(error) {
                    console.error('Error fetching data:', error);
                });
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
                colors: ['#008FFB', '#00E396']
            };

            // Options for RPS Chart
            var optionsRPS = {
                ...commonOptions,
                series: [initialData.total_banyak_pengunggahan_rps, initialData.total_banyak_verifikasi_rps],
                labels: ['Unggahan', 'Verifikasi']
            };

            // Render RPS Chart
            var chartRPS = new ApexCharts(document.querySelector("#chartRPS"), optionsRPS);
            chartRPS.render();

            // Options for UAS Chart
            var optionsUAS = {
                ...commonOptions,
                series: [initialData.total_banyak_pengunggahan_uas, initialData.total_banyak_verifikasi_uas],
                labels: ['Unggahan', 'Verifikasi']
            };

            // Render UAS Chart
            var chartUAS = new ApexCharts(document.querySelector("#chartUAS"), optionsUAS);
            chartUAS.render();

            // Options for Proposal TA Chart
            var optionsTA = {
                ...commonOptions,
                series: [initialData.total_jumlah_proposal, initialData.total_jumlah_review_proposal],
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
            justify-content: space-around;
            align-items: flex-start;
            gap: 20px; /* Space between charts */
            flex-wrap: wrap; /* Ensure charts remain neat on small screens */
        }

        .chart-container {
            flex: 1 1 45%; /* Each chart uses around 45% of the container's width */
            min-width: 300px; /* Minimum width to prevent charts from being too small */
        }

        .chart-container-center {
            text-align: center; /* Center-align text in this container */
        }

        #chartRPS, #chartUAS, #chartTA {
            width: 100%;
            height: 300px; /* Adequate height for charts */
        }
    </style>
@endsection

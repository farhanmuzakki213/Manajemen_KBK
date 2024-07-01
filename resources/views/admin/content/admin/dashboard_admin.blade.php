@extends('admin.admin_master')
@section('admin')
<div class="container-fluid">
    <div class="row">
        <!-- Chart for RPS -->
        <div class="col-md-6">
            <h4>Chart RPS</h4>
            <div id="chart-rps" style="min-height: 350px;"></div>
        </div>
        <!-- Chart for UAS -->
        <div class="col-md-6">
            <h4>Chart UAS</h4>
            <div id="chart-uas" style="min-height: 350px;"></div>
        </div>
        <!-- Chart for TA -->
        <div class="col-md-12">
            <h4>Chart TA</h4>
            <div id="chart-ta" style="min-height: 350px;"></div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data for RPS Chart
        const banyak_pengunggahan_rps = @json($banyak_pengunggahan_rps);
        const banyak_verifikasi_rps = @json($banyak_verifikasi_rps);
        const banyak_berita_rps = @json($banyak_berita_rps);
        const semester_rps = @json($semester_rps);

        const chartRps = new ApexCharts(document.querySelector("#chart-rps"), {
            chart: { type: 'bar', height: 350 },
            series: [
                { name: 'Pengunggahan', data: Object.values(banyak_pengunggahan_rps) },
                { name: 'Verifikasi', data: Object.values(banyak_verifikasi_rps) },
                { name: 'Berita Acara', data: Object.values(banyak_berita_rps) }
            ],
            xaxis: { categories: Object.keys(banyak_pengunggahan_rps) },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value); // Ensure only whole numbers are displayed
                    }
                }
            }
        });

        chartRps.render();

        // Data for UAS Chart
        const banyak_pengunggahan_uas = @json($banyak_pengunggahan_uas);
        const banyak_verifikasi_uas = @json($banyak_verifikasi_uas);
        const banyak_berita_uas = @json($banyak_berita_uas);
        const semester_uas = @json($semester_uas);

        const chartUas = new ApexCharts(document.querySelector("#chart-uas"), {
            chart: { type: 'bar', height: 350 },
            series: [
                { name: 'Pengunggahan', data: Object.values(banyak_pengunggahan_uas) },
                { name: 'Verifikasi', data: Object.values(banyak_verifikasi_uas) },
                { name: 'Berita Acara', data: Object.values(banyak_berita_uas) }
            ],
            xaxis: { categories: Object.keys(banyak_pengunggahan_uas) },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value); // Ensure only whole numbers are displayed
                    }
                }
            }
        });

        chartUas.render();

        // Data for TA Chart
        const bulan = @json($bulan);
        const review = @json($review);
        const statuses = @json($statuses);
        const colors = ['#008FFB', '#FF4560', '#FEB019', '#00E396']; // Tambahkan warna sesuai dengan jumlah status

        const seriesData = statuses.map((status, index) => ({
            name: status,
            data: review.map(monthData => monthData[status] || 0),
            color: colors[index] // Set color for each status
        }));

        const chartTa = new ApexCharts(document.querySelector("#chart-ta"), {
            chart: { type: 'bar', height: 350 },
            series: seriesData,
            xaxis: { categories: bulan },
            yaxis: {
                labels: {
                    formatter: function (value) {
                        return Math.round(value); // Ensure only whole numbers are displayed
                    }
                }
            }
        });

        chartTa.render();
    });
</script>
@endsection
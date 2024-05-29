@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Grafik dan Tabel Review dan Status Proposal</h5>
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Grafik</h6>
                            </div>
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
                        </div>
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Judul Proposal</th>
                                            <th>Tanggal Penugasan</th>
                                            <th>Tanggal Review</th>
                                            <th>Status Proposal</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Judul Proposal</th>
                                            <th>Tanggal Penugasan</th>
                                            <th>Tanggal Review</th>
                                            <th>Status Proposal</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_proposal as $data)
                                        <tr class="table-Light">
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{ $data->nama }}</th>
                                            <th>{{ $data->nim }}</th>
                                            <th>{{ $data->judul }}</th>
                                            <th>{{ $data->tanggal_penugasan }}</th>
                                            <th>{{ $data->tanggal_review }}</th>
                                            <th>
                                                @if ($data->status_review_proposal == 0)
                                                    Diajukan
                                                @elseif ($data->status_review_proposal == 1)
                                                    Ditolak
                                                @elseif ($data->status_review_proposal == 2)
                                                    Direvisi
                                                @elseif ($data->status_review_proposal == 3)
                                                    Diterima
                                                @endif
                                            </th>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript">
        var review = <?php echo json_encode($review); ?>;
        var statuses = <?php echo json_encode($statuses); ?>;
        var bulan = <?php echo json_encode($bulan); ?>;

        var series = statuses.map((status) => ({
            name: status,
            data: review.map(monthlyData => monthlyData[status] ?? 0)
        }));

        var options = {
            series: series,
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '15%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: bulan,
            },
            yaxis: {
                title: {
                    text: 'Jumlah'
                },
                labels: {
                    formatter: function (value) {
                        if (Number.isInteger(value)) {
                            return value;
                        }
                        return '';
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return parseInt(val) + " Proposal";
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection

@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Grafik dan Tabel Pengunggahan dan Verifikasi UAS</h5>
                <div class="container-fluid">
                    <!-- DataVerifikasiRPS -->
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
                                            <th>Matakuliah</th>
                                            <th>Dosen Pengampu</th>
                                            <th>Semester</th>
                                            <th>Tanggal Pengunggahan</th>
                                            <th>Status Verifikasi</th>
                                            <th>Tanggal Verifikasi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Matakuliah</th>
                                            <th>Dosen Pengampu</th>
                                            <th>Semester</th>
                                            <th>Tanggal Pengunggahan</th>
                                            <th>Status Verifikasi</th>
                                            <th>Tanggal Verifikasi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_ver_uas as $data)
                                        <tr class="table-Light">
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{$data->nama_matkul}}</th>
                                            <th>{{$data->nama_dosen}}</th>
                                            <th>{{$data->smt_thnakd}}</th>
                                            <th>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}</th>
                                            <th>
                                                @if ($data->status_ver_uas == 0)
                                                    Tidak Diverifikasi
                                                @else
                                                    Diverifikasi
                                                @endif
                                            </th>
                                            <th>{{$data->tanggal_diverifikasi}}</th>
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
        var pengunggahan = <?php echo json_encode($banyak_pengunggahan); ?>;
        var verifikasi = <?php echo json_encode($banyak_verifikasi); ?>;
        var semester = <?php echo json_encode($semester); ?>;
    
        var options = {
            series: [
                {
                    name: 'Banyak Pengunggahan',
                    data: Object.values(pengunggahan)
                },
                {
                    name: 'Banyak Verifikasi',
                    data: Object.values(verifikasi)
                }
            ],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '5%',
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
                categories: Object.values(semester),
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
                        return parseInt(val) + " RPS";
                    }
                }
            }
        };
    
        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>    
@endsection

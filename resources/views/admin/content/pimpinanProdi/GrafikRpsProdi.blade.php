@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Grafik dan Tabel Pengunggahan dan Verifikasi RPS</h5>
                <div class="container-fluid">
                    <div>
                        <select id="filterType">
                            <option value="smt">Semester</option>
                            <option value="kbk">KBK</option>
                        </select>

                        <select id="filterValue" hidden>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="card shadow my-4">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Grafik</h6>
                            </div>
                            <div class="card-body">
                                <div id="chart"></div>
                            </div>
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
                                        <th>Prodi</th>
                                        <th>Jenis KBK</th>
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
                                        <th>Prodi</th>
                                        <th>Jenis KBK</th>
                                        <th>Tanggal Pengunggahan</th>
                                        <th>Status Verifikasi</th>
                                        <th>Tanggal Verifikasi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @foreach ($data['data_ver_rps'] as $data_ver)
                                        <tr class="table-Light">
                                            <th>{{ $loop->iteration }}</th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->nama_matkul }}</th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_dosen_matkul->r_dosen->nama_dosen }}</th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_smt_thnakd->smt_thnakd }}</th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->r_kurikulum->r_prodi->prodi }}</th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_jenis_kbk->jenis_kbk }}</th>
                                            <th>{{ \Carbon\Carbon::parse($data_ver->created_at)->format('d-m-Y') }}</th>
                                            <th>
                                                @if ($data_ver->rekomendasi == 0)
                                                    Belum Diverifikasi
                                                @elseif ($data_ver->rekomendasi == 1)
                                                    Tidak Layak Pakai
                                                @elseif ($data_ver->rekomendasi == 2)
                                                    Butuh Revisi
                                                @else
                                                    Layak Pakai
                                                @endif
                                            </th>
                                            <th>{{$data_ver->tanggal_diverifikasi}}</th>
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
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const data = <?php echo json_encode($data); ?>;
        let chart;

        function updateChart(type, value) {
            let labels = [];
            let pengunggahanData = [];
            let verifikasiData = [];
            let beritaData = [];
            let beritaDataVer = [];

            if (type === 'smt') {
                labels = Object.keys(data.banyak_pengunggahan_smt);
                pengunggahanData = Object.values(data.banyak_pengunggahan_smt);
                verifikasiData = Object.values(data.banyak_verifikasi_smt);
                beritaData = Object.values(data.banyak_berita_smt);
                beritaDataVer = Object.values(data.banyak_berita_ver_smt);
            } else if (type === 'kbk') {
                labels = Object.keys(data.banyak_pengunggahan_kbk);
                pengunggahanData = Object.values(data.banyak_pengunggahan_kbk);
                verifikasiData = Object.values(data.banyak_verifikasi_kbk);
                beritaData = Object.values(data.banyak_berita_kbk);
                beritaDataVer = Object.values(data.banyak_berita_ver_kbk);
            }

            const options = {
                series: [
                    {
                        name: 'Banyak Pengunggahan',
                        data: pengunggahanData
                    },
                    {
                        name: 'Banyak Verifikasi',
                        data: verifikasiData
                    },
                    {
                        name: 'Banyak Verifikasi Rps di Berita Acara',
                        data: beritaDataVer
                    },
                    {
                        name: 'Banyak Pengunggahan Berita Acara',
                        data: beritaData
                    }
                ],
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
                    categories: labels
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

            if (chart) {
                chart.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            }
        }

        document.getElementById('filterType').addEventListener('change', function() {
            const type = this.value;
            const filterValueSelect = document.getElementById('filterValue');
            filterValueSelect.innerHTML = '';

            let options = [];
            if (type === 'smt') {
                options = data.semester;
            } else if (type === 'kbk') {
                options = data.kbk;
            }

            options.forEach(option => {
                const opt = document.createElement('option');
                opt.value = option;
                opt.text = option;
                filterValueSelect.add(opt);
            });

            updateChart(type, filterValueSelect.value);
        });

        document.getElementById('filterValue').addEventListener('change', function() {
            const type = document.getElementById('filterType').value;
            updateChart(type, this.value);
        });

        // Initial chart load
        document.getElementById('filterType').dispatchEvent(new Event('change'));
    </script>
@endsection

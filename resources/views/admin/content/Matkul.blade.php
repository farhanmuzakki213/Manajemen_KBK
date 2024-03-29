@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Mata Kuliah</h5>
                <div class="container-fluid">
                    <!-- Data Mata Kuliah -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Kode Matkul</th>
                                            <th>Nama Matkul</th>
                                            <th>TP</th>
                                            <th>SKS</th>
                                            <th>Jam</th>
                                            <th>SKS Teori</th>
                                            <th>SKS Praktek</th>
                                            <th>Jam Teori</th>
                                            <th>Jam Praktek</th>
                                            <th>Semester</th>
                                            <th>Nama Kurikulum</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Kode Matkul</th>
                                            <th>Nama Matkul</th>
                                            <th>TP</th>
                                            <th>SKS</th>
                                            <th>Jam</th>
                                            <th>SKS Teori</th>
                                            <th>SKS Praktek</th>
                                            <th>Jam Teori</th>
                                            <th>Jam Praktek</th>
                                            <th>Semester</th>
                                            <th>Nama Kurikulum</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_matkul as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_matkul}}</th>
                                            <th>{{$data->kode_matkul}}</th>
                                            <th>{{$data->nama_matkul}}</th>
                                            <th>{{$data->TP}}</th>
                                            <th>{{$data->sks}}</th>
                                            <th>{{$data->jam}}</th>
                                            <th>{{$data->sks_teori}}</th>
                                            <th>{{$data->sks_praktek}}</th>
                                            <th>{{$data->jam_teori}}</th>
                                            <th>{{$data->jam_praktek}}</th>
                                            <th>{{$data->semester}}</th>
                                            <th>{{$data->nama_kurikulum}}</th>
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
@endsection

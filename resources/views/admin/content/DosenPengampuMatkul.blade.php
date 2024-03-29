@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Dosen Pengampu Mata Kuliah</h5>
                <div class="container-fluid">
                    <!-- DataDosen Pengampu Mata Kuliah -->
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
                                            <th>Nama Dosen</th>
                                            <th>Mata Kuliah</th>
                                            <th>kelas</th>
                                            <th>Tahun Ajaran</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Dosen</th>
                                            <th>Mata Kuliah</th>
                                            <th>kelas</th>
                                            <th>Tahun Ajaran</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_dosen_pengampu as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_dosen_matkul}}</th>
                                            <th>{{$data->nama_dosen}}</th>
                                            <th>{{$data->nama_kelas}}</th>
                                            <th>{{$data->nama_matkul}}</th>
                                            <th>{{$data->smt_thnakd}}</th>
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

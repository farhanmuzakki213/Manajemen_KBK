@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Prodi</h5>
                <div class="container-fluid">
                    <!-- Data Prodi -->
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
                                            <th>Kode_Prodi</th>
                                            <th>Prodi</th>
                                            <th>Jurusan</th>
                                            <th>Jenjang</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Kode_Prodi</th>
                                            <th>Prodi</th>
                                            <th>Jurusan</th>
                                            <th>Jenjang</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_prodi as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_prodi}}</th>
                                            <th>{{$data->kode_prodi}}</th>
                                            <th>{{$data->prodi}}</th>
                                            <th>{{$data->jurusan}}</th>
                                            <th>{{$data->jenjang}}</th>
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
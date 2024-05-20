@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Pimpinan Jurusan</h5>
                <div class="container-fluid">
                    <!-- Data Pimpinan Jurusan -->
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
                                            <th>Jabatan Pimpinan</th>
                                            <th>Jurusan</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Dosen</th>
                                            <th>Jabatan Pimpinan</th>
                                            <th>Jurusan</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_pimpinan_jurusan as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_pimpinan_jurusan}}</th>
                                            <th>{{$data->nama_dosen}}</th>
                                            <th>{{$data->jabatan_pimpinan}}</th>
                                            <th>{{$data->jurusan}}</th>
                                            <th>{{$data->periode}}</th>
                                            <th>
                                                @if ($data->status_pimpinan_jurusan == 0)
                                                    Tidak Aktif
                                                @else
                                                    Aktif
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
@endsection

@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Mahasiswa</h5>
                <div class="container-fluid">
                    <!-- DataMahasiswa -->
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
                                            <th>Nim</th>
                                            <th>Name</th>
                                            <th>Jurusan</th>
                                            <th>prodi</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nim</th>
                                            <th>Name</th>
                                            <th>Jurusan</th>
                                            <th>prodi</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_mahasiswa as $data)                                        
                                            <tr class="table-Light">
                                                <th>{{ $data->id_mahasiswa }}</th>
                                                <th>{{ $data->nim }}</th>
                                                <th>{{ $data->nama }}</th>
                                                <th>{{ $data->jurusan }}</th>
                                                <th>{{ $data->prodi }}</th>
                                                <th>{{ $data->gender }}</th>
                                                <th>
                                                    @if ($data->status_mahasiswa == 0)
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

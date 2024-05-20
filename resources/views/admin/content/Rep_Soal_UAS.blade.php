@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Repositori Soal Uas</h5>
                <div class="container-fluid">
                    <!-- DataRepositori Soal Uas -->
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
                                            <th>Name</th>
                                            <th>Nidn</th>
                                            <th>Nip</th>
                                            <th>gender</th>
                                            <th>Jurusan</th>
                                            <th>prodi</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Foto</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Nidn</th>
                                            <th>Nip</th>
                                            <th>gender</th>
                                            <th>Jurusan</th>
                                            <th>prodi</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Foto</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        <tr class="table-Light">
                                            <th>id</th>
                                            <th>nama</th>
                                            <th>Nidn</th>
                                            <th>Nip</th>
                                            <th>gender</th>
                                            <th>Jurusan</th>
                                            <th>prodi</th>
                                            <th>Email</th>
                                            <th>Password</th>
                                            <th>Foto</th>
                                            <th>Status</th>
                                        </tr>
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

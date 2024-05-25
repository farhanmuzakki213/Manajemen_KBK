@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Dosen</h5>
                @if (Session::has('success'))
                    <div id="delay" class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div id="delay" class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <script>
                    setTimeout(function() {
                        var element = document.getElementById('delay');
                        if (element) {
                            element.parentNode.removeChild(element);
                        }
                    }, 5000); // 5000 milliseconds = 5 detik
                </script>
                <div class="container-fluid">
                    <!-- DataDosen -->
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

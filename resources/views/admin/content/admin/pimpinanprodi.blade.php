@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Pimpinan Prodi</h5>
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
                    <!-- Data Pimpinan Prodi -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="{{ route('pimpinanprodi.show') }}"
                                    class="btn btn-primary me-md-3">
                                    <i class="ti ti-upload"></i> Ambil Data API
                                </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Dosen</th>
                                            <th>Jabatan Pimpinan</th>
                                            <th>Prodi</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Dosen</th>
                                            <th>Jabatan Pimpinan</th>
                                            <th>Prodi</th>
                                            <th>Periode</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_pimpinan_prodi as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_pimpinan_prodi}}</th>
                                            <th>{{$data->r_dosen->nama_dosen}}</th>
                                            <th>{{$data->r_jabatan_pimpinan->jabatan_pimpinan}}</th>
                                            <th>{{$data->r_prodi->prodi}}</th>
                                            <th>{{$data->periode}}</th>
                                            <th>
                                                @if ($data->status_pimpinan_prodi == 0)
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

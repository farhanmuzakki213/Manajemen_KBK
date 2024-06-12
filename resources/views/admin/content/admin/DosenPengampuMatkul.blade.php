@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Dosen Pengampu Mata Kuliah</h5>
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
                    <!-- DataDosen Pengampu Mata Kuliah -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="{{ route('DosenPengampuMatkul.export') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-box-arrow-in-up"></i> Export</a>
                            </div>
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
                                            <th>{{$data->r_dosen->nama_dosen}}</th>
                                            <th>
                                                @foreach($data->p_matkulKbk as $matkulKbk)
                                                    {{ $matkulKbk->r_matkul->nama_matkul }}<br>
                                                @endforeach
                                            </th>
                                            <th>
                                                @foreach($data->p_kelas as $kelas)
                                                    {{ $kelas->nama_kelas }}<br>
                                                @endforeach
                                            </th>
                                            <th>{{$data->r_smt_thnakd->smt_thnakd}}</th>
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

@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Mahasiswa</h5>
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
                <div class="container-fluid">
                    <!-- DataMahasiswa -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <a href="{{ route('mahasiswa.show') }}" 
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
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Jurusan</th>
                                            <th>Prodi</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>NIM</th>
                                            <th>Nama</th>
                                            <th>Jurusan</th>
                                            <th>Prodi</th>
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
                                                <th>{{ $data->r_jurusan->jurusan }}</th>
                                                <th>{{ $data->r_prodi->prodi }}</th>
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
@section('scripts')
<script>
    setTimeout(function() {
        var element = document.getElementById('delay');
        if (element) {
            element.parentNode.removeChild(element);
        }
    }, 5000); // 5000 milliseconds = 5 detik
</script>
@endsection
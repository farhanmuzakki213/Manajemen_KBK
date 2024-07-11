@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data RPS</h5>
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
                    <!-- DataRPS -->
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
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen Upload</th>
                                            <th>Prodi</th>
                                            <th>Dosen Verifikasi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>

                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen Upload</th>
                                            <th>Prodi</th>
                                            <th>Dosen Verifikasi</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($result as $data)
                                            @php
                                                $rekomendasi = optional(
                                                    $data_ver_rps->firstWhere(
                                                        'rep_rps_uas_id',
                                                        $data['id_rep_rps_uas'],
                                                    ),
                                                )->rekomendasi;
                                                $status = 'File Belum Diupload';

                                                if ($rekomendasi !== null) {
                                                    switch ($rekomendasi) {
                                                        case 1:
                                                            $status = 'Belum Diverifikasi';
                                                            break;
                                                        case 2:
                                                            $status = 'Tidak Layak Pakai';
                                                            break;
                                                        case 3:
                                                            $status = 'Butuh Revisi';
                                                            break;
                                                        default:
                                                            $status = 'Layak Pakai';
                                                            break;
                                                    }
                                                }
                                            @endphp
                                            <tr>
                                                <th>{{ $no++ }}</th>
                                                <th>{{ $data['kode_matkul'] }}</th>
                                                <th>{{ $data['semester'] }}</th>
                                                <th>{{ $data['nama_dosen'] }}</th>
                                                <th>{{ $data['prodi'] }}</th>
                                                <th style="{{ $status === 'File Belum Diupload' ? 'color: red;' : '' }}">{{ $data_ver_rps->firstWhere('rep_rps_uas_id', $data['id_rep_rps_uas'])->r_pengurus->r_dosen->nama_dosen ?? 'File Belum Diupload' }}
                                                </th>
                                                <th style="{{ $status === 'File Belum Diupload' ? 'color: red;' : '' }}">
                                                    {{ $status }}
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

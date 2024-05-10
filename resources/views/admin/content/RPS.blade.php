@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Dosen</h5>
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
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen Verifikasi</th>
                                            <th>Tgl Unggah</th>
                                            <th>Tgl Ubah</th>
                                            <th>Tgl Verifikasi</th>
                                            <th>Status</th>
                                            <th>file</th>
                                            
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen Verifikasi</th>
                                            <th>Tgl Unggah</th>
                                            <th>Tgl Ubah</th>
                                            <th>Tgl Verifikasi</th>
                                            <th>Status</th>
                                            <th>file</th>                                            
                                        </tr>
                                    </tfoot>
                                    <tbody>    
                                        @foreach ($data_rps as $data)                                    
                                        <tr class="table-Light">
                                            <th>{{$data->id_rep_rps}}</th>
                                            <th>{{$data->nama_matkul}}</th>
                                            <th>{{$data->semester}}</th>
                                            <th>{{$data->nama_dosen}}</th>
                                            <th>{{$data->created_at}}</th>
                                            <th>{{$data->updated_at}}</th>
                                            <th>{{$data->tanggal_diverifikasi}}</th>
                                            <th>
                                                @if ($data->status_ver_rps == 0)
                                                    Tidak Diverifikasi
                                                @else
                                                    Diverifikasi
                                                @endif
                                            </th>
                                            <th>{{$data->file}}</th>                                            
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

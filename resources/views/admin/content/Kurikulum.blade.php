@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Kurikulum</h5>
                <div class="container-fluid">
                    <!-- Data Kurikulum -->
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
                                            <th>Kode Kurikulum</th>
                                            <th>Nama Kurikulum</th>
                                            <th>Tahun</th>
                                            <th>Prodi</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Kode Kurikulum</th>
                                            <th>Nama Kurikulum</th>
                                            <th>Tahun</th>
                                            <th>Prodi</th>
                                            <th>Status</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_kurikulum as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_kurikulum}}</th>
                                            <th>{{$data->kode_kurikulum}}</th>
                                            <th>{{$data->nama_kurikulum}}</th>
                                            <th>{{$data->tahun}}</th>
                                            <th>{{$data->prodi}}</th>
                                            <th>
                                                @if ($data->status == 0)
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

@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Kurikulum</h5>
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
                    <!-- Data Kurikulum -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">

                            @can('admin-sinkronData Kurikulum')
                                <a href="{{ route('kurikulum.show') }}" class="btn btn-primary mb-2 d-flex align-items-center">
                                    <i class="ti ti-upload"></i> Ambil Data API
                                </a>
                            @endcan
                            {{-- <a href="delete-row" class="btn btn-danger mb-2 d-flex align-items-center">
                                <i class="bi bi-trash""></i> Hapus
                            </a> --}}
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
                                            <th>Aksi</th>
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
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_kurikulum as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_kurikulum }}</th>
                                                <th>{{ $data->kode_kurikulum }}</th>
                                                <th>{{ $data->nama_kurikulum }}</th>
                                                <th>{{ $data->tahun }}</th>
                                                <th>{{ $data->r_prodi->prodi }}</th>
                                                <th>
                                                    @if ($data->status_kurikulum == 0)
                                                        Tidak Aktif
                                                    @else
                                                        Aktif
                                                    @endif
                                                </th>

                                                <th style="width: 10%">
                                                    <div class="row">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data->id_kurikulum }}"
                                                            class="btn btn-secondary mb-2 d-flex align-items-cente"><span
                                                                class="bi bi-three-dots-vertical"></span>Detail</a>
                                                    </div>
                                                </th>
                                            </tr>


                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail{{ $data->id_kurikulum }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="detailLabel">Detail Kurikulum</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="kode_matkul" class="col-form-label">Kode
                                                                            kurikulum</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kode_matkul"
                                                                            value="{{ $data->kode_kurikulum }}" readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="message-text"
                                                                            class="col-form-label">Nama Kurikulum</label>
                                                                        <input class="form-control" id="message-text"
                                                                            value="{{ $data->nama_kurikulum }}"
                                                                            readonly></input>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="kode_matkul"
                                                                    class="col-form-label">Prodi</label>
                                                                <input type="text" class="form-control" id="kode_matkul"
                                                                    value="{{ $data->r_prodi->prodi }}" readonly>
                                                            </div>


                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="kode_matkul"
                                                                            class="col-form-label">Tahun</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kode_matkul" value="{{ $data->tahun }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="message-text"
                                                                            class="col-form-label">Status</label>
                                                                        <input class="form-control" id="message-text"
                                                                            value="{{ $data->status_kurikulum == 1 ? 'Aktif' : 'Tidak Aktif' }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

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

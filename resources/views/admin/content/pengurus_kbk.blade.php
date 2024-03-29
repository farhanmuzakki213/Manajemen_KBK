@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Pengurus KBK</h5>
                <div class="container-fluid">
                    <!-- DataPengurus KBK -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <p><a href="{{ route('pengurus_kbk.create') }}" class="btn btn-primary"> New</a></p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Jenis_KBK</th>
                                            <th>Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Jenis_KBK</th>
                                            <th>Jabatan</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_pengurus_kbk as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_pengurus }}</th>
                                                <th>{{ $data->nama_dosen }}</th>
                                                <th>{{ $data->jenis_kbk }}</th>
                                                <th>{{ $data->jabatan }}</th>
                                                <th>
                                                    <a href="{{ route('pengurus_kbk.edit', ['id' => $data->id_pengurus]) }}"
                                                        class="btn btn-primary"> Edit</a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{$data->id_pengurus }}"
                                                        class="btn btn-danger"> Hapus</a>
                                                </th>
                                            </tr>
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_pengurus }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">>
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi
                                                                Hapus Data</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah kamu yakin ingin menghapus data user
                                                                <b>{{ $data->nama_dosen }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">

                                                            <form
                                                                action="{{ route('pengurus_kbk.delete', ['id' => $data->id_pengurus]) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-default"
                                                                    data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary">Ya,
                                                                    Hapus</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

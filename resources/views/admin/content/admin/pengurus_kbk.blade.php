@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Pengurus KBK</h5>
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
                    <!-- DataPengurus KBK -->
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <div class="d-grid gap-2 d-md-block">
                                @can('admin-create PengurusKbk')
                                    <a href="{{ route('pengurus_kbk.create') }}" class="btn btn-primary me-md-3"><i
                                            class="bi bi-file-earmark-plus"></i> New</a>
                                @endcan
                                @can('admin-import PengurusKbk')
                                    <a data-bs-toggle="modal" data-bs-target="#import{{-- {{ $data->id_jenis_kbk }} --}}"
                                        class="btn btn-primary"><i class="bi bi-box-arrow-in-down"></i> Import</a>
                                @endcan
                                @can('admin-export PengurusKbk')
                                    <a href="{{ route('pengurus_kbk.export') }}" class="btn btn-primary me-md-3"><i
                                            class="bi bi-box-arrow-in-up"></i> Export</a>
                                @endcan



                            </div>
                        </div>

                        {{-- Modal Import --}}
                        <div class="modal fade" id="import" tabindex="-1" aria-labelledby="importLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="importlabel">New message
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post" action="{{ route('pengurus_kbk.import') }}"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="file" class="col-form-label">Import File</label>
                                                <input type="file" class="form-control" name="file" id="file">
                                                @error('file')
                                                    <small>{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-primary">Upload</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Jenis KBK</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th>Akasi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Jenis KBK</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th>Akasi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_pengurus_kbk as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_pengurus }}</th>
                                                <th>{{ $data->r_dosen->nama_dosen }}</th>
                                                <th>{{ $data->r_jenis_kbk->jenis_kbk }}</th>
                                                <th>{{ $data->r_jabatan_kbk->jabatan }}</th>
                                                <th>
                                                    @if ($data->status_pengurus_kbk == 0)
                                                        Tidak Aktif
                                                    @else
                                                        Aktif
                                                    @endif
                                                </th>

                                                <th style="width: 10%;">
                                                    <div class="row">
                                                        @can('admin-update PengurusKbk')
                                                            <a href="{{ route('pengurus_kbk.edit', ['id' => $data->id_pengurus]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"><span
                                                                    class="bi bi-pencil-square">Edit</span></a>
                                                        @endcan
                                                        @can('admin-delete PengurusKbk')
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop{{ $data->id_pengurus }}"
                                                                class="btn btn-danger mb-2 d-flex align-items-center"><span
                                                                    class="bi bi-trash">Hapus</span></a>
                                                        @endcan


                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data->id_pengurus }}"
                                                            class="btn btn-secondary mb-2 d-flex align-items-center"><span
                                                                class="bi bi-three-dots-vertical">Detail</span></a>
                                                    </div>

                                                </th>
                                            </tr>
                                            {{-- Modal Konfirmasi hapus data --}}
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
                                                                <b>{{ $data->r_dosen->nama_dosen }}</b>
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

                                            {{-- Modal Detail Tabel --}}

                                            <div class="modal fade" id="detail{{ $data->id_pengurus }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="detailLabel">Detail Pengurus KBK
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="mb-3">

                                                                <label for="kode_matkul" class="col-form-label">Nama
                                                                    Dosen</label>
                                                                <input type="text" class="form-control"
                                                                    id="kode_matkul"
                                                                    value="{{ $data->r_dosen->nama_dosen }}" readonly>

                                                            </div>

                                                            <div class="mb-3">

                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="message-text"
                                                                            class="col-form-label">NIDN</label>
                                                                        <input class="form-control" id="message-text"
                                                                            value="{{ $data->r_dosen->nidn }}"
                                                                            readonly></input>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="message-text"
                                                                            class="col-form-label">NIP</label>
                                                                        <input class="form-control"
                                                                            id="message-text"value="{{ $data->r_dosen->nip }}"
                                                                            readonly></input>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="mb-3">

                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="kode_matkul"
                                                                            class="col-form-label">Jenis KBK</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kode_matkul"
                                                                            value="{{ $data->r_jenis_kbk->jenis_kbk }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="message-text"
                                                                            class="col-form-label">Jabatan</label>
                                                                        <input class="form-control" id="message-text"
                                                                            value="{{ $data->r_jabatan_kbk->jabatan }}"
                                                                            readonly></input>
                                                                    </div>
                                                                </div>

                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="kode_matkul"
                                                                            class="col-form-label">Gender</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kode_matkul"
                                                                            value="{{ $data->r_dosen->gender }}" readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="message-text"
                                                                            class="col-form-label">Status</label>
                                                                        <input class="form-control" id="message-text"
                                                                            value="{{ $data->status_pengurus_kbk == 1 ? 'Aktif' : 'Tidak Aktif' }}"
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

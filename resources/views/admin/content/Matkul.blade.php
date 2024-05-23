@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Mata Kuliah</h5>
                <div class="container-fluid">
                    <!-- Data Mata Kuliah -->
                    <div class="card shadow mb-4">

                        <div class="card-header py-2">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="{{ route('matkul.create') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-file-earmark-plus"></i> New</a>
                                <a href="{{ route('matkul.export') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-box-arrow-in-up"></i> Export</a>
                                <a data-bs-toggle="modal" data-bs-target="#import{{-- {{ $data->id_jenis_kbk }} --}}" class="btn btn-primary"><i class="bi bi-box-arrow-in-down"></i> Import</a>
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
                                        <form method="post" action="{{ route('matkul.import') }}" enctype="multipart/form-data">
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
                                            <th>Kode Matkul</th>
                                            <th>Nama Matkul</th>
                                            <th>Semester</th>
                                            <th>Nama Kurikulum</th>
                                            {{-- <th>Tahun Akademik</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Kode Matkul</th>
                                            <th>Nama Matkul</th>
                                            <th>Semester</th>
                                            <th>Nama Kurikulum</th>
                                            {{-- <th>Tahun Akademik</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_matkul as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_matkul }}</th>
                                                <th>{{ $data->kode_matkul }}</th>
                                                <th>{{ $data->nama_matkul }}</th>
                                                <th>{{ $data->semester }}</th>
                                                <th>{{ $data->nama_kurikulum }}</th>
                                                {{-- <th>{{ $data->smt_thnakd }}</th> --}}
                                                <th>
                                                    <a href="{{ route('matkul.edit', ['id' => $data->id_matkul]) }}"
                                                        class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $data->id_matkul }}"
                                                        class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                    <a data-bs-toggle="modal" data-bs-target="#detail{{ $data->id_matkul }}" class="btn btn-secondary"><i class="bi bi-three-dots-vertical"></i></a>
                                                </th>
                                            </tr>
                                            {{-- Modal Konfirmasi hapus data --}}
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_matkul }}"
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
                                                            <p>Apakah kamu yakin ingin menghapus data Ini
                                                                <b>{{ $data->kode_matkul }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">

                                                            <form
                                                                action="{{ route('matkul.delete', ['id' => $data->id_matkul]) }}"
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
                                            <div class="modal fade" id="detail{{ $data->id_matkul }}" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title fs-5" id="detailLabel">Detail Matkul</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form>
                                                                <div class="mb-3">
                                                                    <label for="kode_matkul" class="col-form-label">Kode Matkul</label>
                                                                    <input type="text" class="form-control" id="kode_matkul" value="{{ $data->kode_matkul }}" readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Nama Matkul</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->nama_matkul }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">TP</label>
                                                                    <input class="form-control" id="message-text"value="{{ $data->TP }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">sks</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->sks }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Jam</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->jam }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">sks teori</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->sks_teori }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">sks praktek</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->sks_praktek }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Jam teori</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->jam_teori }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Jam praktek</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->jam_praktek }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Semester</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->semester }}" readonly></input>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="message-text"
                                                                        class="col-form-label">Kurikulum</label>
                                                                    <input class="form-control" id="message-text" value="{{ $data->nama_kurikulum }}" readonly></input>
                                                                </div>
                                                            </form>
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

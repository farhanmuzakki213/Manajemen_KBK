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
                                            <th>Name</th>
                                            <th>Nidn</th>
                                            <th>Nip</th>
                                            <th>gender</th>
                                            <th>Jurusan</th>
                                            <th>prodi</th>
                                            {{-- <th>Email</th>
                                            <th>Password</th>
                                            <th>Foto</th>
                                            <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Nidn</th>
                                            <th>Nip</th>
                                            <th>gender</th>
                                            <th>Jurusan</th>
                                            <th>prodi</th>
                                            {{-- <th>Email</th>
                                            <th>Password</th>
                                            <th>Foto</th>
                                            <th>Status</th> --}}
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_dosen as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_dosen}}</th>
                                            <th>{{$data->nama_dosen}}</th>
                                            <th>{{$data->nidn}}</th>
                                            <th>{{$data->nip}}</th>
                                            <th>{{$data->gender}}</th>
                                            <th>{{$data->jurusan}}</th>
                                            <th>{{$data->prodi}}</th>
                                            {{-- <th>{{$data->email}}</th>
                                            <th>{{$data->password}}</th>
                                            <th>{{$data->image}}</th>
                                            <th>{{$data->status}}</th> --}}
                                            <th>
                                                <a data-bs-toggle="modal" data-bs-target="#detail{{ $data->id_dosen }}" class="btn btn-secondary"><i class="bi bi-three-dots-vertical"></i></a>
                                            </th>
                                        </tr>

                                        {{-- Modal Detail Tabel --}}
                                        <div class="modal fade" id="detail{{ $data->id_dosen }}" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="detailLabel">Detail Matkul</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label for="kode_matkul" class="col-form-label">Nama Dosen</label>
                                                                <input type="text" class="form-control" id="kode_matkul" value="{{ $data->nama_dosen }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">NIDN</label>
                                                                <input class="form-control" id="message-text" value="{{ $data->nidn }}" readonly></input>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">NIP</label>
                                                                <input class="form-control" id="message-text"value="{{ $data->nip }}" readonly></input>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">Gender</label>
                                                                <input class="form-control" id="message-text" value="{{ $data->gender }}" readonly></input>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">Jurusan</label>
                                                                <input class="form-control" id="message-text" value="{{ $data->jurusan }}" readonly></input>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">Prodi</label>
                                                                <input class="form-control" id="message-text" value="{{ $data->prodi }}" readonly></input>
                                                            </div>
                                                        </form>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">Email</label>
                                                            <input class="form-control" id="message-text" value="{{ $data->email }}" readonly></input>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">Password</label>
                                                            <input class="form-control" id="message-text" value="{{ $data->password }}"  readonly></input>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">Image</label>
                                                            <input class="form-control" id="message-text" value="{{ $data->image }}" readonly></input>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="message-text"
                                                                class="col-form-label">Status</label>
                                                            <input class="form-control" id="message-text" value="{{ $data->status }}" readonly></input>
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

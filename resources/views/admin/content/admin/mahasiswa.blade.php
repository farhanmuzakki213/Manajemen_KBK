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

                            @can('admin-sinkronData Mahasiswa')
                                <a href="{{ route('mahasiswa.show') }}" class="btn btn-primary me-md-3">
                                    <i class="ti ti-upload"></i> Ambil Data API
                                </a>
                            @endcan

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
                                            <th>Aksi</th>
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
                                            <th>Aksi</th>
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
                                                <th style="width: 10%">
                                                    <div class="row">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data->id_mahasiswa }}"
                                                            class="btn btn-secondary mb-2 d-flex align-items-cente"><span
                                                                class="bi bi-three-dots-vertical"></span>Detail</a>
                                                    </div>
                                                </th>
                                            </tr>


                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail{{ $data->id_mahasiswa }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="detailLabel">Detail Mahasiswa</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="mb-3">
                                                                <label for="kode_matkul" class="col-form-label">Nama
                                                                    Mahasiswa</label>
                                                                <input type="text" class="form-control" id="kode_matkul"
                                                                    value="{{ $data->nama }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text" class="col-form-label">NIM</label>
                                                                <input class="form-control" id="message-text"
                                                                    value="{{ $data->nim }}" readonly></input>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">Jurusan</label>
                                                                <input class="form-control" id="message-text"
                                                                    value="{{ $data->r_jurusan->jurusan }}"
                                                                    readonly></input>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">Prodi</label>
                                                                <input class="form-control" id="message-text"
                                                                    value="{{ $data->r_prodi->prodi }}" readonly></input>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">Gender</label>
                                                                <input class="form-control" id="message-text"
                                                                    value="{{ $data->gender }}" readonly></input>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="message-text"
                                                                    class="col-form-label">Status</label>
                                                                <input class="form-control" id="message-text"
                                                                    value="{{ $data->status_mahasiswa == 1 ? 'Aktif' : 'Tidak Aktif' }}"
                                                                    readonly>
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

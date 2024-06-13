@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Berita Acara Verifikasi Soal UAS</h5>
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
                <script>
                    setTimeout(function() {
                        var element = document.getElementById('delay');
                        if (element) {
                            element.parentNode.removeChild(element);
                        }
                    }, 5000); // 5000 milliseconds = 5 detik
                </script>
                <div class="container-fluid">
                    <!-- DataDosen -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="card-header py-2">
                                <div class="d-grid gap-2 d-md-block">
                                    {{-- <a href="{{ route('berita_acara_ver_uas.create') }}" class="btn btn-primary me-md-3"><i
                                            class="bi bi-file-earmark-plus"></i> New</a> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Nama Dosen</th>
                                                <th>kode Kuliah</th>
                                                <th>Semester</th>
                                                <th>File Verifikasi</th>
                                                <th>Status</th>
                                                <th>Tanggal Verifikasi</th>
                                            
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Nama Dosen</th>
                                                <th>kode Kuliah</th>
                                                <th>Semester</th>
                                                <th>File Verifikasi</th>
                                                <th>Status</th>
                                                <th>Tanggal Verifikasi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($data_ver_soal_uas as $data_ver)
                                                <tr class="table-Light">
                                                    <th>{{ $data_ver->id_ver_rps_uas }}</th>
                                                    <th>{{ optional($data_ver->r_rep_rps_uas)->r_dosen->nama_dosen }}</th>
                                                    <th>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->kode_matkul }}</th>
                                                    <th>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->semester }}</th>
                                                    <th><a href="{{ asset('storage/uploads/ver_soal_uas_files/' . $data_ver->file_verifikasi) }}" target="_blank">{{ $data_ver->file_verifikasi }}</a>
                                                    </th>
                                                    <th>
                                                        @if ($data_ver->status_ver_uas == 0)
                                                            Tidak Diverifikasi
                                                        @else
                                                            Diverifikasi
                                                        @endif
                                                    </th>
                                                    <th>{{ $data_ver->tanggal_diverifikasi }}</th>

                                                    {{-- <th>
                                                        <a href="{{ route('ver_soal_uas.edit', ['id' => $data->id_ver_uas]) }}"
                                                            class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop{{ $data->id_ver_uas }}"
                                                            class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data->id_ver_uas }}"
                                                            class="btn btn-secondary"><i
                                                                class="bi bi-three-dots-vertical"></i></a>
                                                    </th> --}}
                                                </tr>
                                                {{-- Modal Konfirmasi hapus data --}}
                                                {{-- <div class="modal fade" id="staticBackdrop{{ $data->id_ver_uas }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">>
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Konfirmasi
                                                                    Hapus Data</h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah kamu yakin ingin menghapus data Ini
                                                                    <b>{{ $data->id_ver_uas }}</b>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">

                                                                <form
                                                                    action="{{ route('ver_soal_uas.delete', ['id' => $data->id_ver_uas]) }}"
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
                                                </div> --}}
                                                {{-- Modal Detail Tabel --}}
                                                {{-- <div class="modal fade" id="detail{{ $data->id_ver_uas }}" tabindex="-1"
                                                    aria-labelledby="detailLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fs-5" id="detailLabel">Detail Matkul
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form>
                                                                    <div class="mb-3">
                                                                        <label for="kode_matkul" class="col-form-label">Kode
                                                                            Matkul</label>
                                                                        <input type="text" class="form-control"
                                                                            id="kode_matkul"
                                                                            value="{{ $data->kode_matkul }}" readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="message-text"
                                                                            class="col-form-label">Nama Matkul</label>
                                                                        <input class="form-control" id="message-text"
                                                                            value="{{ $data->nama_matkul }}"
                                                                            readonly></input>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="catatan"
                                                                            class="form-label">Catatan</label>
                                                                        <textarea class="form-control" id="catatan" name="catatan" rows="3" readonly>{{ $data->catatan }}</textarea>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div> --}}
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

@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data uas</h5>
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
                    <!-- Datauas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="card-header py-2">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="{{ route('upload_soal_uas.create') }}" class="btn btn-primary me-md-3"><i
                                            class="bi bi-file-earmark-plus"></i> New</a>
                                </div>
                            </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen</th>
                                            <th>Tahun Akademik</th>
                                            <th>File</th>
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tfoot>

                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen</th>
                                            <th>Tahun Akademik</th>
                                            <th>File</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_uas as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_rep_uas }}</th>
                                                <th>{{ $data->nama_matkul }}</th>
                                                <th>{{ $data->semester }}</th>
                                                <th>{{ $data->nama_dosen }}</th>
                                                <th>{{ $data->smt_thnakd }}</th>
                                                <th><a href="{{ asset('storage/uploads/uas_files/' . $data->file) }}" target="_blank">{{ $data->file }}</a>
                                                </th>
                                                {{-- <th>
                                                    @if ($data->status_ver_uas == 0)
                                                        Tidak Diverifikasi
                                                    @else
                                                        Diverifikasi
                                                    @endif
                                                </th> --}}
                                                <th>
                                                    
                                                        <a href="{{ route('upload_soal_uas.edit', ['id' => $data->id_rep_uas]) }}"
                                                            class="btn btn-primary mb-2"><i class="bi bi-pencil-square"></i></a>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop{{ $data->id_rep_uas }}"
                                                            class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                        {{-- <a data-bs-toggle="modal" data-bs-target="#detail{{ $data->id_rep_uas }}" class="btn btn-secondary"><i class="bi bi-three-dots-vertical"></i></a> --}}
        
                                                    {{-- <a data-bs-toggle="modal"
                                                        data-bs-target="#detail{{ $data->id_rep_uas }}"
                                                        class="btn btn-secondary"><i
                                                            class="bi bi-three-dots-vertical"></i></a> --}}
                                                </th>
                                            </tr>
                                              {{-- Modal Konfirmasi hapus data --}}
                                              <div class="modal fade" id="staticBackdrop{{ $data->id_rep_uas }}"
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
                                                                <b>{{ $data->id_rep_uas }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">

                                                            <form
                                                                action="{{ route('upload_soal_uas.delete', ['id' => $data->id_rep_uas]) }}"
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
                                            {{-- <div class="modal fade" id="detail{{ $data->id_rep_uas }}" aria-hidden="true"
                                                aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalToggleLabel">Detail</h1>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            isi detail uas beserta file
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary"
                                                                data-bs-target="#exampleModalToggle2"
                                                                data-bs-toggle="modal">Verifikasi</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="modal fade" id="exampleModalToggle2" aria-hidden="true"
                                                aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="uas.store" class="was-validated">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="catatan"
                                                                        class="form-label">Catatan</label>
                                                                    <textarea class="form-control" id="catatan" name="catatan" placeholder="Ketik 'Selesai' Jika tidak ada revisi dan jika ada beri keterangan" required></textarea>
                                                                    <div class="invalid-feedback">
                                                                        Please enter a message in the textarea.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" class="btn btn-primary" >Verifikasi</button>
                                                            </div>
                                                        </form>
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

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
                <script>
                    setTimeout(function() {
                        var element = document.getElementById('delay');
                        if (element) {
                            element.parentNode.removeChild(element);
                        }
                    }, 5000); // 5000 milliseconds = 5 detik
                </script>
                <div class="container-fluid">
                    <!-- DataPengurus KBK -->
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <div class="d-grid gap-2 d-md-block">
                            <a href="{{ route('pengurus_kbk.create') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-file-earmark-plus"></i> New</a>
                            <a href="{{ route('pengurus_kbk.export') }}" class="btn btn-primary me-md-3"><i class="bi bi-box-arrow-in-up"></i> Export</a>
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
                                <form method="post" action="{{ route('pengurus_kbk.import') }}" enctype="multipart/form-data">
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
                                            <th>Jenis_KBK</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Jenis_KBK</th>
                                            <th>Jabatan</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_pengurus_kbk as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_pengurus }}</th>
                                                <th>{{ $data->nama_dosen }}</th>
                                                <th>{{ $data->jenis_kbk }}</th>
                                                <th>{{ $data->deskripsi }}</th>
                                                <th>
                                                    @if ($data->status_pengurus_kbk == 0)
                                                        Tidak Aktif
                                                    @else
                                                        Aktif
                                                    @endif
                                                </th>
                                                <th>
                                                    <a href="{{ route('pengurus_kbk.edit', ['id' => $data->id_pengurus]) }}"
                                                        class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $data->id_pengurus }}"
                                                        class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                                    {{-- <a data-bs-toggle="modal"
                                                        data-bs-target="#detail"
                                                        class="btn btn-secondary"><i class="bi bi-three-dots-vertical"></i></a> --}}
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

                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail" tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailLabel">Detail Pengurus KBK</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Nama Dosen:</label>
                                                                <input type="text" class="form-control" id="nama_dosen" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jenis_kbk" class="form-label">Jenis KBK:</label>
                                                                <input type="text" class="form-control" id="jenis_kbk" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jabatan_kbk" class="form-label">Jabatan:</label>
                                                                <input type="text" class="form-control" id="jabatan_kbk" readonly>
                                                            </div>
                                                            <!-- tambahkan input untuk atribut lainnya jika diperlukan -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

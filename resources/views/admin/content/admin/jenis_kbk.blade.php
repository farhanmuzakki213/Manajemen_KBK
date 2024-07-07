@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data KBK</h5>
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
                    <!-- Data KBK -->
                    <div class="card shadow mb-4">

                        <div class="card-header py-2"> 
                            <div class="d-grid gap-2 d-md-block">
                            <a href="{{ route('jenis_kbk.create') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-file-earmark-plus"></i> New</a>
                            <a href="{{ route('jenis_kbk.export') }}" class="btn btn-primary me-md-3"><i class="bi bi-box-arrow-in-up"></i> Export</a>
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
                                <form method="post" action="{{ route('jenis_kbk.import') }}" enctype="multipart/form-data">
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
                                            <th>Jenis KBK</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Jenis KBK</th>
                                            <th>Deskripsi</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_jenis_kbk as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_jenis_kbk }}</th>
                                                <th>{{ $data->jenis_kbk }}</th>
                                                <th>{{ $data->deskripsi }}</th>
                                                <th style="width: 10%;">
                                                    <div class="row">
                                                    <a href="{{ route('jenis_kbk.edit', ['id' => $data->id_jenis_kbk]) }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"><span class="bi bi-pencil-square">Edit</span></a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $data->id_jenis_kbk }}"
                                                        class="btn btn-danger mb-2 d-flex align-items-center"><span class="bi bi-trash">Hapus</span></a>
                                                        <a data-bs-toggle="modal"
                                                        data-bs-target="#detail{{ $data->id_jenis_kbk }}"
                                                        class="btn btn-secondary mb-2 d-flex align-items-center"><span
                                                            class="bi bi-three-dots-vertical">Detail</span></a>
                                                        </div>
                                                </th>
                                            </tr>
                                            
                                            {{-- Modal Konfirmasi hapus data --}}
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_jenis_kbk }}"
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
                                                                <b>{{ $data->jenis_kbk }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">

                                                            <form
                                                                action="{{ route('jenis_kbk.delete', ['id' => $data->id_jenis_kbk]) }}"
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
                                        <div class="modal fade" id="detail{{ $data->id_jenis_kbk }}" tabindex="-1"
                                            aria-labelledby="detailLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title" id="detailLabel">Detail Data KBK</h5>
                                                        <button type="button" class="btn-close btn-close-white"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="kode_matkul" class="col-form-label">Nama KBK</label>
                                                            <input type="text" class="form-control" id="kode_matkul"
                                                                value="{{ $data->jenis_kbk }}" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="Judul" class="form-label">Deskripsi</label>
                                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" readonly>{{ $data->deskripsi }}</textarea>
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
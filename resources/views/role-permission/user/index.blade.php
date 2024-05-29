@extends('role-permission.master-role-permission')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Roles</h5>
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
                    <!-- Roles -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="card-header py-2">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="{{ url('users/create') }}" class="btn btn-primary me-md-3"><i
                                            class="bi bi-file-earmark-plus"></i> New</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tfoot>

                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Nama</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($roles as $data)
                                                <tr class="table-Light">
                                                    <th>{{ $data->id }}</th>
                                                    <th>{{ $data->name }}</th>
                                                    <th style="width: 27%;">
                                                        <div class="row">
                                                            <div class="col-lg-12">
                                                                <a href="{{ url('roles/'.$data->id.'/give-permissions')}}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                        class="bi bi-pencil-square"></i>Tambah / Edit Permission</a>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <a href="{{ url('roles/'.$data->id.'/edit')}}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                        class="bi bi-pencil-square"></i>Edit</a>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop{{ $data->id }}"
                                                                class="btn btn-danger mb-2 d-flex align-items-center"><i class="bi bi-trash"></i>Delete</a>
                                                            </div>
                                                        </div>
                                                    </th>
                                                </tr>
                                                {{-- Modal Konfirmasi hapus data --}}
                                                <div class="modal fade" id="staticBackdrop{{ $data->id }}"
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
                                                                    <b>{{ $data->name }}</b>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">

                                                                <form
                                                                    action="{{ url('roles/'.$data->id.'/delete') }}"
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

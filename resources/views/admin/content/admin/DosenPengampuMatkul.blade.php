@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Dosen Pengampu Mata Kuliah</h5>
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
                    <!-- DataDosen Pengampu Mata Kuliah -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="{{ route('DosenPengampuMatkul.show') }}"
                                class="btn btn-primary me-md-3">
                                <i class="ti ti-upload"></i> Ambil Data API
                            </a>
                                <a href="{{ route('DosenPengampuMatkul.create') }}" class="btn btn-primary me-md-3"><i
                                    class="bi bi-file-earmark-plus"></i> New</a>
                                <a href="{{ route('DosenPengampuMatkul.export') }}" class="btn btn-primary me-md-3"><i
                                    class="bi bi-box-arrow-in-up"></i> Export</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Dosen</th>
                                            <th>Mata Kuliah</th>
                                            <th>kelas</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Dosen</th>
                                            <th>Mata Kuliah</th>
                                            <th>kelas</th>
                                            <th>Tahun Ajaran</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_dosen_pengampu as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_dosen_matkul}}</th>
                                            <th>{{$data->r_dosen->nama_dosen}}</th>
                                            <th>
                                                @foreach($data->p_matkulKbk as $matkulKbk)
                                                    {{ $matkulKbk->r_matkul->nama_matkul }}<br>
                                                @endforeach
                                            </th>
                                            <th>
                                                @foreach($data->p_kelas as $kelas)
                                                    {{ $kelas->nama_kelas }}<br>
                                                @endforeach
                                            </th>
                                            <th>{{$data->r_smt_thnakd->smt_thnakd}}</th>
                                            <th>
                                                <a href="{{ route('DosenPengampuMatkul.edit', ['id' => $data->id_dosen_matkul]) }}"
                                                    class="btn btn-primary"><i class="bi bi-pencil-square"></i></a>
                                                <a data-bs-toggle="modal"
                                                    data-bs-target="#staticBackdrop{{ $data->id_dosen_matkul }}"
                                                    class="btn btn-danger"><i class="bi bi-trash"></i></a>
                                            </th>
                                        </tr>

                                        <div class="modal fade" id="staticBackdrop{{ $data->id_dosen_matkul }}"
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
                                                            action="{{ route('DosenPengampuMatkul.delete', ['id' => $data->id_dosen_matkul]) }}"
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
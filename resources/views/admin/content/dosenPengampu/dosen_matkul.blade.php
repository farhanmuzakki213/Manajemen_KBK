@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Pengampu</h5>
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
                    <!-- DataDosen -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <button id="toggleTableBtn" class="btn btn-primary" onclick="toggleTable_matkul()">Tabel Data
                                Matkul</button>
                        </div>
                        <div class="card-body" id="tabel_matkul" style="display: block;">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @if ($data_matkul->isNotEmpty())
                                            @foreach ($data_matkul as $id_matkul_kbk => $nama_matkul)
                                                @php
                                                    $cek_data_rep_rps = App\Models\RepRpsUas::with('r_dosen_matkul')
                                                        ->whereHas('r_dosen_matkul', function ($query) use (
                                                            $dosen_pengampu,
                                                        ) {
                                                            $query->where('dosen_id', $dosen_pengampu->dosen_id);
                                                        })
                                                        ->where('matkul_kbk_id', $id_matkul_kbk)
                                                        ->where('type', '=', '0')
                                                        ->exists();
                                                    $cek_data_rep_uas = App\Models\RepRpsUas::with('r_dosen_matkul')
                                                        ->whereHas('r_dosen_matkul', function ($query) use (
                                                            $dosen_pengampu,
                                                        ) {
                                                            $query->where('dosen_id', $dosen_pengampu->dosen_id);
                                                        })
                                                        ->where('matkul_kbk_id', $id_matkul_kbk)
                                                        ->where('type', '=', '1')
                                                        ->exists();
                                                @endphp
                                                <tr class="table-Light">
                                                    <th>{{ $no++ }}</th>
                                                    <th>{{ $nama_matkul }}</th>
                                                    <th>
                                                        @if ($cek_data_rep_rps && $cek_data_rep_uas)
                                                            File sudah diunggah
                                                        @else
                                                            @if (!$cek_data_rep_rps)
                                                                @can('dosenMatkul-create RepRps')
                                                                    <a href="{{ route('upload_rps.create', ['id_matkul' => $id_matkul_kbk]) }}"
                                                                        class="btn btn-primary me-md-3"><i
                                                                            class="bi bi-file-earmark-plus"></i> Upload RPS</a>
                                                                @endcan
                                                            @endif
                                                            @if (!$cek_data_rep_uas)
                                                                @can('dosenMatkul-create RepUas')
                                                                    <a href="{{ route('upload_soal_uas.create', ['id_matkul' => $id_matkul_kbk]) }}"
                                                                        class="btn btn-primary me-md-3"><i
                                                                            class="bi bi-file-earmark-plus"></i> Upload UAS</a>
                                                                @endcan
                                                            @endif
                                                        @endif
                                                    </th>
                                                </tr>
                                            @endforeach
                                        @else
                                            <th>Anda tidak memiliki mata kuliah ampu</th>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">
                    <!-- DataRPS -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <button id="toggleTableBtn" class="btn btn-primary" onclick="toggleTable_rps()">Tabel Data
                                RPS</button>
                        </div>
                        <div class="card-body" id="tabel_rps" style="display: block;">
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
                                        @foreach ($data_rps as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_rep_rps_uas }}</th>
                                                <th>{{ optional($data->r_matkulKbk)->r_matkul->nama_matkul }}</th>
                                                <th>{{ optional($data->r_matkulKbk)->r_matkul->semester }}</th>
                                                <th>{{ optional($data->r_dosen)->nama_dosen }}</th>
                                                <th>{{ optional($data->r_smt_thnakd)->smt_thnakd }}</th>
                                                <th><a href="{{ asset('storage/uploads/rps/repositori_files/' . $data->file) }}"
                                                        target="_blank">{{ $data->file }}</a>
                                                </th>
                                                <th style="width: 10%;">
                                                    <div class="row">
                                                        @can('dosenMatkul-update RepRps')
                                                            <a href="{{ route('upload_rps.edit', ['id' => $data->id_rep_rps_uas]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-pencil-square"></i>Revisi</a>
                                                        @endcan
                                                        @can('dosenMatkul-delete RepRps')
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop{{ $data->id_rep_rps_uas }}"
                                                                class="btn btn-danger mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-trash"></i>Hapus</a>
                                                        @endcan


                                                    </div>
                                                </th>
                                            </tr>
                                            {{-- Modal Konfirmasi hapus data --}}
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_rep_rps_uas }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">>
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="staticBackdropLabel">
                                                                Konfirmasi
                                                                Hapus Data</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah kamu yakin ingin menghapus data Ini
                                                                <b>{{ $data->id_rep_rps_uas }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">

                                                            <form
                                                                action="{{ route('upload_rps.delete', ['id' => $data->id_rep_rps_uas]) }}"
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
                <div class="container-fluid">
                    <!-- Datauas -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <button id="toggleTableBtn" class="btn btn-primary" onclick="toggleTable_uas()">Tabel Data
                                UAS</button>
                        </div>
                        <div class="card-body" id="tabel_uas" style="display: block;">
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
                                                <th>{{ $data->id_rep_rps_uas }}</th>
                                                <th>{{ optional($data->r_matkulKbk)->r_matkul->nama_matkul }}</th>
                                                <th>{{ optional($data->r_matkulKbk)->r_matkul->semester }}</th>
                                                <th>{{ optional($data->r_dosen)->nama_dosen }}</th>
                                                <th>{{ optional($data->r_smt_thnakd)->smt_thnakd }}</th>
                                                <th><a href="{{ asset('storage/uploads/uas/repositori_files/' . $data->file) }}"
                                                        target="_blank">{{ $data->file }}</a></th>
                                                <th style="width: 10%;">
                                                    <div class="row">
                                                        @can('dosenMatkul-update RepUas')
                                                            <a href="{{ route('upload_soal_uas.edit', ['id' => $data->id_rep_rps_uas]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-pencil-square"></i>Revisi</a>
                                                        @endcan
                                                        @can('dosenMatkul-delete RepUas')
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop{{ $data->id_rep_rps_uas }}"
                                                                class="btn btn-danger mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-trash"></i>Hapus</a>
                                                        @endcan
                                                    </div>
                                                </th>
                                            </tr>
                                            {{-- Modal Konfirmasi hapus data --}}
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_rep_rps_uas }}"
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
                                                                <b>{{ $data->id_rep_rps_uas }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">

                                                            <form
                                                                action="{{ route('upload_soal_uas.delete', ['id' => $data->id_rep_rps_uas]) }}"
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
    @endsection
    @section('scripts')
        <script>
            setTimeout(function() {
                var element = document.getElementById('delay');
                if (element) {
                    element.parentNode.removeChild(element);
                }
            }, 5000); // 5000 milliseconds = 5 detik

            function toggleTable_matkul() {
                var tableContent = document.getElementById('tabel_matkul');
                if (tableContent.style.display === 'none') {
                    tableContent.style.display = 'block';
                } else {
                    tableContent.style.display = 'none';
                }
            }

            function toggleTable_rps() {
                var tableContent = document.getElementById('tabel_rps');
                if (tableContent.style.display === 'none') {
                    tableContent.style.display = 'block';
                } else {
                    tableContent.style.display = 'none';
                }
            }

            function toggleTable_uas() {
                var tableContent = document.getElementById('tabel_uas');
                if (tableContent.style.display === 'none') {
                    tableContent.style.display = 'block';
                } else {
                    tableContent.style.display = 'none';
                }
            }
        </script>
    @endsection

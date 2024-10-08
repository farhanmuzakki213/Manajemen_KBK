@extends('admin.admin_master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/multi-dropdown.css') }}" />
    <link href="{{ asset('backend/assets/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <style>
        .dropdown-item {
            width: auto;
            white-space: nowrap;
        }

        .dropdown-item .row {
            display: flex;
            flex-wrap: nowrap;
        }

        .dropdown-item .col-lg-3 {
            flex: 1;
        }

        .dropdown-item .col-lg-4 {
            flex: 3;
        }
    </style>
@endsection
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
                <div class="container-fluid">
                    <!-- Data Verifikasi RPS -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Berita Acara</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload Berita Acara</th>
                                            <th>Prodi</th>
                                            <th>Jenis KBK</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload Berita Acara</th>
                                            <th>Prodi</th>
                                            <th>Jenis KBK</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data_berita_acara as $data)
                                            <tr class="table-Light">
                                                <th>{{ $no++ }}</th>
                                                {{-- <th>{{ $data_rep->id_rep_rps }}</th> --}}
                                                <th>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Mata Kuliah
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach ($data->p_ver_rps_uas as $data_matkul)
                                                                <div class="dropdown-item">
                                                                    <div class="d-flex justify-content-between" style="margin: 0;">
                                                                        <div class="flex-shrink-0" style="padding: 0 10px 0 0;">
                                                                            {{ optional(optional($data_matkul->r_rep_rps_uas)->r_matkulKbk)->r_matkul->kode_matkul }}
                                                                        </div>
                                                                        <div class="flex-grow-1" style="padding: 0;">
                                                                            {{ optional(optional($data_matkul->r_rep_rps_uas)->r_matkulKbk)->r_matkul->nama_matkul }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </th>

                                                <th>
                                                    @foreach ($data->first()->p_ver_rps_uas->unique('pengurus_id') as $data_pengurus)
                                                        {{ optional($data_pengurus->r_pengurus)->r_dosen->nama_dosen }}
                                                    @endforeach
                                                </th>
                                                <th>{{ optional($data->r_pimpinan_prodi)->r_prodi->prodi }}
                                                </th>
                                                <th>{{ optional($data->r_jenis_kbk)->jenis_kbk }}</th>
                                                <th style="width: 10%;">
                                                    <div class="row">
                                                        @if (!$data->file_berita_acara)
                                                            <p style="color: red">File Belum Diupload</p>
                                                        @else
                                                            @can('pimpinanProdi-update BeritaAcaraUasProdi')
                                                                <a href="{{ route('berita_ver_uas.edit', ['id' => $data->id_berita_acara]) }}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                        class="bi bi-pencil-square"></i>Upload</a>
                                                            @endcan

                                                            <a href="{{ asset('storage/uploads/uas/berita_acara/' . $data->file_berita_acara) }}"
                                                                class="btn btn-success mb-2 d-flex align-items-center"
                                                                target="_blank"><i
                                                                    class="bi bi-file-earmark-arrow-down"></i>Download</a>
                                                        @endif
                                                    </div>
                                                </th>
                                            </tr>
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
    <script src="{{ asset('backend/assets/js/jquery3-1-1.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/multi-dropdown.js') }}"></script>
    <script>
        setTimeout(function() {
            var element = document.getElementById('delay');
            if (element) {
                element.parentNode.removeChild(element);
            }
        }, 5000); // 5000 milliseconds = 5 detik
    </script>
@endsection

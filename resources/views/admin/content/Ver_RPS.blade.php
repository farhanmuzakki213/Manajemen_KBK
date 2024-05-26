@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Verifikasi RPS</h5>
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

                    function toggleTable() {
                        var tableContent = document.getElementById('tableContent');
                        if (tableContent.style.display === 'none') {
                            tableContent.style.display = 'block';
                        } else {
                            tableContent.style.display = 'none';
                        }
                    }
                </script>
                <div class="container-fluid">
                    <!-- DataDosen -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Data RPS</h6>
                            <button id="toggleTableBtn" class="btn btn-primary" onclick="toggleTable()">Toggle
                                Tabel</button>
                        </div>
                        <div class="card-body" id="tableContent" style="display: block;">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload RPS</th>
                                            <th>Semester</th>
                                            <th>Tahun Akademik</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload RPS</th>
                                            <th>Semester</th>
                                            <th>Tahun Akademik</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data_rep_rps as $data_rep)
                                            @php
                                                $verifikasi = App\Models\Ver_Rps::where(
                                                    'rep_rps_id',
                                                    $data_rep->id_rep_rps,
                                                )->exists();
                                            @endphp
                                            @if (!$verifikasi)
                                                <tr class="table-Light">
                                                    <th>{{ $no++ }}</th>
                                                    {{-- <th>{{ $data_rep->id_rep_rps }}</th> --}}
                                                    <th>{{ $data_rep->kode_matkul }}</th>
                                                    <th>{{ $data_rep->nama_dosen }}</th>
                                                    <th>{{ $data_rep->semester }}</th>
                                                    <th>{{ $data_rep->smt_thnakd }}</th>
                                                    <th style="width: 10%;">
                                                        <div class="row">
                                                            <a href="{{ route('ver_rps.create', ['id' => $data_rep->id_rep_rps]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-pencil-square"></i> Ambil</a>
                                                            <a href="{{ asset('storage/uploads/rps/repositori_files/' . $data_rep->file) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"
                                                                target="_blank"><i
                                                                    class="bi bi-file-earmark-arrow-down"></i>
                                                                FileRPS</a>
                                                        </div>
                                                    </th>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Data Verifikasi RPS -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tabel Data Verifikasi</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr class="table-info">
                                        <th>#</th>
                                        {{-- <th>id rep</th> --}}
                                        <th>Kode Matkul</th>
                                        <th>Dosen Upload RPS</th>
                                        <th>Semester</th>
                                        <th>Tahun Akademik</th>
                                        <th>Dosen Verifikasi</th>
                                        <th>File Verifikasi</th>
                                        <th>Status Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="table-info">
                                        <th>#</th>
                                        {{-- <th>id rep</th> --}}
                                        <th>Kode Matkul</th>
                                        <th>Dosen Upload RPS</th>
                                        <th>Semester</th>
                                        <th>Tahun Akademik</th>
                                        <th>Dosen Verifikasi</th>
                                        <th>File Verifikasi</th>
                                        <th>Status Verifikasi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data_ver_rps as $data_ver)
                                        <tr class="table-Light">
                                            <th>{{ $no++ }}</th>
                                            {{-- <th>{{ $data_rep->id_rep_rps }}</th> --}}
                                            <th>{{ $data_ver->kode_matkul }}</th>
                                            <th>{{ $data_ver->nama_upload }}</th>
                                            <th>{{ $data_ver->semester }}</th>
                                            <th>{{ $data_ver->smt_thnakd }}</th>
                                            <th>{{ $data_ver->nama_verifikasi }}</th>
                                            <th>
                                                @php
                                                    $file_verifikasi = App\Models\Ver_Rps::where(
                                                        'rep_rps_id',
                                                        $data_rep->id_rep_rps,
                                                    )->value('file_verifikasi');
                                                @endphp
                                                @if ($file_verifikasi)
                                                    <a href="{{ asset('storage/uploads/rps/ver_files/' . $data_rep->file) }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"
                                                        target="_blank"><i class="bi bi-file-earmark-arrow-down"></i>
                                                        Unduh</a>
                                                @else
                                                    File Tidak Ada
                                                @endif
                                            </th>

                                            <th>
                                                @if ($data_ver->status_ver_rps == 0)
                                                    Tidak Diverifikasi
                                                @else
                                                    Diverifikasi
                                                @endif
                                            </th>
                                            <th style="width: 10%;">
                                                <div class="row">
                                                    <a href="{{ route('ver_rps.edit', ['id' => $data_ver->id_ver_rps]) }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                            class="bi bi-pencil-square"></i>Review</a>
                                                    <a href="{{ asset('storage/uploads/rps/repositori_files/' . $data_ver->file) }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"
                                                        target="_blank"><i
                                                            class="bi bi-file-earmark-arrow-down"></i>FileRPS</a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#detail{{ $data_ver->id_ver_rps }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                            class="bi bi-three-dots-vertical"></i>Detail</a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $data_ver->id_ver_rps }}"
                                                        class="btn btn-danger mb-2 d-flex align-items-center"><i
                                                            class="bi bi-trash"></i>Hapus</a>
                                                </div>
                                            </th>
                                        </tr>
                                        {{-- Modal Konfirmasi hapus data --}}
                                        <div class="modal fade" id="staticBackdrop{{ $data_ver->id_ver_rps }}"
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
                                                            <b>{{ $data_ver->kode_matkul }} |
                                                                {{ $data_ver->nama_matkul }}</b>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">

                                                        <form
                                                            action="{{ route('ver_rps.delete', ['id' => $data_ver->id_ver_rps]) }}"
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
                                        {{-- Modal Detail Tabel Verifikasi --}}
                                        <div class="modal fade" id="detail{{ $data_ver->id_ver_rps }}" tabindex="-1"
                                            aria-labelledby="detailLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="detailLabel">Detail
                                                            Verifikasi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label for="nama_matkul" class="form-label">Nama
                                                                    Matkul</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_matkul"
                                                                    value="{{ $data_ver->kode_matkul }} | {{ $data_ver->nama_matkul }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label class="form-label">Tahun
                                                                            Akademik</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data_ver->smt_thnakd }}" readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Semester</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data_ver->semester }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label class="form-label">Dosen
                                                                            Upload</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data_ver->nama_upload }}" readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Dosen
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data_ver->nama_verifikasi }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label class="form-label">Tanggal
                                                                            Upload</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data_ver->updated_at }}" readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Tanggal
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data_ver->tanggal_diverifikasi }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="status" class="form-label">Status
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="status"value="@if ($data_ver->status_ver_rps == 0) Tidak Diverifikasi @else Diverifikasi @endif"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        {{-- <label for="File"
                                                                                class="form-label">File
                                                                                Verifikasi</label> --}}
                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </form>
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
@endsection

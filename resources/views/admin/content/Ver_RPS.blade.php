@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Verifikasi RPS</h5>
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
                            {{-- <div class="card-header py-2">
                                <div class="d-grid gap-2 d-md-block">
                                    <a href="{{ route('ver_rps.create') }}" class="btn btn-primary me-md-3"><i
                                            class="bi bi-file-earmark-plus"></i> New</a>
                                </div>
                            </div> --}}
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
                                            @foreach ($data_rep_rps as $data_rep)
                                                <tr class="table-Light">
                                                    <th>{{ $no++ }}</th>
                                                    {{-- <th>{{ $data_rep->id_rep_rps }}</th> --}}
                                                    <th>{{ $data_rep->kode_matkul }}</th>
                                                    <th>{{ $data_rep->nama_upload }}</th>
                                                    <th>{{ $data_rep->semester }}</th>
                                                    <th>{{ $data_rep->smt_thnakd }}</th>
                                                    @foreach ($data_ver_rps as $data_ver)
                                                        @php
                                                            $verifikasi = $data_ver_rps
                                                                ->where('rep_rps_id', $data_rep->id_rep_rps)
                                                                ->first();
                                                        @endphp
                                                        @if ($verifikasi)
                                                            <th>{{ $verifikasi->nama_verifikasi }}</th>
                                                            <th><a href="{{ asset('storage/uploads/rps/ver_files/' . $verifikasi->file_verifikasi) }}"
                                                                    target="_blank">{{ $verifikasi->file_verifikasi }}</a>
                                                            </th>
                                                            <th>
                                                                @if ($verifikasi->status_ver_rps == 1)
                                                                    Diverifikasi
                                                                @else
                                                                    Tidak Diverifikasi
                                                                @endif
                                                            </th>
                                                        @else
                                                            <th>-</th>
                                                            <th>-</th>
                                                            <th>-</th>
                                                        @endif
                                                        <th style="width: 10%;">
                                                            <div class="row">
                                                                @if ($verifikasi)
                                                                <!-- Tombol untuk review jika nama_verifikasi sudah ada -->
                                                                <a href="{{ route('ver_rps.edit', ['id' => $data_ver->id_ver_rps]) }}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                        class="bi bi-pencil-square"></i>Review</a>
                                                                @else
                                                                <!-- Tombol untuk ambil jika nama_verifikasi belum ada -->
                                                                <a href="{{ route('ver_rps.create', ['id' => $data_rep->id_rep_rps]) }}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                        class="bi bi-pencil-square"></i>Ambil</a>
                                                                @endif
                                                                <a href="{{ asset('storage/uploads/rps/repositori_files/' . $data_rep->file) }}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center"
                                                                    target="_blank"><i
                                                                        class="bi bi-file-earmark-arrow-down"></i>FileRPS</a>
                                                                {{-- <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop{{ $data->id_penugasan }}"
                                                                class="btn btn-danger"><i class="bi bi-trash"></i></a> --}}
                                                                <a data-bs-toggle="modal"
                                                                    data-bs-target="#detail{{-- {{ $data->id_ver_rps }} --}}"
                                                                    class="btn btn-primary d-flex align-items-center"><i
                                                                        class="bi bi-three-dots-vertical"></i>Detail</a>
                                                            </div>
                                                        </th>
                                                    @endforeach
                                                </tr>

                                                {{-- Modal Detail Tabel --}}
                                                {{-- <div class="modal fade" id="detail{{ $data->id_ver_rps }}" tabindex="-1"
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
                                                                        <label for="nama_matkul" class="form-label">Nama
                                                                            Matkul</label>
                                                                        <input type="text" class="form-control"
                                                                            id="nama_matkul"
                                                                            value="{{ $data->kode_matkul }} | {{ $data->nama_matkul }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <label class="form-label">Tahun
                                                                                    Akademik</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $data->smt_thnakd }}"
                                                                                    readonly>
                                                                            </div>
                                                                            <div class="col">
                                                                                <label class="form-label">Semester</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $data->semester }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <div class="row">
                                                                            <div class="col">
                                                                                <label class="form-label">Dosen
                                                                                    Upload</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $data->nama_upload }}"
                                                                                    readonly>
                                                                            </div>
                                                                            <div class="col">
                                                                                <label class="form-label">Dosen
                                                                                    Verifikasi</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $data->nama_verifikasi }}"
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
                                                                                    value="{{ $data->updated_at }}"
                                                                                    readonly>
                                                                            </div>
                                                                            <div class="col">
                                                                                <label class="form-label">Tanggal
                                                                                    Verifikasi</label>
                                                                                <input type="text" class="form-control"
                                                                                    value="{{ $data->tanggal_diverifikasi }}"
                                                                                    readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label">Status
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="status"
                                                                            value="@if ($data->status_ver_rps == 0) Tidak Diverifikasi
                                                                        @else
                                                                            Diverifikasi @endif"
                                                                            readonly>
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

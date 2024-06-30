@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Repositori Proposal TA Jurusan</h5>
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
                    <!-- DataReview Proposal TA -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Prodi</th>
                                            <th>Jurusan</th>
                                            <th>Status Proposal</th>
                                            <th>Status Final</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>NIM</th>
                                            <th>Prodi</th>
                                            <th>Jurusan</th>
                                            <th>Status Proposal</th>
                                            <th>Status Final</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_rep_proposal_jurusan as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_penugasan }}</th>
                                                <th>{{ optional($data->proposal_ta)->r_mahasiswa->nama }}</th>
                                                <th>{{ optional($data->proposal_ta)->r_mahasiswa->nim }}</th>
                                                <th>{{ optional($data->proposal_ta)->r_mahasiswa->r_prodi->prodi }}</th>
                                                <th>{{ optional($data->proposal_ta)->r_mahasiswa->r_jurusan->jurusan }}</th>
                                                <th>
                                                    @if ($data->status_review_proposal == 0)
                                                        Diajukan
                                                    @elseif ($data->status_review_proposal == 1)
                                                        Ditolak
                                                    @elseif ($data->status_review_proposal == 2)
                                                        Direvisi
                                                    @else
                                                        Diterima
                                                    @endif
                                                </th>
                                                <th>
                                                    @if ($data->status_final_proposal == 0)
                                                        Belum Final
                                                    @else
                                                        Final
                                                    @endif
                                                </th>
                                                <th style="width: 14%;">
                                                    <div class="row">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data->id_penugasan }}"
                                                            class="btn btn-secondary d-flex align-items-center"><i
                                                                class="bi bi-three-dots-vertical"></i>Detail</a>
                                                    </div>
                                                </th>
                                            </tr>
                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail{{ $data->id_penugasan }}" tabindex="-1" aria-labelledby="detailLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="detailLabel">Detail Review Proposal</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                                                <input type="text" class="form-control" id="nama_mahasiswa" value="{{ optional($data->proposal_ta)->r_mahasiswa->nama }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">NIM</label>
                                                                <input type="text" class="form-control" id="nim" value="{{ optional($data->proposal_ta)->r_mahasiswa->nim }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Judul" class="form-label">Judul</label>
                                                                <textarea class="form-control" id="Judul" name="Judul" rows="3"
                                                                    readonly>{{ optional($data->proposal_ta)->judul }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status Proposal</label>
                                                                <input type="text" class="form-control" id="status"
                                                                    value="@if ($data->status_review_proposal == 0) Di Ajukan @elseif ($data->status_review_proposal == 1) Di Tolak @elseif ($data->status_review_proposal == 2) Di Revisi @else Di Terima @endif"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="prodi" class="form-label">Program Studi</label>
                                                                <input type="text" class="form-control" id="prodi" value="{{ optional($data->proposal_ta)->r_mahasiswa->r_prodi->prodi }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Pembimbing</label>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <input type="text" class="form-control" value="{{ optional($data->proposal_ta)->r_pembimbing_satu->nama_dosen }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <input type="text" class="form-control" value="{{ optional($data->proposal_ta)->r_pembimbing_dua->nama_dosen }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Reviewer</label>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <input type="text" class="form-control" value="{{ optional($data->reviewer_satu_dosen)->r_dosen->nama_dosen }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <input type="text" class="form-control" value="{{ optional($data->reviewer_dua_dosen)->r_dosen->nama_dosen }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="tanggal_penugasan" class="form-label">Tanggal Penugasan</label>
                                                                <input type="date" class="form-control" id="tanggal_penugasan"
                                                                    value="{{ $data->tanggal_penugasan }}" readonly>
                                                            </div>
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

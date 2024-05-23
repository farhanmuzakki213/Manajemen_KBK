@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Review Proposal TA</h5>
                <div class="container-fluid">
                    <!-- DataReview Proposal TA -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="{{ route('review_proposal_ta.create') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-file-earmark-plus"></i> New</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Judul</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Judul</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_review_proposal_ta as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_penugasan }}</th>
                                                <th>{{ $data->nama }}</th>
                                                <th>{{ $data->judul }}</th>
                                                <th>{{ $data->tanggal_penugasan }}</th>
                                                <th>
                                                    @if ($data->status_review_proposal == 0)
                                                        Di Ajukan
                                                    @elseif ($data->status_review_proposal == 1)
                                                        Di Tolak
                                                    @elseif ($data->status_review_proposal == 2)
                                                        Di Revisi
                                                    @else
                                                        Di Terima
                                                    @endif
                                                </th>
                                                <th>
                                                    <a href="{{ route('review_proposal_ta.edit', ['id' => $data->id_penugasan]) }}"
                                                        class="btn btn-primary mb-2"><i
                                                            class="bi bi-pencil-square"></i>Review</a>
                                                    <a href="{{ route('review_proposal_ta', ['id' => $data->id_penugasan]) }}"
                                                        class="btn btn-primary"><i
                                                            class="bi bi-file-earmark-arrow-down"></i>File</a>
                                                    {{-- <a data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $data->id_penugasan }}"
                                                        class="btn btn-danger"><i class="bi bi-trash"></i></a> --}}
                                                    {{-- <a data-bs-toggle="modal"
                                                        data-bs-target="#detail"
                                                        class="btn btn-secondary"><i class="bi bi-three-dots-vertical"></i></a> --}}
                                                </th>
                                            </tr>
                                            {{-- Modal Konfirmasi hapus data --}}
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_penugasan }}"
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
                                                                action="{{ route('review_proposal_ta.delete', ['id' => $data->id_penugasan]) }}"
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
                                            <div class="modal fade" id="detail" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailLabel">Detail penugasan KBK
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Nama
                                                                    Dosen:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jenis_kbk" class="form-label">Jenis
                                                                    KBK:</label>
                                                                <input type="text" class="form-control" id="jenis_kbk"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jabatan_kbk" class="form-label">Jabatan:</label>
                                                                <input type="text" class="form-control" id="jabatan_kbk"
                                                                    readonly>
                                                            </div>
                                                            <!-- tambahkan input untuk atribut lainnya jika diperlukan -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
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

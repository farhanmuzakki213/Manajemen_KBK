@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Review Proposal TA</h5>
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
                    <!-- DataReview Proposal TA -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Penugasan Proposal TA</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Pembimbing 1</th>
                                            <th>Pembimbing 2</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Pembimbing 1</th>
                                            <th>Pembimbing 2</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($reviewer_data as $data)
                                            @php

                                                $existsInDetail = App\Models\ReviewProposalTaDetailPivot::where(
                                                    'penugasan_id',
                                                    $data->id_penugasan,
                                                )
                                                    ->where('dosen', $data->dosen_r)
                                                    ->exists();
                                            @endphp

                                            <tr class="table-Light">
                                                <th>{{ $no++ }}</th>
                                                <th>{{ $data->nama }}</th>
                                                <th>{{ $data->pembimbing_satu }}</th>
                                                <th>{{ $data->pembimbing_dua }}</th>
                                                <th>{{ $data->tanggal_penugasan }}</th>
                                                <th style="width: 10%;">
                                                    @if (!$existsInDetail)
                                                        <div class="row">
                                                            <a href="{{ route('review_proposal_ta.create', ['id' => $data->id_penugasan, 'dosen' => $data->dosen_r]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-pencil-square"></i>Review</a>

                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#detail{{ $data->id_penugasan }}"
                                                                class="btn btn-primary d-flex align-items-center"><i
                                                                    class="bi bi-three-dots-vertical"></i>Detail</a>
                                                        </div>
                                                    @else
                                                        Data Sudah Direview
                                                    @endif
                                                </th>
                                            </tr>

                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail{{ $data->id_penugasan }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailLabel">Detail penugasan
                                                                KBK</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_mahasiswa" class="form-label">Nama
                                                                    Mahasiswa</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $data->nama }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">NIM</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $data->nim }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen_satu" class="form-label">Pembimbing
                                                                    1</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $data->pembimbing_satu }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen_dua" class="form-label">Pembimbing
                                                                    2</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $data->pembimbing_dua }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="judul" class="form-label">Judul</label>
                                                                <textarea class="form-control" rows="3" readonly>{{ $data->judul }}</textarea>
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


                <div class="container-fluid">
                    <!-- DataReview Proposal TA -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-2">
                            <div class="d-grid gap-2 d-md-block">
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Tanggal Review</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Tanggal Review</th>
                                            <th>Status</th>
                                            <th>Catatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($reviewer_data_detail as $data)
                                            @if ($data->dosen == $data->dosen_r)
                                                <tr class="table-Light">
                                                    <td>{{ $no++ }}</td>
                                                    <td>{{ $data->nama }}</td>
                                                    <td>{{ $data->tanggal_penugasan }}</td>
                                                    <td>{{ $data->tanggal_review }}</td>
                                                    <td>
                                                        @if ($data->status_review_proposal == 0)
                                                            Diajukan
                                                        @elseif ($data->status_review_proposal == 1)
                                                            Ditolak
                                                        @elseif ($data->status_review_proposal == 2)
                                                            Direvisi
                                                        @else
                                                            Diterima
                                                        @endif
                                                    </td>
                                                    <td>{{ $data->catatan }}</td>
                                                    <td style="width: 10%;">
                                                        <div class="row">
                                                            <a href="{{ route('review_proposal_ta.edit', ['id' => $data->penugasan_id, 'dosen' => $data->dosen_r]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-pencil-square"></i>Edit</a>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop{{ $data->penugasan_id, $data->dosen }}"
                                                                class="btn btn-danger mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-trash"></i>Delete</a>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#detail{{ $data->penugasan_id }}"
                                                                class="btn btn-primary d-flex align-items-center"><i
                                                                    class="bi bi-three-dots-vertical"></i>Detail</a>
                                                        </div>
                                                    </td>
                                                </tr>

                                                {{-- Modal Konfirmasi hapus data --}}
                                                <div class="modal fade"
                                                    id="staticBackdrop{{ $data->penugasan_id, $data->dosen }}"
                                                    data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                    aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title fs-5" id="staticBackdropLabel">
                                                                    Konfirmasi Hapus Data
                                                                </h4>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>Apakah kamu yakin ingin menghapus data ini?
                                                                    <b>{{ $data->nama }}</b>
                                                                </p>
                                                            </div>
                                                            <div class="modal-footer justify-content-between">
                                                                <form
                                                                    action="{{ route('review_proposal_ta.delete', ['id' => $data->penugasan_id, 'dosen' => $data->dosen]) }}"
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
                                                <div class="modal fade" id="detail{{ $data->penugasan_id }}"
                                                    tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="detailLabel">Detail Review
                                                                    Proposal TA</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="nama_mahasiswa" class="form-label">Nama
                                                                        Mahasiswa</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nama_mahasiswa" value="{{ $data->nama }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="nim_mahasiswa" class="form-label">NIM
                                                                        Mahasiswa</label>
                                                                    <input type="text" class="form-control"
                                                                        id="nim_mahasiswa" value="{{ $data->nim }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="Judul" class="form-label">Judul</label>
                                                                    <textarea class="form-control" id="Judul" name="Judul" rows="3" readonly>{{ $data->judul }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="reviewer"
                                                                        class="form-label">Reviewer</label>
                                                                    <input type="text" class="form-control"
                                                                        id="reviewer" value="{{ $data->dosen }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status"
                                                                        class="form-label">Status</label>
                                                                    <input type="text" class="form-control"
                                                                        id="status"
                                                                        value="{{ $data->status_review_proposal == 0 ? 'DiAjukan' : ($data->status_review_proposal == 1 ? 'DiTolak' : ($data->status_review_proposal == 2 ? 'Direvisi' : 'Diterima')) }}"
                                                                        readonly>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="catatan"
                                                                        class="form-label">Catatan</label>
                                                                    <textarea class="form-control" id="catatan" name="catatan" rows="3" readonly>
                                                                {{ $data->catatan }}
                                                                </textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <label for="tanggal_pengajuan"
                                                                                class="form-label">Tanggal
                                                                                Pengajuan</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $data->tanggal_penugasan }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col">
                                                                            <label for="tanggal_pengajuan"
                                                                                class="form-label">Tanggal
                                                                                Review</label>
                                                                            <input type="text" class="form-control"
                                                                                value="{{ $data->tanggal_review }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
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
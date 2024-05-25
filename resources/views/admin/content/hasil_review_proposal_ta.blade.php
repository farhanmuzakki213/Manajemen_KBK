@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Hasil Review Proposal TA</h5>
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
                            <a href="{{ route('hasil_review_proposal_ta.export') }}" class="btn btn-primary me-md-3"><i class="bi bi-box-arrow-in-up"></i> Export</a>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Nama Reviewer 1</th>
                                            <th>Nama Reviewer 2</th>
                                            {{-- <th>Status Proposal</th> --}}
                                            <th>Status Final</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Nama Reviewer 1</th>
                                            <th>Nama Reviewer 2</th>
                                            {{-- <th>Status Proposal</th> --}}
                                            <th>Status Final</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_review_proposal_ta as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_penugasan }}</th>
                                                <th>{{ $data->nama }}</th>
                                                <th>{{ $data->reviewer_satu_nama }}</th>
                                                <th>{{ $data->reviewer_dua_nama }}</th>
                                                {{-- <th>
                                                    @if ($data->status_review_proposal == 0)
                                                        Di Ajukan
                                                    @elseif ($data->status_review_proposal == 1)
                                                        Di Tolak
                                                    @elseif ($data->status_review_proposal == 2)
                                                        Di Revisi
                                                    @else
                                                        Di Terima
                                                    @endif
                                                </th> --}}
                                                <th>
                                                    @if ($data->status_final_proposal == 0)
                                                        Belum Final
                                                    @else
                                                        Final
                                                    @endif
                                                </th>
                                                <th style="width: 14%;">
                                                    <div class="row">
                                                        @if ($data->status_review_proposal == 3)
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#edit{{ $data->id_penugasan }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center">
                                                                <i class="bi bi-pencil-square"></i> Ubah Status
                                                            </a>
                                                        @else
                                                            <a href="{{ route('hasil_review_proposal_ta.edit', ['id' => $data->id_penugasan]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center">
                                                                <i class="bi bi-pencil-square"></i> Ubah Status
                                                            </a>
                                                        @endif
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data->id_penugasan }}"
                                                            class="btn btn-secondary d-flex align-items-center"><i
                                                                class="bi bi-three-dots-vertical"></i>Detail</a>
                                                    </div>
                                                </th>
                                            </tr>
                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail{{ $data->id_penugasan }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailLabel">Detail Review Proposal
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_mahasiswa"
                                                                    class="form-label">Nama_mahasiswa</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_mahasiswa" value="{{ $data->nama }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">NIM</label>
                                                                <input type="text" class="form-control" id="nim"
                                                                    value="{{ $data->nim }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">pembimbing
                                                                    1:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ $data->pembimbing_satu_nama }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">pembimbing
                                                                    2:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ $data->pembimbing_dua_nama }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Reviewer
                                                                    1:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ $data->reviewer_satu_nama }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Reviewer
                                                                    2:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ $data->reviewer_dua_nama }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Judul" class="form-label">Judul</label>
                                                                <textarea class="form-control" id="Judul" name="Judul" rows="3" readonly>{{ $data->judul }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status</label>
                                                                <input type="text" class="form-control" id="status"
                                                                    value="@if ($data->status_review_proposal == 0) Di Ajukan
                                                                @elseif ($data->status_review_proposal == 1)
                                                                    Di Tolak
                                                                @elseif ($data->status_review_proposal == 2)
                                                                    Di Revisi
                                                                @else
                                                                    Di Terima @endif"
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
                                            {{-- Modal Edit Status --}}

                                            <div class="modal fade" id="edit{{ $data->id_penugasan }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailLabel">Detail Review
                                                                Proposal
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post"
                                                                action="{{ route('hasil_review_proposal_ta.update', ['id' => $data->id_penugasan]) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" class="form-control"
                                                                    id="id_penugasan" name="id_penugasan"
                                                                    value="{{ $data->id_penugasan }}">
                                                                <div class="mb-3">
                                                                    <label for="status"
                                                                        class="form-label">Status</label><br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="status" id="aktif" value="0"
                                                                            {{ $data->status_final_proposal == 0 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="aktif">
                                                                            Belum Final</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="status" id="aktif" value="1"
                                                                            {{ $data->status_final_proposal == 1 ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="aktif">
                                                                            Final</label>
                                                                    </div>
                                                                </div>

                                                                <!-- tambahkan input untuk atribut lainnya jika diperlukan -->
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="sutmit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                        </form>
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

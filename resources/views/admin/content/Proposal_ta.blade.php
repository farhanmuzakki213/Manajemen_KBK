@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Proposal TA</h5>
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
                            <div class="d-grid gap-2 d-md-block">
                                {{-- <a href="{{ route('review_proposal_ta.create') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-file-earmark-plus"></i> New</a> --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            {{-- <th>Judul</th> --}}
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Pembimbing 1</th>
                                            <th>Pembimbing 2</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            {{-- <th>Judul</th> --}}
                                            <th>Status</th>
                                            <th>File</th>
                                            <th>Pembimbing 1</th>
                                            <th>Pembimbing 2</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_proposal_ta as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_proposal_ta }}</th>
                                                <th>{{ $data->nama }}</th>
                                                {{-- <th>{{ Str::words($data->judul, 2, '...') }}</th> --}}
                                                <th>
                                                    @if ($data->status_proposal_ta == 0)
                                                        Di Ajukan
                                                    @elseif ($data->status_proposal_ta == 1)
                                                        Di Tolak
                                                    @elseif ($data->status_proposal_ta == 2)
                                                        Di Revisi
                                                    @else
                                                        Di Terima
                                                    @endif
                                                </th>
                                                <th>
                                                    <a href="{{ asset('storage/uploads/proposal_ta_files/' . $data->file_proposal) }}"
                                                        target="_blank">
                                                        {{ Str::limit($data->file_proposal, 5, '...') }}
                                                    </a>
                                                </th>
                                                <th>{{ $data->pembimbing_satu }}</th>
                                                <th>{{ $data->pembimbing_dua }}</th>

                                                <th style="width: 10%;">
                                                    {{-- <a data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop{{ $data->id_penugasan }}"
                                                            class="btn btn-danger"><i class="bi bi-trash"></i></a> --}}
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#detail{{ $data->id_proposal_ta }}"
                                                        class="btn btn-primary d-flex align-items-center"><i
                                                            class="bi bi-three-dots-vertical"></i>Detail</a>
                            </div>
                            </th>
                            </tr>

                            {{-- Modal Detail Tabel --}}
                            <div class="modal fade" id="detail{{ $data->id_proposal_ta }}" tabindex="-1"
                                aria-labelledby="detailLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailLabel">Detail Proposal TA
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Mahasiswa
                                                    1:</label>
                                                <input type="text" class="form-control" id="nama"
                                                    value="{{ $data->nama }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Judul" class="form-label">Judul</label>
                                                <textarea class="form-control" id="Judul" name="Judul" rows="3" readonly>{{ $data->judul }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status_proposal_ta" class="form-label">Status</label>
                                                <input type="text" class="form-control" id="status_proposal_ta"
                                                    value="{{ $data->status_proposal_ta == 0 ? 'Di Ajukan' : ($data->status_proposal_ta == 1 ? 'Di Tolak' : ($data->status_proposal_ta == 2 ? 'Di Revisi' : 'Di Terima')) }}"
                                                    readonly>
                                            </div>

                                            <div class="mb-3">
                                                <label for="file_proposal" class="form-label">File
                                                    1:</label>
                                                <input type="fle" class="form-control" id="file_proposal"
                                                    value="{{ $data->file_proposal }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_dosen" class="form-label">Pembimbing
                                                    1:</label>
                                                <input type="text" class="form-control" id="nama_dosen"
                                                    value="{{ $data->pembimbing_satu }}" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama_dosen" class="form-label">Pembimbing
                                                    2:</label>
                                                <input type="text" class="form-control" id="nama_dosen"
                                                    value="{{ $data->pembimbing_dua }}" readonly>
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

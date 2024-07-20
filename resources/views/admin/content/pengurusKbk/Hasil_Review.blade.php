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
                                            <th>Nama Reviewer 1</th>
                                            <th>Status Proposal 1</th>
                                            <th>Nama Reviewer 2</th>
                                            <th>Status Proposal 2</th>
                                            <th>Status Final</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Nama Reviewer 1</th>
                                            <th>Status Proposal 1</th>
                                            <th>Nama Reviewer 2</th>
                                            <th>Status Proposal 2</th>
                                            <th>Status Final</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        {{-- @dd($merged_data); --}}
                                        @foreach ($merged_data as $data)
                                            <tr class="table-Light">
                                                <th>{{ $no++ }}</th>
                                                <th>{{ $data['nama_mahasiswa'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['proposal_ta']['r_mahasiswa']['nama'] ?? 'null') }}
                                                </th>
                                                <th>{{ $data['reviewer_satu'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['reviewer_satu_dosen']['r_dosen']['nama_dosen'] ?? 'null') }}
                                                </th>
                                                <th>
                                                    @if ($data['status_satu'] == 0)
                                                        Belum Diverifikasi
                                                    @elseif ($data['status_satu'] == 1)
                                                        Ditolak
                                                    @elseif ($data['status_satu'] == 2)
                                                        Direvisi
                                                    @else
                                                        Diterima
                                                    @endif
                                                </th>
                                                <th>{{ $data['reviewer_dua'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['reviewer_dua_dosen']['r_dosen']['nama_dosen'] ?? 'null') }}
                                                </th>
                                                <th>
                                                    @if ($data['status_dua'] == 0)
                                                        Belum Diverifikasi
                                                    @elseif ($data['status_dua'] == 1)
                                                        Ditolak
                                                    @elseif ($data['status_dua'] == 2)
                                                        Direvisi
                                                    @else
                                                        Diterima
                                                    @endif
                                                </th>
                                                <th>
                                                    @if ($data['status_final_proposal'] == 0)
                                                        Belum Diverifikasi
                                                    @elseif ($data['status_final_proposal'] == 1)
                                                        Ditolak
                                                    @elseif ($data['status_final_proposal'] == 2)
                                                        Direvisi
                                                    @else
                                                        Diterima
                                                    @endif
                                                </th>
                                                <th style="width: 14%;">
                                                    <div class="row">
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data['penugasan_id'] }}"
                                                            class="btn btn-secondary d-flex align-items-center">
                                                            <i class="bi bi-three-dots-vertical"></i>Detail
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail{{ $data['penugasan_id'] }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="detailLabel">Detail Review Proposal
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_mahasiswa"
                                                                    class="form-label">Nama_mahasiswa</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_mahasiswa"
                                                                    value="{{ $data['nama_mahasiswa'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['proposal_ta']['r_mahasiswa']['nama'] ?? 'null') }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">NIM</label>
                                                                <input type="text" class="form-control" id="nim"
                                                                    value="{{ $data['nim_mahasiswa'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['proposal_ta']['r_mahasiswa']['nim'] ?? 'null') }}"
                                                                    readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="nama_dosen"
                                                                            class="form-label">pembimbing
                                                                            1:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="pembimbing_satu"
                                                                            value="{{ $data['pembimbing_satu'] ?? ($data_ta->firstWhere('proposal_ta_id', $data['proposal_ta_id_satu'] ?? $data['proposal_ta_id_dua'])->proposal_ta->r_pembimbing_satu->nama_dosen ?? 'Tidak Ada') }}"
                                                                            readonly>
                                                                    </div>

                                                                    <div class="col">
                                                                        <label for="pembimbing_dua"
                                                                            class="form-label">Pembimbing 2:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="pembimbing_dua"
                                                                            value="{{ $data['pembimbing_dua'] ?? ($data_ta->firstWhere('proposal_ta_id', $data['proposal_ta_id_satu'] ?? $data['proposal_ta_id_dua'])->proposal_ta->r_pembimbing_dua->nama_dosen ?? 'Tidak Ada') }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="nama_dosen" class="form-label">Reviewer
                                                                            1:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="reviewer_satu"
                                                                            value="{{ $data['status_satu'] == 0 ? 'Belum Diverifikasi' : ($data['status_satu'] == 1 ? 'Ditolak' : ($data['status_satu'] == 2 ? 'Direvisi' : 'Diterima')) }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="reviewer_dua"
                                                                            class="form-label">Reviewer 2:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="reviewer_dua"
                                                                            value="{{ $data['status_dua'] == 0 ? 'Belum Diverifikasi' : ($data['status_dua'] == 1 ? 'Ditolak' : ($data['status_dua'] == 2 ? 'Direvisi' : 'Diterima')) }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="nama_dosen" class="form-label">Status
                                                                            Reviewer
                                                                            1:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="reviewer_satu"
                                                                            value="{{ $data['reviewer_satu'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['reviewer_satu_dosen']['r_dosen']['nama_dosen'] ?? 'Tidak Ada') }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="reviewer_dua"
                                                                            class="form-label">Status Reviewer 2:</label>
                                                                        <input type="text" class="form-control"
                                                                            id="reviewer_dua"
                                                                            value="{{ $data['reviewer_dua'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['reviewer_dua_dosen']['r_dosen']['nama_dosen'] ?? 'Tidak Ada') }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="Judul" class="form-label">Judul</label>
                                                                <textarea class="form-control" id="Judul" name="Judul" rows="3" readonly>{{ $data['judul'] ?? ($data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal['proposal_ta']['judul'] ?? 'null') }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status
                                                                    Final</label>
                                                                <input type="text" class="form-control" id="status"
                                                                    value="{{ $data['status_final_proposal'] == 0 ? 'Belum Diverifikasi' : ($data['status_final_proposal'] == 1 ? 'Ditolak' : ($data['status_final_proposal'] == 2 ? 'Direvisi' : 'Diterima')) }}"
                                                                    readonly>
                                                            </div>

                                                            <!-- tambahkan input untuk atribut lainnya jika diperlukan -->
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

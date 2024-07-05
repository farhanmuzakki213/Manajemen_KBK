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
                                            <th>Prodi</th>
                                            <th>Nama Reviewer</th>
                                            <th>Status Proposal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Prodi</th>
                                            <th>Nama Reviewer</th>
                                            <th>Status Proposal</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($merged_data as $data)
                                            <tr class="table-Light">
                                                <th>{{ $no++ }}</th>
                                                <th>{{ $data['nama_mahasiswa'] }}</th>
                                                <th>{{ $data['prodi'] }}</th>
                                                <th>{{ $data['reviewer_satu'] ?? $data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal->reviewer_satu_dosen->r_dosen->nama_dosen ? : $data['reviewer_dua'] ?? $data_review_proposal_ta->firstWhere('penugasan_id', $data['penugasan_id'])->p_reviewProposal->reviewer_dua_dosen->r_dosen->nama_dosen }}</th>
                                                <th>
                                                    @if ($data['status_satu'] == 0 || $data['status_dua'] == 0)
                                                        Diajukan
                                                    @elseif ($data['status_satu'] == 1 || $data['status_dua'] == 1)
                                                        Ditolak
                                                    @elseif ($data['status_satu'] == 2 || $data['status_dua'] == 2)
                                                        Direvisi
                                                    @else
                                                        Diterima
                                                    @endif
                                                </th>
                                                <th style="width: 10%;">
                                                    <div class="row">                                                        
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data['penugasan_id'] }}"
                                                            class="btn btn-primary d-flex align-items-center"><i
                                                                class="bi bi-three-dots-vertical"></i>Detail</a>
                                                    </div>
                                                </th>
                                            </tr>

                                            {{-- Modal Detail Tabel --}}
                                            <div class="modal fade" id="detail{{ $data['penugasan_id'] }}" tabindex="-1"
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
                                                                <label for="nama_dosen" class="form-label">Reviewer
                                                                    1:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ optional($data->reviewer_satu_dosen)->r_dosen->nama_dosen }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Reviewer
                                                                    2:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ optional($data->reviewer_dua_dosen)->r_dosen->nama_dosen }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Judul" class="form-label">Judul</label>
                                                                <textarea class="form-control" id="Judul" name="Judul" rows="3" readonly>{{ optional($data->proposal_ta)->judul }}</textarea>
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
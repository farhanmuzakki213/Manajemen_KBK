@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Penugasan Review Proposal TA</h5>
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
                    <!-- Data Proposal TA -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Proposal TA</h6>
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
                                            <th>Nama Mahasiswa</th>
                                            <th>Pembimbing 1</th>
                                            <th>Pembimbing 2</th>
                                            <th>Jenis Kbk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Nama Mahasiswa</th>
                                            <th>Pembimbing 1</th>
                                            <th>Pembimbing 2</th>
                                            <th>Jenis Kbk</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_proposal_ta as $data)
                                        @php
                                            // Check if the proposal TA already has an assignment
                                            $hasReviewAssigned = $data->review_proposal_ta()->exists();
                                        @endphp
                                        @unless($hasReviewAssigned)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_proposal_ta }}</th>
                                                <th>{{ optional($data->r_mahasiswa)->nama }}</th>
                                                <th>{{ optional($data->r_pembimbing_satu)->nama_dosen }}</th>
                                                <th>{{ optional($data->r_pembimbing_dua)->nama_dosen }}</th>
                                                <th>{{ optional($data->r_jenis_kbk)->jenis_kbk }}</th>
                                                <th style="width: 10%;">
                                                    <div class="row">
                                                        <a href="{{ route('PenugasanReview.create', ['id' => $data['id_proposal_ta']]) }}"
                                                           class="btn btn-primary mb-2 d-flex align-items-center">
                                                            <i class="bi bi-pencil-square"></i> Penugasan
                                                        </a>
                                                        <a data-bs-toggle="modal"
                                                           data-bs-target="#detail{{ $data->id_proposal_ta }}"
                                                           class="btn btn-primary d-flex align-items-center">
                                                            <i class="bi bi-three-dots-vertical"></i>Detail
                                                        </a>
                                                    </div>
                                                </th>
                                            </tr>
                                        @endunless
                                    
                                        {{-- Modal Detail Tabel --}}
                                        {{-- Kode modal detail yang sudah ada tetap sama --}}
                                   
                                    
                                            

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
                                                                <label for="nama_dosen" class="form-label">Nama Mahasiswa</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ optional($data->r_mahasiswa)->nama }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="Judul" class="form-label">Judul</label>
                                                                <textarea class="form-control" id="Judul" name="Judul" rows="3" readonly>{{ $data->judul }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Status</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ $data->status_proposal_ta }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="file_proposal" class="form-label">File</label>
                                                                <input type="text" class="form-control" id="file_proposal"
                                                                    value="{{ $data->file_proposal }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Dosen Pembimbing 1</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ optional($data->r_pembimbing_satu)->nama_dosen }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Dosen Pembimbing 2</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ optional($data->r_pembimbing_dua)->nama_dosen }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="jenis_kbk" class="form-label">Jenis kbk</label>
                                                                <input type="text" class="form-control" id="jenis_kbk"
                                                                    value="{{ optional($data->r_jenis_kbk)->jenis_kbk }}" readonly>
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
                        {{-- <div class="card-header py-2">
                            <div class="d-grid gap-2 d-md-block">
                                <a href="{{ route('PenugasanReview.create') }}" class="btn btn-primary me-md-3"><i
                                        class="bi bi-file-earmark-plus"></i> New</a>
                            </div>
                        </div> --}}
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
                                            <th>Nama Reviewer 1</th>
                                            <th>Nama Reviewer 2</th>
                                            <th>Nama Pimpinan Prodi</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Nama Reviewer 1</th>
                                            <th>Nama Reviewer 2</th>
                                            <th>Nama Pimpinan Prodi</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($data_review_proposal_ta as $data)
                                            <tr class="table-Light">
                                                <th>{{ $data->id_penugasan }}</th>
                                                <th>{{ optional($data->proposal_ta)->r_mahasiswa->nama }}</th>
                                                <th>{{ optional($data->reviewer_satu_dosen)->r_dosen->nama_dosen }}</th>
                                                <th>{{ optional($data->reviewer_dua_dosen)->r_dosen->nama_dosen }}</th>
                                                <th>{{ optional($data->pimpinan_prodi_dosen)->r_dosen->nama_dosen }}</th>
                                                <th>{{ $data->tanggal_penugasan }}</th>
                                                <th style="width: 10%;">
                                                    <div class="row">
                                                        <a href="{{ route('PenugasanReview.edit', ['id' => $data->id_penugasan]) }}"
                                                            class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                class="bi bi-pencil-square"></i>Edit</a>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#staticBackdrop{{ $data->id_penugasan }}"
                                                            class="btn btn-danger mb-2 d-flex align-items-center"><i
                                                                class="bi bi-trash"></i>Delete</a>
                                                        <a data-bs-toggle="modal"
                                                            data-bs-target="#detail{{ $data->id_penugasan }}"
                                                            class="btn btn-primary d-flex align-items-center"><i
                                                                class="bi bi-three-dots-vertical"></i>Detail</a>
                                                    </div>
                                                </th>
                                            </tr>
                                            {{-- Modal Konfirmasi hapus data --}}
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_penugasan }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi
                                                                Hapus Data</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah kamu yakin ingin menghapus data ini?
                                                                <b>{{ $data->proposal_ta->r_mahasiswa->nama }}</b>
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">
                                                            <form
                                                                action="{{ route('PenugasanReview.delete', ['id' => $data->id_penugasan]) }}"
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
                                            <div class="modal fade" id="detail{{ $data->id_penugasan }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="detailLabel">Detail penugasan Proposal TA
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                                                <input type="text" class="form-control" id="nama_mahasiswa"
                                                                    value="{{ optional($data->proposal_ta)->r_mahasiswa->nama }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nim" class="form-label">NIIM</label>
                                                                <input type="text" class="form-control" id="nim"
                                                                    value="{{ optional($data->proposal_ta)->r_mahasiswa->nim }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Reviewer
                                                                    1:</label>
                                                                <input type="text" class="form-control" id="nama_dosen"
                                                                    value="{{ optional($data->reviewer_satu_dosen)->r_dosen->nama_dosen }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="nama_dosen" class="form-label">Reviewer
                                                                    2:</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_dosen"
                                                                    value="{{ optional($data->reviewer_dua_dosen)->r_dosen->nama_dosen }}"
                                                                    readonly>
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

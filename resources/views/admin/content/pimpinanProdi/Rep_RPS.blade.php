@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data RPS</h5>
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
                    <!-- DataRPS -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Aksi</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen Upload</th>
                                            <th>Prodi</th>
                                            <th>Dosen Verifikasi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>

                                        </tr>
                                    </thead>
                                    <tfoot>

                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Mata Kuliah</th>
                                            <th>Semester</th>
                                            <th>Dosen Upload</th>
                                            <th>Prodi</th>
                                            <th>Dosen Verifikasi</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($result as $data)
                                            @php
                                                $rekomendasi = optional(
                                                    $data_ver_rps->firstWhere(
                                                        'rep_rps_uas_id',
                                                        $data['id_rep_rps_uas'],
                                                    ),
                                                )->rekomendasi;
                                                $status = 'File Belum Diverifikasi';

                                                if ($rekomendasi !== null) {
                                                    switch ($rekomendasi) {
                                                        case 1:
                                                            $status = 'Belum Diverifikasi';
                                                            break;
                                                        case 2:
                                                            $status = 'Tidak Layak Pakai';
                                                            break;
                                                        case 3:
                                                            $status = 'Butuh Revisi';
                                                            break;
                                                        default:
                                                            $status = 'Layak Pakai';
                                                            break;
                                                    }
                                                }
                                                $ver_rps = $data_ver_rps->firstWhere(
                                                    'rep_rps_uas_id',
                                                    $data['id_rep_rps_uas'],
                                                );

                                                if (!$ver_rps || !$ver_rps->tanggal_diverifikasi) {
                                                    $tanggal_ver = 'File Belum Diverifikasi';
                                                } else {
                                                    $tanggal_ver = \Carbon\Carbon::parse(
                                                        $ver_rps->tanggal_diverifikasi,
                                                    )->format('Y-m-d');
                                                }
                                            @endphp
                                            <tr>
                                                <th>{{ $no++ }}</th>
                                                <th>{{ $data['nama_matkul'] }}</th>
                                                <th>{{ $data['semester'] }}</th>
                                                <th>{{ $data['nama_dosen'] }}</th>
                                                <th>{{ $data['prodi'] }}</th>
                                                <th
                                                    style="{{ $status === 'File Belum Diverifikasi' ? 'color: red;' : '' }}">
                                                    {{ $data_ver_rps->firstWhere('rep_rps_uas_id', $data['id_rep_rps_uas'])->r_pengurus->r_dosen->nama_dosen ?? 'File Belum Diverifikasi' }}
                                                </th>
                                                <th
                                                    style="{{ $status === 'File Belum Diverifikasi' ? 'color: red;' : '' }}">
                                                    {{ $status }}
                                                </th>
                                                <th>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#detail{{ $data['id_rep_rps_uas'] }}"
                                                        class="btn btn-secondary d-flex align-items-center"><i
                                                            class="bi bi-three-dots-vertical"></i>Detail</a>
                                                </th>
                                            </tr>
                                            <div class="modal fade" id="detail{{ $data['id_rep_rps_uas'] }}" tabindex="-1"
                                                aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="detailLabel">Detail RPS</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="nama_matkul" class="form-label">Mata
                                                                    Kuliah</label>
                                                                <input type="text" class="form-control" id="nama_matkul"
                                                                    value="{{ $data['nama_matkul'] }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="semester" class="form-label">Semester</label>
                                                                <input type="text" class="form-control" id="semester"
                                                                    value="{{ $data['semester'] }}" readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="dosen_upload" class="form-label">Dosen
                                                                    Upload</label>
                                                                <input type="text" class="form-control" id="dosen_upload"
                                                                    value="{{ $data['nama_dosen'] }}" readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="dosen_verifikasi" class="form-label">Dosen
                                                                    Verifikasi</label>
                                                                <input type="text" class="form-control"
                                                                    id="dosen_verifikasi"
                                                                    value="{{ $data_ver_rps->firstWhere('rep_rps_uas_id', $data['id_rep_rps_uas'])->r_pengurus->r_dosen->nama_dosen ?? 'File Belum Diverifikasi' }}"
                                                                    readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="prodi" class="form-label">Program
                                                                    Studi</label>
                                                                <input type="text" class="form-control" id="prodi"
                                                                    value="{{ $data['prodi'] }}" readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="status" class="form-label">Status
                                                                    Proposal</label>
                                                                <input type="text" class="form-control" id="status"
                                                                    value="{{ $status }}" readonly>
                                                            </div>

                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="created_at" class="form-label">Tanggal
                                                                            Di
                                                                            Upload</label>
                                                                        <input type="text" class="form-control"
                                                                            id="created_at"
                                                                            value="{{ \Carbon\Carbon::parse($data['tanggal_upload'])->format('Y-m-d') }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="tanggal_diverifikasi"
                                                                            class="form-label">Tanggal
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="tanggal_diverifikasi"
                                                                            value="{{ $tanggal_ver }}" readonly>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal fade" id="exampleModalToggle2" aria-hidden="true"
                                                aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="POST" action="rps.store" class="was-validated">
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="catatan"
                                                                        class="form-label">Catatan</label>
                                                                    <textarea class="form-control" id="catatan" name="catatan"
                                                                        placeholder="Ketik 'Selesai' Jika tidak ada revisi dan jika ada beri keterangan" required></textarea>
                                                                    <div class="invalid-feedback">
                                                                        Please enter a message in the textarea.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit"
                                                                    class="btn btn-primary">Verifikasi</button>
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

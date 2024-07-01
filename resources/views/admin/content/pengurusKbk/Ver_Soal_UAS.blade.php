@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Verifikasi UAS</h5>
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
                    <!-- DataDosen -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Tabel Data UAS</h6>
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
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload uas</th>
                                            <th>Semester</th>
                                            <th>Tahun Akademik</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload uas</th>
                                            <th>Semester</th>
                                            <th>Tahun Akademik</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($result as $data_rep)
                                            @php
                                                $cek_data_rep = false;
                                                if ($data_rep['id_rep_rps_uas'] !== null) {
                                                    $cek_data_rep = App\Models\VerRpsUas::whereHas(
                                                        'r_rep_rps_uas',
                                                        function ($query) use ($data_rep) {
                                                            $query
                                                                ->where('type', '=', '1')
                                                                ->where('rep_rps_uas_id', $data_rep['id_rep_rps_uas']);
                                                        },
                                                    )->exists();
                                                }
                                            @endphp
                                            <tr class="table-Light">
                                                <th>{{ $no++ }}</th>
                                                <th>{{ $data_rep['kode_matkul'] }}</th>
                                                <th>{{ $data_rep['nama_dosen'] }}</th>
                                                <th>{{ $data_rep['semester'] }}</th>
                                                <th>{{ $data_rep['smt_thnakd'] }}</th>
                                                <th style="width: 10%;">
                                                    @if ($data_rep['id_rep_rps_uas'] === null)
                                                        <p style="color: red">File belum diupload</p>
                                                    @else
                                                        @if (!$cek_data_rep)
                                                            <div class="row">
                                                                <a href="{{ route('ver_soal_uas.create', ['id' => $data_rep['id_rep_rps_uas']]) }}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center">
                                                                    <i class="bi bi-pencil-square"></i> Review
                                                                </a>
                                                                <a href="{{ asset('storage/uploads/uas/repositori_files/'. $data_rep['file']) }}"
                                                                    class="btn btn-primary mb-2 d-flex align-items-center"
                                                                    target="_blank">
                                                                    <i class="bi bi-file-earmark-arrow-down"></i> Fileuas
                                                                </a>
                                                            </div>
                                                        @else
                                                            <p style="color: green">Sudah diverifikasi</p>
                                                        @endif
                                                    @endif
                                                </th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid">
                <!-- Data Verifikasi uas -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Tabel Data Verifikasi</h6>
                    </div>
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
                                        <th>Rekomendasi</th>
                                        <th>Saran</th>
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
                                        <th>Rekomendasi</th>
                                        <th>Saran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($data_ver_uas as $data_ver)
                                        <tr class="table-Light">
                                            <th>{{ $no++ }}</th>
                                            {{-- <th>{{ $data_rep->id_rep_rps }}</th> --}}
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->kode_matkul }}
                                            </th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_dosen_matkul->r_dosen->nama_dosen }}
                                            </th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->semester }}
                                            </th>
                                            <th>{{ optional($data_ver->r_rep_rps_uas)->r_smt_thnakd->smt_thnakd }}</th>
                                            <th>{{ optional($data_ver->r_pengurus)->r_dosen->nama_dosen }}</th>
                                            <th>
                                                @if ($data_ver->rekomendasi == 0)
                                                    Belum diverifikasi
                                                @elseif ($data_ver->rekomendasi == 1)
                                                    Tidak Layak Pakai
                                                @elseif ($data_ver->rekomendasi == 2)
                                                    Butuh Revisi
                                                @else
                                                    Layak Pakai
                                                @endif
                                            </th>
                                            <th>{{ $data_ver->saran }}</th>
                                            <th style="width: 10%;">
                                                <div class="row">
                                                    <a href="{{ route('ver_soal_uas.edit', ['id' => $data_ver->id_ver_rps_uas]) }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                            class="bi bi-pencil-square"></i>Revisi</a>
                                                    <a href="{{ asset('storage/uploads/uas/repositori_files/'. $data_ver->r_rep_rps_uas->file) }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"
                                                        target="_blank"><i
                                                            class="bi bi-file-earmark-arrow-down"></i>FileUas</a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#detail{{ $data_ver->id_ver_rps_uas }}"
                                                        class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                            class="bi bi-three-dots-vertical"></i>Detail</a>
                                                    <a data-bs-toggle="modal"
                                                        data-bs-target="#staticBackdrop{{ $data_ver->id_ver_rps_uas }}"
                                                        class="btn btn-danger mb-2 d-flex align-items-center"><i
                                                            class="bi bi-trash"></i>Hapus</a>
                                                </div>
                                            </th>
                                        </tr>
                                        {{-- Modal Konfirmasi hapus data --}}
                                        <div class="modal fade" id="staticBackdrop{{ $data_ver->id_ver_rps_uas }}"
                                            data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">>
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title fs-5" id="staticBackdropLabel">
                                                            Konfirmasi
                                                            Hapus Data</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah kamu yakin ingin menghapus data Ini
                                                            <b>{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->kode_matkul }}
                                                                |
                                                                {{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->nama_matkul }}</b>
                                                        </p>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">

                                                        <form
                                                            action="{{ route('ver_soal_uas.delete', ['id' => $data_ver->id_ver_rps_uas]) }}"
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
                                        {{-- Modal Detail Tabel Verifikasi --}}
                                        <div class="modal fade" id="detail{{ $data_ver->id_ver_rps_uas }}" tabindex="-1"
                                            aria-labelledby="detailLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fs-5" id="detailLabel">Detail
                                                            Verifikasi
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="mb-3">
                                                                <label for="nama_matkul" class="form-label">Nama
                                                                    Matkul</label>
                                                                <input type="text" class="form-control"
                                                                    id="nama_matkul"
                                                                    value="{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->kode_matkul }} | {{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->nama_matkul }}"
                                                                    readonly>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label class="form-label">Tahun
                                                                            Akademik</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ optional($data_ver->r_rep_rps_uas)->r_smt_thnakd->smt_thnakd }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Semester</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ optional($data_ver->r_rep_rps_uas)->r_matkulKbk->r_matkul->semester }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label class="form-label">Dosen
                                                                            Upload</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ optional($data_ver->r_rep_rps_uas)->r_dosen_matkul->r_dosen->nama_dosen }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Dosen
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ optional($data_ver->r_dosen)->nama_dosen }}"
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
                                                                            value="{{ optional($data_ver->r_rep_rps_uas)->updated_at }}"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label class="form-label">Tanggal
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            value="{{ $data_ver->tanggal_diverifikasi }}"
                                                                            readonly>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <label for="status" class="form-label">Status
                                                                            Verifikasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="status"value="@if ($data_ver->status_verifikasi == 0) Tidak Diverifikasi @else Diverifikasi @endif"
                                                                            readonly>
                                                                    </div>
                                                                    <div class="col">
                                                                        <label for="saran"
                                                                            class="form-label">Rekomendasi</label>
                                                                        <input type="text" class="form-control"
                                                                            id="saran"
                                                                            value="@if ($data_ver->saran == 0) Belum Diverifikasi
                                                                                   @elseif ($data_ver->saran == 1) Tidak Layak Dipakai
                                                                                   @elseif ($data_ver->saran == 2) Butuh Revisi
                                                                                   @elseif ($data_ver->saran == 3) Layak Dipakai @endif"
                                                                            readonly>
                                                                    </div>



                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="catatan" class="form-label">Catatan</label>
                                                                <textarea class="form-control" id="catatan" name="catatan" rows="3" readonly>{{ $data_ver->saran }}</textarea>
                                                            </div>



                                                        </form>
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
@endsection
@section('scripts')
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
@endsection
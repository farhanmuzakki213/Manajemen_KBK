@extends('admin.admin_master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/multi-dropdown.css') }}" />
    <style>
        .dropdown-item {
            width: auto;
            /* Lebar menyesuaikan dengan konten */
            white-space: nowrap;
            /* Konten tidak akan melintasi baris */
        }

        .dropdown-item .row {
            display: flex;
            /* Menggunakan flexbox untuk mengatur kolom */
            flex-wrap: nowrap;
            /* Konten tidak akan melintasi baris */
        }

        .dropdown-item .col-lg-3 {
            flex: 1;
            /* Kolom kode_matkul mengambil 1 bagian */
        }

        .dropdown-item .col-lg-4 {
            flex: 3;
            /* Kolom nama_matkul mengambil 3 bagian */
        }
    </style>
@endsection
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Verifikasi UAS</h5>
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
                    <!-- Data Verifikasi RPS -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3 mb-3">
                                <!-- Dropdown for selecting Prodi -->
                                <select id="prodiSelect" class="form-select me-2" onchange="filterByProdi()"
                                    style="width: auto;">
                                    <option value="">Pilih Prodi</option>
                                    @foreach ($prodiList as $prodi)
                                        <option value="{{ $prodi->id_prodi }}"
                                            {{ request('prodi_id') == $prodi->id_prodi ? 'selected' : '' }}>
                                            {{ $prodi->prodi }}
                                        </option>
                                    @endforeach
                                </select>
                                @can('pengurusKbk-download BeritaAcaraUas')
                                    <!-- Print Button -->
                                    <a href="{{ route('cetak_uas_berita_acara.download', ['prodi_id' => $selectedProdiId]) }}"
                                        class="btn btn-primary d-flex align-items-center">
                                        <i class="bi bi-box-arrow-in-up me-2"></i>Cetak
                                    </a>
                                @endcan

                                @can('pengurusKbk-create BeritaAcaraUas')
                                    <!-- Upload Button -->
                                    <a href="{{ route('upload_uas_berita_acara.create') }}"
                                        class="btn btn-primary d-flex align-items-center">
                                        <i class="ti ti-upload me-2"></i>Upload Berita
                                    </a>
                                @endcan


                            </div>
                            <button id="toggleTableBtn" class="btn btn-primary" onclick="toggleTable()">Tutup Tabel</button>
                        </div>
                        <div class="card-body" id="tableContent" style="display: block;">
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
                                            <th>Evaluasi</th>
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
                                            <th>Evaluasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data_ver_rps as $data_ver)
                                            @php
                                                $hasReviewAssigned = $data_ver->p_VerBeritaAcara()->exists();
                                            @endphp
                                            @unless ($hasReviewAssigned)
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
                                                            <a href="{{ asset('storage/uploads/uas/repositori_files/' . $data_ver->r_rep_rps_uas->file) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"
                                                                target="_blank"><i
                                                                    class="bi bi-file-earmark-arrow-down"></i>FileRPS</a>
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#detail{{ $data_ver->id_ver_rps_uas }}"
                                                                class="btn btn-secondary mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-three-dots-vertical"></i>Detail</a>
                                                        </div>
                                                    </th>
                                                </tr>
                                            @endunless
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
                                                                action="{{ route('ver_rps.delete', ['id' => $data_ver->id_ver_rps_uas]) }}"
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
                                            <div class="modal fade" id="detail{{ $data_ver->id_ver_rps_uas }}"
                                                tabindex="-1" aria-labelledby="detailLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="detailLabel">Detail Verifikasi</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                                                value="{{ optional($data_ver->r_pengurus)->r_dosen->nama_dosen }}"
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
                                                                            <label for="status"
                                                                                class="form-label">Rekomendasi</label>
                                                                            <input type="text" class="form-control"
                                                                                id="status"value="@if ($data_ver->rekomendasi == 0) Belum diverifikasi @elseif ($data_ver->rekomendasi == 1) Tidak Layak Pakai @elseif ($data_ver->rekomendasi == 2) Butuh Revisi @else Layak Pakai @endif"
                                                                                readonly>
                                                                        </div>
                                                                        <div class="col">
                                                                            <label for="saran"
                                                                                class="form-label">Evaluasi</label>
                                                                            <input type="text" class="form-control"
                                                                                id="saran"value="{{ $data_ver->saran }}"
                                                                                readonly>
                                                                        </div>
                                                                    </div>
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
                <div class="container-fluid">
                    <!-- Data Verifikasi RPS -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Berita Acara</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload Berita Acara</th>
                                            <th>Prodi</th>
                                            <th>Jurusan</th>
                                            <th>Jenis KBK</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            {{-- <th>id rep</th> --}}
                                            <th>Kode Matkul</th>
                                            <th>Dosen Upload Berita Acara</th>
                                            <th>Prodi</th>
                                            <th>Jurusan</th>
                                            <th>Jenis KBK</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach ($data_berita_acara as $data)
                                            <tr class="table-Light">
                                                <th>{{ $no++ }}</th>
                                                {{-- <th>{{ $data_rep->id_rep_rps }}</th> --}}
                                                <th>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton" data-toggle="dropdown"
                                                            aria-haspopup="true" aria-expanded="false">
                                                            Mata Kuliah
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            @foreach ($data->p_ver_rps_uas as $data_matkul)
                                                                <div class="dropdown-item">
                                                                    <div class="row">
                                                                        <div class="col-lg-5">
                                                                            {{ optional(optional($data_matkul->r_rep_rps_uas)->r_matkulKbk)->r_matkul->kode_matkul }}
                                                                        </div>
                                                                        <div class="col-lg-5">
                                                                            {{ optional(optional($data_matkul->r_rep_rps_uas)->r_matkulKbk)->r_matkul->nama_matkul }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </th>

                                                <th>
                                                    @foreach ($data->first()->p_ver_rps_uas->unique('pengurus_id') as $data_pengurus)
                                                        {{ optional($data_pengurus->r_pengurus)->r_dosen->nama_dosen }}
                                                    @endforeach
                                                </th>
                                                <th>{{ optional($data->r_pimpinan_prodi)->r_prodi->prodi }}
                                                </th>
                                                <th>{{ optional(optional($data->r_pimpinan_jurusan)->r_jurusan)->jurusan }}
                                                </th>
                                                <th>{{ optional($data->r_jenis_kbk)->jenis_kbk }}</th>
                                                <th style="width: 10%;">
                                                    <div class="row">
                                                        @can('pengurusKbk-update BeritaAcaraUas')
                                                            <a href="{{ route('upload_uas_berita_acara.edit', ['id' => $data->id_berita_acara]) }}"
                                                                class="btn btn-primary mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-pencil-square"></i>Revisi</a>
                                                        @endcan
                                                        @can('pengurusKbk-delete BeritaAcaraUas')
                                                            <a data-bs-toggle="modal"
                                                                data-bs-target="#staticBackdrop{{ $data->id_berita_acara }}"
                                                                class="btn btn-danger mb-2 d-flex align-items-center"><i
                                                                    class="bi bi-trash"></i>Hapus</a>
                                                        @endcan

                                                        <a href="{{ asset('storage/uploads/uas/berita_acara/' . $data->file_berita_acara) }}"
                                                            class="btn btn-success mb-2 d-flex align-items-center"
                                                            target="_blank"><i
                                                                class="bi bi-file-earmark-arrow-down"></i>Download</a>

                                                    </div>
                                                </th>
                                            </tr>
                                            {{-- Modal Konfirmasi hapus data --}}
                                            <div class="modal fade" id="staticBackdrop{{ $data->id_berita_acara }}"
                                                data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                aria-labelledby="staticBackdropLabel" aria-hidden="true">>
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title fs-5" id="staticBackdropLabel">
                                                                Konfirmasi
                                                                Hapus Data</h4>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Apakah kamu yakin ingin menghapus data Ini?
                                                            </p>
                                                        </div>
                                                        <div class="modal-footer justify-content-between">

                                                            <form
                                                                action="{{ route('upload_uas_berita_acara.delete', ['id' => $data->id_berita_acara]) }}"
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
    <script src="{{ asset('backend/assets/js/jquery3-1-1.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/multi-dropdown.js') }}"></script>
    <script>
        setTimeout(function() {
            var element = document.getElementById('delay');
            if (element) {
                element.parentNode.removeChild(element);
            }
        }, 5000); // 5000 milliseconds = 5 detik

        function toggleTable() {
            var tableContent = document.getElementById('tableContent');
            var toggleTableBtn = document.getElementById('toggleTableBtn');

            if (tableContent.style.display === 'none') {
                tableContent.style.display = 'block';
                toggleTableBtn.textContent = 'Tutup Tabel';
            } else {
                tableContent.style.display = 'none';
                toggleTableBtn.textContent = 'Buka Tabel';
            }
        }
    </script>
    <script>
        function filterByProdi() {
            const selectedProdi = document.getElementById('prodiSelect').value;
            window.location.href = `{{ route('upload_uas_berita_acara') }}?prodi_id=${selectedProdi}`;
        }
    </script>
@endsection

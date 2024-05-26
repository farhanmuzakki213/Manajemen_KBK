@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Verifikasi UAS </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_soal_uas') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('ver_soal_uas.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    {{-- <label for="id_ver_soal_uas" class="form-label">ID Verifikasi RPS</label> --}}
                                    <input type="hidden" class="form-control" id="id_ver_uas" name="id_ver_uas"
                                        value="{{ $nextNumber }}" readonly>
                                    @error('id_ver_uas')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_dosen"
                                        id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            <option value="{{ $dosen->id_dosen }}">{{ $dosen->nama_dosen }}</option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                    @foreach ($data_rep_soal_uas as $data)
                                        <input type="hidden" class="form-control" id="id_rep_uas" name="id_rep_uas"
                                            value="{{ $data->id_rep_uas }}" readonly>
                                        <input type="text" class="form-control" id="nama_matkul" name="nama_matkul"
                                            value="{{ $data->kode_matkul }} | {{ $data->nama_matkul }}" readonly>
                                    @endforeach
                                    @error('nama_matkul')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="upload_file" class="form-label">Upload File Verifikasi</label>
                                    <input type="file" class="form-control" id="upload_file" name="upload_file">
                                    @error('upload_file')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_diverifikasi"
                                            value="1">
                                        <label class="form-check-label" for="status_diverifikasi">Diverifikasi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_tidak_diverifikasi"
                                            value="0">
                                        <label class="form-check-label" for="status_tidak_diverifikasi">Tidak Diverifikasi</label>
                                    </div>
                                    @error('status')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" id="saran_section" style="display: none;">
                                    <label for="saran" class="form-label">Saran</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_layak"
                                            value="1">
                                        <label class="form-check-label" for="saran_layak">Layak Dipakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_tidak_layak"
                                            value="0">
                                        <label class="form-check-label" for="saran_tidak_layak">Tidak Layak Dipakai</label>
                                    </div>
                                    @error('saran')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                {{-- <label for="date" class=" col-form-label">Tanggal Verifikasi</label> --}}
                                <div class="col-5 mb-3">
                                    <div class="input-group date">
                                        <input type="hidden" class="form-control" id="date" name="date"
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}" />
                                    </div>
                                    @error('date')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusDiverifikasi = document.getElementById('status_diverifikasi');
            const statusTidakDiverifikasi = document.getElementById('status_tidak_diverifikasi');
            const saranSection = document.getElementById('saran_section');

            statusDiverifikasi.addEventListener('change', function () {
                if (this.checked) {
                    saranSection.style.display = 'block';
                }
            });

            statusTidakDiverifikasi.addEventListener('change', function () {
                if (this.checked) {
                    saranSection.style.display = 'none';
                }
            });
        });
    </script>
@endsection

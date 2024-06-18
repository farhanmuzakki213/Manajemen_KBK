@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Upload Berita Acara </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_rps') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('ver_rps_berita_acara.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id_berita_acara" name="id_berita_acara"
                                    value="{{ $nextNumber }}"readonly>
                                <input type="hidden" class="form-control" id="jenis_kbk_id" name="jenis_kbk_id"
                                    value="{{ $pengurus_kbk->jenis_kbk_id }}"readonly>
                                <input type="hidden" class="form-control" id="type" name="type"
                                    value="0"readonly>
                                <input type="hidden" class="form-control" id="kajur" name="kajur"
                                    value="{{ $kajur }}"readonly>
                                <input type="hidden" class="form-control" id="prodi" name="prodi"
                                    value="{{ $kaprodi }}"readonly>
                                <div class="mb-3">
                                    <label for="file_berita_acara" class="form-label">Upload File Berita Acara Rps</label>
                                    <input type="file" class="form-control" id="file_berita_acara"
                                        name="file_berita_acara">
                                    @error('file_berita_acara')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="ver_rps_uas_id[]" class="form-label">Mata Kuliah</label>
                                    <select name="ver_rps_uas_id[]" class="form-control" multiple>
                                        <option value="" disabled selected>Pilih Mata Kuliah VERIFIKASI</option>
                                        @foreach ($data_ver_rps as $data)
                                            <option value="{{ $data['id_rep_rps_uas'] }}">{{ $data['kode_matkul'] }} ||
                                                {{ $data['nama_matkul'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('ver_rps_uas_id')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-5 mb-3">
                                    <div class="input-group tanggal_upload">
                                        <input type="hidden" class="form-control" id="tanggal_upload" name="tanggal_upload"
                                            value="{{ \Carbon\Carbon::now() }}" required/>
                                    </div>
                                    @error('tanggal_upload')
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
@endsection

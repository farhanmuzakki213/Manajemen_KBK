@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Data Verifikasi UAS </h5>
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_soal_uas') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('ver_soal_uas.update',['id' => $data_ver_soal_uas->id_ver_uas]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="id_ver_uas" name="id_ver_uas" value="{{ $data_ver_soal_uas->id_ver_uas }}" readonly>
                                    @error('id_ver_uas')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" name="nama_dosen" id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            <option value="{{ $dosen->id_dosen }}" {{ $dosen->id_dosen == $data_ver_soal_uas->dosen_id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                    @foreach ($data_rep_soal_uas as $data)
                                        <input type="hidden" class="form-control" id="id_rep_uas" name="id_rep_uas" value="{{ $data->id_rep_uas }}" readonly>
                                        <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" value="{{ $data->kode_matkul }} | {{ $data->nama_matkul }}" readonly>
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
                                        <input class="form-check-input" type="radio" name="status" id="aktif" value="1" {{ $data_ver_soal_uas->status_ver_uas == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">Diverifikasi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="tidak_aktif" value="0" {{ $data_ver_soal_uas->status_ver_uas == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">Tidak Diverifikasi</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="saran" class="form-label">Saran</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="layak_dipakai" value="1" {{ $data_ver_soal_uas->saran == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="layak_dipakai">Layak Dipakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="tidak_layak_dipakai" value="0" {{ $data_ver_soal_uas->saran == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_layak_dipakai">Tidak Layak Dipakai</label>
                                    </div>
                                </div>
                                <div class="col-5 mb-3">
                                    <div class="input-group date">
                                        <input type="hidden" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}"/>
                                    </div>
                                    @error('date')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

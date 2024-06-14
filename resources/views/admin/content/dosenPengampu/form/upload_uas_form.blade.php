@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data uas </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('dosen_matkul') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('upload_soal_uas.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id_rep_uas" name="id_rep_uas"
                                    value="{{ $nextNumber }}"readonly>
                                <input type="hidden" class="form-control" id="id_matkul" name="id_matkul"
                                    value="{{ $id_matkul_kbk }}"readonly>
                                <input type="hidden" class="form-control" id="id_dosen" name="id_dosen"
                                    value="{{ $id_dosen_matkul }}"readonly>
                                <input type="hidden" class="form-control" id="id_smt_thnakd" name="id_smt_thnakd"
                                    value="{{ $id_smt_thnakd }}"readonly>
                                <input type="hidden" class="form-control" id="type" name="type"
                                    value="1"readonly>
                                <div class="mb-3">
                                    <label for="upload_file" class="form-label">Upload File UAS</label>
                                    <input type="file" class="form-control" id="upload_file" name="upload_file">
                                    @error('upload_file')
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
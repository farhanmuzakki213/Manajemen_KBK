@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Data uas</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2">
                                    <p><a href="{{ route('dosen_matkul') }}" class="btn btn-success">Kembali</a></p>
                                </div>
                            </div>
                            <form method="post"
                                action="{{ route('upload_soal_uas.update', ['id' => $data_uas->id_rep_rps_uas]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" class="form-control" id="id_rep_uas" name="id_rep_uas"
                                    value="{{ $data_uas->id_rep_rps_uas }}"readonly>
                                <input type="hidden" class="form-control" id="id_matkul" name="id_matkul"
                                    value="{{ $data_uas->matkul_kbk_id }}"readonly>
                                <input type="hidden" class="form-control" id="id_dosen" name="id_dosen"
                                    value="{{ $data_uas->dosen_matkul_id }}"readonly>
                                <input type="hidden" class="form-control" id="id_smt_thnakd" name="id_smt_thnakd"
                                    value="{{ $data_uas->smt_thnakd_id }}"readonly>
                                <div class="mb-3">                                    
                                    <label for="upload_file" class="form-label">Upload File RPS</label>
                                    <input type="file" class="form-control" id="upload_file" name="upload_file">
                                    @error('upload_file')
                                        <small class="text-danger">{{ $message }}</small>
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
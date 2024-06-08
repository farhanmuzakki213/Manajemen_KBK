@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Data RPS</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2">
                                    <p><a href="{{ route('dosen_matkul') }}" class="btn btn-success">Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('upload_rps.update', ['id' => $data_rps->id_rep_rps_uas]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" class="form-control" id="id_rep_rps" name="id_rep_rps"
                                    value="{{ $data_rps->id_rep_rps }}"readonly>
                                <input type="hidden" class="form-control" id="id_matkul" name="id_matkul"
                                    value="{{ $data_rps->matkul_kbk_id }}"readonly>
                                <input type="hidden" class="form-control" id="id_dosen" name="id_dosen"
                                    value="{{ $data_rps->dosen_id }}"readonly>
                                <input type="hidden" class="form-control" id="id_smt_thnakd" name="id_smt_thnakd"
                                    value="{{ $data_rps->smt_thnakd_id }}"readonly>
                                {{-- <div class="mb-3">
                                    <label for="id_rep_rps" class="form-label">ID Repositori RPS</label>
                                    <input type="text" class="form-control" id="id_rep_rps" name="id_rep_rps" value="{{ $data_rps->id_rep_rps }}" readonly>
                                    @error('id_rep_rps')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                    <select class="form-select" name="nama_matkul" id="nama_matkul" required>
                                        <option selected disabled>Pilih Nama Mata Kuliah</option>
                                        @foreach ($data_matkul as $matkul)                                            
                                            <option value="{{ $matkul->id_matkul }}" {{ $matkul->id_matkul == $data_rps->matkul_id ? 'selected' : '' }}>
                                                {{ $matkul->nama_matkul }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_matkul')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" name="nama_dosen" id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            <option value="{{ $dosen->id_dosen }}" {{ $dosen->id_dosen == $data_rps->dosen_id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="smt_thnakd" class="form-label">Semester Tahun Akademik</label>
                                    @foreach ($data_thnakd as $smt_thnakd)
                                    <input type="hidden" class="form-control" id="id_smt_thnakd" name="id_smt_thnakd"
                                            value="{{ $smt_thnakd->id_smt_thnakd }}" readonly>
                                        <input type="text" class="form-control" id="smt_thnakd" name="smt_thnakd"
                                            value="{{ $smt_thnakd->smt_thnakd }}" readonly>
                                    @endforeach
                                    @error('smt_thnakd')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div> --}}
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
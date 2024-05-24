@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Verifikasi RPS </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_rps') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('ver_rps.store') }}"  enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    {{-- <label for="id_ver_rps" class="form-label">ID Verifikasi RPS</label> --}}
                                    <input type="hidden" class="form-control" id="id_ver_rps" name="id_ver_rps" value="{{ 'VRPS' . $nextNumber }}" readonly>
                                    @error('id_ver_rps')
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
                                    <select class="form-select" aria-label="Default select example" name="nama_matkul"
                                        id="nama_matkul" required>
                                        <option selected disabled>Pilih Nama Mata Kuliah</option>
                                        @foreach ($data_rep_rps as $rep_rps)
                                            <option value="{{ $rep_rps->id_matkul && $rep_rps->id_rep_rps}}">{{ $rep_rps->kode_matkul }} | {{ $rep_rps->nama_matkul }}</option>
                                        @endforeach
                                    </select>
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
                                        <input class="form-check-input" type="radio" name="status" id="aktif"
                                            value="1">
                                        <label class="form-check-label" for="aktif">Diverifikasi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="tidak_aktif"
                                            value="0">
                                        <label class="form-check-label" for="tidak_aktif">Tidak Diverifikasi</label>
                                    </div>
                                    @error('status')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                                    @error('catatan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- <label for="date" class=" col-form-label">Tanggal Verifikasi</label> --}}
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

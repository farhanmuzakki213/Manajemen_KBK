@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Data Dosen Pengampu Matkul</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('DosenPengampuMatkul') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('DosenPengampuMatkul.update',['id' => $data_dosen_pengampu->id_dosen_matkul]) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="id_dosen_matkul" class="form-label">ID Dosen Matkul</label>
                                    <input type="number" class="form-control" id="id_dosen_matkul" name="id_dosen_matkul" value="{{$data_dosen_pengampu->id_dosen_matkul}}">
                                    @error('id_dosen_matkul')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_dosen"
                                        id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            <option value="{{ $dosen->id_dosen }}"
                                                {{ $dosen->id_dosen == $data_dosen_pengampu->dosen_id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="thnakd" class="form-label">Tahun Akademik</label>
                                    <select class="form-select" aria-label="Default select example" name="thnakd"
                                        id="thnakd" required>
                                        <option selected disabled>Pilih Tahun Akademik</option>
                                        @foreach ($data_smt as $smt)
                                            <option value="{{ $smt->id_smt_thnakd }}"
                                                {{ $smt->id_smt_thnakd == $data_dosen_pengampu->smt_thnakd_id ? 'selected' : '' }}>
                                                {{ $smt->smt_thnakd }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('thnakd')
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

@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Pengurus KBK </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('pengurus_kbk') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('pengurus_kbk.store') }}">
                                @csrf
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
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kbk" class="form-label">Jenis KBK</label>
                                    <select class="form-select" aria-label="Default select example" name="jenis_kbk"
                                        id="jenis_kbk" required>
                                        <option selected disabled>Pilih Jenis KBK</option>
                                        @foreach ($data_jenis_kbk as $jenis_kbk)
                                            <option value="{{ $jenis_kbk->id_jenis_kbk }}">{{ $jenis_kbk->jenis_kbk }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kbk')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <select class="form-select" aria-label="Default select example" name="jabatan"
                                        id="jabatan" required>
                                        <option selected disabled>Pilih Jabatan</option>
                                        @foreach ($data_jabatan_kbk as $jabatan_kbk)
                                            <option value="{{ $jabatan_kbk->id_jabatan_kbk }}">{{ $jabatan_kbk->jabatan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_kbk')
                                        <small>{{ $message}}</small>
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
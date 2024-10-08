@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Dosen </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('dosen') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('dosen.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="id_dosen" class="form-label">ID Dosen</label>
                                    <input type="number" class="form-control" id="id_dosen" name="id_dosen">
                                    @error('id_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>                                    
                                    <input type="text" class="form-control" id="nama_dosen" name="nama_dosen">
                                    @error('nama_dosen')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nidn" class="form-label">NIDN</label>                                    
                                    <input type="text" class="form-control" id="nidn" name="nidn">
                                    @error('nidn')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nip" class="form-label">NIP</label>                                    
                                    <input type="text" class="form-control" id="nip" name="nip">
                                    @error('nip')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>                                    
                                    <input type="text" class="form-control" id="gender" name="gender">
                                    @error('gender')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <select class="form-select" aria-label="Default select example" name="jurusan"
                                        id="jurusan" required>
                                        <option selected disabled>Pilih Jurusan</option>
                                        @foreach ($data_jurusan as $jurusan)
                                            <option value="{{ $jurusan->id_jurusan }}">{{ $jurusan->jurusan }}</option>
                                        @endforeach
                                    </select>
                                    @error('jurusan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="prodi" class="form-label">Prodi</label>
                                    <select class="form-select" aria-label="Default select example" name="prodi"
                                        id="prodi" required>
                                        <option selected disabled>Pilih prodi</option>
                                        @foreach ($data_prodi as $prodi)
                                            <option value="{{ $prodi->id_prodi }}">{{ $prodi->prodi }}</option>
                                        @endforeach
                                    </select>
                                    @error('prodi')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>                                    
                                    <input type="text" class="form-control" id="email" name="email">
                                    @error('email')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>                                    
                                    <input type="text" class="form-control" id="password" name="password">
                                    @error('password')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>                                    
                                    <input type="text" class="form-control" id="image" name="image">
                                    @error('image')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status_dosen" class="form-label">Status Dosen</label>                                    
                                    <input type="text" class="form-control" id="status_dosen" name="status_dosen">
                                    @error('status_dosen')
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

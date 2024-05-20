@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Matkul KBK </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('matkul_kbk') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('matkul_kbk.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="id_matkul_kbk" class="form-label">ID Matkul KBK</label>
                                    <input type="number" class="form-control" id="id_matkul_kbk" name="id_matkul_kbk">
                                    @error('id_matkul_kbk')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_matkul" class="form-label">Nama matkul</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_matkul"
                                        id="nama_matkul" required>
                                        <option selected disabled>Pilih Nama matkul</option>
                                        @foreach ($data_matkul as $matkul)
                                            <option value="{{ $matkul->id_matkul }}">{{ $matkul->nama_matkul }}</option>
                                        @endforeach
                                    </select>
                                    @error('nama_matkul')
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
                                    <label for="kurikulum" class="form-label">Kurikulum</label>
                                    <select class="form-select" aria-label="Default select example" name="kurikulum"
                                        id="kurikulum">
                                        <option selected disabled>Pilih Kurikulum</option>
                                        @foreach ($data_kurikulum as $data)
                                            <option value="{{ $data->id_kurikulum }}">{{ $data->nama_kurikulum }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kurikulum')
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

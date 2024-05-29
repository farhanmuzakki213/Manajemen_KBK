@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Data Dosen KBK </h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('dosen_kbk') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('dosen_kbk.update',['id' => $data_dosen_kbk->id_dosen_kbk]) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="id_dosen_kbk" class="form-label">ID Dosen KBK</label>
                                    <input type="number" class="form-control" id="id_dosen_kbk" name="id_dosen_kbk" value="{{$data_dosen_kbk->id_dosen_kbk}}">
                                    @error('id_dosen_kbk')
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
                                                {{ $dosen->id_dosen == $data_dosen_kbk->dosen_id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kbk" class="form-label">Jenis KBK</label>
                                    <select class="form-select" aria-label="Default select example" name="jenis_kbk"
                                        id="jenis_kbk" required>
                                        <option selected disabled>Pilih Jenis KBK</option>
                                        @foreach ($data_jenis_kbk as $jenis_kbk)
                                            <option value="{{ $jenis_kbk->id_jenis_kbk }}"
                                                {{ $jenis_kbk->id_jenis_kbk == $data_dosen_kbk->jenis_kbk_id ? 'selected' : '' }}>
                                                {{ $jenis_kbk->jenis_kbk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kbk')
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

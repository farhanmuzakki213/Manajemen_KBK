@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Data Jenis KBK </h5>
                <div class="container-fluid">
                    <!-- Form edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('matkul') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('matkul.update',['id' => $data_matkul->id_matkul]) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="id_matkul" class="form-label">ID Matkul</label>
                                    <input type="number" class="form-control" id="id_matkul" name="id_matkul" value="{{$data_matkul->id_matkul}}">
                                    @error('id_matkul')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="kode_matkul" class="form-label">Kode MataKuliah</label>
                                    <input type="text" class="form-control" id="kode_matkul" name="kode_matkul" value="{{$data_matkul->kode_matkul}}">
                                    @error('kode_matkul')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_matkul" class="form-label">Nama MataKuliah</label>
                                    <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" value="{{$data_matkul->nama_matkul}}">
                                    @error('nama_matkul')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="tp" class="form-label">TP (Teori / Praktek)</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tp" id="gridRadios1"
                                            value="T" {{ $data_matkul->TP == 'T' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios1">
                                            T
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tp" id="gridRadios2"
                                            value="P" {{ $data_matkul->TP == 'P' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios2">
                                            P
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="tp" id="gridRadios3"
                                            value="T/P" {{ $data_matkul->TP == 'T/P' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="gridRadios3">
                                            T/P
                                        </label>
                                    </div>
                                    @error('tp')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jam" class="form-label">Jam</label>
                                    <input type="number" class="form-control" id="jam" name="jam" value="{{$data_matkul->jam}}">
                                    @error('jam')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="sks" class="form-label">SKS</label>
                                    <input type="number" class="form-control" id="sks" name="sks" value="{{$data_matkul->sks}}">
                                    @error('sks')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="sks_teori" class="form-label">SKS Teori</label>
                                    <input type="number" class="form-control" id="sks_teori" name="sks_teori" value="{{$data_matkul->sks_teori}}">
                                    @error('sks_teori')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="sks_praktek" class="form-label">SKS Praktek</label>
                                    <input type="number" class="form-control" id="sks_praktek" name="sks_praktek" value="{{$data_matkul->sks_praktek}}">
                                    @error('sks_praktek')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jam_teori" class="form-label">Jam Teori</label>
                                    <input type="number" class="form-control" id="jam_teori" name="jam_teori" value="{{$data_matkul->jam_teori}}">
                                    @error('jam_teori')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jam_praktek" class="form-label">Jam Praktek</label>
                                    <input type="number" class="form-control" id="jam_praktek" name="jam_praktek" value="{{$data_matkul->jam_praktek}}">
                                    @error('jam_praktek')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="semester" class="form-label">Semester</label>
                                    <input type="number" class="form-control" id="semester" name="semester" value="{{$data_matkul->semester}}">
                                    @error('semester')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>                                
                                <div class="mb-3">
                                    <label for="kurikulum" class="form-label">Kurikulum</label>
                                    <select class="form-select" aria-label="Default select example" name="kurikulum"
                                        id="kurikulum">
                                        <option selected disabled>Pilih Kurikulum</option>
                                        @foreach ($data_kurikulum as $data)
                                            <option value="{{ $data->id_kurikulum }}"
                                                {{ $data->id_kurikulum == $data_matkul->kurikulum_id ? 'selected' : ''}}>
                                                {{ $data->nama_kurikulum }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kurikulum')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="smt_thnakd" class="form-label">Semester Tahun Akademi</label>
                                    <select class="form-select" aria-label="Default select example" name="smt_thnakd"
                                        id="smt_thnakd">
                                        <option selected disabled>Pilih Semester Tahun Akademi</option>
                                        @foreach ($data_smt_thnakd as $data)
                                            <option value="{{ $data->id_smt_thnakd }}"
                                                {{ $data->id_smt_thnakd == $data_matkul->smt_thnakd_id ? 'selected' : ''}}>
                                                {{ $data->smt_thnakd }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('smt_thnakd')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>                          --}}
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

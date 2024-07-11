@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Data Pengurus KBK </h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('pengurus_kbk') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('pengurus_kbk.update',['id' => $data_pengurus_kbk->id_pengurus]) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    @if ($errors->has('nama_dosen'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('nama_dosen') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    @if ($errors->has('jabatan'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('jabatan') }}
                                        </div>
                                    @endif
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="id_pengurus" class="form-label">ID Pengurus</label>
                                    <input type="number" class="form-control" id="id_pengurus" name="id_pengurus" value="{{$data_pengurus_kbk->id_pengurus}}">
                                    @error('id_pengurus')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div> --}}

                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="id_pengurus" name="id_pengurus" value="{{ $data_pengurus_kbk->id_pengurus }}" readonly>
                                    @error('id_pengurus')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_dosen" id="nama_dosen" required>
                                        <option disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            @php
                                                $isDisabled = \App\Models\Pengurus_kbk::where('dosen_id', $dosen->id_dosen)->exists();
                                                $isSelected = ($dosen->id_dosen == $data_pengurus_kbk->dosen_id) ? 'selected' : '';
                                            @endphp
                                            @unless ($isDisabled && $dosen->id_dosen != $data_pengurus_kbk->dosen_id)
                                                <option value="{{ $dosen->id_dosen }}" {{ $isSelected }}>{{ $dosen->nama_dosen }}</option>
                                            @endunless
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <div class="alert alert-danger" role="alert">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_dosen"
                                        id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            <option value="{{ $dosen->id_dosen }}"
                                                {{ $dosen->id_dosen == $data_pengurus_kbk->dosen_id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div> --}}
                                <div class="mb-3">
                                    <label for="jenis_kbk" class="form-label">Jenis KBK</label>
                                    <select class="form-select" aria-label="Default select example" name="jenis_kbk"
                                        id="jenis_kbk" required>
                                        <option selected disabled>Pilih Jenis KBK</option>
                                        @foreach ($data_jenis_kbk as $jenis_kbk)
                                            <option value="{{ $jenis_kbk->id_jenis_kbk }}"
                                                {{ $jenis_kbk->id_jenis_kbk == $data_pengurus_kbk->jenis_kbk_id ? 'selected' : '' }}>
                                                {{ $jenis_kbk->jenis_kbk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_kbk')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="jabatan" class="form-label">Jabatan</label>
                                    <select class="form-select" aria-label="Default select example" name="jabatan"
                                        id="jabatan" required>
                                        <option selected disabled>Pilih Jabatan</option>
                                        @foreach ($data_jabatan_kbk as $jabatan_kbk)
                                            <option value="{{ $jabatan_kbk->id_jabatan_kbk }}"
                                                {{ $jabatan_kbk->id_jabatan_kbk == $data_pengurus_kbk->jabatan_kbk_id ? 'selected' : '' }}>
                                                {{ $jabatan_kbk->jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jabatan_kbk')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="aktif" value="1" {{ $data_pengurus_kbk->status_pengurus_kbk == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">Aktif</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="tidak_aktif" value="0" {{ $data_pengurus_kbk->status_pengurus_kbk == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">Tidak Aktif</label>
                                    </div>
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

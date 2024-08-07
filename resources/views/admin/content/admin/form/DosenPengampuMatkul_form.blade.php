@extends('admin.admin_master')

@section('styles')
<link rel="stylesheet" href="{{ asset('backend/assets/css/multi-dropdown.css') }}" />
@endsection

@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Dosen Matkul </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('DosenPengampuMatkul') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('DosenPengampuMatkul.store') }}">
                                @csrf
                                <div class="mb-3">
                                    @if ($errors->has('nama_dosen'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('nama_dosen') }}
                                        </div>
                                    @endif
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="id_dosen_matkul" class="form-label">ID Dosen Matkul</label>
                                    <input type="number" class="form-control" id="id_dosen_matkul" name="id_dosen_matkul">
                                    @error('id_dosen_matkul')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div> --}}

                                <input type="hidden" class="form-control" id="id_dosen_matkul" name="id_dosen_matkul"
                                value="{{ $nextNumber }}"readonly>
                                
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_dosen" id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            @php
                                                $isDisabled = \App\Models\DosenPengampuMatkul::where('dosen_id', $dosen->id_dosen)->exists();
                                            @endphp
                                            @unless ($isDisabled)
                                                <option value="{{ $dosen->id_dosen }}">{{ $dosen->nama_dosen }}</option>
                                            @endunless
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- <div class="mb-3">
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
                                </div> --}}


                                <div class="mb-3">
                                    <label for="mata_kuliah_dosen[]" class="form-label">Mata Kuliah Dosen</label>
                                    <select name="mata_kuliah_dosen[]" id="mata_kuliah_dosen" class="form-control selectpicker" multiple data-live-search="true">
                                        <option value="" disabled selected>Pilih mata kuliah dosen</option>
                                        @foreach ($data_matkul_kbk as $matkulKbk)
                                            <option value="{{ $matkulKbk->id_matkul_kbk }}">{{ $matkulKbk->r_matkul->nama_matkul }}</option>
                                        @endforeach
                                    </select>
                                    @error('mata_kuliah_dosen[]')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                            
                                <div class="mb-3">
                                    <label for="kelas[]" class="form-label">Kelas</label>
                                    <select name="kelas[]" id="kelas" class="form-control selectpicker" multiple data-live-search="true">
                                        <option value="" disabled selected>Pilih Kelas</option>
                                        @foreach ($data_kelas as $kelas)
                                            <option value="{{ $kelas->id_kelas }}">{{ $kelas->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas[]')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                

                                <div class="mb-3">
                                    <label for="smt_thnakd" class="form-label">Tahun Akademik</label>
                                    <select class="form-select" aria-label="Default select example" name="smt_thnakd"
                                        id="smt_thnakd" required>
                                        <option selected disabled>Pilih Tahun Akademik</option>
                                        @foreach ($data_smt as $smt)
                                            <option value="{{ $smt->id_smt_thnakd }}">{{ $smt->smt_thnakd }}</option>
                                        @endforeach
                                    </select>
                                    @error('smt_thnakd')
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

@section('scripts')
    <script src="{{ asset('backend/assets/js/jquery3-1-1.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/multi-dropdown.js') }}"></script>
@endsection
@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Review Proposal TA</h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('penugasan_review_proposal_ta') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('penugasan_review_proposal_ta.store') }}"  enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="id_penugasan" class="form-label">ID Review Proposal TA</label>
                                    <input type="number" class="form-control" id="id_penugasan" name="id_penugasan">
                                    @error('id_penugasan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="mahasiswa_id" class="form-label">Mahasiswa</label>
                                    <select class="form-select" aria-label="Default select example" name="mahasiswa_id" id="mahasiswa_id" required>
                                        <option selected disabled>Pilih Mahasiswa</option>
                                        @foreach ($data_mahasiswa as $mahasiswa)
                                            <option value="{{ $mahasiswa->id_mahasiswa }}">{{ $mahasiswa->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('mahasiswa_id')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Pilih Dosen</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_dosen" id="nama_dosen" required>
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
                                    <label for="status" class="form-label">Status</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="aktif"
                                            value="0">
                                        <label class="form-check-label" for="aktif">Diajukan</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="tidak_aktif"
                                            value="1">
                                        <label class="form-check-label" for="tidak_aktif">Ditolak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="tidak_aktif"
                                            value="2">
                                        <label class="form-check-label" for="tidak_aktif">Direvisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="tidak_aktif"
                                            value="3">
                                        <label class="form-check-label" for="tidak_aktif">Diterima</label>
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
                                <div class="col-5 mb-3">
                                    <label for="tanggal_penugasan" class="form-label">Tanggal Penugasan</label>
                                    <div class="input-group date">
                                        <input type="date" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}"/>
                                    </div>
                                    @error('date')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-5 mb-3">
                                    <label for="tanggal_review" class="form-label">Tanggal Review</label>
                                    <div class="input-group date">
                                        <input type="date" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}"/>
                                    </div>
                                    @error('date')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                
                              
                                {{-- <div class="mb-3">
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
                                </div> --}}
                                {{-- <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                                    @error('catatan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <label for="date" class=" col-form-label">Tanggal Verifikasi</label>
                                <div class="col-5 mb-3">
                                    <div class="input-group date">
                                        <input type="date" class="form-control" id="date" name="date" />
                                    </div>
                                    @error('date')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div> --}}
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

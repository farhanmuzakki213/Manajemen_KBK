@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Form Review Proposal TA </h5>
                <div class="container-fluid">
                    <!-- Form Review Proposal TA -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('review_proposal_ta') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('review_proposal_ta.update', ['id' => $data_review_proposal_ta->id_penugasan]) }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="id_review_proposal_ta" class="form-label">ID Review Proposal TA</label>
                                    <input type="number" class="form-control" id="id_review_proposal_ta" name="id_review_proposal_ta">
                                    @error('id_review_proposal_ta')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>                                                                                              
                                <div class="mb-3">
                                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_mahasiswa" id="nama_mahasiswa" required>
                                        <option selected disabled>Pilih Nama Mahasiswa</option>
                                        @foreach ($data_mahasiswa as $mahasiswa)
                                            <option value="{{ $mahasiswa->id_mahasiswa }}"
                                                {{ $mahasiswa->id_mahasiswa == $data_proposal_ta->mahasiswa_id ? 'selected' : '' }}>
                                                {{ $mahasiswa->nama_mahasiswa }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_mahasiswa')
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
                                                {{ $dosen->id_dosen == $data_review_proposal_ta->dosen_id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                {{-- <div class="mb-3">
                                    <label for="smt_thnakd" class="form-label">Semerter Tahun Akademik</label>
                                    <select class="form-select" aria-label="Default select example" name="smt_thnakd"
                                        id="smt_thnakd">
                                        <option selected disabled>Pilih Semerter Tahun Akademik</option>
                                        @foreach ($data_smt_thnakd as $data)
                                            <option value="{{ $data->id_smt_thnakd }}">{{ $data->smt_thnakd }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('smt_thnakd')
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

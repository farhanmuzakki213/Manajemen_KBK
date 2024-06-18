@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Penugasan Proposal TA </h5>
                <div class="container-fluid">
                    <!-- Edit Penugasan Proposal TA -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('PenugasanReview') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('PenugasanReview.update', ['id' => $data_review_proposal_ta->id_penugasan]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    @if ($errors->has('reviewer_satu'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('reviewer_satu') }}
                                        </div>
                                    @endif
                                </div>
                                <input type="hidden" class="form-control" id="id_penugasan" name="id_penugasan" value="{{ $data_review_proposal_ta->id_penugasan }}">
                                <input type="hidden" class="form-control" id="proposal_ta_id" name="proposal_ta_id" value="{{ $data_review_proposal_ta->proposal_ta_id }}">
                                <div class="mb-3">
                                    <label for="nama_mahasiswa" class="form-label">Nama Mahasiswa</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_mahasiswa" id="nama_mahasiswa" disabled>
                                        <option selected disabled>Pilih NIM | Nama Mahasiswa</option>
                                        @foreach ($mahasiswa as $mahasiswa)
                                            <option value="{{$mahasiswa->proposal_ta->id_proposal_ta}}"
                                                {{ $mahasiswa->proposal_ta->id_proposal_ta == $data_review_proposal_ta->proposal_ta_id ? 'selected' : '' }}>
                                                {{ $mahasiswa->proposal_ta->r_mahasiswa->nim }} | {{ $mahasiswa->proposal_ta->r_mahasiswa->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_mahasiswa')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="reviewer_satu" class="form-label">Nama Reviewer 1</label>
                                    <select class="form-select" aria-label="Default select example" name="reviewer_satu"
                                        id="reviewer_satu" required>
                                        <option selected disabled>Pilih Nama Reviewer 1</option>
                                        @foreach ($data_dosen_kbk as $dosen_kbk)
                                            <option value="{{ $dosen_kbk->id_dosen_kbk }}"
                                                {{ $dosen_kbk->id_dosen_kbk == $data_review_proposal_ta->reviewer_satu ? 'selected' : '' }}>
                                                {{ $dosen_kbk->r_dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('reviewer_satu')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="reviewer_dua" class="form-label">Nama Reviewer 2</label>
                                    <select class="form-select" aria-label="Default select example" name="reviewer_dua"
                                        id="reviewer_dua" required>
                                        <option selected disabled>Pilih Nama Reviewer 2</option>
                                        @foreach ($data_dosen_kbk as $dosen_kbk)
                                            <option value="{{ $dosen_kbk->id_dosen_kbk}}"
                                                {{ $dosen_kbk->id_dosen_kbk == $data_review_proposal_ta->reviewer_dua ? 'selected' : '' }}>
                                                {{ $dosen_kbk->r_dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('reviewer_dua')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    {{-- <label for="date" class="form-label">Tanggal Penugasan</label> --}}
                                    <input type="hidden" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()}}">
                                    @error('date')
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

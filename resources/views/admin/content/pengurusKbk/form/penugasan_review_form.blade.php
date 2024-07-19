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
                                    <p><a href="{{ route('PenugasanReview') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('PenugasanReview.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    @if ($errors->has('reviewer_satu'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('reviewer_satu') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    {{-- <label for="id_penugasan" class="form-label">ID Verifikasi RPS</label> --}}
                                    <input type="hidden" class="form-control" id="id_penugasan" name="id_penugasan"
                                        value="{{$nextNumber }}" readonly>
                                    @error('id_penugasan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <label for="proposal_ta_id" class="form-label">Nama Mahasiswa</label>
                                    <input type="text" class="form-control" id="proposal_ta_id" name="proposal_ta_id" value="{{ $selected_proposal_ta->r_mahasiswa->nim }} | {{ $selected_proposal_ta->r_mahasiswa->nama }}" readonly>
                                    <input type="hidden" name="proposal_ta_id" value="{{ $selected_proposal_ta->id_proposal_ta }}">
                                    <input type="hidden" name="pimpinan_prodi" value="{{ $data_pimpinan_prodi->id_pimpinan_prodi }}">
                                    <input type="hidden" name="pengurus_id" value="{{ $pengurus_kbk->id_pengurus }}">
                                    @error('proposal_ta_id')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                
                                
                                <div class="mb-3">
                                    <label for="reviewer_satu" class="form-label">Nama Reviewer 1 *</label>
                                    <select class="form-select" aria-label="Default select example" name="reviewer_satu" id="reviewer_satu" required>
                                        <option selected disabled>Pilih Nama Reviewer 1</option>
                                        @foreach ($data_dosen_kbk as $dosen_kbk)
                                            <option value="{{ $dosen_kbk->id_dosen_kbk }}" {{ old('reviewer_satu') == $dosen_kbk->id_dosen_kbk ? 'selected' : '' }}>
                                                {{ $dosen_kbk->r_dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('reviewer_satu')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                
                            
                                <div class="mb-3">
                                    <label for="reviewer_dua" class="form-label">Nama Reviewer 2 *</label>
                                    <select class="form-select" aria-label="Default select example" name="reviewer_dua" id="reviewer_dua" required>
                                        <option selected disabled>Pilih Nama Reviewer 2</option>
                                        @foreach ($data_dosen_kbk as $dosen_kbk)
                                            <option value="{{ $dosen_kbk->id_dosen_kbk }}">{{ $dosen_kbk->r_dosen->nama_dosen }}</option>
                                        @endforeach
                                    </select>
                                    @error('reviewer_dua')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>                               

                                <div class="mb-3">
                                    {{-- <label for="date" class="form-label">Tanggal Penugasan</label> --}}
                                    <input type="hidden" class="form-control" id="date" name="date"
                                        value="{{ \Carbon\Carbon::now()}}">
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

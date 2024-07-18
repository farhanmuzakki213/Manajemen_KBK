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
                            <form method="post" action="{{ route('review_proposal_ta.update', ['id' => $penugasan_id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" class="form-control" id="penugasan_id" name="penugasan_id" value="{{ $penugasan_id }}">
                                <input type="hidden" class="form-control" id="reviewer" name="reviewer" value="{{ $dosen_review }}">
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan *</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $data_dosen->catatan }}</textarea>
                                    @error('catatan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="aktif" value="1" {{ $data_dosen->status_review_proposal == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">DiTolak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="aktif" value="2" {{ $data_dosen->status_review_proposal == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">DiRevisi</label>
                                    </div> 
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="aktif" value="3" {{ $data_dosen->status_review_proposal == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">DiTerima</label>
                                    </div>                                   
                                </div>
                               
                                <div class="mb-3">
                                    {{-- <label for="date" class="form-label">Tanggal Review</label> --}}
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

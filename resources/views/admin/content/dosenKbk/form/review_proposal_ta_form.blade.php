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
                            <form method="post" action="{{ route('review_proposal_ta.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="penugasan_id" name="penugasan_id"
                                        value="{{ $penugasan_id }}" readonly>
                                    @error('penugasan_id')
                                        <small>{{ $message }}</small>
                                    @enderror
                                    @if (Session::has('error'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ Session::get('error') }}
                                        </div>
                                    @endif
                                </div>

                                @foreach ($reviewer_data as $data)
                                    @php
                                        $reviewer =
                                            $data->reviewer_role == 'reviewer_satu'
                                                ? 1
                                                : ($data->reviewer_role == 'reviewer_dua'
                                                    ? 2
                                                    : '');
                                    @endphp

                                    <input type="hidden" class="form-control" id="reviewer" name="reviewer"
                                        value="{{ $reviewer }}" readonly>
                                @endforeach
                               


                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status"
                                            id="belum_diverifikasi" value="1">
                                        <label class="form-check-label" for="aktif">DiTolak</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status"
                                            id="tidak_layak_pakai" value="2">
                                        <label class="form-check-label" for="tidak_aktif">DiRevisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="layak_pakai"
                                            value="3">
                                        <label class="form-check-label" for="tidak_aktif">DiTerima</label>
                                    </div>
                                    @error('status')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="catatan" class="form-label">Catatan (optional)</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
                                    @error('catatan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    {{-- <label for="date" class="form-label">Tanggal Penugasan</label> --}}
                                    <input type="hidden" class="form-control" id="date" name="date"
                                        value="{{ \Carbon\Carbon::now()->toDateString() }}">
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

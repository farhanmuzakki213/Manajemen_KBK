@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Data Verifikasi RPS </h5>
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_rps') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('ver_rps.update',['id' => $data_ver_rps->id_ver_rps_uas]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="id_ver_rps" name="id_ver_rps" value="{{ $data_ver_rps->id_ver_rps_uas }}" readonly>
                                    <input type="hidden" class="form-control" id="rep_rps_uas_id" name="rep_rps_uas_id" value="{{ $data_ver_rps->rep_rps_uas_id }}" readonly>
                                    @error('id_ver_rps')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="rekomendasi" class="form-label">Rekomendasi</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi"
                                            id="belum_diverifikasi" value="2" {{ $data_ver_rps->rekomendasi == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">Butuh Revisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi"
                                            id="tidak_layak_pakai" value="1" {{ $data_ver_rps->rekomendasi == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">Tidak layak Pakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi" id="layak_pakai"
                                            value="3" {{ $data_ver_rps->rekomendasi == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">layak Pakai</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="evaluasi" class="form-label">Evaluasi</label>
                                    <textarea class="form-control" id="evaluasi" name="evaluasi" rows="3">{{ $data_ver_rps->saran }}</textarea>
                                    @error('evaluasi')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-5 mb-3">
                                    <div class="input-group date">
                                        <input type="hidden" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()}}"/>
                                    </div>
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

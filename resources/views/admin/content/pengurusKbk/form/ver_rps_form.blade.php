@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Verifikasi RPS </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_rps') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('ver_rps.store') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id_ver_rps" name="id_ver_rps"
                                    value="{{ $nextNumber }}"readonly>
                                <input type="hidden" class="form-control" id="id_rep_rps" name="id_rep_rps"
                                    value="{{ $rep_id }}"readonly>
                                <input type="hidden" class="form-control" id="id_pengurus_kbk" name="id_pengurus_kbk"
                                    value="{{ $data_dosen }}"readonly>

                                    <div class="mb-3">
                                        <label for="evaluasi" class="form-label">Evaluasi *</label>
                                        <textarea class="form-control" id="evaluasi" name="evaluasi" rows="3">{{old('evaluasi')}}</textarea>
                                        @error('evaluasi')
                                            <small>{{ $message }}</small>
                                        @enderror
                                    </div>
                                <div class="mb-3">
                                    <label for="rekomendasi" class="form-label">Rekomendasi *</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi"
                                            id="belum_diverifikasi" value="2" {{ old('rekomendasi') == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">Butuh Revisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi"
                                            id="tidak_layak_pakai" value="1" {{ old('rekomendasi') == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">Tidak layak Pakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi" id="layak_pakai"
                                            value="3" {{ old('rekomendasi') == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">layak Pakai</label>
                                    </div>
                                    @error('rekomendasi')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                               
                                {{-- <label for="date" class=" col-form-label">Tanggal Verifikasi</label> --}}
                                <div class="col-5 mb-3">
                                    <div class="input-group date">
                                        <input type="hidden" class="form-control" id="date" name="date"
                                            value="{{ \Carbon\Carbon::now() }}" />
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

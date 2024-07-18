@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Edit Data Verifikasi UAS</h5>
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_soal_uas') }}" class="btn btn-success">Kembali</a></p>
                                </div>
                            </div>
                            <form method="post"
                                action="{{ route('ver_soal_uas.update', ['id' => $data_ver_soal_uas->id_ver_rps_uas]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="id_ver_uas" name="id_ver_uas"
                                        value="{{ $data_ver_soal_uas->id_ver_rps_uas }}" readonly>
                                    <input type="hidden" class="form-control" id="rep_rps_uas_id" name="rep_rps_uas_id"
                                        value="{{ $data_ver_soal_uas->rep_rps_uas_id }}" readonly>
                                    @error('id_ver_uas')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="evaluasi" class="form-label">Evaluasi *</label>
                                    <textarea class="form-control" id="evaluasi" name="evaluasi" rows="3">{{ old('evaluasi') ?? $data_ver_soal_uas->saran }}</textarea>
                                    @error('evaluasi')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="rekomendasi" class="form-label">Rekomendasi *</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi" id="butuh_revisi"
                                            value="2"
                                            {{ old('rekomendasi', $data_ver_soal_uas->rekomendasi) == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="butuh_revisi">Butuh Revisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi"
                                            id="tidak_layak_pakai" value="1"
                                            {{ old('rekomendasi', $data_ver_soal_uas->rekomendasi) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_layak_pakai">Tidak layak Pakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi" id="layak_pakai"
                                            value="3"
                                            {{ old('rekomendasi', $data_ver_soal_uas->rekomendasi) == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="layak_pakai">layak Pakai</label>
                                    </div>
                                    @error('rekomendasi')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="jumlah_soal">Jumlah Soal *</label>
                                    <input type="number" class="form-control" placeholder="Input Jumlah Soal Ujian"
                                        name="jumlah_soal" id="jumlah_soal"
                                        value="{{ old('jumlah_soal', $data_hasil->jumlah_soal) }}">
                                    @error('jumlah_soal')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div id="dynamic_content">
                                    @if (old('jumlah_soal', $data_hasil->jumlah_soal))
                                        <div class="row">
                                            <div
                                                class="col-md-6 d-flex justify-content-center align-items-center text-center">
                                                <label class="form-label">Validasi Isi *</label><br>
                                            </div>
                                            <div
                                                class="col-md-6 d-flex justify-content-center align-items-center text-center">
                                                <label class="form-label">Bahasa dan Penulisan Soal *</label><br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label class="form-label">Butir Soal</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Tidak Valid</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Kurang Valid</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Cukup Valid</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Valid</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Sangat Valid</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <label class="form-label">Butir Soal</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Tidak Baik</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Kurang Baik</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Cukup Baik</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Baik</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label class="form-label">Sangat Baik</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $validasi_isi = old(
                                                'validasi_isi_',
                                                $data_hasil->soal_data['validasi_isi'] ?? [],
                                            );
                                            $bahasa_soal = old(
                                                'bahasa_soal_',
                                                $data_hasil->soal_data['bahasa_soal'] ?? [],
                                            );
                                        @endphp

                                        @foreach (range(1, old('jumlah_soal', $data_hasil->jumlah_soal)) as $i)
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="validasi_isi_[{{ $i }}]"
                                                                class="form-label">{{ $i }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="validasi_isi_{{ $i }}_1"
                                                                name="validasi_isi_[{{ $i }}]" value="1"
                                                                {{ isset($validasi_isi[$i]) && $validasi_isi[$i] == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="validasi_isi_{{ $i }}_1">TV</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="validasi_isi_{{ $i }}_2"
                                                                name="validasi_isi_[{{ $i }}]" value="2"
                                                                {{ isset($validasi_isi[$i]) && $validasi_isi[$i] == 2 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="validasi_isi_{{ $i }}_2">KV</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="validasi_isi_{{ $i }}_3"
                                                                name="validasi_isi_[{{ $i }}]" value="3"
                                                                {{ isset($validasi_isi[$i]) && $validasi_isi[$i] == 3 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="validasi_isi_{{ $i }}_3">CV</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="validasi_isi_{{ $i }}_4"
                                                                name="validasi_isi_[{{ $i }}]" value="4"
                                                                {{ isset($validasi_isi[$i]) && $validasi_isi[$i] == 4 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="validasi_isi_{{ $i }}_4">V</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="validasi_isi_{{ $i }}_5"
                                                                name="validasi_isi_[{{ $i }}]" value="5"
                                                                {{ isset($validasi_isi[$i]) && $validasi_isi[$i] == 5 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="validasi_isi_{{ $i }}_5">SV</label>
                                                        </div>
                                                    </div>
                                                    @error("validasi_isi_[{{ $i }}]")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="bahasa_soal_[{{ $i }}]"
                                                                class="form-label">{{ $i }}</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="bahasa_soal_{{ $i }}_1"
                                                                name="bahasa_soal_[{{ $i }}]" value="1"
                                                                {{ isset($bahasa_soal[$i]) && $bahasa_soal[$i] == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="bahasa_soal_{{ $i }}_1">TB</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="bahasa_soal_{{ $i }}_2"
                                                                name="bahasa_soal_[{{ $i }}]" value="2"
                                                                {{ isset($bahasa_soal[$i]) && $bahasa_soal[$i] == 2 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="bahasa_soal_{{ $i }}_2">KB</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="bahasa_soal_{{ $i }}_3"
                                                                name="bahasa_soal_[{{ $i }}]" value="3"
                                                                {{ isset($bahasa_soal[$i]) && $bahasa_soal[$i] == 3 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="bahasa_soal_{{ $i }}_3">CB</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="bahasa_soal_{{ $i }}_4"
                                                                name="bahasa_soal_[{{ $i }}]" value="4"
                                                                {{ isset($bahasa_soal[$i]) && $bahasa_soal[$i] == 4 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="bahasa_soal_{{ $i }}_4">B</label>
                                                        </div>
                                                        <div class="form-check form-check-inline col-md-2"
                                                            style="margin-right: 0;">
                                                            <input class="form-check-input" type="radio"
                                                                id="bahasa_soal_{{ $i }}_5"
                                                                name="bahasa_soal_[{{ $i }}]" value="5"
                                                                {{ isset($bahasa_soal[$i]) && $bahasa_soal[$i] == 5 ? 'checked' : '' }}>
                                                            <label class="form-check-label"
                                                                for="bahasa_soal_{{ $i }}_5">SB</label>
                                                        </div>
                                                    </div>
                                                    @error("bahasa_soal_[{{ $i }}]")
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
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
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jumlahSoalInput = document.getElementById('jumlah_soal');
            const dynamicContent = document.getElementById('dynamic_content');
            const soalForm = document.getElementById('soalForm');
            const soalDataInput = document.getElementById('soal_data');

            jumlahSoalInput.addEventListener('change', function() {
                const jumlahSoal = parseInt(jumlahSoalInput.value);
                dynamicContent.innerHTML = ''; // Clear existing content

                // Insert static content
                dynamicContent.innerHTML += `
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-center align-items-center text-center">
                        <label class="form-label">Validasi Isi *</label><br>
                    </div>
                    <div class="col-md-6 d-flex justify-content-center align-items-center text-center">
                        <label class="form-label">Bahasa dan Penulisan Soal *</label><br>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Butir Soal</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tidak Valid</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Kurang Valid</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Cukup Valid</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Valid</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Sangat Valid</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-2">
                                <label class="form-label">Butir Soal</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Tidak Baik</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Kurang Baik</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Cukup Baik</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Baik</label>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Sangat Baik</label>
                            </div>
                        </div>
                    </div>
                </div>
            `;
                // Insert dynamic content
                for (let i = 1; i <= jumlahSoal; i++) {
                    dynamicContent.innerHTML += `
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="validasi_isi_[${i}]" class="form-label">${i}</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="validasi_isi_${i}_1" name="validasi_isi_[${i}]" value="1">
                                    <label class="form-check-label" for="validasi_isi_${i}_1">TV</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="validasi_isi_${i}_2" name="validasi_isi_[${i}]" value="2">
                                    <label class="form-check-label" for="validasi_isi_${i}_2">KV</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="validasi_isi_${i}_3" name="validasi_isi_[${i}]" value="3">
                                    <label class="form-check-label" for="validasi_isi_${i}_3">CV</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="validasi_isi_${i}_4" name="validasi_isi_[${i}]" value="4">
                                    <label class="form-check-label" for="validasi_isi_${i}_4">V</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="validasi_isi_${i}_5" name="validasi_isi_[${i}]" value="5">
                                    <label class="form-check-label" for="validasi_isi_${i}_5">SV</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-2">
                                    <label for="bahasa_soal_[${i}]" class="form-label">${i}</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="bahasa_soal_${i}_1" name="bahasa_soal_[${i}]" value="1">
                                    <label class="form-check-label" for="bahasa_soal_${i}_1">TB</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="bahasa_soal_${i}_2" name="bahasa_soal_[${i}]" value="2">
                                    <label class="form-check-label" for="bahasa_soal_${i}_2">KB</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="bahasa_soal_${i}_3" name="bahasa_soal_[${i}]" value="3">
                                    <label class="form-check-label" for="bahasa_soal_${i}_3">CB</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="bahasa_soal_${i}_4" name="bahasa_soal_[${i}]" value="4">
                                    <label class="form-check-label" for="bahasa_soal_${i}_4">B</label>
                                </div>
                                <div class="form-check form-check-inline col-md-2" style="margin-right: 0;">
                                    <input class="form-check-input" type="radio" id="bahasa_soal_${i}_5" name="bahasa_soal_[${i}]" value="5">
                                    <label class="form-check-label" for="bahasa_soal_${i}_5">SB</label>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                }
            });
        });
    </script>
@endsection

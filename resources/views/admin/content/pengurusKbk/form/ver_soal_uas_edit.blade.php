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
                            <form method="post" action="{{ route('ver_soal_uas.update', ['id' => $data_ver_soal_uas->id_ver_rps_uas]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="id_ver_uas" name="id_ver_uas" value="{{ $data_ver_soal_uas->id_ver_rps_uas }}" readonly>
                                    <input type="hidden" class="form-control" id="rep_rps_uas_id" name="rep_rps_uas_id" value="{{ $data_ver_soal_uas->rep_rps_uas_id }}" readonly>
                                    @error('id_ver_uas')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="rekomendasi" class="form-label">Rekomendasi</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi"
                                            id="belum_diverifikasi" value="2" {{ $data_ver_soal_uas->rekomendasi == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="aktif">Butuh Revisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi"
                                            id="tidak_layak_pakai" value="1" {{ $data_ver_soal_uas->rekomendasi == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">Tidak layak Pakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="rekomendasi" id="layak_pakai"
                                            value="3" {{ $data_ver_soal_uas->rekomendasi == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tidak_aktif">layak Pakai</label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="saran" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="saran" name="saran" rows="3">{{ $data_ver_soal_uas->saran }}</textarea>
                                    @error('saran')
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
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusDiverifikasi = document.getElementById('status_diverifikasi');
            const statusTidakDiverifikasi = document.getElementById('status_tidak_diverifikasi');
            const saranLayak = document.getElementById('saran_layak');
            const saranButuhRevisi = document.getElementById('saran_butuh_revisi');
            const saranTidakLayak = document.getElementById('saran_tidak_layak');
            const saranBelumDiverifikasi = document.getElementById('saran_belum_diverifikasi');
            const saranSection = document.getElementById('saran_section');
            const catatanSection = document.getElementById('catatan_section');
            const catatanElement = document.getElementById('catatan');
            const form = document.querySelector('form'); // Ensure the form variable is declared
    
            function updateSections() {
                if (statusDiverifikasi.checked) {
                    saranSection.style.display = 'block';
                    if (saranBelumDiverifikasi.checked) {
                        catatanElement.value = 'Soal uas belum diverifikasi';
                    } else {
                        catatanElement.value = '';
                    }
                    catatanSection.style.display = 'none';
                } else {
                    saranSection.style.display = 'none';
                    catatanSection.style.display = 'none';
                    saranBelumDiverifikasi.checked = true;
                    catatanElement.value = 'Soal uas belum diverifikasi';
                }
            }
    
            function updateCatatanSection() {
                if (saranButuhRevisi.checked) {
                    catatanSection.style.display = 'block';
                    catatanElement.value = '';
                } else {
                    catatanSection.style.display = 'none';
                    if (saranLayak.checked) {
                        catatanElement.value = 'soal uas layak dipakai';
                    } else if (saranTidakLayak.checked) {
                        catatanElement.value = 'soal uas tidak layak dipakai';
                    } else if (saranBelumDiverifikasi.checked) {
                        catatanElement.value = 'soal uas belum diverifikasi';
                    }
                }
            }
    
            statusDiverifikasi.addEventListener('change', updateSections);
            statusTidakDiverifikasi.addEventListener('change', updateSections);
            saranLayak.addEventListener('change', updateCatatanSection);
            saranButuhRevisi.addEventListener('change', updateCatatanSection);
            saranTidakLayak.addEventListener('change', updateCatatanSection);
    
            form.addEventListener('submit', function(event) {
                if (statusDiverifikasi.checked) {
                    if (!saranLayak.checked && !saranButuhRevisi.checked && !saranTidakLayak.checked) {
                        alert('Silakan pilih saran jika status diverifikasi dipilih.');
                        event.preventDefault();
                    }
                }
            });
    
            // Inisialisasi tampilan berdasarkan data awal
            updateSections();
            updateCatatanSection();
    
            window.alert = function(message) {
                const errorMessageDiv = document.getElementById('error-message');
                const errorDiv = document.createElement('div');
                errorDiv.classList.add('alert', 'alert-danger');
                errorDiv.setAttribute('role', 'alert');
                errorDiv.innerText = message;
                // Insert the error message div above the "Kembali" button
                errorMessageDiv.insertAdjacentElement('beforebegin', errorDiv);
                setTimeout(() => {
                    errorDiv.remove();
                }, 3000); // Remove error message after 3 seconds
            };
        });
    </script>
     --}}
    
@endsection

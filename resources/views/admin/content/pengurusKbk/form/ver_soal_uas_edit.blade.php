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
                            <form method="post" action="{{ route('ver_soal_uas.update', ['id' => $data_ver_soal_uas->id_ver_uas]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3" id="error-message">
                                    @if ($errors->has('saran'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('saran') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <input type="text" class="form-control" id="id_ver_uas" name="id_ver_uas" value="{{ $data_ver_soal_uas->id_ver_uas }}" readonly>
                                    @error('id_ver_uas')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" name="nama_dosen" id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            <option value="{{ $dosen->id_dosen }}" {{ $dosen->id_dosen == $data_ver_soal_uas->dosen_id ? 'selected' : '' }}>
                                                {{ $dosen->nama_dosen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nama_dosen')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_matkul" class="form-label">Nama Mata Kuliah</label>
                                    @foreach ($data_rep_soal_uas as $data)
                                        <input type="hidden" class="form-control" id="id_rep_uas" name="id_rep_uas" value="{{ $data->id_rep_uas }}" readonly>
                                        <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" value="{{ $data->kode_matkul }} | {{ $data->nama_matkul }}" readonly>
                                    @endforeach
                                    @error('nama_matkul')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="upload_file" class="form-label">Upload File Verifikasi</label>
                                    <input type="file" class="form-control" id="upload_file" name="upload_file">
                                    @error('upload_file')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_diverifikasi" value="1" {{ $data_ver_soal_uas->status_ver_uas == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_diverifikasi">Diverifikasi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_tidak_diverifikasi" value="0" {{ $data_ver_soal_uas->status_ver_uas == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status_tidak_diverifikasi">Tidak Diverifikasi</label>
                                    </div>
                                    @error('status')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" id="saran_section" style="{{ $data_ver_soal_uas->status_ver_uas == 1 ? 'display: block;' : 'display: none;' }}">
                                    <label for="saran" class="form-label">Saran</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_layak" value="3" {{ $data_ver_soal_uas->saran == 3 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="saran_layak">Layak Dipakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_butuh_revisi" value="2" {{ $data_ver_soal_uas->saran == 2 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="saran_butuh_revisi">Butuh Revisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_tidak_layak" value="1" {{ $data_ver_soal_uas->saran == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="saran_tidak_layak">Tidak Layak Dipakai</label>
                                    </div>
                                    <div class="form-check form-check-inline" hidden>
                                        <input class="form-check-input" type="radio" name="saran" id="saran_belum_diverifikasi" value="0" {{ $data_ver_soal_uas->saran == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="saran_belum_diverifikasi">Belum Diverifikasi</label>
                                    </div>
                                    @error('saran')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" id="catatan_section" style="{{ $data_ver_soal_uas->saran == 2 ? 'display: block;' : 'display: none;' }}">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3">{{ $data_ver_soal_uas->catatan }}</textarea>
                                    @error('catatan')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-5 mb-3">
                                    <div class="input-group date">
                                        <input type="hidden" class="form-control" id="date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}" />
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

    <script>
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
    
    
@endsection

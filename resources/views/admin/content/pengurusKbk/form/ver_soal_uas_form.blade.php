@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Verifikasi UAS </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('ver_soal_uas') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('ver_soal_uas.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    @if ($errors->has('saran'))
                                        <div class="alert alert-danger" role="alert">
                                            {{ $errors->first('saran') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" class="form-control" id="id_ver_uas" name="id_ver_uas" value="{{ $nextNumber }}" readonly>
                                    @error('id_ver_uas')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_dosen" class="form-label">Nama Dosen</label>
                                    <select class="form-select" aria-label="Default select example" name="nama_dosen" id="nama_dosen" required>
                                        <option selected disabled>Pilih Nama Dosen</option>
                                        @foreach ($data_dosen as $dosen)
                                            <option value="{{ $dosen->id_dosen }}">{{ $dosen->nama_dosen }}</option>
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
                                        <input class="form-check-input" type="radio" name="status" id="status_diverifikasi" value="1">
                                        <label class="form-check-label" for="status_diverifikasi">Diverifikasi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="status" id="status_tidak_diverifikasi" value="0">
                                        <label class="form-check-label" for="status_tidak_diverifikasi">Tidak Diverifikasi</label>
                                    </div>
                                    @error('status')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" id="saran_section" style="display: none;">
                                    <label for="saran" class="form-label">Saran</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_layak" value="3">
                                        <label class="form-check-label" for="saran_layak">Layak Dipakai</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_butuh_revisi" value="2">
                                        <label class="form-check-label" for="saran_butuh_revisi">Butuh Revisi</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="saran" id="saran_tidak_layak" value="1">
                                        <label class="form-check-label" for="saran_tidak_layak">Tidak Layak Dipakai</label>
                                    </div>
                                    <div class="form-check form-check-inline" hidden>
                                        <input class="form-check-input" type="radio" name="saran" id="saran_belum_diverifikasi" value="0">
                                        <label class="form-check-label" for="saran_belum_diverifikasi">Belum Diverifikasi</label>
                                    </div>
                                    @error('saran')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3" id="catatan_section" style="display: none;">
                                    <label for="catatan" class="form-label">Catatan</label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3"></textarea>
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
    const saranBelumDiverifikasi = document.getElementById('saran_belum_diverifikasi');
    const saranLayak = document.getElementById('saran_layak');
    const saranButuhRevisi = document.getElementById('saran_butuh_revisi');
    const saranTidakLayak = document.getElementById('saran_tidak_layak');
    const saranSection = document.getElementById('saran_section');
    const catatanSection = document.getElementById('catatan_section');
    const catatanElement = document.getElementById('catatan');


    function updateSections() {
    if (statusDiverifikasi.checked) {
        saranSection.style.display = 'block';
        // Reset saran radio buttons and catatan field
        saranBelumDiverifikasi.checked = false;
        saranLayak.checked = false;
        saranButuhRevisi.checked = false;
        saranTidakLayak.checked = false;
        catatanElement.value = '';
        catatanSection.style.display = 'none';
    } else if (statusTidakDiverifikasi.checked) {
        saranSection.style.display = 'none';
        catatanSection.style.display = 'none';
        catatanElement.value = 'Soal Belum Diverifikasi';
    } else {
        saranSection.style.display = 'none';
        catatanSection.style.display = 'none';
        catatanElement.value = 'Soal Belum Diverifikasi';
        // Jika tidak ada status yang dipilih, atur saran ke "Belum Diverifikasi"
        saranBelumDiverifikasi.checked = true;
    }
}

function updateCatatan() {
    if (saranBelumDiverifikasi.checked) {
        catatanSection.style.display = 'none';
        catatanElement.value = 'Soal Belum Diverifikasi';
    } else if (saranLayak.checked) {
        catatanSection.style.display = 'none';
        catatanElement.value = 'Soal Layak Pakai';
    } else if (saranButuhRevisi.checked) {
        catatanSection.style.display = 'block';
        catatanElement.value = '';
    } else if (saranTidakLayak.checked) {
        catatanSection.style.display = 'none';
        catatanElement.value = 'Soal tidak layak dipakai';
    }
}

    function validateForm(event) {
        if (statusDiverifikasi.checked) {
            if (!saranLayak.checked && !saranButuhRevisi.checked && !saranTidakLayak.checked) {
                alert('Silakan pilih saran jika status diverifikasi dipilih.');
                event.preventDefault();
            }
        }
    }

    statusDiverifikasi.addEventListener('change', updateSections);
    statusTidakDiverifikasi.addEventListener('change', updateSections);
    saranBelumDiverifikasi.addEventListener('change', updateCatatan);
    saranLayak.addEventListener('change', updateCatatan);
    saranButuhRevisi.addEventListener('change', updateCatatan);
    saranTidakLayak.addEventListener('change', updateCatatan);
    form.addEventListener('submit', validateForm);

    // Initialize sections based on default or pre-filled values
    updateSections();
});

    </script>
@endsection

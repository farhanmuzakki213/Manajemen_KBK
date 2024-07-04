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
                                <input type="hidden" class="form-control" id="id_ver_uas" name="id_ver_uas"
                                value="{{ $nextNumber }}"readonly>
                            <input type="hidden" class="form-control" id="id_rep_uas" name="id_rep_uas"
                                value="{{ $rep_id }}"readonly>
                            <input type="hidden" class="form-control" id="id_pengurus_kbk" name="id_pengurus_kbk"
                                value="{{ $data_dosen }}"readonly>
                            <div class="mb-3">
                                <label for="rekomendasi" class="form-label">Rekomendasi</label><br>
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
                            <div class="mb-3">
                                <label for="evaluasi" class="form-label">Evaluasi</label>
                                <textarea class="form-control" id="evaluasi" name="evaluasi" rows="3">{{old('evaluasi')}}</textarea>
                                @error('evaluasi')
                                    <small>{{ $message }}</small>
                                @enderror
                            </div>
                            {{-- <label for="date" class=" col-form-label">Tanggal Verifikasi</label> --}}
                            <div class="col-5 mb-3">
                                <div class="input-group date">
                                    <input type="hidden" class="form-control" id="date" name="date"
                                        value="{{ \Carbon\Carbon::now()}}" />
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
    </div>{{-- 

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

    </script> --}}
@endsection

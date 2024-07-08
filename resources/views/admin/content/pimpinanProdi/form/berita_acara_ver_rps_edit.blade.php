@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Upload Berita Acara</h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('berita_ver_rps') }}" class="btn btn-success"> Kembali</a>
                                    </p>
                                </div>
                            </div>
                            <form method="post"
                                action="{{ route('berita_ver_rps.update', ['id' => $beritaAcara->id_berita_acara]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" class="form-control" id="id_berita_acara" name="id_berita_acara"
                                    value="{{ $beritaAcara->id_berita_acara }}" readonly>
                                    <input type="hidden" class="form-control" id="Status_dari_kaprodi" name="Status_dari_kaprodi"
                                    value="3" readonly>
                                <div class="mb-3">
                                    <label for="file_berita_acara" class="form-label">Upload File Berita Acara RPS</label>
                                    <input type="file" class="form-control" id="file_berita_acara"
                                        name="file_berita_acara">
                                    <small>Pastikan upload file berita acara yang sudah anda beri tanda tangan</small>
                                    @error('file_berita_acara')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col-5 mb-3">
                                    <div class="input-group tanggal_disetujui_kaprodi">
                                        <input type="hidden" class="form-control" id="tanggal_disetujui_kaprodi" name="tanggal_disetujui_kaprodi"
                                            value="{{ \Carbon\Carbon::now() }}" required />
                                    </div>
                                    @error('tanggal_disetujui_kaprodi')
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

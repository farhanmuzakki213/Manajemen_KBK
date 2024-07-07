@extends('admin.admin_master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/multi-dropdown.css') }}" />
@endsection

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
                                    <p><a href="{{ route('upload_uas_berita_acara') }}" class="btn btn-success"> Kembali</a>
                                    </p>
                                </div>
                            </div>
                            <form method="post"
                                action="{{ route('upload_uas_berita_acara.update', ['beritaAcara' => $data_berita_acara->id_berita_acara]) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" class="form-control" id="id_berita_acara" name="id_berita_acara"
                                    value="{{ $data_berita_acara->id_berita_acara }}" readonly>
                                <div class="mb-3">
                                    <label for="file_berita_acara" class="form-label">Upload File Berita Acara Uas</label>
                                    <input type="file" class="form-control" id="file_berita_acara"
                                        name="file_berita_acara">
                                    @error('file_berita_acara')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                

                                <div class="col-5 mb-3">
                                    <div class="input-group tanggal_upload">
                                        <input type="hidden" class="form-control" id="tanggal_upload" name="tanggal_upload"
                                            value="{{ \Carbon\Carbon::now() }}" required />
                                    </div>
                                    @error('tanggal_upload')
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

@section('scripts')
    <script src="{{ asset('backend/assets/js/jquery3-1-1.js') }}"></script>
    <script src="{{ asset('backend/assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/multi-dropdown.js') }}"></script>
@endsection

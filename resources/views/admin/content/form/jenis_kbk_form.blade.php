@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Data Jenis KBK </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('jenis_kbk') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ route('jenis_kbk.store') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="jenis_kbk" class="form-label">Jenis KBK</label>                                    
                                    <input type="text" class="form-control" id="jenis_kbk" name="jenis_kbk">
                                    @error('jenis_kbk')
                                        <small>{{ $message}}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi</label>                                    
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
                                    @error('deskripsi')
                                        <small>{{ $message}}</small>
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
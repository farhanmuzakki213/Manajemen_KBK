@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Edit Role </h5>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ url('roles') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ url('roles/'.$role->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Role</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$role->name}}">
                                    @error('name')
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

@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Tambah Role </h5>
                <div class="container-fluid">
                    <!-- Form Tambah Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ url('users') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ url('users/'.$user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}">
                                    @error('name')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}" readonly>
                                    @error('email')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" name="password">
                                    @error('password')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="roles[]" class="form-label">Roles</label>
                                    <select name="roles[]" class="form-control" multiple>
                                        <option value="">Pilih Role</option>
                                        @foreach ($roles as $role)
                                            <option value="{{$role}}" {{in_array($role, $userRoles) ? 'selected':''}}>{{$role}}</option>
                                        @endforeach
                                    </select>
                                    @error('roles[]')
                                        <small>{{ $message }}</small>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

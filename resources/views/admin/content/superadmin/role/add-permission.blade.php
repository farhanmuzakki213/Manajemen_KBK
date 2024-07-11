@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                    <h5 class="card-title fw-semibold mb-4">Role : {{ $role->name }}
                        <a href="{{ url('roles') }}" class="btn btn-success float-end" style="width: 100px; font-size:80%; height: 30px; --bs-btn-padding-y: 4px;"> Kembali</a>
                    </h5>
                @if (Session::has('success'))
                    <div id="delay" class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('error'))
                    <div id="delay" class="alert alert-danger" role="alert">
                        {{ Session::get('error') }}
                    </div>
                @endif
                <script>
                    setTimeout(function() {
                        var element = document.getElementById('delay');
                        if (element) {
                            element.parentNode.removeChild(element);
                        }
                    }, 5000); // 5000 milliseconds = 5 detik
                </script>
                <div class="container-fluid">
                    <!-- Form Edit Data -->
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            
                            <form method="post" action="{{ url('roles/' . $role->id . '/give-permissions') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    @error('permission')
                                        <small>{{ $message }}</small>
                                    @enderror
                                    <label for="" class="fw-semibold">Permissions Admin</label>
                                    <div class="row mt-2">
                                        @foreach ($permissionsAdmin as $permission)
                                            <div class="col-lg-3">
                                                <label>
                                                    <input type="checkbox" class="ms-auto" name="permission[]"
                                                        value="{{ $permission->name_real }}" {{in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>  {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <label for="" class="mt-2 fw-semibold">Permissions Pengurus KBK</label>
                                    <div class="row mt-2">
                                        @foreach ($permissionsPengurusKbk as $permission)
                                            <div class="col-lg-3">
                                                <label>
                                                    <input type="checkbox" class="ms-auto" name="permission[]"
                                                        value="{{ $permission->name_real }}" {{in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>  {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <label for="" class="mt-2 fw-semibold">Permissions Dosen KBK</label>
                                    <div class="row mt-2">
                                        @foreach ($permissionsDosenKbk as $permission)
                                            <div class="col-lg-3">
                                                <label>
                                                    <input type="checkbox" class="ms-auto" name="permission[]"
                                                        value="{{ $permission->name_real }}" {{in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>  {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <label for="" class="mt-2 fw-semibold">Permissions Dosen Matkul</label>
                                    <div class="row mt-2">
                                        @foreach ($permissionsDosenMatkul as $permission)
                                            <div class="col-lg-3">
                                                <label>
                                                    <input type="checkbox" class="ms-auto" name="permission[]"
                                                        value="{{ $permission->name_real }}" {{in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>  {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <label for="" class="mt-2 fw-semibold">Permissions Pimpinan Prodi</label>
                                    <div class="row mt-2">
                                        @foreach ($permissionsPimpinanProdi as $permission)
                                            <div class="col-lg-3">
                                                <label>
                                                    <input type="checkbox" class="ms-auto" name="permission[]"
                                                        value="{{ $permission->name_real }}" {{in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>  {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <label for="" class="mt-2 fw-semibold">Permissions Pimpinan Jurusan</label>
                                    <div class="row mt-2">
                                        @foreach ($permissionsPimpinanJurusan as $permission)
                                            <div class="col-lg-3">
                                                <label>
                                                    <input type="checkbox" class="ms-auto" name="permission[]"
                                                        value="{{ $permission->name_real }}" {{in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>  {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

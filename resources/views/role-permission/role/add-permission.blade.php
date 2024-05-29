@extends('role-permission.master-role-permission')
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Role : {{ $role->name }} </h5>
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
                            <div class="row justify-content-end">
                                <div class="col-2-kembali">
                                    <p><a href="{{ url('roles') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <form method="post" action="{{ url('roles/' . $role->id . '/give-permissions') }}">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    @error('permission')
                                        <small>{{ $message }}</small>
                                    @enderror
                                    <label for="">Permissions</label>
                                    <div class="row mt-2">
                                        @foreach ($permissions as $permission)
                                            <div class="col-md-2">
                                                <label>
                                                    <input type="checkbox" class="ms-auto" name="permission[]"
                                                        value="{{ $permission->name }}" {{in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>  {{ $permission->name }}
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

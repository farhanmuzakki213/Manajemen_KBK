@extends('admin.admin_master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/profile.css') }}" />
    <style>
        .mb-n4 {
            margin-bottom: -3rem !important;
        }

        .img-fluid {
            max-width: 60%;
            height: auto;
        }

        
    .simplebar-content::-webkit-scrollbar {
        width: 12px;               /* lebar seluruh scrollbar */
    }

    .simplebar-content::-webkit-scrollbar-track {
        background: #fff;          /* warna area tracking */
    }

    .simplebar-content::-webkit-scrollbar-thumb {
        background-color: #000;    /* warna thumb scrollbar */
        border-radius: 20px;       /* kebulatan thumb scrollbar */
        border: 3px solid #fff;    /* border untuk memberi padding sekitar thumb */
    }

    </style>
@endsection
@section('admin')
    <div class="container-fluid">
        <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
                <div class="row align-items-center">
                    <div class="col-9">
                        <h4 class="fw-semibold mb-8">Account Setting</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a class="text-muted text-decoration-none" href="/">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Account Setting</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-5">
                            <img src="{{ asset('backend/assets/images/logos/e-kbk.svg') }}" alt="modernize-img"
                                class="img-fluid mb-n4">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane fade show active" role="tabpanel" tabindex="0">
                        <div class="row">
                            <div class="col-lg-6 d-flex align-items-stretch">
                                <div class="card w-100 border position-relative overflow-hidden">
                                    <div class="card-body p-4">
                                        <h4 class="card-title">Change Profile</h4>
                                        @if (session('gambar'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('gambar') }}
                                            </div>
                                        @endif
                                        @if (session('error'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('error') }}
                                            </div>
                                        @endif
                                        @if (session('reset'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('reset') }}
                                            </div>
                                        @endif
                                        @php
                                            $user = Auth::user();
                                            $image_user = App\Models\Dosen::where('nama_dosen', $user->name)
                                                ->where('email', $user->email)
                                                ->first();
                                            if ($user->name == 'Admin User' || $user->name == 'Super Admin') {
                                                $image = asset('profile_pictures/avatar-2.png');
                                            } else {
                                                if ($image_user->image) {
                                                    $image = asset('profile_pictures/' . $image_user->image);
                                                } else {
                                                    if ($image_user->gender == 'Laki-laki') {
                                                        $image = asset('profile_pictures/avatar-1.png');
                                                    } else {
                                                        $image = asset('profile_pictures/avatar-3.png');
                                                    }
                                                }
                                            }
                                        @endphp
                                        <div class="text-center mt-4">
                                            <form action="{{ route('profile.update') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')

                                                <!-- Display Current Profile Picture -->
                                                <img src="{{ $image }}" alt="Profile Picture"
                                                    class="img-fluid rounded-circle" width="120" height="120">

                                                <!-- Upload Button -->
                                                <div class="d-flex align-items-center justify-content-center my-4 gap-6">
                                                    <label class="btn btn-primary">
                                                        Upload
                                                        <input type="file" name="profile_picture" id="profile_picture"
                                                            class="d-none" onchange="this.form.submit()">
                                                    </label>
                                                    <button type="button" class="btn bg-danger-subtle text-danger"
                                                        id="reset-button">Hapus</button>
                                                </div>
                                                <small class="mb-0">Hanya JPEG, JPG, GIF or PNG. Maksimal 10MB</small>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-stretch">
                                <div class="card w-100 border position-relative overflow-hidden">
                                    <div class="card-body p-4">
                                        <h4 class="card-title mb-4">Ubah Password</h4>
                                        @if (session('password'))
                                            <div class="alert alert-success" role="alert">
                                                {{ session('password') }}
                                            </div>
                                        @endif
                                        <form id="password-update-form" action="{{ route('password.updatePassword') }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="current_password" class="form-label">Password Lama</label>
                                                <input type="password" class="form-control" id="current_password"
                                                    name="current_password" required>
                                                @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="new_password" class="form-label">Password Baru</label>
                                                <input type="password" class="form-control" id="new_password"
                                                    name="new_password" required>
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="new_password_confirmation" class="form-label">Password
                                                    Konfirmasi
                                                </label>
                                                <input type="password" class="form-control" id="new_password_confirmation"
                                                    name="new_password_confirmation" required>
                                                @error('new_password_confirmation')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <button type="submit" id="submit-update-password"
                                                class="btn btn-primary mt-3">Ubah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card w-100 border position-relative overflow-hidden mb-0">
                                    <div class="card-body p-4">
                                        <h4 class="card-title">Personal Details</h4>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext" class="form-label">Name</label>
                                                    <p class="form-control-static">{{ $user->name ?? 'Data Tidak Ada' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIDN</label>
                                                    <p class="form-control-static">
                                                        {{ $userDosen->nidn ?? 'Data Tidak Ada' }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">Jurusan</label>
                                                    <p class="form-control-static">
                                                        {{ $userDosen->r_jurusan->jurusan ?? 'Data Tidak Ada' }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">Jenis
                                                        Kelamin</label>
                                                    <p class="form-control-static">
                                                        {{ $userDosen->gender ?? 'Data Tidak Ada' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">Email</label>
                                                    <p class="form-control-static">{{ $user->email ?? 'Data Tidak Ada' }}
                                                    </p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">NIP</label>
                                                    <p class="form-control-static">
                                                        {{ $userDosen->nip ?? 'Data Tidak Ada' }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext3" class="form-label">Prodi</label>
                                                    <p class="form-control-static">
                                                        {{ $userDosen->r_prodi->prodi ?? 'Data Tidak Ada' }}</p>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputtext1" class="form-label">Status</label>
                                                    <p class="form-control-static">
                                                        {{ isset($userDosen->status) ? ($userDosen->status == 0 ? 'Aktif' : 'Tidak Aktif') : 'Data tidak ada' }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.getElementById('reset-button').addEventListener('click', function() {
            fetch('{{ route('profile.reset') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }).then(response => {
                if (response.ok) {
                    location.reload();
                } else {
                    alert('Failed to reset profile picture');
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            // Form submit event listener
            var submit = document.getElementById('submit-update-password')
            document.getElementById('password-update-form').addEventListener(submit, function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Collect form data
                const formData = new FormData(this);

                // Send POST request using Fetch API
                fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            // Clear form inputs on success
                            document.getElementById('current_password').value = '';
                            document.getElementById('new_password').value = '';
                            document.getElementById('new_password_confirmation').value = '';

                            // Show success message
                            const successAlert =
                                `<div class="alert alert-success" role="alert">${data.message}</div>`;
                            document.getElementById('password-update-form').insertAdjacentHTML(
                                'beforebegin', successAlert);
                        } else if (data.status === 'error') {
                            // Display error messages
                            Object.keys(data.errors).forEach(key => {
                                const errorSpan = document.getElementById(key + '-error');
                                if (errorSpan) {
                                    errorSpan.textContent = data.errors[key][0];
                                }
                            });
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
@endsection

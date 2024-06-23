@extends('admin.admin_master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/profile.css') }}" />
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
                                    <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">Account Setting</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-3">
                        <div class="text-center mb-5">
                            <img src="{{asset('frontend/landing-page/assets/img/logo-putih1.svg')}}" alt="modernize-img"
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
                                        <p class="card-subtitle mb-4">Change your profile picture from here</p>
                                        <div class="text-center">
                                            <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}" alt="modernize-img"
                                                class="img-fluid rounded-circle" width="120" height="120">
                                            <div class="d-flex align-items-center justify-content-center my-4 gap-6">
                                                <button class="btn btn-primary">Upload</button>
                                                <button class="btn bg-danger-subtle text-danger">Reset</button>
                                            </div>
                                            <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 d-flex align-items-stretch">
                                <div class="card w-100 border position-relative overflow-hidden">
                                    <div class="card-body p-4">
                                        <h4 class="card-title">Change Password</h4>
                                        <p class="card-subtitle mb-4">To change your password please confirm here</p>
                                        <form>
                                            <div class="mb-3">
                                                <label for="exampleInputPassword1" class="form-label">Current
                                                    Password</label>
                                                <input type="password" class="form-control"
                                                    id="exampleInputPassword1" value="12345678910">
                                            </div>
                                            <div class="mb-3">
                                                <label for="exampleInputPassword2" class="form-label">New
                                                    Password</label>
                                                <input type="password" class="form-control"
                                                    id="exampleInputPassword2" value="12345678910">
                                            </div>
                                            <div>
                                                <label for="exampleInputPassword3" class="form-label">Confirm
                                                    Password</label>
                                                <input type="password" class="form-control"
                                                    id="exampleInputPassword3" value="12345678910">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card w-100 border position-relative overflow-hidden mb-0">
                                    <div class="card-body p-4">
                                        <h4 class="card-title">Personal Details</h4>
                                        <p class="card-subtitle mb-4">To change your personal detail , edit and save
                                            from here</p>
                                        <form>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext" class="form-label">Your
                                                            Name</label>
                                                        <input type="text" class="form-control"
                                                            id="exampleInputtext" placeholder="Mathew Anderson">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Location</label>
                                                        <select class="form-select"
                                                            aria-label="Default select example">
                                                            <option selected="">United Kingdom</option>
                                                            <option value="1">United States</option>
                                                            <option value="2">United Kingdom</option>
                                                            <option value="3">India</option>
                                                            <option value="3">Russia</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext1"
                                                            class="form-label">Email</label>
                                                        <input type="email" class="form-control"
                                                            id="exampleInputtext1" placeholder="info@modernize.com">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext2" class="form-label">Store
                                                            Name</label>
                                                        <input type="text" class="form-control"
                                                            id="exampleInputtext2" placeholder="Maxima Studio">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Currency</label>
                                                        <select class="form-select"
                                                            aria-label="Default select example">
                                                            <option selected="">India (INR)</option>
                                                            <option value="1">US Dollar ($)</option>
                                                            <option value="2">United Kingdom (Pound)</option>
                                                            <option value="3">India (INR)</option>
                                                            <option value="3">Russia (Ruble)</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="exampleInputtext3"
                                                            class="form-label">Phone</label>
                                                        <input type="text" class="form-control"
                                                            id="exampleInputtext3" placeholder="+91 12345 65478">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div>
                                                        <label for="exampleInputtext4"
                                                            class="form-label">Address</label>
                                                        <input type="text" class="form-control"
                                                            id="exampleInputtext4"
                                                            placeholder="814 Howard Street, 120065, India">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div
                                                        class="d-flex align-items-center justify-content-end mt-4 gap-6">
                                                        <button class="btn btn-primary">Save</button>
                                                        <button
                                                            class="btn bg-danger-subtle text-danger">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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
    
@endsection
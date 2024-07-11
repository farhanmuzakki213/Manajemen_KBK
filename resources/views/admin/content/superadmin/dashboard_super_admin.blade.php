@extends('admin.admin_master')
@section('admin')
    <div class="container-fluid">
        <div class="d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-7">
                        <div class="mb-3 mb-sm-0">
                            <h4 class="card-title fw-semibold">Log Activity</h4>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle text-nowrap mb-0" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr class="text-muted fw-semibold">
                                    <th scope="col">User</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Created at</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="border-top">
                                @foreach ($logs as $log)
                                <tr>
                                    <th>{{ $log->causer->name ?? 'anonim' }}</th>
                                    <th>{{ $log->description ?? 'null'}}</th>
                                    <th>{{ $log->created_at }}</th>
                                    <th><a href="#"
                                            class="badge fw-semibold py-1 w-85 bg-primary-subtle text-primary">Detail</a>
                                    </th>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

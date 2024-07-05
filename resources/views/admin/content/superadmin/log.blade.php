@extends('admin.admin_master')
@section('admin')
    
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Log Activity</h5>
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
                    <!-- Roles -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Event</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                            </tr>
                                        </thead>
                                        <tfoot>

                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>User</th>
                                                <th>Event</th>
                                                <th>Created at</th>
                                                <th>Updated at</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @foreach ($logs as $log)
                                                <tr class="table-Light">
                                                    <th>{{ $loop->iteration }}</th>
                                                    <th>{{ $log->causer->name }}</th>
                                                    <th>{{ $log->event }}</th>
                                                    <th>{{ $log->created_at }}</th>
                                                    <th>{{ $log->updated_at }}</th>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

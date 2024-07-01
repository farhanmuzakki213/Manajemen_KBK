@extends('admin.admin_master')
@section('styles')
    <style>
        .table-Light.selected {
            background-color: lightblue;
        }
    </style>
@endsection
@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data Jurusan</h5>
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
                <div class="container-fluid">
                    <!-- Data Jurusan -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <a href="{{ route('jurusan.show') }}"
                                class="btn btn-primary mb-2 d-flex align-items-center">
                                <i class="ti ti-upload"></i> Ambil Data API
                            </a>
                            <a href="delete-row" class="btn btn-danger mb-2 d-flex align-items-center">
                                <i class="bi bi-trash""></i> Hapus
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Kode Jurusan</th>
                                            <th>Jurusan</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr class="table-info">
                                            <th>#</th>
                                            <th>Kode Jurusan</th>
                                            <th>Jurusan</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>                                        
                                        @foreach ($data_jurusan as $data)
                                        <tr class="table-Light">
                                            <th>{{$data->id_jurusan}}</th>
                                            <th>{{$data->kode_jurusan}}</th>
                                            <th>{{$data->jurusan}}</th>
                                        </tr>
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
@section('scripts')
    <script>
        var table3 = $("#sing_row_del").DataTable();

        $("#sing_row_del tbody").on("click", "tr", function() {
            if ($(this).hasClass("selected")) {
                $(this).removeClass("selected");
            } else {
                table3.$("tr.selected").removeClass("selected");
                $(this).addClass("selected");
            }
        });

        $("#delete-row").click(function() {
            table3.row(".selected").remove().draw(false);
        });
    </script>
    <script>
        setTimeout(function() {
            var element = document.getElementById('delay');
            if (element) {
                element.parentNode.removeChild(element);
            }
        }, 5000); // 5000 milliseconds = 5 detik
    </script>
@endsection
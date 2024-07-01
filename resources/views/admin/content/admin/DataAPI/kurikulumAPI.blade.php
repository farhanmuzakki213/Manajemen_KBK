@extends('admin.admin_master')



@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data API Kurikulum</h5>
                <div class="container-fluid">
                    @if (isset($error))
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @else
                        @if (Session::has('error'))
                            <div {{-- id="delay" --}} class="alert alert-danger" role="alert">
                                {{ Session::get('error') }}
                            </div>
                        @endif
                        <!-- Data Kurikulum -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary mb-2 d-flex align-items-center"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="ti ti-refresh"></i>
                                    Sinkron</button>
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('kurikulum') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="sing_row_del" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Kode Kurikulum</th>
                                                <th>Nama Kurikulum</th>
                                                <th>Tahun</th>
                                                <th>Prodi</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Kode Kurikulum</th>
                                                <th>Nama Kurikulum</th>
                                                <th>Tahun</th>
                                                <th>Prodi</th>
                                                <th>Status</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">---------------------------// Data API \\---------------------------</td>
                                            </tr>
                                            @if (isset($differences_api) && !empty($differences_api))
                                                @foreach ($differences_api as $data)
                                                    <tr class="table-Light">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data['kode_kurikulum'] }}</td>
                                                        <td>{{ $data['nama_kurikulum'] }}</td>
                                                        <td>{{ $data['tahun'] }}</td>
                                                        <td>{{ $data['id_prodi'] }}</td>
                                                        <td>{{ $data['status'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Tidak Ada Pembaharuan
                                                        data.</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td colspan="6" class="text-center text-muted">---------------------------// Data Tabel Kurikulum DB \\---------------------------</td>
                                            </tr>
                                            @if (isset($differences_db) && !empty($differences_db))
                                                @foreach ($differences_db as $data)
                                                    <tr class="table-Light">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data['kode_kurikulum'] }}</td>
                                                        <td>{{ $data['nama_kurikulum'] }}</td>
                                                        <td>{{ $data['tahun'] }}</td>
                                                        <td>{{ $data['prodi_id'] }}</td>
                                                        <td>{{ $data['status_kurikulum'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">Tidak Ada Pembaharuan
                                                        data.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Konfirmasi Sinkron Data -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Sinkron Data</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('kurikulum.store') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Apakah kamu yakin ingin menyinkronkan data ini?</p>
                                            <input type="hidden" name="differences_api"
                                                value="{{ json_encode($differences_api) }}">
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="differences_db"
                                                value="{{ json_encode($differences_db) }}">
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Ya, Yakin</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
<script>
    setTimeout(function() {
        var element = document.getElementById('delay');
        if (element) {
            element.parentNode.removeChild(element);
        }
    }, 5000); // 5000 milliseconds = 5 detik
</script>
@endsection
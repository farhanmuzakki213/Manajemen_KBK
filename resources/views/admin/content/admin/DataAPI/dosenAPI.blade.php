@extends('admin.admin_master')



@section('admin')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <!-- Page Heading -->
                <h5 class="card-title fw-semibold mb-4">Data API Dosen</h5>
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
                        <script>
                            setTimeout(function() {
                                var element = document.getElementById('delay');
                                if (element) {
                                    element.parentNode.removeChild(element);
                                }
                            }, 5000); // 5000 milliseconds = 5 detik
                        </script>
                        <!-- Data Dosen -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                                <button type="button" class="btn btn-primary mb-2 d-flex align-items-center"
                                    data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="ti ti-upload"></i>
                                    Tambah</button>
                                <div class="col-2-kembali">
                                    <p><a href="{{ route('dosen') }}" class="btn btn-success"> Kembali</a></p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="sing_row_del" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Nidn</th>
                                                <th>Nip</th>
                                                <th>gender</th>
                                                <th>Jurusan</th>
                                                <th>prodi</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr class="table-info">
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Nidn</th>
                                                <th>Nip</th>
                                                <th>gender</th>
                                                <th>Jurusan</th>
                                                <th>prodi</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                            @if (isset($differences) && !empty($differences))
                                                @foreach ($differences as $data)
                                                    <tr class="table-Light">
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $data['nama'] }}</td>
                                                        <td>{{ $data['nidn'] }}</td>
                                                        <td>{{ $data['nip'] }}</td>
                                                        <td>{{ $data['gender'] }}</td>
                                                        <td>{{ $data['kode_jurusan'] }}</td>
                                                        <td>{{ $data['kode_prodi'] }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center text-muted">Tidak Ada Pembaharuan
                                                        data.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- Modal Konfirmasi Tambah Data -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                            tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Tambah Data</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('dosen.storeAPI') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <p>Apakah kamu yakin ingin menambahkan data ini?</p>
                                            <input type="hidden" name="differences"
                                                value="{{ json_encode($differences) }}">
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default"
                                                data-bs-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Ya, Tambah</button>
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

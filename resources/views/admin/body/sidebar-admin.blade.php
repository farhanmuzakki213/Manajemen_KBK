@section('styles')
    <link rel="stylesheet" href="{{ asset('backend/assets/css/side-drop.css') }}" />
@endsection


<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div>
        <div class="brand-logo d-flex align-items-center justify-content-between my-3 mb-0">
            <a class="text-nowrap logo-img ms-auto me-auto">
                <img class="centered-image" src="{{ asset('backend/assets/images/logos/Logo-E-KBK-Black.svg') }}" width="100" alt="" />
            </a>
            <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                <i class="ti ti-x fs-8"></i>
            </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
            <ul id="sidebarnav">
                @hasanyrole('superAdmin|admin|pimpinanJurusan|pimpinanProdi|dosenMatkul|pengurusKbk|dosenKbk')
                    <li class="nav-small-cap">
                        <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                        <span class="hide-menu">Home</span>
                    </li>
                    {{-- <li class="sidebar-item">
                        <a class="sidebar-link" href="# aria-expanded="false">
                            <span>
                                <i class="ti ti-layout-dashboard"></i>
                            </span>
                            <span class="hide-menu">Dashboard</span>
                        </a>
                    </li> --}}
                    @hasanyrole('superAdmin|admin|pimpinanJurusan|pimpinanProdi|dosenMatkul|pengurusKbk|dosenKbk')
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-layout-dashboard"></i>
                                </span>
                                <span class="hide-menu">Dashboard</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @hasrole('superAdmin')
                                    <li class="sidebar-item">
                                        <a href="{{ url('logs') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Super Admin</span>
                                        </a>
                                    </li>
                                @endhasrole
                                @hasrole('admin')
                                    @can('admin-dashboard')
                                        <li class="sidebar-item">
                                            <a href="{{ route('dashboard_admin') }}" class="sidebar-link dropdown-item-custom">
                                                <div class="round-16 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-circle"></i>
                                                </div>
                                                <span class="hide-menu">Admin</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endhasrole
                                @hasrole('pimpinanJurusan')
                                    @can('pimpinanJurusan-dashboard')
                                        @php
                                            // Mendapatkan nama route saat ini
                                            $currentRoute = Route::currentRouteName();

                                            // Memeriksa apakah route saat ini adalah dashboard_pimpinan
                                            $isActive = $currentRoute == 'dashboard_pimpinan';

                                            // Mendapatkan prodi_id dari query parameter
                                            $prodiId = request()->query('prodi_id');
                                        @endphp

                                        <li class="sidebar-item {{ $isActive && !$prodiId ? 'active' : '' }}">
                                            <a href="{{ route('dashboard_pimpinan') }}" class="sidebar-link dropdown-item-custom">
                                                <div class="round-16 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-circle"></i>
                                                </div>
                                                <span class="hide-menu">Pimpinan Jurusan</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endhasrole
                                @hasrole('pimpinanProdi')
                                    @can('pimpinanProdi-dashboard')
                                        <li class="sidebar-item dropdown-item-custom">
                                            <a href="{{ route('dashboard_kaprodi') }}" class="sidebar-link dropdown-item-custom">
                                                <div class="round-16 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-circle"></i>
                                                </div>
                                                <span class="hide-menu">Pimpinan Prodi</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endhasrole
                                @hasrole('dosenMatkul')
                                    @can('dosenMatkul-dashboard')
                                        <li class="sidebar-item dropdown-item-custom">
                                            <a href="{{ route('dashboard_pengampu') }}" class="sidebar-link dropdown-item-custom">
                                                <div class="round-16 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-circle"></i>
                                                </div>
                                                <span class="hide-menu">Dosen Pengampu</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endhasrole

                                @hasrole('pengurusKbk')
                                    @can('pengurusKbk-dashboard')
                                        <li class="sidebar-item dropdown-item-custom">
                                            <a href="{{ route('dashboard_pengurus') }}" class="sidebar-link dropdown-item-custom">
                                                <div class="round-16 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-circle"></i>
                                                </div>
                                                <span class="hide-menu">Pengurus KBK</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endhasrole

                                @hasrole('dosenKbk')
                                    @can('dosenKbk-dashboard')
                                        <li class="sidebar-item dropdown-item-custom">
                                            <a href="{{ route('dashboard_dosenKbk') }}" class="sidebar-link dropdown-item-custom">
                                                <div class="round-16 d-flex align-items-center justify-content-center">
                                                    <i class="ti ti-circle"></i>
                                                </div>
                                                <span class="hide-menu">Dosen KBK</span>
                                            </a>
                                        </li>
                                    @endcan
                                @endhasrole
                            </ul>
                        </li>
                    @endhasanyrole
                    @hasrole('superAdmin')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Super Admin</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('permissions') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-aperture"></i>
                                </span>
                                <span class="hide-menu">Permission</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('roles') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-aperture"></i>
                                </span>
                                <span class="hide-menu">Role</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link" href="{{ url('users') }}" aria-expanded="false">
                                <span>
                                    <i class="ti ti-aperture"></i>
                                </span>
                                <span class="hide-menu">User</span>
                            </a>
                        </li>
                    @endhasrole



                    @hasrole('admin')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Admin</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-briefcase"></i>
                                </span>
                                <span class="hide-menu">Data Perkuliahan</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('admin-view RepProposalTA')
                                    <li class="sidebar-item">
                                        <a href="{{ route('rep_proposal_ta') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Repositori Proposal TA</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view Dosen')
                                    <li class="sidebar-item">
                                        <a href="{{ route('dosen') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Dosen</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view Mahasiswa')
                                    <li class="sidebar-item">
                                        <a href="{{ route('mahasiswa') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Mahasiswa</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view Jurusan')
                                    <li class="sidebar-item">
                                        <a href="{{ route('jurusan') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Jurusan</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view Prodi')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('prodi') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Prodi</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view Matkul')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('matkul') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Mata Kuliah</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view ThnAkademik')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('thnakademik') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tahun Akademik</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view Kurikulum')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('kurikulum') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Kurikulum</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view PimpinanJurusan')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('pimpinanjurusan') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Pimpinan Jurusan</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view PimpinanProdi')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('pimpinanprodi') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Pimpinan Prodi</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-notebook"></i>
                                </span>
                                <span class="hide-menu">Input Data</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('admin-view DosenMatkul')
                                    <li class="sidebar-item">
                                        <a href="{{ route('DosenPengampuMatkul') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Pengampu Matkul</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view PengurusKbk')
                                    <li class="sidebar-item">
                                        <a href="{{ route('pengurus_kbk') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Pengurus KBK</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view DosenKbk')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('dosen_kbk') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Dosen KBK</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view MatkulKbk')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('matkul_kbk') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Mata Kuliah KBK</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('admin-view JenisKbk')
                                    <li class="sidebar-item dropdown-item-custom">
                                        <a href="{{ route('jenis_kbk') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Data KBK</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endhasrole


                    @hasrole('pimpinanJurusan')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Kepala Jurusan</span>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-books"></i>
                                </span>
                                <span class="hide-menu">Data RPS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pimpinanJurusan-view RepRPSJurusan')
                                    <li class="sidebar-item">
                                        <a href="{{ route('rep_rps_jurusan') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Repositori RPS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pimpinanJurusan-view BeritaAcaraRpsKajur')
                                    <li class="sidebar-item">
                                        <a href="{{ route('kajur_berita_ver_rps') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Berita Acara RPS</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pimpinanJurusan-view grafikRps')
                                    <li class="sidebar-item">
                                        <a href="{{ route('grafik_rps') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tabel & Grafik RPS</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">Data UAS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pimpinanJurusan-view RepSoalUASJurusan')
                                    <li class="sidebar-item">
                                        <a href="{{ route('rep_soal_uas_jurusan') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Repositori Soal UAS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pimpinanJurusan-view BeritaAcaraUasKajur')
                                    <li class="sidebar-item">
                                        <a href="{{ route('kajur_berita_ver_uas') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Berita Acara Soal UAS</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pimpinanJurusan-view grafikUas')
                                    <li class="sidebar-item">
                                        <a href="{{ route('grafik_uas') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tabel & Grafik UAS</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-school"></i>
                                </span>
                                <span class="hide-menu">Data TA</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pimpinanJurusan-view RepProposalTAJurusan')
                                    <li class="sidebar-item">
                                        <a href="{{ route('rep_proposal_ta_jurusan') }}"
                                            class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Repositori Proposal TA</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pimpinanJurusan-view grafikProposal')
                                    <li class="sidebar-item">
                                        <a href="{{ route('grafik_proposal') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tabel & Grafik Proposal TA</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endhasrole
                    @hasrole('pimpinanProdi')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Kepala Prodi</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-books"></i>
                                </span>
                                <span class="hide-menu">Data RPS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pimpinanProdi-view RepRpsProdi')
                                    <li class="sidebar-item">
                                        <a href="{{ route('rep_rps') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Repositori RPS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pimpinanProdi-view BeritaAcaraRpsProdi')
                                    <li class="sidebar-item">
                                        <a href="{{ route('berita_ver_rps') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Berita Acara RPS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pimpinanProdi-view grafikRps')
                                    <li class="sidebar-item">
                                        <a href="{{ route('grafik_rps_prodi') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tabel & Grafik RPS</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">Data UAS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pimpinanProdi-view RepUasProdi')
                                    <li class="sidebar-item">
                                        <a href="{{ route('rep_soal_uas') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Repositori Soal UAS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pimpinanProdi-view BeritaAcaraUasProdi')
                                    <li class="sidebar-item">
                                        <a href="{{ route('berita_ver_uas') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Berita Acara Soal UAS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pimpinanProdi-view grafikUas')
                                    <li class="sidebar-item">
                                        <a href="{{ route('grafik_uas_prodi') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tabel & Grafik UAS</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-school"></i>
                                </span>
                                <span class="hide-menu">Data TA</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pimpinanProdi-view ProposalTaFinal')
                                    <li class="sidebar-item">
                                        <a href="{{ route('hasil_review_proposal_ta') }}"
                                            class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Hasil Review Proposal TA</span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </li>
                    @endhasrole


                    @hasrole('pengurusKbk')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Pengurus KBK</span>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-books"></i>
                                </span>
                                <span class="hide-menu">Data RPS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pengurusKbk-view VerRps')
                                    <li class="sidebar-item">
                                        <a href="{{ route('ver_rps') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Verifikasi RPS</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pengurusKbk-view BeritaAcaraRps')
                                    <li class="sidebar-item">
                                        <a href="{{ route('upload_rps_berita_acara') }}"
                                            class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Berita Acara RPS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pengurusKbk-view GrafikRps')
                                    <li class="sidebar-item">
                                        <a href="{{ route('grafik_rps_pengurus') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tabel & Grafik RPS</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-file-description"></i>
                                </span>
                                <span class="hide-menu">Data UAS</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                <li class="sidebar-item">
                                    @can('pengurusKbk-view VerUas')
                                        <a href="{{ route('ver_soal_uas') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Verifikasi Soal UAS</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pengurusKbk-view BeritaAcaraUas')
                                    <li class="sidebar-item">
                                        <a href="{{ route('upload_uas_berita_acara') }}"
                                            class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Berita Acara Soal UAS</span>
                                        </a>
                                    </li>
                                @endcan

                                @can('pengurusKbk-view GrafikUas')
                                    <li class="sidebar-item">
                                        <a href="{{ route('grafik_uas_pengurus') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Tabel & Grafik UAS</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow" href="javascript:void(0)" aria-expanded="false">
                                <span class="d-flex">
                                    <i class="ti ti-school"></i>
                                </span>
                                <span class="hide-menu">Data TA</span>
                            </a>
                            <ul aria-expanded="false" class="collapse first-level">
                                @can('pengurusKbk-view PenugasanReview')
                                    <li class="sidebar-item">
                                        <a href="{{ route('PenugasanReview') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Penugasan Review</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('pengurusKbk-view PenugasanHasilReview')
                                    <li class="sidebar-item">
                                        <a href="{{ route('HasilReview') }}" class="sidebar-link dropdown-item-custom">
                                            <div class="round-16 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-circle"></i>
                                            </div>
                                            <span class="hide-menu">Hasil Review</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endhasrole

                    @hasrole('dosenMatkul')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Dosen Pengampu</span>
                        </li>
                        @can('dosenMatkul-view DosenMatkul')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('dosen_matkul') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-aperture"></i>
                                    </span>
                                    <span class="hide-menu">Dosen Mata Kuliah</span>
                                </a>
                            </li>
                        @endcan
                    @endhasrole
                    
                    @hasrole('dosenKbk')
                        <li class="nav-small-cap">
                            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                            <span class="hide-menu">Dosen KBK</span>
                        </li>
                        @can('dosenKbk-view ReviewProposalTA')
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="{{ route('review_proposal_ta') }}" aria-expanded="false">
                                    <span>
                                        <i class="ti ti-aperture"></i>
                                    </span>
                                    <span class="hide-menu">Review Proposal TA</span>
                                </a>
                            </li>
                        @endcan
                    @endhasrole
                @endhasanyrole
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
@section('scripts')
    <script src="{{ asset('backend/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/assets/js/side-drop.js') }}"></script>
@endsection

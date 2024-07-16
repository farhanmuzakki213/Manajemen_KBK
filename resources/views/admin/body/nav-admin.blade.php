<style>
    .simplebar-content::-webkit-scrollbar {
        width: 12px;
    }

    .simplebar-content::-webkit-scrollbar-track {
        background: #fff;
    }

    .simplebar-content::-webkit-scrollbar-thumb {
        background-color: #000;
        border-radius: 20px;
        border: 3px solid #fff;
    }
</style>


<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                    <i class="ti ti-menu-2"></i>
                </a>
            </li>

        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                @hasanyrole('dosenMatkul|dosenKbk')
                    <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                        </a>



                        <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up"
                            aria-labelledby="drop2" style="width: 360px;">
                            <div class="d-flex align-items-center justify-content-between py-3 px-7">
                                <h5 class="mb-0 fs-5 fw-semibold">Notifications</h5>
                                <span
                                    class="badge text-bg-primary rounded-4 px-3 py-1 lh-sm">{{ auth()->user()->unreadNotifications->count() }}</span>
                            </div>
                            @hasrole('dosenMatkul')
                                {{-- dosen matkul --}}
                                <div class="simplebar-content" style="padding: 0px; max-height: 300px; overflow-y: auto;">
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                        @if (isset($notification->data['id_ver_rps_uas']))
                                            @php
                                                $image_user = App\Models\Dosen::where(
                                                    'nama_dosen',
                                                    $notification->data['pengurus_kbk'],
                                                )->first();
                                                if ($image_user->image) {
                                                    $image = asset('profile_pictures/' . $image_user->image);
                                                } else {
                                                    if ($image_user->gender == 'Laki-laki') {
                                                        $image = asset('profile_pictures/avatar-1.png');
                                                    } else {
                                                        $image = asset('profile_pictures/avatar-3.png');
                                                    }
                                                }
                                            @endphp
                                            <a href="#" class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span class="me-3">
                                                    <img src="{{ $image }}" alt="user" class="rounded-circle"
                                                        width="48" height="48">
                                                </span>
                                                <div class="w-100">
                                                    <h6 class="mb-1 fw-semibold lh-base">
                                                        {{ $notification->data['pengurus_kbk'] }}</h6>
                                                    <p class="fs-2 d-block text-body-secondary"
                                                        style="max-width: 100%; overflow-wrap: break-word; word-break: break-word; white-space: normal;">
                                                        {{ ucwords($notification->data['rekomendasi']) }}<br>Mata Kuliah :
                                                        {{ $notification->data['matkul'] }}
                                                    </p>

                                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endhasrole
                            @hasrole('dosenKbk')
                                {{-- pengurus kbk --}}
                                <div class="simplebar-content" style="padding: 0px;">
                                    @foreach (auth()->user()->unreadNotifications as $notification)
                                        @if (isset($notification->data['id_penugasan']))
                                            @php
                                                $image_user = App\Models\Dosen::where(
                                                    'nama_dosen',
                                                    $notification->data['pengurus_kbk'],
                                                )->first();
                                                if ($image_user->image) {
                                                    $image = asset('profile_pictures/' . $image_user->image);
                                                } else {
                                                    if ($image_user->gender == 'Laki-laki') {
                                                        $image = asset('profile_pictures/avatar-1.png');
                                                    } else {
                                                        $image = asset('profile_pictures/avatar-3.png');
                                                    }
                                                }
                                            @endphp
                                            <a href="{{ url($notification->data['url']) }}"
                                                class="py-6 px-7 d-flex align-items-center dropdown-item">
                                                <span class="me-3">
                                                    <img src="{{ $image }}" alt="user" class="rounded-circle"
                                                        width="48" height="48">
                                                </span>
                                                <div class="w-100">
                                                    <h6 class="mb-1 fw-semibold lh-base">
                                                        {{ $notification->data['pengurus_kbk'] }}</h6>
                                                    <p class="fs-2 d-block text-body-secondary">
                                                        {{ $notification->data['pesan'] }}<br>Nama Mahasiswa :
                                                        {{ $notification->data['nama_mahasiswa'] }}</p>
                                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                                </div>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endhasrole
                            <div class="message-body" data-simplebar="init">
                                <div class="simplebar-wrapper" style="margin: 0px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: 0px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" tabindex="0"
                                                aria-label="scrollable content" style="height: auto; overflow: hidden;">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: 0px; height: 0px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="width: 0px; display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar"
                                        style="height: 0px; display: none; transform: translate3d(0px, 0px, 0px);"></div>
                                </div>
                            </div>
                            <div class="py-6 px-7 mb-1">
                                <button class="btn btn-outline-primary w-100">See All Notifications</button>
                            </div>
                        </div>
                    </li>
                @endhasanyrole
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
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ $image ?? asset('profile_pictures/avatar-1.png') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2"
                        style="width: 360px;">
                        <div class="message-body">
                            <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                                <img src="{{ $image ?? asset('profile_pictures/avatar-1.png') }}"
                                    class="rounded-circle" width="80" height="80" alt="modernize-img">
                                <div class="ms-3">
                                    <h5 class="mb-1 fs-3">{{ Auth::user()->name }}</h5>
                                    <span
                                        class="mb-1 d-block">{{ implode(', ', Auth::user()->roles->pluck('name')->toArray()) }}</span>
                                    <p class="mb-0 d-flex align-items-center gap-2">
                                        <i class="ti ti-mail fs-4"></i> {{ Auth::user()->email }}
                                    </p>
                                </div>
                            </div>
                            <a href="{{ route('profile.edit') }}"
                                class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                            {{-- <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">My Account</p>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-list-check fs-6"></i>
                                <p class="mb-0 fs-3">My Task</p>
                            </a> --}}
                            <a href="{{ route('admin.logout') }}"
                                class="btn btn-outline-primary mx-3 mt-2 mb-2 d-block">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new SimpleBar(document.querySelector('.message-body'));
        });
    </script>
</header>

<header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light">
        <ul class="navbar-nav">

        </ul>
        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                <li class="nav-item d-block d-xl-none">
                    <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                        <i class="ti ti-menu-2"></i>
                    </a>
                </li>
                <li class="nav-item nav-icon-hover-bg rounded-circle dropdown">
                    <a class="nav-link" href="javascript:void(0)" id="drop2" aria-expanded="false">
                        <i class="ti ti-bell-ringing"></i>
                        <div class="notification bg-primary rounded-circle"></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-header">
                            <a href="javascript:void(0)"
                                class="d-flex align-items-center gap-2 py-3 px-4 dropdown-item">
                                <div class="row">
                                    <div class="position-relative lg">
                                        gambar - nama
                                    </div>
                                    <div class="lg">pesan</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </li>
                <div class="">{{ Auth::user()->name }}</div>
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="{{ asset('backend/assets/images/profile/user-1.jpg') }}" alt="" width="35"
                            height="35" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                        <div class="message-body">
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-user fs-6"></i>
                                <p class="mb-0 fs-3">My Profile</p>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-mail fs-6"></i>
                                <p class="mb-0 fs-3">My Account</p>
                            </a>
                            <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                <i class="ti ti-list-check fs-6"></i>
                                <p class="mb-0 fs-3">My Task</p>
                            </a>
                            <a href="{{ route('admin.logout') }}"
                                class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownToggle = document.getElementById('drop2');
            const dropdownMenu = dropdownToggle.nextElementSibling;

            dropdownToggle.addEventListener('click', function() {
                dropdownMenu.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.classList.remove('show');
                }
            });
        });
    </script>
</header>

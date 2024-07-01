<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard-KBK</title>
    <link rel="shortcut icon" type="image/png" href="backend/assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('backend/assets/css/admin.css') }}" />
    <!-- Custom styles for this DataTable -->
    <link href="{{ asset('backend/assets/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @yield('styles')
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @include('admin.body.sidebar-admin')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            @include('admin.body.nav-admin')
            <!--  Header End -->
            <!--  Content Start -->
            @yield('admin')
            <!--  Content End -->
        </div>
    </div>
    <script src="{{ asset('backend/assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('backend/assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <!-- Page level plugins -->
    <script src="{{ asset('backend/assets/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/assets/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/assets/js/demo/datatables-demo.js') }}"></script>
    <script src="{{ asset('backend/assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('backend/assets/js/side-drop.js') }}"></script>
    @yield('scripts')
</body>

</html>

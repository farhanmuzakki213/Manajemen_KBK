<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Agency - Start Bootstrap Theme</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('frontend/landing-page/css/styles.css')}}" rel="stylesheet" />
        <link href="{{asset('frontend/landing-page/css/berita.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.css">
        <link rel="stylesheet" href="{{asset('frontend/landing-page/css/struktur.css')}}">
    </head>
    <body id="page-top">
        <!-- Navigation-->
        @include('frontend.body.nav')
        <!-- Masthead-->
        @include('frontend.body.header')
        <!-- Services-->
        <section class="content">
            @yield('landing_page')
            @yield('detail_berita')
        </section>
        <!-- Footer-->
        @include('frontend.body.footer')        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('frontend/landing-page/js/scripts.js')}}"></script>
        <script src="{{asset('frontend/landing-page/js/main.js')}}"></script>
    </body>
</html>

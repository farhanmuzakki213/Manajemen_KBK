<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>e-KBK</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="{{asset('frontend/landing-page/assets/img/logos/e-kbk_putih.svg')}}" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('frontend/landing-page/animate/animate.min.css')}}" rel="stylesheet" />
        <link href="{{asset('frontend/landing-page/css/styles.css')}}" rel="stylesheet" />
        <link href="{{asset('frontend/landing-page/css/berita.css')}}" rel="stylesheet" />
        <link href="{{asset('frontend/landing-page/css/data.css')}}" rel="stylesheet" />
        <link href="{{asset('frontend/landing-page/css/about.css')}}" rel="stylesheet" />
        <link href="{{asset('frontend/landing-page/css/detail.css')}}" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.css">
        <link rel="stylesheet" href="{{asset('frontend/landing-page/css/struktur.css')}}">
        {{-- @yield('styles') --}}
        {{-- <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet"> --}}
    </head>
    <body id="page-top">
        <!-- Navigation-->
        @include('frontend.body.nav')

        <!-- Masthead-->
        {{-- @include('frontend.body.header') --}}
        <!-- Services-->
        <section class="content">
            @yield('detail_berita')
            @yield('landing_page')
           
        </section>
        <!-- Footer-->
        @include('frontend.body.footer')        
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Core theme JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/8.4.7/swiper-bundle.min.js"></script>
        <!-- Core theme JS-->

        <script src="{{asset('frontend/landing-page/wow/wow.min.js')}}"></script>
        <script src="{{asset('frontend/landing-page/js/scripts.js')}}"></script>
        <script src="{{asset('frontend/landing-page/js/main.js')}}"></script>
        <script src="{{asset('frontend/landing-page/js/berita.js')}}"></script>
        <script>
            new WOW().init();
        </script>
    </body>
</html>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top"><img src="{{asset('frontend/landing-page/assets/img/logoti3-white.svg')}}"/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">

                <li class="nav-item"><a class="nav-link" href="#berita">Berita</a></li>
                <li class="nav-item"><a class="nav-link" href="#struktural">Struktural</a></li>
                
                {{-- <li class="nav-item"><a class="nav-link" href="#about">About</a></li> --}}
                <li class="nav-item"><a class="nav-link" href="#team">Team</a></li>
                {{-- <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li> --}}
                <li class="nav-item"><a class="nav-link" href="{{route('login')}}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{route('register')}}">register</a></li>
            </ul>
        </div>
    </div>
</nav>

@extends('frontend.landing_page')
@section('landing_page')
    <!-- Clients-->
    
    @include('frontend.section.prodi')

    @include('frontend.section.berita_kbk')
    <!-- Services-->
    @include('frontend.section.struktur_kbk')
    <!-- Portfolio Grid-->
   

    {{-- @include('frontend.section.detail_berita_kbk') --}}
    {{-- <!-- About-->
    @include('frontend.section.about') --}}
    <!-- Team-->
    @include('frontend.section.team')
    {{-- <!-- Contact-->
    @include('frontend.section.contact') --}}
@endsection

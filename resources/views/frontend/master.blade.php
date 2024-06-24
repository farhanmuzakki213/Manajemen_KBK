@extends('frontend.landing_page')
@section('landing_page')
    <!-- Clients-->
    
    @include('frontend.body.header')
    @include('frontend.section.prodi')

    @include('frontend.section.penjelasan_kbk')

    @include('frontend.section.berita_kbk')
    <!-- Services-->
    @include('frontend.section.struktur_kbk')
    @include('frontend.section.jenis_kbk')
    @include('frontend.section.data')
    <!-- Portfolio Grid-->
   

    {{-- @include('frontend.section.detail_berita_kbk') --}}
    {{-- <!-- About-->
    @include('frontend.section.about') --}}
    <!-- Team-->
    @include('frontend.section.team')
    {{-- <!-- Contact-->
    @include('frontend.section.contact') --}}
@endsection

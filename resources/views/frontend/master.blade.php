@extends('frontend.landing_page')
@section('landing_page')
    <!-- Services-->
    @include('frontend.section.services')
    <!-- Portfolio Grid-->
    @include('frontend.section.portfolio')
    <!-- About-->
    @include('frontend.section.about')
    <!-- Team-->
    @include('frontend.section.team')
    <!-- Clients-->
    @include('frontend.section.client')
    <!-- Contact-->
    @include('frontend.section.contact')
@endsection

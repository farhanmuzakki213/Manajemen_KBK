@extends('frontend.landing_page')

@section('title', $data_berita->judul)

@section('styles')
<style>
    /* .navbar-detail {
        background-color: #343a40 !important; 
    } */

    
</style>
@endsection

@section('content')
@section('detail_berita')
<div class="card mb-3 card-custom" id="detail_berita"> 
    <div class="row g-0">
        <div class="col-md-12">
            <div class="card-body-detail">
                <img src="{{ asset($data_berita->foto_sampul) }}" class="img-custom" alt="{{ $data_berita->judul }}">
                <div class="text-container">
                    <h4 class="card-title-detail">{{ $data_berita->judul }}</h4>
                    <p class="card-text-detail">{{ $data_berita->isi_berita }}</p>
                    <a href="/" class="btn btn-warning btn-detail">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Memastikan navbar memiliki background saat halaman dimuat
        $(".navbar-detail").addClass("bg-dark");
    });
</script>
@endsection

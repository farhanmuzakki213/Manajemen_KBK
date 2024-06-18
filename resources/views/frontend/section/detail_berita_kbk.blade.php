@extends('frontend.landing_page')

@section('title', $data_berita->judul)

@section('detail_berita')

<div class="card mb-3">
    <div class="row g-0">
      <div class="col-md-9">
        <div class="card-body">
            <div class="col-md-3">
                <img src="{{ $data_berita-> foto_sampul }}" class="img-fluid rounded-end" alt="...">
              </div>
          <h2 class="card-title">{{ $data_berita-> judul }}</h2>
          <p class="card-text-detail">{{ $data_berita-> isi_berita }}</p>
          <a href="/" class="btn btn-warning">Kembali</a>
        </div>
      </div>
    </div>
  </div>

@endsection
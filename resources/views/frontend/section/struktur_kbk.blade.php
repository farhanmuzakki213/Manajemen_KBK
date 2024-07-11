<section class="page-section bg-light" id="struktural">
    <h1 class="text-center wow fadeInUp" data-wow-delay="0.2s">Struktural</h1>
    <div class="container-main wow fadeInUp" data-wow-delay="0.3s">
        <div class="card__container swiper">
            <div class="card__content">
                <div class="swiper-wrapper">
                    @foreach ($data_pengurus_kbk as $data)
                        <article class="card__article swiper-slide">
                            <div class="card__image">
                                {{-- <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-1.png') }}" alt="image" class="card__img"> --}}
                                @if ($data->r_dosen->image)
                                    <img src="{{ asset($data->r_dosen->image) }}" alt="image" class="card__img">
                                @else
                                    @if ($data->r_dosen->gender == 'Laki-laki')
                                        <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-1.png') }}"
                                            alt="image" class="card__img">
                                    @else
                                        <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-3.png') }}"
                                            alt="image" class="card__img">
                                    @endif
                                @endif
                                <div class="card__shadow"></div>
                            </div>

                            <div class="card__data">
                                <h3 class="card__name">{{ $data->r_dosen->nama_dosen }}</h3>
                                <p class="card__description">
                                    Jabatan : {{ $data->r_jabatan_kbk->jabatan }}
                                </p>
                                <p class="card__description">
                                    Bidang : {{ $data->r_jenis_kbk->jenis_kbk }}
                                </p>
                                {{-- <a href="#" class="card__button">View More</a> --}}
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next">
                {{-- <i class="ri-arrow-right-s-line"></i> --}}
            </div>

            <div class="swiper-button-prev">
                {{-- <i class="ri-arrow-left-s-line"></i> --}}
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>



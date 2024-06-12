<section class="page-section bg-light" id="struktural">
    <h1 class="text-center">Struktural</h1>
    <div class="container-main">
        <div class="card__container swiper">
            <div class="card__content">
                <div class="swiper-wrapper">
                    
                    @foreach ($data_pengurus_kbk as $data)
                    <article class="card__article swiper-slide">
                        <div class="card__image">
                            <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-1.png') }}" alt="image" class="card__img">
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

                            <a href="#" class="card__button">View More</a>
                        </div>
                    </article>
                    @endforeach

                    {{-- <article class="card__article swiper-slide">
                        <div class="card__image">
                            <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-2.png') }}" alt="image" class="card__img">
                            <div class="card__shadow"></div>
                        </div>

                        <div class="card__data">
                            <h3 class="card__name">Cipto Prabowo</h3>
                            <p class="card__description">
                                Jabatan Fungsional : IT infrastructur
                            </p>

                            <a href="#" class="card__button">View More</a>
                        </div>
                    </article>

                    <article class="card__article swiper-slide">
                        <div class="card__image">
                            <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-1.png') }}" alt="image" class="card__img">
                            <div class="card__shadow"></div>
                        </div>

                        <div class="card__data">
                            <h3 class="card__name">Ervan Asri</h3>
                            <p class="card__description">
                                Jabatan Fungsional : Proggramming
                            </p>

                            <a href="#" class="card__button">View More</a>
                        </div>
                    </article>

                    <article class="card__article swiper-slide">
                        <div class="card__image">
                            <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-2.png') }}" alt="image" class="card__img">
                            <div class="card__shadow"></div>
                        </div>

                        <div class="card__data">
                            <h3 class="card__name">Alde Alanda</h3>
                            <p class="card__description">
                                Jabatan Fungsional : <br> Networking 
                            </p>

                            <a href="#" class="card__button">View More</a>
                        </div>
                    </article>

                    <article class="card__article swiper-slide">
                        <div class="card__image">
                            <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-3.png') }}" alt="image" class="card__img">
                            <div class="card__shadow"></div>
                        </div>

                        <div class="card__data">
                            <h3 class="card__name">Meri Azmi</h3>
                            <p class="card__description">
                                Jabatan Fungsional : <br> CAIT
                            </p>

                            <a href="#" class="card__button">View More</a>
                        </div>
                    </article>

                    <article class="card__article swiper-slide">
                        <div class="card__image">
                            <img src="{{ asset('frontend/landing-page/assets/img/struktur/avatar-4.png') }}" alt="image" class="card__img">
                            <div class="card__shadow"></div>
                        </div>

                        <div class="card__data">
                            <h3 class="card__name">Yulherniwati</h3>
                            <p class="card__description">
                                Jabatan Fungsional : <br> CAIT
                            </p>

                            <a href="#" class="card__button">View More</a>
                        </div>
                    </article> --}}

                </div>
            </div>

            <!-- Navigation buttons -->
            <div class="swiper-button-next">
                <i class="ri-arrow-right-s-line"></i>
            </div>

            <div class="swiper-button-prev">
                <i class="ri-arrow-left-s-line"></i>
            </div>

            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
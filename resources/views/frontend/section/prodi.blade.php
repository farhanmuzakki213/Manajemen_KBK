{{-- <div class="container-prodi">
  <div class="shadow_prodi p-3 mb-5 bg-body rounded">
    <div class="row_prodi align-items-center">
      <div>
        <img class="img-fluid d-block mx-auto" src="frontend/landing-page/assets/img/prodi/animasi.png" aria-label="ANIMASI Logo" />
      </div>
      <div>
         <img class="img-fluid d-block mx-auto" src="frontend/landing-page/assets/img/prodi/trpl.png" aria-label="TRPL Logo" />
      </div>
      <div>
        <img class="img-fluid d-block mx-auto" src="frontend/landing-page/assets/img/prodi/mi.png" aria-label="MI Logo" />
      </div>
      <div>
        <img class="img-fluid d-block mx-auto" src="frontend/landing-page/assets/img/prodi/tkom.png" aria-label="TKOM Logo" />
      </div>
      <div>
        <img class="img-fluid d-block mx-auto" src="frontend/landing-page/assets/img/prodi/si.png" aria-label="SI Logo" />
      </div>
      <div>
        <img class="img-fluid d-block mx-auto" src="frontend/landing-page/assets/img/prodi/adm_jaringan.png" aria-label="ADM JARINGAN Logo" />
      </div>
    </div>
  </div>
</div> --}}







<div class="container-prodi animated zoomIn" >
  <div class="shadow_prodi p-3 mb-5 bg-body rounded">
    <div class="swiper-container swiper-container-prodi">
    <div class="swiper-wrapper swiper-wrapper-prodi">
    <div class="swiper-slide swiper-slide-prodi">
      <img class="img-fluid d-block mx-auto" src="frontend/landing-page/assets/img/kbk/cait.png" aria-label="TRPL Logo" />
    </div>
    <div class="swiper-slide swiper-slide-prodi">
      <img class="img-fluid img-prodi d-block mx-auto" src="frontend/landing-page/assets/img/kbk/softam.png" aria-label="ANIMASI Logo" />
    </div>
    <div class="swiper-slide swiper-slide-prodi">
      <img class="img-fluid img-prodi d-block mx-auto" src="frontend/landing-page/assets/img/kbk/it_infrastruktur.png" aria-label="MI Logo" />
    </div>
    <div class="swiper-slide swiper-slide-prodi">
      <img class="img-fluid img-prodi d-block mx-auto" src="frontend/landing-page/assets/img/kbk/programming.png" aria-label="TKOM Logo" />
    </div>
    <div class="swiper-slide swiper-slide-prodi">
      <img class="img-fluid img-prodi d-block mx-auto" src="frontend/landing-page/assets/img/kbk/ncs.png" aria-label="SI Logo" />
    </div>
    {{-- <div class="swiper-slide swiper-slide-prodi">
      <img class="img-fluid img-prodi d-block mx-auto" src="frontend/landing-page/assets/img/prodi/ajk2.png" aria-label="ADM JARINGAN Logo" />
    </div> --}}
  </div>
  </div>
  </div>
</div>

<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
 
  const swiper = new Swiper('.swiper-container-prodi', {
    slidesPerView: 4,       // Menampilkan 4 slide sekaligus
    spaceBetween: 30,       // Jarak antara slide
    loop: true,             // Loop agar slider mengulang setelah slide terakhir
    speed: 2000,            // Kecepatan transisi (ms)
    autoplay: {
      delay: 0,             // Tanpa delay antara slide
      disableOnInteraction: false,
    },
  });

</script>


      
    
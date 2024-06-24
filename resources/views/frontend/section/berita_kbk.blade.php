<section class="page-section bg-white" id="berita">
    <div class="container-berita py-5">
        <h1 class="text-center mb-5 text-3xl font-bold">Berita</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($data_berita as $index => $data)
            <div class="col-berita {{ $index >= 3 ? 'hidden' : '' }}">
                <div class="card h-100 border-0">
                    <img src="{{ asset($data->foto_sampul) }}" class="card-img-top" alt="...">
                    <div class="card-body d-flex flex-column">
                        <h4 class="card-title">{{$data->judul}}</h4>
                        <p class="card-text mb-4">{{$data->isi_berita}}</p>
                        <div class="mt-auto text-start">
                            {{-- <a href="/detail_berita/{{ $data->id_berita }}" class="btn btn-primary">Read More</a> --}}
                            <a data-bs-toggle="modal" data-bs-target="#detail{{ $data->id_berita }}" class="btn btn-primary">Read More</a>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Modal Detail Tabel --}}
            <div class="modal fade" id="detail{{ $data->id_berita }}" tabindex="-1"
                aria-labelledby="detailLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="detailLabel">Detail Berita "{{ $data->judul }}"</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="card-body-detail">
                                <img src="{{ asset($data->foto_sampul) }}" class="img-custom"
                                    alt="{{ $data->judul }}">
                                <div class="text-container">
                                    <h4 class="card-title-detail">{{ $data->judul }}</h4>
                                    <div class="card-text-detail">
                                        @foreach (explode("\n", $data->isi_berita) as $paragraph)
                                            @if (!empty(trim($paragraph)))
                                                <p>{!! e($paragraph) !!}</p>
                                            @endif
                                        @endforeach
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- tambahkan input untuk atribut lainnya jika diperlukan -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            
            @endforeach
        </div>
        <div class="text-center mt-4">
            <button id="loadMore" class="btn_detail p-0">
                <img src="{{asset('frontend/landing-page/assets/img/icon/down-arrow2.svg')}}" alt="Tampilkan Lebih Banyak" width="30" height="30">
            </button>
            <button id="loadLess" class="btn_detail p-0" style="display: none;">
                <img src="{{asset('frontend/landing-page/assets/img/icon/up-arrow2.svg')}}" alt="Tampilkan Lebih Sedikit" width="30" height="30">
            </button>
        </div>
    </div>
</section>









{{-- <section class="page-section bg-gray-100 py-10" id="berita">
    <div class="container- mx-auto px-4">
        <h1 class="text-center text-3xl font-bold mb-10">Berita</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($data_berita as $data)
            <div class="relative flex flex-col mt-6 text-gray-700 bg-white shadow-md bg-clip-border rounded-xl">
                <div
                    class="relative h-56 mx-4 -mt-6 overflow-hidden text-white shadow-lg bg-clip-border rounded-xl bg-blue-gray-500 shadow-blue-gray-500/40">
                    <img src="{{$data->foto_sampul}}" alt="card-image" class="w-full h-full object-cover" />
                </div>
                <div class="p-6">
                    <h5 class="block mb-2 font-sans text-xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
                        {{$data->judul}}
                    </h5>
                    <p class="block font-sans text-base antialiased font-light leading-relaxed text-inherit">
                        {{$data->isi_berita}}
                    </p>
                </div>
                <div class="p-6 pt-0 flex flex-col text-center self-start mt-auto">
                    <a href="/berita/{{ $data->id_berita }}" class="align-middle select-none font-sans font-bold uppercase text-xs py-3 px-6 rounded-lg bg-gray-900 text-white shadow-md shadow-gray-900/10 hover:shadow-lg hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none">
                        Read More
                    </a>
                </div>
                
            </div>
            @endforeach
        </div>
    </div>
</section> --}}



{{-- <section class="page-section bg-gray-100 py-10" id="berita">
    <div class="container mx-auto px-4">
        <h1 class="text-center text-3xl font-bold mb-10">Berita</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($data_berita as $data)
                <div class="relative flex flex-col mt-6 text-gray-700 bg-white shadow-md bg-clip-border rounded-xl">
                    <div class="relative h-56 mx-4 -mt-6 overflow-hidden text-white shadow-lg bg-clip-border rounded-xl bg-blue-gray-500 shadow-blue-gray-500/40">
                        <img src="{{ $data->foto_sampul }}" alt="card-image" class="w-full h-full object-cover" />
                    </div>
                    <div class="p-6">
                        <h5 class="block mb-2 font-sans text-xl font-semibold leading-snug text-blue-gray-900">
                            {{ $data->judul }}
                        </h5>
                        <p class="block font-sans text-base font-light leading-relaxed text-gray-700">
                            {{ $data->isi_berita }}
                        </p>
                    </div>
                    <div class="p-6 pt-0 flex flex-col items-center mt-auto">
                        <a href="/berita/{{ $data->id_berita }}" class="inline-block px-6 py-3 text-xs font-bold uppercase bg-gray-900 text-white rounded-lg shadow-md hover:shadow-lg focus:opacity-85 focus:outline-none focus:shadow-none active:opacity-85 active:shadow-none">
                            Read More
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section> --}}



{{-- <script>
    document.querySelectorAll('.read-more').forEach(item => {
        item.addEventListener('click', event => {
            event.preventDefault();
            const targetIndex = item.getAttribute('data-target');
            const card = document.getElementById('card' + targetIndex);
            const isiBerita = document.getElementById('isi_berita' + targetIndex);

            if (isiBerita.style.height === '100px') {
                isiBerita.style.height = 'auto';
                card.querySelector('.read-more').innerText = 'Read Less';
            } else {
                isiBerita.style.height = '100px';
                card.querySelector('.read-more').innerText = 'Read More';
            }
        });
    });
</script> --}}




<style>
    .card {
        border-radius: 30px;
        box-shadow: rgba(0, 0, 0, 0.1) 0px 1px 2px 0px;
    }

    .card-img-top {
        border-radius: 50px;
        padding: 20px;
        object-fit: cover;
        height: 200px;
    }

    .card-body {
        padding: 25px;
        margin-top: -15px;
        height: 310px;
        overflow: hidden;
    }

    .btn-primary {
        border-radius: 50px;
        width: 120px;
        margin-bottom: 600px;
    }

    .btn-primary:hover {
        background-color: black;
        border: none;
    }

    h3,
    h6 {
        color: rgb(0, 0, 0);
    }

    .detail-content {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
        line-height: 2.5;
    }

    .detail-content .image-container {
        flex: 0 0 40%;
        padding: 20px;
    }

    .detail-content .image-container img {
        max-width: 100%;
        height: auto;
        border-radius: 50px;
        object-fit: cover;
    }

    .detail-content .text-container {
        flex: 0 0 60%;
        padding: 60px;
    }

    .detail-content h3 {
        margin-bottom: 10px;
        line-height: 2.5;
    }

    .detail-content h6 {
        margin-bottom: 10px;
        line-height: 2.5;
    }
</style>

<section class="page-section bg-light" id="berita">
    <div class="container py-1">
        <h1 class="text-center mb-5">Berita</h1>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($data_berita as $index => $data)
                <div class="col">
                    <div class="card" id="card{{ $index }}">
                        <img src="{{ $data->foto_sampul }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h4 class="card-title">{{ $data->judul }}</h4>
                            <p class="card-text" style="height: 100px; overflow: hidden;"
                                id="isi_berita{{ $index }}">{{ $data->isi_berita }}</p>
                            <div class="text-center">
                                <a href="#" class="btn btn-primary read-more"
                                    data-target="{{ $index }}">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>

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

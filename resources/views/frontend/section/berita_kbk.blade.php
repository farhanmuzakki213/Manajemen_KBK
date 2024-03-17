<style>
    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

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

<div class="container py-5">
    <h1 class="text-center">Berita</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4 py-5">
        <div class="col">
            <div class="card">
                <img src="frontend/landing-page/assets/img/berita/berita1.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">Pekan IT Politeknik Negeri Padang 2023 : The Digital Revolution</h4>
                    <p class="card-text" style="height: 100px; overflow: hidden;">Politeknik Negeri Padang, melalui Jurusan Teknologi Informasi, siap mengguncang dunia Teknologi Informasi dengan acara besar, “Pekan IT Politeknik Negeri Padang 2023.” Acara ini akan menggugah semangat generasi muda, terutama pelajar SLTA di seluruh Sumatera Barat, untuk mengejar pengetahuan tentang Teknologi Informasi. Dengan tema “The Digital Revolution – Transforming Industry and Everyday Life,” acara ini menawarkan beragam kegiatan yang tidak hanya mendalam, tetapi juga menginspirasi.</p>
                    <div class="mb-5 d-flex justify-content-around">
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="frontend/landing-page/assets/img/berita/berita2.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">Tiga Program Studi di PSDKU Raih Akreditasi Baik Sekali</h4>
                    <p class="card-text" style="height: 100px; overflow: hidden;">Ketiga program studi yang berhasil meraih akreditasi “Baik Sekali” adalah Prodi Manajemen Informatika di PSDKU Kabupaten Pelalawan, Prodi Sistem Informasi di PSDKU Kabupaten Tanah Datar, dan Prodi Teknik Komputer di PSDKU Kabupaten Solok Selatan. Prestasi ini merupakan hasil dari upaya dan kerja keras para dosen, staf, dan mahasiswa dalam menjaga kualitas pendidikan di tiga program studi tersebut.</p>
                    <div class="mb-5 d-flex justify-content-around">
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <img src="frontend/landing-page/assets/img/berita/berita3.png" class="card-img-top" alt="...">
                <div class="card-body">
                    <h4 class="card-title">Jadwal Perkuliahan Semester Genap TA 2021/2022</h4>
                    <p class="card-text" style="height: 100px; overflow: hidden;">Jadwal Perkuliahan saat ini sudah tersedia dan dapat dilihat pada link presensi.pnp.ac.id/ti</p>
                    <div class="mb-5 d-flex justify-content-around">
                        <a href="#" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-xxl service py-5" id="jenis_kbk">
    <style>
        .service .nav-link {
            padding: 15px 20px !important;
            /* Mengurangi padding untuk membuat tombol lebih kecil */
            margin-bottom: 26px !important;
            /* Mengurangi margin bawah untuk jarak antar tombol */
            font-size: 8px !important;
            /* Mengurangi ukuran teks */
            font-weight: 400 !important;
            /* background-color: #000 !important; */
            color: #000000 !important;
            /* Warna teks putih */
            border: none !important;
            /* Menghapus border */
            text-align: left;
            /* Penyesuaian untuk teks menjadi satu baris */
            white-space: nowrap;
            /* Mencegah pematahan teks ke baris baru */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .service .nav-pills {
            margin-bottom: 10px;
        }

        .service .nav-link i {
            font-size: 20px !important;
            /* Mengurangi ukuran ikon */
            margin-right: 8px !important;
            /* Mengurangi jarak antara ikon dan teks */
        }

        /* Menyesuaikan tombol aktif pada navbar */
        .service .nav-link.active {
            background-color: #000000 !important;
            /* Warna latar belakang untuk tombol aktif */
            color: #ffffff !important;
            /* Warna teks untuk tombol aktif */
        }

        /* Menambahkan jarak antara h3 dan paragraf */
        /* .service .tab-content h3 {
            margin-bottom: 40px !important;
        } */

        .tab-pane p {
            text-align: justify;
            /* Ratakan paragraf ke kiri dan kanan */
            margin-bottom: 30px;
            /* Atur margin bottom untuk paragraf */
        }

        .tab-pane img {
            width: 100%;
            height: 400px;
            object-fit: cover;
        }

        @media (min-width: 310px) {
            .tab-pane img {
                max-height: 200px;
            }

            .tab-pane .media-1 {
                margin-top: 220px;
                /* Ubah margin-top sesuai kebutuhan Anda */
            }
        }


        @media (min-width: 360px) {
            .tab-pane img {
                max-height: 325px;
            }
            .tab-pane .media-1 {
                margin-top: 350px;
                /* Ubah margin-top sesuai kebutuhan Anda */
            }
        }

        @media (min-width: 374px) {
            .tab-pane img {
                max-height: 330px;
            }
        }

        @media (min-width: 389px) {
            .tab-pane img {
                max-height: 350px;
            }
            .tab-pane .media-1 {
                margin-top: 370px;
                /* Ubah margin-top sesuai kebutuhan Anda */
            }
        }

        @media (min-width: 410px) {
            .tab-pane img {
                max-height: 365px;
            }
            .tab-pane .media-1 {
                margin-top: 380px;
                /* Ubah margin-top sesuai kebutuhan Anda */
            }
        }

        @media (min-width: 767px) {
            .tab-pane img {
                max-height: 380px;
            }
            .tab-pane .media-1 {
                margin-top: 20px;
                /* Ubah margin-top sesuai kebutuhan Anda */
            }
        }

        @media (min-width: 1114px) {
            .tab-pane img {
                max-height: 390px;
            }
        }


        @media (min-width: 1240px) {
            .tab-pane img {
                max-height: 400px;
            }
        }
    </style>


    <div class="container">
        <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
            <h1 class="mb-5">Jenis KBK</h1>
        </div>
        <div class="row g-5 wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-lg-4">
                <div class="nav w-100 nav-pills me-5">
                    <button class="nav-link w-100 d-flex align-items-center text-start p-4 active" data-bs-toggle="pill"
                        data-bs-target="#tab-pane-1" type="button">
                        <i class="fa fa-code fa-2x me-3"></i>
                        <h4 class="m-0">Programming</h4>
                    </button>
                    <button class="nav-link w-100 d-flex align-items-center text-start" data-bs-toggle="pill"
                        data-bs-target="#tab-pane-2" type="button">
                        <i class="fa fa-server fa-2x me-3"></i>
                        <h4 class="m-0">IT Infrastruktur</h4>
                    </button>
                    <button class="nav-link w-100 d-flex align-items-center text-start" data-bs-toggle="pill"
                        data-bs-target="#tab-pane-3" type="button">
                        <i class="fa fa-shield-alt fa-2x me-3"></i>
                        <h4 class="m-0">Networking and Cybersec</h4>
                    </button>
                    <button class="nav-link w-100 d-flex align-items-center text-start" data-bs-toggle="pill"
                        data-bs-target="#tab-pane-4" type="button">
                        <i class="fa fa-paint-brush fa-2x me-3"></i>
                        <h4 class="m-0">CAIT</h4>
                    </button>
                    <button class="nav-link w-100 d-flex align-items-center text-start" data-bs-toggle="pill"
                        data-bs-target="#tab-pane-5" type="button">
                        <i class="fa fa-project-diagram fa-2x me-3"></i>
                        <h4 class="m-0">SOFTAM</h4>
                    </button>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="tab-content w-100">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img class="position-absolute img-fluid"
                                        src="frontend/landing-page/assets/img/jenis/programming1.jpg"
                                        style="object-fit: cover;" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 media-1">
                                <h4 class="mb-3">Programming</h4>
                                <p class="mb-4">KBK Programming merupakan disiplin yang fokus pada pengembangan
                                    perangkat lunak dan aplikasi komputer. Ini meliputi semua aspek dari proses
                                    pengembangan perangkat lunak, mulai dari perencanaan dan analisis kebutuhan
                                    pengguna, desain arsitektur sistem, penulisan kode, pengujian, hingga implementasi
                                    dan pemeliharaan. Spesialis dalam KBK ini mampu menggunakan berbagai bahasa
                                    pemrograman dan teknologi terkini untuk menciptakan solusi perangkat lunak yang
                                    efisien dan sesuai dengan kebutuhan bisnis.</p>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tab-pane-2">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img class="position-absolute img-fluid"
                                        src="frontend/landing-page/assets/img/jenis/it-infrastruktur1.jpg"
                                        style="object-fit: cover;" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 media-1">
                                <h4 class="mb-3">IT Infrastruktur</h4>
                                <p class="mb-4">KBK Programming merupakan disiplin yang fokus pada pengembangan
                                    perangkat lunak dan aplikasi komputer. Ini meliputi semua aspek dari proses
                                    pengembangan perangkat lunak, mulai dari perencanaan dan analisis kebutuhan
                                    pengguna, desain arsitektur sistem, penulisan kode, pengujian, hingga implementasi
                                    dan pemeliharaan. Spesialis dalam KBK ini mampu menggunakan berbagai bahasa
                                    pemrograman dan teknologi terkini untuk menciptakan solusi perangkat lunak yang
                                    efisien dan sesuai dengan kebutuhan bisnis.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img class="position-absolute img-fluid"
                                        src="frontend/landing-page/assets/img/jenis/networking.jpg"
                                        style="object-fit: cover;" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 media-1">
                                <h4 class="mb-3">Networking and Cybersec</h4>
                                <p class="mb-4">KBK Programming merupakan disiplin yang fokus pada pengembangan
                                    perangkat lunak dan aplikasi komputer. Ini meliputi semua aspek dari proses
                                    pengembangan perangkat lunak, mulai dari perencanaan dan analisis kebutuhan
                                    pengguna, desain arsitektur sistem, penulisan kode, pengujian, hingga implementasi
                                    dan pemeliharaan. Spesialis dalam KBK ini mampu menggunakan berbagai bahasa
                                    pemrograman dan teknologi terkini untuk menciptakan solusi perangkat lunak yang
                                    efisien dan sesuai dengan kebutuhan bisnis.</p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-4">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img class="position-absolute img-fluid"
                                        src="frontend/landing-page/assets/img/jenis/cait3.png"
                                        style="object-fit: cover;" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 media-1">
                                <h4 class="mb-3"">CAIT (Creative Animation and IT)</h4>
                                <p class="mb-4">KBK CAIT menggabungkan kreativitas digital dengan teknologi informasi
                                    untuk menghasilkan konten visual yang menarik dan bermakna. Ini meliputi
                                    pengembangan animasi, grafis digital, dan konten multimedia lainnya menggunakan
                                    perangkat lunak khusus. Spesialis dalam KBK ini tidak hanya memiliki keterampilan
                                    teknis dalam menggunakan alat-alat kreatif, tetapi juga memahami prinsip desain
                                    estetika dan kebutuhan pasar untuk konten digital yang inovatif.</p>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="tab-pane-5">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="position-relative h-100">
                                    <img class="position-absolute img-fluid"
                                        src="frontend/landing-page/assets/img/jenis/softam.jpg"
                                        style="object-fit: cover;" alt="">
                                </div>
                            </div>
                            <div class="col-md-6 media-1">
                                <h4 class="mb-3"">SOFTAM (Software Application and Management)</h4>
                                <p class="mb-4">KBK SOFTAM berfokus pada manajemen siklus hidup aplikasi perangkat
                                    lunak dari awal
                                    pengembangan hingga pensiun. Ini mencakup perencanaan kebutuhan bisnis, analisis,
                                    desain, implementasi,
                                    pengujian, dan pemeliharaan aplikasi. Spesialis dalam KBK ini tidak hanya menguasai
                                    teknologi aplikasi
                                    terkini, tetapi juga memiliki pemahaman mendalam tentang proses bisnis dan kebutuhan
                                    pengguna. Mereka
                                    bertanggung jawab untuk memastikan bahwa aplikasi berfungsi optimal, aman, dan
                                    memenuhi tujuan bisnis
                                    yang ditetapkan.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

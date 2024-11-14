@extends('User.partials.master')

@section('content')
    @if (session('error'))
        <div class="position-fixed" style="top: 100px; right: 100px; z-index: 1050;">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                @if (is_array(session('error')))
                    <ul>
                        @foreach (session('error') as $error)
                            <li><strong>{{ $error }}</strong></li>
                        @endforeach
                    </ul>
                @else
                    <strong>{{ session('error') }}</strong>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="position-fixed" style="top: 100px; right: 100px; z-index: 1050;">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section light-background">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                        <h1>Welcome to <span>UIN Malang EventHub</span></h1>
                        <p>
                            Kami adalah jembatan informasi bagi mahasiswa UIN Malang untuk mengetahui berbagai acara
                            yang diselenggarakan di kampus, serta memudahkan mereka untuk mendaftar acara yang
                            diinginkan melalui platform kami, UIN Malang EventHub.
                        </p>
                        <div class="d-flex">
                            <a href="#about" class="btn-get-started">Mulai</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section light-background py-5">
            <!-- Section Title -->
            <div class="container section-title text-center mb-4" data-aos="fade-up">
                <h2 class="fw-bold text-primary">Tentang Kami</h2>
                <p class="text-muted">
                    <span>Cari Tahu Lebih Lanjut</span>
                    <span class="description-title d-block fs-5">Tentang Kami</span>
                </p>
            </div>
            <!-- End Section Title -->

            <div class="container">
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <img src="{{ asset('images/about.jpg') }}" alt="Tentang Kami" class="img-fluid rounded shadow" />
                    </div>

                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="about-content ps-0 ps-lg-3">
                            <h3 class="text-primary fw-bold">UIN Malang EventHub</h3>
                            <p class="fst-italic text-muted">
                                UIN Malang EventHub adalah aplikasi yang dikembangkan untuk memberikan kemudahan bagi
                                mahasiswa UIN Malang dalam mengakses informasi mengenai berbagai acara yang ada di
                                kampus. Aplikasi ini bertujuan untuk meningkatkan keterlibatan mahasiswa dalam kegiatan
                                akademik maupun non-akademik dengan fitur-fitur sebagai berikut
                            </p>
                            <ul class="list-unstyled">
                                <li class="d-flex align-items-start mb-3">
                                    <i class="bi bi-calendar-check text-success fs-4 me-3"></i>
                                    <div>
                                        <p class="text-muted">
                                            <strong>Informasi Acara Terbaru:</strong>
                                            Pengguna dapat dengan mudah melihat daftar acara yang sedang atau akan
                                            berlangsung di UIN Malang, lengkap dengan informasi detail tentang tanggal,
                                            lokasi, dan deskripsi acara.
                                        </p>
                                    </div>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="bi bi-person-check text-warning fs-4 me-3"></i>
                                    <div>
                                        <p class="text-muted">
                                            <strong>Pendaftaran Acara yang Mudah: </strong> Mahasiswa dapat mendaftar
                                            langsung untuk
                                            acara yang mereka
                                            minati hanya dengan beberapa klik, tanpa perlu repot mengunjungi tempat
                                            pendaftaran secara fisik.
                                        </p>
                                    </div>
                                </li>
                                <li class="d-flex align-items-start mb-3">
                                    <i class="bi bi-list-check text-info fs-4 me-3"></i>
                                    <div>
                                        <p class="text-muted">
                                            <strong>Akses yang Praktis dan Terorganisir:</strong> Semua informasi acara
                                            dapat diakses kapan
                                            saja dan di mana
                                            saja, memungkinkan mahasiswa untuk tetap up-to-date dan terorganisir dengan
                                            jadwal kegiatan kampus mereka.
                                        </p>
                                    </div>
                                </li>
                            </ul>
                            <p class="fst-italic text-muted">
                                Dengan UIN Malang EventHub, mahasiswa dapat memaksimalkan pengalaman kampus mereka dan
                                lebih mudah terlibat dalam kegiatan yang mendukung perkembangan pribadi dan akademik.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /About Section -->

        <hr>
        <!-- Section for Criteria and Weights -->
        <section id="eventList" class="section py-2">
            <div class="container">
                <div class="container section-title text-center mb-4" data-aos="fade-up" style="margin-bottom: -40px;">
                    <h2 class="fw-bold text-primary">Daftar Acara di UIN Malang</h2>
                    <p class="text-muted">Temukan berbagai acara yang akan datang di kampus dan daftar untuk acara yang
                        kamu minati!</p>
                </div>

                <!-- Carousel for Events -->
                <h3 class="text-primary text-center">Acara yang Akan Datang</h3>
                <div id="eventCarousel" class="carousel slide mt-3" data-bs-interval="false">
                    <div class="carousel-inner">
                        @foreach (collect($datas)->chunk(3) as $chunk)
                            <div class="carousel-item @if ($loop->first) active @endif">
                                <div class="row justify-content-center">
                                    @foreach ($chunk as $data)
                                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4" data-aos="fade-up"
                                            data-aos-delay="100">
                                            <div class="card shadow-lg border-0 h-100 rounded-3">
                                                <div class="card-body text-center">
                                                    <h5 class="card-title text-success">{{ $data->nama_event }}</h5>
                                                    <p class="card-text">{{ Str::limit($data->deskripsi, 100) }}</p>
                                                    <p class="text-muted">
                                                        Tanggal:
                                                        {{ \Carbon\Carbon::parse($data->tanggal_event)->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y') }}
                                                    </p>
                                                    <p class="text-muted">Lokasi: {{ $data->lokasi->nama_lokasi }}</p>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal{{ $data->id_event }}">
                                                        Daftar Sekarang!!
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal fade" id="exampleModal{{ $data->id_event }}" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Daftar
                                                            {{ $data->nama_event }}</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah kamu yakin untuk daftar event <strong>{{ $data->nama_event }}
                                                        </strong> ini
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <form action="{{ route('daftar-event') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id_event"
                                                                value="{{ $data->id_event }}">
                                                            <button type="submit" class="btn btn-primary">Daftar
                                                                Sekarang!!</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>

                <!-- Optional: Additional explanation or instructions -->
                <p class="text-muted mt-4 text-center">
                    Klik tombol "Daftar Sekarang!!" untuk mendaftar ke acara yang kamu pilih. Pastikan kamu sudah login untuk
                    bisa mendaftar acara.
                </p>
            </div>
        </section>


        <!-- Optional CSS to fix carousel icon visibility -->
        <style>
            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                background-color: rgba(0, 0, 0, 0.5);
                /* Color for the icons */
                border-radius: 50%;
                /* Round icon buttons */
                width: 30px;
                /* Icon size */
                height: 30px;
            }
        </style>
    </main>
@endsection

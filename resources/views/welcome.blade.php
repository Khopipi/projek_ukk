@extends('layouts.landing')

@section('title', 'Selamat Datang di Aplikasi Desa Sruni')

@section('content')
    <!-- [ Header ] start -->
    <header id="home" class="d-flex align-items-center"
        style="position: relative; min-height: 100dvh; background: url('{{ asset('assets/images/my/sruni_full.jpg') }}') no-repeat center center; background-size: cover;">
        <!-- Overlay -->
        <div
            style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-image: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0.1));">
        </div>

        <div class="container mt-5 pt-5">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8 text-center">
                    <h1 class="mt-sm-3 text-white mb-4 f-w-600 wow fadeInUp" data-wow-delay="0.2s" style="font-size: 3.5rem;">
                        Selamat Datang di
                        <br>
                        <span class="text-primary">Aplikasi Desa Sruni</span>
                    </h1>
                    <h5 class="mb-4 text-white opacity-75 wow fadeInUp" data-wow-delay="0.4s" style="font-size: 1.25rem;">
                        Wujudkan Tata Kelola Pemerintahan Desa yang <b>Transparan, Cepat, dan Akuntabel</b>
                        <br class="d-none d-md-block">
                        Akses layanan administrasi dan informasi publik secara online, mudah, dan efisien.
                    </h5>
                    <div class="my-5 wow fadeInUp" data-wow-delay="0.6s">
                        <a href="{{ route('register') }}"
                            class="btn btn-primary btn-lg d-inline-flex align-items-center me-2">Daftar Akun Warga <i
                                class="ti ti-arrow-right ms-2"></i></a>
                        <a href="#layanan" class="btn btn-outline-light btn-lg me-2">Lihat Layanan Desa</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- [ Header ] End -->

    <!-- [ Keunggulan Kami ] start -->
    <section>
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-10 col-xl-6">
                    <h5 class="text-primary mb-0">Desa Digital & Modern</h5>
                    <h2 class="my-3">Mengapa Gunakan Aplikasi Desa Sruni?</h2>
                    <p class="mb-0">Kami menghadirkan layanan digital terpadu untuk warga desa agar lebih mudah dalam
                        mengurus administrasi, mendapatkan informasi, dan berpartisipasi dalam pembangunan desa.</p>
                </div>
            </div>
        </div>
        <div class="container" id="layanan">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.4s">
                        <div class="card-body">
                            <img src="../assets/images/landing/img-feature1.svg"
                                alt="Layanan administrasi online" class="img-fluid">
                            <h5 class="my-3">Layanan Administrasi</h5>
                            <p class="mb-0 text-muted">Urus surat keterangan, domisili, dan dokumen penting langsung dari
                                rumah tanpa antre di kantor desa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.6s">
                        <div class="card-body">
                            <img src="../assets/images/landing/img-feature2.svg"
                                alt="Informasi publik desa" class="img-fluid">
                            <h5 class="my-3">Informasi Publik</h5>
                            <p class="mb-0 text-muted">Dapatkan berita terbaru, laporan keuangan, kegiatan, dan pengumuman
                                resmi dari Pemerintah Desa Sruni.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card wow fadeInUp" data-wow-delay="0.8s">
                        <div class="card-body">
                            <img src="../assets/images/landing/img-feature3.svg"
                                alt="Transparansi data dan keuangan desa" class="img-fluid">
                            <h5 class="my-3">Transparansi & Akuntabilitas</h5>
                            <p class="mb-0 text-muted">Semua data desa, anggaran, dan kegiatan masyarakat dapat diakses
                                secara terbuka oleh warga.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ Keunggulan Kami ] End -->

    <!-- [ Alur Penggunaan ] start -->
    <section class="pt-0" id="alur">
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-10 col-xl-6">
                    <h5 class="text-primary mb-0">Langkah Mudah</h5>
                    <h2 class="my-3">Cara Menggunakan Aplikasi Desa</h2>
                    <p class="mb-0">Ikuti langkah-langkah berikut untuk mengakses berbagai layanan publik dari Desa Sruni.</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="0.4s">
                        <div class="card-body text-center">
                            <i class="ti ti-user-plus f-36 text-primary"></i>
                            <h5 class="my-3">1. Daftar Akun</h5>
                            <p class="mb-0 text-muted">Buat akun warga dengan email dan NIK untuk mengakses sistem desa.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="0.6s">
                        <div class="card-body text-center">
                            <i class="ti ti-file-text f-36 text-primary"></i>
                            <h5 class="my-3">2. Pilih Layanan</h5>
                            <p class="mb-0 text-muted">Pilih jenis layanan seperti surat pengantar, izin usaha, atau
                                keperluan lainnya.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="0.8s">
                        <div class="card-body text-center">
                            <i class="ti ti-send f-36 text-primary"></i>
                            <h5 class="my-3">3. Kirim Permohonan</h5>
                            <p class="mb-0 text-muted">Lengkapi data dan ajukan permohonan Anda secara online.</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="card wow fadeInUp" data-wow-delay="1.0s">
                        <div class="card-body text-center">
                            <i class="ti ti-check f-36 text-primary"></i>
                            <h5 class="my-3">4. Selesai & Cetak</h5>
                            <p class="mb-0 text-muted">Permohonan Anda akan diverifikasi, dan surat bisa langsung diunduh
                                atau diambil di kantor desa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ Alur Penggunaan ] End -->

    <!-- [ CTA ] start -->
    <section class="cta-block"
        style="position: relative; padding: 120px 0; background: url('{{ asset('assets/images/my/foto-orang.jpg') }}') no-repeat center center; background-size: cover; background-attachment: fixed;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.6);"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-md-8 text-center">
                    <h2 class="text-white mb-4" style="font-size: 2.8rem; font-weight: 600;">
                        Bersama Membangun <span class="text-primary">Desa Sruni</span> yang Lebih Baik
                    </h2>
                    <p class="text-white opacity-75 mb-4 lead">
                        Mari berpartisipasi aktif dalam membangun desa dengan teknologi digital yang transparan dan inklusif.
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">Gabung Sekarang <i
                            class="ti ti-arrow-right ms-2"></i></a>
                </div>
            </div>
        </div>
    </section>
    <!-- [ CTA ] End -->

    <!-- [ Statistik ] start -->
    <section class="bg-white">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h2 class="m-0 text-primary">5000+</h2>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mb-2">Penduduk Terdaftar</h4>
                                    <p class="mb-0">Warga aktif menggunakan sistem layanan digital desa.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.4s">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h2 class="m-0 text-primary">25+</h2>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mb-2">Layanan Online</h4>
                                    <p class="mb-0">Berbagai kebutuhan administrasi kini bisa dilakukan secara daring.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="card border-0 wow fadeInUp" data-wow-delay="0.6s">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <h2 class="m-0 text-primary">100%</h2>
                                <div class="flex-grow-1 ms-3">
                                    <h4 class="mb-2">Transparan</h4>
                                    <p class="mb-0">Semua data dan laporan kegiatan dapat diakses oleh masyarakat desa.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ Statistik ] End -->

   <!-- [ Testimoni ] start -->
    <section class="pt-0">
        <div class="container title">
            <div class="row justify-content-center text-center wow fadeInUp" data-wow-delay="0.2s">
                <div class="col-md-10 col-xl-6">
                    <h5 class="text-primary mb-0">Testimoni</h5>
                    <h2 class="my-3">Apa Kata Warga?</h2>
                    <p class="mb-0">Kami bangga memberikan pelayanan terbaik. Simak pengalaman warga dalam menggunakan Sistem Informasi Desa Bangah.</p>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row cust-slider">
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInRight" data-wow-delay="0.2s">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/user/avatar-1.jpg"
                                        alt="Foto warga pria tersenyum" class="img-fluid wid-40 rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Pelayanan Cepat dan Ramah</h5>
                                    <div class="star f-12 mb-3">
                                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                    </div>
                                    <p class="mb-2 text-muted">Proses pengurusan surat jauh lebih mudah dan cepat melalui sistem ini. Sangat membantu warga!</p>
                                    <h6 class="mb-0">Ahmad Aril, Warga</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInRight" data-wow-delay="0.4s">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/user/avatar-2.jpg"
                                        alt="Foto warga wanita tersenyum"
                                        class="img-fluid wid-40 rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Transparansi Data Desa</h5>
                                    <div class="star f-12 mb-3">
                                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star-half-alt text-warning"></i>
                                    </div>
                                    <p class="mb-2 text-muted">Sekarang semua informasi desa bisa diakses dengan mudah dan terbuka. Sangat bagus untuk warga.</p>
                                    <h6 class="mb-0">AnaSHT, Warga</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="card wow fadeInRight" data-wow-delay="0.6s">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <img src="../assets/images/user/avatar-3.jpg"
                                        alt="Foto warga berhijab tersenyum"
                                        class="img-fluid wid-40 rounded-circle">
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="mb-1">Inovasi Digital Desa</h5>
                                    <div class="star f-12 mb-3">
                                        <i class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i
                                            class="fas fa-star text-warning"></i><i class="fas fa-star text-warning"></i>
                                    </div>
                                    <p class="mb-2 text-muted">Sistem ini benar-benar membantu warga mengurus layanan tanpa harus datang ke kantor desa.</p>
                                    <h6 class="mb-0">Aang , Warga</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ Testimoni ] End -->
@endsection

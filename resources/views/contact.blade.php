@extends('layouts.landing')

@section('title', 'Hubungi Kami')

@section('content')

    <header class="contact-hero"
        style="position: relative; padding: 100px 0; background: url('{{ asset('assets/images/my/join-us.png') }}') no-repeat center center; background-size: cover;">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background-color: rgba(0, 0, 0, 0.5);"></div>
        <div class="container">
            <div class="row justify-content-center text-center text-light">
                <div class="col-md-8 col-lg-6">
                    <h1 class="text-white display-4">Hubungi <span class="text-primary">Kami</span></h1>
                    <p class="text-white-75 lead">
                        Silakan hubungi kami untuk pertanyaan, informasi, atau bantuan lebih lanjut terkait proses
                        pengaduan atau pengajuan.
                    </p>
                </div>
            </div>
        </div>
    </header>

    <section class="contact-form">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-md-10 col-xl-5 mb-4">
                    <h5 class="text-primary mb-0">Tetap Terhubung</h5>
                    <h2 class="my-3">Kirim Pesan Anda</h2>
                    <p class="text-muted">Kami siap membantu menjawab setiap pertanyaan Anda. Silakan isi formulir di bawah
                        ini.</p>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xxl-6 col-md-8 col-sm-10">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Nama Lengkap">
                        </div>
                        <div class="col-md-6">
                            <input type="email" class="form-control" placeholder="Alamat Email">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <input type="text" class="form-control" placeholder="Subjek Pesan">
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <textarea class="form-control form-control-lg" rows="4" placeholder="Tuliskan pesan Anda di sini..."></textarea>
                        </div>
                    </div>
                    <div class="form-check mt-3 text-start">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            Saya setuju dengan <a href="#" class="link-primary"> Kebijakan Privasi</a>.
                        </label>
                    </div>
                    <div class="mt-3 text-end">
                        <button type="button" class="btn btn-primary">Kirim Pesan</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

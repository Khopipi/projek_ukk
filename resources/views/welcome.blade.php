<!-- FULL REVISED LANDING PAGE WITH PREMIUM MODERN DESIGN -->
@extends('layouts.landing')
@section('title', 'Selamat Datang di Aplikasi Desa Sruni')

@section('content')

<!-- Include Google Font: Poppins + Inter -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* ===== GLOBAL STYLES ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        font-family: 'Inter', sans-serif;
        color: #1a1a1a;
        scroll-behavior: smooth;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        letter-spacing: -0.8px;
    }

    p {
        font-weight: 400;
        line-height: 1.8;
        color: #555;
    }

    /* ===== ANIMATIONS ===== */
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-60px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(60px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(60px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes glow {
        0%, 100% {
            box-shadow: 0 0 20px rgba(0, 132, 255, 0.3);
        }
        50% {
            box-shadow: 0 0 40px rgba(0, 132, 255, 0.6);
        }
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    .animate-fade-in-down {
        animation: fadeInDown 1s ease-out;
    }

    .animate-fade-in-up {
        animation: fadeInUp 1s ease-out;
        animation-delay: 0.2s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    .animate-slide-in-right {
        animation: slideInRight 1s ease-out;
        animation-delay: 0.4s;
        opacity: 0;
        animation-fill-mode: forwards;
    }

    /* ===== HERO SECTION PREMIUM ===== */
    .hero-section {
        position: relative;
        min-height: 100vh;
        background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 50%, #16213e 100%);
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 60px 20px;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('{{ asset('assets/images/my/sruni_full.jpg') }}') center/cover;
        opacity: 0.4;
        z-index: 0;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(26, 26, 46, 0.85) 0%, rgba(15, 52, 96, 0.85) 50%, rgba(22, 33, 62, 0.85) 100%);
        z-index: 1;
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        max-width: 900px;
    }

    .hero-content h1 {
        font-size: 4.5rem;
        color: white;
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 20px;
        text-shadow: 0 4px 20px rgba(0, 0, 0, 0.5);
        letter-spacing: -1px;
    }

    .hero-content h1 .text-primary {
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content p {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.3rem;
        max-width: 800px;
        margin: 25px auto 40px;
        font-weight: 400;
        line-height: 1.8;
    }

    .hero-buttons {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    /* ===== BUTTON STYLES ===== */
    .btn-primary-modern {
        padding: 16px 40px;
        font-size: 1.05rem;
        font-weight: 600;
        border-radius: 14px;
        border: none;
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%);
        color: white;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 10px 30px rgba(0, 132, 255, 0.4);
        text-decoration: none;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    .btn-primary-modern:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 45px rgba(0, 212, 255, 0.5);
    }

    .btn-primary-modern:active {
        transform: translateY(-2px);
    }

    .btn-secondary-modern {
        padding: 16px 40px;
        font-size: 1.05rem;
        font-weight: 600;
        border-radius: 14px;
        border: 2px solid rgba(255, 255, 255, 0.4);
        background: rgba(0, 132, 255, 0.15);
        color: white;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        backdrop-filter: blur(10px);
        text-decoration: none;
        display: inline-block;
        letter-spacing: 0.5px;
    }

    .btn-secondary-mphpmodern:hover {
        background: rgba(0, 132, 255, 0.25);
        border-color: rgba(255, 255, 255, 0.6);
        transform: translateY(-6px);
        box-shadow: 0 15px 40px rgba(0, 132, 255, 0.3);
    }

    /* ===== FEATURES SECTION ===== */
    .features-section {
        padding: 100px 20px;
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
    }

    .section-header {
        text-align: center;
        margin-bottom: 80px;
    }

    .section-header .badge {
        display: inline-block;
        padding: 8px 20px;
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%);
        color: white;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 15px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .section-header h2 {
        font-size: 3rem;
        color: #1a1a1a;
        margin-bottom: 20px;
    }

    .section-header p {
        font-size: 1.1rem;
        color: #666;
        max-width: 600px;
        margin: 0 auto;
    }

    /* ===== FEATURE CARDS - MODERN ===== */
    .feature-card {
        background: white;
        border-radius: 20px;
        padding: 45px 35px;
        border: 2px solid #e8eef9;
        transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease;
    }

    .feature-card:hover {
        transform: translateY(-15px);
        border-color: #bae6fd;
        box-shadow: 0 25px 50px rgba(0, 132, 255, 0.15);
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-card .icon {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(0, 132, 255, 0.1) 0%, rgba(0, 212, 255, 0.1) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }

    .feature-card:hover .icon {
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%);
        transform: scale(1.1);
    }

    .feature-card h5 {
        font-size: 1.4rem;
        color: #1a1a1a;
        margin-bottom: 15px;
    }

    .feature-card p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.7;
    }

    /* ===== CTA SECTION - MODERN GRADIENT ===== */
    .cta-section {
        position: relative;
        padding: 100px 20px;
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 50%, #0f3460 100%);
        color: white;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .cta-section::after {
        content: '';
        position: absolute;
        bottom: -50%;
        left: -10%;
        width: 600px;
        height: 600px;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        border-radius: 50%;
        z-index: 0;
    }

    .cta-content {
        position: relative;
        z-index: 1;
        text-align: center;
        max-width: 800px;
        margin: 0 auto;
    }

    .cta-content h2 {
        font-size: 3rem;
        margin-bottom: 20px;
        line-height: 1.3;
    }

    .cta-content p {
        color: rgba(255, 255, 255, 0.95);
        font-size: 1.15rem;
        margin-bottom: 40px;
    }

    /* ===== STATISTICS SECTION ===== */
    .stats-section {
        padding: 100px 20px;
        background: white;
    }

    .stat-card {
        text-align: center;
        padding: 40px 30px;
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        border-radius: 18px;
        border: 2px solid #e8eef9;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .stat-card:hover {
        transform: translateY(-12px);
        border-color: #bae6fd;
        box-shadow: 0 20px 45px rgba(0, 132, 255, 0.15);
    }

    .stat-number {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(135deg, #0084ff 0%, #00d4ff 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 15px;
    }

    .stat-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: #1a1a1a;
        margin-bottom: 10px;
    }

    .stat-desc {
        font-size: 0.95rem;
        color: #666;
        line-height: 1.6;
    }

    /* ===== CONTAINER ===== */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .hero-content h1 {
            font-size: 2.8rem;
        }

        .hero-content p {
            font-size: 1rem;
        }

        .hero-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn-primary-modern,
        .btn-secondary-modern {
            width: 100%;
            max-width: 350px;
        }

        .section-header h2 {
            font-size: 2rem;
        }

        .cta-content h2 {
            font-size: 2rem;
        }

        .stat-number {
            font-size: 2.5rem;
        }
    }
</style>

<!-- HERO SECTION -->
<header class="hero-section">
    <div class="hero-content">
        <!-- ANIMATED TITLE -->
        <h1 class="animate-fade-in-down">
            Selamat Datang di <br>
            <span class="text-primary">Aplikasi Desa Sruni</span>
        </h1>

        <p class="animate-fade-in-up">
            Wujudkan Tata Kelola Pemerintahan Desa yang <strong>Cepat, Transparan, dan Akuntabel</strong>.<br>
            Akses layanan administrasi dan informasi publik secara online dengan mudah dan aman.
        </p>

        <div class="hero-buttons animate-fade-in-up">
            <a href="{{ route('register') }}" class="btn-primary-modern">Daftar Akun Sekarang</a>
            <a href="#features" class="btn-secondary-modern">Jelajahi Layanan</a>
        </div>
    </div>
</header>

<!-- FEATURES SECTION -->
<section class="features-section" id="features">
    <div class="container">
        <div class="section-header">
            <div class="badge">✨ Fitur Unggulan</div>
            <h2>Layanan Digital Terpadu untuk Desa Sruni</h2>
            <p>Kami menghadirkan solusi administrasi desa yang modern, efisien, dan mudah diakses oleh semua warga.</p>
        </div>

        <div class="row">
            <div class="feature-card">
                <div class="icon">📋</div>
                <h5>Pengajuan Surat Online</h5>
                <p>Urus surat keterangan, surat domisili, surat nikah, dan dokumen penting lainnya langsung dari rumah tanpa perlu antri.</p>
            </div>

            <div class="feature-card">
                <div class="icon">📢</div>
                <h5>Informasi Publik Real-time</h5>
                <p>Dapatkan update terbaru tentang berita, program, dan kegiatan desa kapan saja, di mana saja dengan notifikasi real-time.</p>
            </div>

            <div class="feature-card">
                <div class="icon">💬</div>
                <h5>Saluran Pengaduan Warga</h5>
                <p>Laporkan masalah dan keluhan secara aman dan terpercaya dengan sistem pelacakan status pengaduan yang transparan.</p>
            </div>

            <div class="feature-card">
                <div class="icon">📊</div>
                <h5>Dashboard Transparansi</h5>
                <p>Akses laporan keuangan, program pembangunan, dan kegiatan desa secara terbuka dengan visualisasi data yang mudah dipahami.</p>
            </div>

            <div class="feature-card">
                <div class="icon">👥</div>
                <h5>Manajemen Data Penduduk</h5>
                <p>Kelola data kependudukan dengan sistem yang terorganisir, aman, dan memudahkan akses informasi administratif.</p>
            </div>

            <div class="feature-card">
                <div class="icon">🔒</div>
                <h5>Keamanan Data Terjamin</h5>
                <p>Data pribadi Anda dilindungi dengan enkripsi tingkat tinggi dan sistem keamanan berlapis untuk privasi maksimal.</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Bergabunglah dengan Revolusi Digital Desa</h2>
            <p>Mari bersama-sama membangun Desa Sruni yang lebih maju, transparan, dan sejahtera melalui teknologi digital yang inovatif.</p>
            <a href="{{ route('register') }}" class="btn-primary-modern">Mulai Perjalanan Digital Anda</a>
        </div>
    </div>
</section>

<!-- STATISTICS SECTION -->
<section class="stats-section">
    <div class="container">
        <div class="section-header" style="margin-bottom: 60px;">
            <div class="badge">📈 Pencapaian Kami</div>
            <h2>Dipercaya oleh Ribuan Warga Desa</h2>
        </div>

        <div class="row">
            <div class="stat-card">
                <div class="stat-number">5000+</div>
                <div class="stat-label">Penduduk Terdaftar</div>
                <div class="stat-desc">Warga aktif yang memanfaatkan layanan digital desa untuk administrasi dan informasi publik.</div>
            </div>

            <div class="stat-card">
                <div class="stat-number">25+</div>
                <div class="stat-label">Layanan Online</div>
                <div class="stat-desc">Berbagai jenis layanan administrasi desa kini dapat diakses dan diselesaikan secara digital dan transparan.</div>
            </div>

            <div class="stat-card">
                <div class="stat-number">100%</div>
                <div class="stat-label">Transparansi</div>
                <div class="stat-desc">Semua laporan, kegiatan, dan data publik desa tersedia terbuka untuk akses dan pengawasan warga.</div>
            </div>
        </div>
    </div>
</section>

@endsection

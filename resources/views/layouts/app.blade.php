<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('description', 'LensRent - Sistem Penyewaan Alat Fotografi')">
    <title>@yield('title', 'LensRent')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body>

<nav>
    <div class="nav-left">
        <div class="logo-icon">
            <img src="{{ asset('image/logo_lensrent.png') }}" alt="Logo LensRent">
        </div>
        <span class="logo-text">LensRent</span>
    </div>
    <div class="menu" id="menu">
        <a href="{{ route('home') }}" class="@yield('active_home')">Home</a>
        <a href="{{ route('kamera.index') }}" class="@yield('active_kamera')">Data Kamera</a>
        <a href="{{ route('sewa.form') }}" class="@yield('active_sewa')">Penyewaan</a>
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu">☰</button>
</nav>

<main>
    @yield('content')
</main>

<footer>
    <div class="footer-section">
        <h3>📸 LensRent</h3>
        <p>Sewa kamera mudah dan cepat.</p>
        <p class="copyright">© 2024 LensRent. All rights reserved.</p>
    </div>
    <div class="footer-section">
        <h3>🔗 Navigasi</h3>
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('kamera.index') }}">Data Kamera</a>
        <a href="{{ route('sewa.form') }}">Penyewaan</a>
    </div>
    <div class="footer-section">
        <h3>📞 Kontak Kami</h3>
        <p>📍 Jl. Fotografi No. 123, Jakarta</p>
        <p>📞 (021) 1234-5678</p>
        <p>✉️ info@lensrent.com</p>
    </div>
</footer>

<script src="{{ asset('js/script.js') }}"></script>
@stack('scripts')
</body>
</html>

<nav>
    <div class="nav-left">
        <div class="logo-icon">
            <img src="{{ asset('image/logo_lensrent.png') }}" alt="Logo LensRent">
        </div>
        <span class="logo-text">LensRent</span>
    </div>
    <div class="menu" id="menu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
        <a href="{{ route('kamera.index') }}" class="{{ request()->routeIs('kamera.*') ? 'active' : '' }}">Data Kamera</a>
        <a href="{{ route('sewa.form') }}" class="{{ request()->routeIs('sewa.*') ? 'active' : '' }}">Penyewaan</a>
    </div>
    <button class="hamburger" id="hamburger" aria-label="Menu">☰</button>
</nav>

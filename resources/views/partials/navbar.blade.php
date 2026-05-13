<nav>
    <div class="nav-left">
        <div class="logo-icon">
            <img src="{{ asset('image/logo_lensrent.png') }}" alt="Logo">
        </div>
        <span class="logo-text">LensRent</span>
    </div>
    <div class="menu" id="menu">
        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

        @auth
            <a href="{{ route('kamera.index') }}" class="{{ request()->routeIs('kamera.*') ? 'active' : '' }}">Data Kamera</a>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('sewa.index') }}">Semua Penyewaan</a>
            @else
                <a href="{{ route('sewa.index') }}">Penyewaan Saya</a>
            @endif

            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="logout-button">Logout ({{ auth()->user()->name }})</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
    <button class="hamburger" id="hamburger">☰</button>
</nav>

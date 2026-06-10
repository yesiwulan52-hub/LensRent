<nav>
    <div class="nav-left">
        <div class="logo-icon">
            <img src="{{ asset('image/logo_lensrent.png') }}" alt="Logo">
        </div>
        <span class="logo-text">LensRent</span>
    </div>
    <div class="menu" id="menu">
        <a href="{{ route('home') }}">Home</a>

        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('kamera.index') }}">Data Kamera</a>
                <a href="{{ route('sewa.index') }}">Semua Penyewaan</a>
            @else
                <a href="{{ route('kamera.index') }}">Data Kamera</a>
                <a href="{{ route('sewa.index') }}">Penyewaan Saya</a>
            @endif

            <!-- Dark mode toggle button -->
            <button id="darkModeToggle" class="dark-mode-btn" aria-label="Toggle Dark mode">🌙</button>

            <!-- User Profile Dropdown -->
            <div class="nav-user-dropdown" id="navUserDropdown">
                <button class="nav-user-btn" id="navUserBtn" onclick="toggleUserDropdown()">
                    <span class="nav-user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    <span class="nav-user-name">{{ auth()->user()->name }}</span>
                    <span class="nav-chevron">▾</span>
                </button>
                <div class="nav-dropdown-menu" id="navDropdownMenu">
                    <a href="{{ route('profile.show') }}" class="nav-dropdown-item">
                        <span>👤</span> Profil Saya
                    </a>
                    <a href="{{ route('profile.edit') }}" class="nav-dropdown-item">
                        <span>✏️</span> Edit Profil
                    </a>
                    <div class="nav-dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="nav-dropdown-item nav-dropdown-logout">
                            <span>🚪</span> Logout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </div>
    <button class="hamburger" id="hamburger">☰</button>
</nav>

<script>
function toggleUserDropdown() {
    const menu = document.getElementById('navDropdownMenu');
    const btn = document.getElementById('navUserBtn');
    menu.classList.toggle('show');
    btn.classList.toggle('active');
}
// Close dropdown when clicking outside
document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('navUserDropdown');
    if (dropdown && !dropdown.contains(e.target)) {
        document.getElementById('navDropdownMenu')?.classList.remove('show');
        document.getElementById('navUserBtn')?.classList.remove('active');
    }
});
</script>

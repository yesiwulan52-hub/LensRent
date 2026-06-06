@extends('layouts.app')

@section('title', 'LensRent - Sistem Penyewaan Alat Fotografi')
@section('description', 'Sewa kamera profesional dengan mudah, cepat, dan aman')
@section('active_home', 'active')

@section('content')
<header class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1>Sistem Penyewaan Alat Fotografi</h1>
        <p>Sewa kamera profesional dengan mudah, cepat, dan aman</p>
    </div>
</header>

<div class="container">
    <!-- Sidebar Kiri -->
    <aside class="sidebar">
        <div class="widget">
            <h3>📊 Statistik</h3>
            <div class="stat-item"><span class="stat-label">Total Kamera:</span><span class="stat-value">{{ \App\Models\Kamera::sum('jumlah') }}</span></div>
            <div class="stat-item"><span class="stat-label">Tersedia:</span><span class="stat-value">{{ max(\App\Models\Kamera::sum('jumlah') - \App\Models\Sewa::sum('jumlah_unit'), 0) }}</span></div>
            <div class="stat-item"><span class="stat-label">Disewa:</span><span class="stat-value">{{ \App\Models\Sewa::sum('jumlah_unit') }}</span></div>
        </div>

        <div class="widget">
            <h3>🏷️ Filter Kategori</h3>
            <label class="checkbox-label"><input type="checkbox" class="filter-kategori" value="DSLR"> 📸 DSLR</label>
            <label class="checkbox-label"><input type="checkbox" class="filter-kategori" value="Mirrorless"> 🔄 Mirrorless</label>
        </div>

        <div class="widget">
            <h3>💰 Info Harga Sewa</h3>
            <p>📷 Mirrorless: <strong>Rp150.000 - Rp250.000</strong></p>
            <p>🎥 DSLR: <strong>Rp180.000 - Rp200.000</strong></p>
            <p>💳 DP 50% untuk sewa >3 hari</p>
        </div>

        <div class="widget">
            <h3>💡 Tips Sewa</h3>
            <p>✅ Minimal sewa 1 hari</p>
            <p>✅ Asuransi tersedia</p>
            <p>✅ Free delivery area Jakarta</p>
        </div>
    </aside>

    <div class="main-content">
        <section class="deskripsi-card">
            <h2>Tentang LensRent</h2>
            <p><b>LensRent</b> adalah sistem penyewaan alat fotografi yang dirancang untuk memudahkan pengguna dalam menemukan dan menyewa berbagai peralatan fotografi secara praktis dan efisien. LensRent hadir sebagai solusi bagi para fotografer pemula hingga profesional.</p>
            <div class="highlight">
                <span>✨ 500+ Pelanggan Puas</span>
                <span>⭐ 4.9/5 Rating</span>
                <span>🚚 Free Delivery</span>
                <span>🛡️ Garansi 100%</span>
            </div>
        </section>

        <section class="kamera-populer">
            <div class="section-header">
                <h2>📷 Kamera Populer</h2>
                <div class="search-box">
                    <input type="text" id="searchKamera" placeholder="🔍 Cari kamera...">
                    <button id="btnCari">Cari</button>
                </div>
            </div>
            <div class="grid" id="kameraGrid">
                @forelse ($kameras as $k)
                <div class="card" data-nama="{{ $k->nama }}" data-kategori="{{ $k->kategori }}">
                    <img src="{{ $k->foto ? asset($k->foto) : 'https://placehold.co/400x300' }}" alt="{{ $k->nama }}">
                    <h4>{{ $k->nama }}</h4>
                    <p>Rp {{ number_format($k->harga, 0, ',', '.') }}<span>/hari</span></p>
                    <small>{{ $k->kategori }} | Stok: {{ $k->jumlah }}</small>
                </div>
                @empty
                <p>Tidak ada kamera</p>
                @endforelse
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Filter Live Search (Nama Kamera)
    const searchInput = document.getElementById('searchKamera');
    const cards = document.querySelectorAll('.card');
    const filterCheckboxes = document.querySelectorAll('.filter-kategori');

    function filterCards() {
        const keyword = searchInput ? searchInput.value.toLowerCase() : '';
        const selectedCategories = Array.from(filterCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        cards.forEach(card => {
            const nama = card.getAttribute('data-nama').toLowerCase();
            const kategori = card.getAttribute('data-kategori');
            const matchName = nama.includes(keyword);
            const matchCat = (selectedCategories.length === 0 || selectedCategories.includes(kategori));
            card.style.display = (matchName && matchCat) ? 'block' : 'none';
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const keyword = this.value.toLowerCase();
            cards.forEach(card => {
                const nama = card.getAttribute('data-nama').toLowerCase();
                card.style.display = nama.includes(keyword) ? 'block' : 'none';
            });
        });
    }

    // filterCheckboxes.forEach(cb => cb.addEventListener('change', applyCategoryFilter));
</script>
@endpush

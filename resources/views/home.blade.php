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
            <div class="stat-item"><span class="stat-label">Total Kamera:</span><span class="stat-value" id="statTotalKamera">0</span></div>
            <div class="stat-item"><span class="stat-label">Tersedia:</span><span class="stat-value" id="statTersedia">0</span></div>
            <div class="stat-item"><span class="stat-label">Disewa:</span><span class="stat-value" id="statDisewa">0</span></div>
            <div class="stat-item warning"><span class="stat-label">⚠️ Stok Menipis (&lt;3):</span><span class="stat-value" id="statStokMenipis">0</span></div>
            <div class="stat-item"><span class="stat-label">💰 Pendapatan:</span><span class="stat-value" id="statPendapatan">Rp 0</span></div>
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
            <button id="btnResetData" class="btn-reset">🔄 Reset Semua Data</button>
        </div>
    </aside>

    <!-- Konten Utama -->
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
                <div class="skeleton-card">Loading...</div>
            </div>
        </section>
    </div>
</div>
@endsection

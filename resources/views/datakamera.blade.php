@extends('layouts.app')

@section('title', 'LensRent - Data Kamera')
@section('description', 'Kelola daftar kamera yang tersedia untuk disewakan')
@section('active_kamera', 'active')

@section('content')
<header class="hero-small">
    <div class="hero-content">
        <h1>Data Kamera</h1>
        <p>Kelola daftar kamera yang tersedia untuk disewakan</p>
    </div>
</header>

<div class="container">
    <aside class="sidebar">
        <div class="widget">
            <h3>📊 Statistik</h3>
            <div class="stat-item"><span class="stat-label">Total Kamera:</span><span class="stat-value" id="statTotalKamera">0</span></div>
            <div class="stat-item"><span class="stat-label">Tersedia:</span><span class="stat-value" id="statTersedia">0</span></div>
            <div class="stat-item"><span class="stat-label">Disewa:</span><span class="stat-value" id="statDisewa">0</span></div>
            <div class="stat-item warning"><span class="stat-label">⚠️ Stok Menipis:</span><span class="stat-value" id="statStokMenipis">0</span></div>
        </div>

        <div class="widget">
            <h3>🏷️ Filter Kategori</h3>
            <label class="checkbox-label"><input type="checkbox" class="filter-kategori" value="DSLR"> 📸 DSLR</label>
            <label class="checkbox-label"><input type="checkbox" class="filter-kategori" value="Mirrorless"> 🔄 Mirrorless</label>
        </div>

        <div class="widget">
            <h3>💡 Info</h3>
            <p>Klik Edit untuk mengubah data</p>
            <p>Klik Hapus untuk menghapus data</p>
            <button id="btnResetData" class="btn-reset">🔄 Reset Data</button>
        </div>
    </aside>

    <div class="main-content">
        <div class="section-header">
            <h2>📋 Manajemen Kamera</h2>
            <button id="btnTambah" class="btn-primary">+ Tambah Kamera</button>
        </div>

        <div id="formWrapper" class="form-wrapper" style="display: none;">
            <h3 id="judulForm">Tambah Kamera</h3>
            <form id="formKamera">
                <div class="form-row">
                    <div class="form-group"><label>Kode *</label><input type="text" id="fKode" placeholder="K007" required></div>
                    <div class="form-group"><label>Nama *</label><input type="text" id="fNama" placeholder="Canon EOS R6" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Kategori</label><select id="fKategori"><option>Mirrorless</option><option>DSLR</option></select></div>
                    <div class="form-group"><label>Jumlah</label><input type="number" id="fJumlah" min="1" required></div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Harga/Hari</label><input type="number" id="fHarga" min="1000" required></div>
                    <div class="form-group"><label>Foto URL</label><input type="text" id="fFoto" placeholder="Opsional"></div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn-save">💾 Simpan</button>
                    <button type="button" id="btnBatal" class="btn-cancel">❌ Batal</button>
                </div>
            </form>
        </div>

        <div class="search-box">
            <input type="text" id="search-kamera" placeholder="🔍 Cari kode atau nama kamera...">
        </div>

        <div id="kamera-table-container">
            @include('partials.kamera_table', ['kameras' => $kameras])
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-kamera');
    if (!searchInput) return;

    let debounceTimer;
    searchInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            const keyword = this.value.trim();
            const url = `{{ route('kamera.search') }}?q=${encodeURIComponent(keyword)}`;

            fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(response => response.text())
            .then(html => {
                document.getElementById('kamera-table-container').innerHTML = html;
            })
            .catch(error => {
                console.error('Search error:', error);
                document.getElementById('kamera-table-container').innerHTML = '<p class="text-center text-danger">Terjadi kesalahan saat mencari data.</p>';
            });
        }, 300); // delay 300ms setelah selesai mengetik
    });
});
</script>
@endpush

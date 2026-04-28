@extends('layouts.app')

@section('title', 'Dashboard - LensRent')
@section('active_dashboard', 'active') {{-- Optional jika ingin menu dashboard --}}

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="deskripsi-card">
        <h1>📊 Dashboard LensRent</h1>
        <div id="dashboardStats">
            <p>Total Kamera: <span id="statTotalKamera">0</span></p>
            <p>Tersedia: <span id="statTersedia">0</span></p>
            <p>Disewa: <span id="statDisewa">0</span></p>
            <p>Pendapatan: <span id="statPendapatan">Rp 0</span></p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updateDashboard() {
        const kamera = JSON.parse(localStorage.getItem('lensrent_kamera')) || [];
        const sewa = JSON.parse(localStorage.getItem('lensrent_sewa')) || [];
        const totalKamera = kamera.reduce((s, k) => s + k.jumlah, 0);
        const totalDisewa = sewa.reduce((s, sw) => s + sw.jumlah, 0);
        const totalTersedia = Math.max(totalKamera - totalDisewa, 0);
        const totalPendapatan = sewa.reduce((s, sw) => s + sw.total, 0);
        document.getElementById('statTotalKamera').innerText = totalKamera;
        document.getElementById('statTersedia').innerText = totalTersedia;
        document.getElementById('statDisewa').innerText = totalDisewa;
        document.getElementById('statPendapatan').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPendapatan);
    }
    updateDashboard();
    window.addEventListener('storage', updateDashboard);
</script>
@endpush

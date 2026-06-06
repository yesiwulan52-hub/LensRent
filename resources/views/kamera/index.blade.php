@extends('layouts.app')
@section('title', 'Data Kamera')
@section('content')
<div class="container" style="margin-top: 85px;">
    <div class="section-header">
        <h2>Daftar Kamera</h2>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('kamera.create') }}" class="btn-primary">+ Tambah Kamera</a>
            @endif
        @endauth
    </div>

    <div class="search-box">
        <input type="text" id="search-kamera" placeholder="🔍 Cari kode atau nama kamera...">
        <div id="search-loading" style="display:none; text-align:center; padding:10px;">Memuat...</div>
    </div>

    <div id="kamera-table-container">
        @include('partials.kamera_table', ['kameras' => $kameras])
    </div>
</div>

<!-- Modal konfirmasi hapus -->
<div id="deleteModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center; z-index:1000;">
    <div style="background:white; padding:20px; border-radius:8px; text-align:center;">
        <p>Yakin ingin menghapus data ini?</p>
        <button id="confirmDelete" class="btn-save">Ya, Hapus</button>
        <button id="cancelDelete" class="btn-cancel">Batal</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Modal delete handler
    let deleteForm = null;
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-hapus')) {
            e.preventDefault();
            deleteForm = e.target.closest('form');
            document.getElementById('deleteModal').style.display = 'flex';
        }
    });
    document.getElementById('confirmDelete').onclick = () => { if(deleteForm) deleteForm.submit(); };
    document.getElementById('cancelDelete').onclick = () => { document.getElementById('deleteModal').style.display = 'none'; };
</script>
@endpush

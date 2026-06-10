@extends('layouts.app')
@section('title', 'Tambah Kamera')
@section('content')
<div class="container">
    <div class="form-card">
        <h2>Tambah Kamera Baru</h2>
        <form action="{{ route('kamera.store') }}" method="POST" enctype="multipart/form-data" id="formKamera">
            @csrf
            @method('POST')
            @include('kamera._form')
            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan</button>
                <a href="{{ route('kamera.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('formKamera').addEventListener('submit', function(e) {
        let kode = document.querySelector('[name="kode"]').value.trim();
        let nama = document.querySelector('[name="nama"]').value.trim();
        let jumlah = parseInt(document.querySelector('[name="jumlah"]').value);
        let harga = parseInt(document.querySelector('[name="harga"]').value);
        let errors = [];

        if (kode === '') errors.push('Kode wajib diisi');
        if (nama.length < 3) errors.push('Nama minimal 3 karakter');
        if (isNaN(jumlah) || jumlah <= 0) errors.push('Stok harus > 0');
        if (isNaN(harga) || harga < 1000) errors.push('Harga minimal Rp 1000');

        if (errors.length) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>
@endpush

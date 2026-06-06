@extends('layouts.app')
@section('title', 'Edit Kamera')
@section('content')
<div class="container">
    <div class="form-card">
        <h2>Edit Kamera</h2>
        <form action="{{ route('kamera.update', $kamera->id) }}" method="POST" enctype="multipart/form-data" id="formEditKamera">
            @csrf
            @method('PUT')
            @include('kamera._form', ['kamera' => $kamera])
            <div class="form-actions">
                <button type="submit" class="btn-save">Update</button>
                <a href="{{ route('kamera.index') }}" class="btn-cancel">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('formEditKamera').addEventListener('submit', function(e) {
        const kode = document.querySelector('[name="kode"]').value.trim();
        const nama = document.querySelector('[name="nama"]').value.trim();
        const jumlah = parseInt(document.querySelector('[name="jumlah"]').value, 10);
        const harga = parseInt(document.querySelector('[name="harga"]').value, 10);
        const errors = [];

        if (kode === '') errors.push('Kode kamera wajib diisi.');
        if (nama.length < 3) errors.push('Nama kamera minimal 3 karakter.');
        if (isNaN(jumlah) || jumlah < 0) errors.push('Stok harus berupa angka >= 0.');
        if (isNaN(harga) || harga < 1000) errors.push('Harga minimal Rp 1.000.');

        if (errors.length > 0) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>
@endpush

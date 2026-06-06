@extends('layouts.app')
@section('title', 'Detail Kamera')
@section('content')
<div class="container" style="margin-top:100px;">
    <div class="form-card">
        <h2>{{ $kamera->nama }}</h2>
        <div class="row">
            <div class="col-md-5">
                <img src="{{ $kamera->foto ? asset($kamera->foto) : 'https://placehold.co/400x300' }}" style="width:100%; border-radius:8px;">
            </div>
            <div class="col-md-7">
                <p><strong>Kode:</strong> {{ $kamera->kode }}</p>
                <p><strong>Kategori:</strong> {{ $kamera->kategori }}</p>
                <p><strong>Stok:</strong> {{ $kamera->jumlah }}</p>
                <p><strong>Harga/hari:</strong> Rp {{ number_format($kamera->harga, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> {{ $kamera->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                <a href="{{ route('kamera.index') }}" class="btn-cancel">Kembali</a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Tambah Kamera')
@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="form-card">
        <h2>Tambah Kamera Baru</h2>
        <form action="{{ route('kamera.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('kamera._form')
            <div class="form-actions">
                <button type="submit" class="btn-save">Simpan</button>
                <a href="{{ route('kamera.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

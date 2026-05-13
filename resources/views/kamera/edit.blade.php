@extends('layouts.app')
@section('title', 'Edit Kamera')
@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="form-card">
        <h2>Edit Kamera</h2>
        <form action="{{ route('kamera.update', $kamera->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('kamera._form', ['kamera' => $kamera])
            <div class="form-actions">
                <button type="submit" class="btn-save">Update</button>
                <a href="{{ route('kamera.index') }}" class="btn-cancel">Kembali</a>
            </div>
        </form>
    </div>
</div>
@endsection

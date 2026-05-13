@extends('layouts.app')

@section('title', 'Register LensRent')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="form-card" style="width: 500px; margin: 0 auto;">
        <h2>Daftar Akun Baru</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-group">
                <label>Nama Lengkap *</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Konfirmasi Password *</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Register</button>
            </div>

            <p style="text-align: center; margin-top: 20px;">
                Sudah punya akun? <a href="{{ route('login') }}">Login</a>
            </p>
        </form>
    </div>
</div>
@endsection

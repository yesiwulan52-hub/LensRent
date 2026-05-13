@extends('layouts.app')

@section('title', 'Login LensRent')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="form-card" style="width: 500px; margin: 0 auto;">
        <h2>Login LensRent</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label>Password *</label>
                <input type="password" name="password" required>
                @error('password')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-checkbox">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Ingat saya</label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-save">Login</button>
            </div>

            @if (Route::has('password.request'))
                <div style="text-align: center; margin-top: 15px;">
                    <a href="{{ route('password.request') }}">Lupa password?</a>
                </div>
            @endif

            <p style="text-align: center; margin-top: 20px;">
                Belum punya akun? <a href="{{ route('register') }}">Register</a>
            </p>
        </form>
    </div>
</div>
@endsection

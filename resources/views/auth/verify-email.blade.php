@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="form-card" style="max-width: 500px; margin: 0 auto;">
        <h2>Login LensRent</h2>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label>
                    <input type="checkbox" name="remember"> Remember me
                </label>
            </div>

            <button type="submit" class="btn-save">Login</button>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="display: block; margin-top: 10px;">Lupa password?</a>
            @endif

            <p class="mt-3">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
        </form>
    </div>
</div>
@endsection

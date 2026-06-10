@extends('layouts.app')
@section('title', 'Profil Saya - LensRent')
@section('content')
<div class="container" style="max-width: 600px; display:block; padding: 40px 20px;">

    <h2 style="margin-bottom: 24px;">👤 Profil Saya</h2>

    <div class="form-card" style="background: white; border-radius: 12px; padding: 28px; box-shadow: 0 2px 10px rgba(0,0,0,0.07);">

        <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px; padding-bottom:20px; border-bottom:1px solid #EDE0D4;">
            <div style="width:60px; height:60px; background: linear-gradient(135deg,#6B4C3A,#A0522D); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:26px; font-weight:800; color:white; flex-shrink:0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:18px; font-weight:700; color:#4A3728;">{{ auth()->user()->name }}</div>
                <div style="color:#8B6248; font-size:14px;">{{ auth()->user()->email }}</div>
                <span style="display:inline-block; margin-top:4px; padding:2px 10px; border-radius:20px; font-size:12px; font-weight:600; background: {{ auth()->user()->role === 'admin' ? '#FEF3C7' : '#EDE0D4' }}; color: {{ auth()->user()->role === 'admin' ? '#92400E' : '#6B4C3A' }};">
                    {{ auth()->user()->role === 'admin' ? '👑 Admin' : '👤 Customer' }}
                </span>
            </div>
        </div>

        <table style="width:100%; border-collapse:collapse;">
            <tr>
                <td style="padding:10px 0; color:#8B6248; font-size:14px; width:40%;">Nama</td>
                <td style="padding:10px 0; color:#4A3728; font-weight:600;">{{ auth()->user()->name }}</td>
            </tr>
            <tr style="border-top:1px solid #F5EFE6;">
                <td style="padding:10px 0; color:#8B6248; font-size:14px;">Email</td>
                <td style="padding:10px 0; color:#4A3728; font-weight:600;">{{ auth()->user()->email }}</td>
            </tr>
            <tr style="border-top:1px solid #F5EFE6;">
                <td style="padding:10px 0; color:#8B6248; font-size:14px;">Role</td>
                <td style="padding:10px 0; color:#4A3728; font-weight:600;">{{ ucfirst(auth()->user()->role) }}</td>
            </tr>
            <tr style="border-top:1px solid #F5EFE6;">
                <td style="padding:10px 0; color:#8B6248; font-size:14px;">Bergabung</td>
                <td style="padding:10px 0; color:#4A3728; font-weight:600;">{{ auth()->user()->created_at->format('d M Y') }}</td>
            </tr>
        </table>

        <div style="margin-top:24px; padding-top:20px; border-top:1px solid #EDE0D4; display:flex; gap:10px; flex-wrap:wrap;">
            <a href="{{ route('profile.edit') }}" class="btn-save">✏️ Edit Profil</a>
            <a href="{{ route('home') }}" class="btn-cancel">← Kembali</a>
        </div>

    </div>

</div>
@endsection

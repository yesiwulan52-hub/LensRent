@extends('layouts.app')
@section('title', 'Edit Profil - LensRent')
@section('content')
<div class="profile-edit-container">

    <div class="profile-edit-header">
        <div class="profile-edit-back">
            <a href="{{ route('profile.show') }}" class="back-link">← Kembali ke Profil</a>
        </div>
        <h2>⚙️ Edit Profil</h2>
        <p style="color:#8B6248;">Perbarui informasi akun dan pengaturan keamanan kamu</p>
    </div>

    {{-- Update Profile Info --}}
    <div class="profile-edit-card">
        <div class="profile-edit-card-header">
            <span class="pe-icon">👤</span>
            <div>
                <h3>Informasi Profil</h3>
                <p>Perbarui nama dan alamat email akun kamu.</p>
            </div>
        </div>

        <form method="post" action="{{ route('profile.update') }}" class="pe-form">
            @csrf
            @method('patch')

            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div style="margin-top:10px; padding:10px; background:#fff3cd; border-radius:8px; font-size:13px;">
                        ⚠️ Email belum terverifikasi.
                        <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none; border:none; color:#A0522D; text-decoration:underline; cursor:pointer; font-size:13px;">
                                Kirim ulang email verifikasi
                            </button>
                        </form>
                        @if (session('status') === 'verification-link-sent')
                            <p style="color:#27ae60; margin-top:6px;">✅ Link verifikasi baru telah dikirim ke email kamu.</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="pe-form-actions">
                <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
                @if (session('status') === 'profile-updated')
                    <span class="save-success">✅ Profil berhasil diperbarui!</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Update Password --}}
    <div class="profile-edit-card">
        <div class="profile-edit-card-header">
            <span class="pe-icon">🔐</span>
            <div>
                <h3>Ganti Password</h3>
                <p>Gunakan password yang panjang dan unik untuk keamanan akun.</p>
            </div>
        </div>

        <form method="post" action="{{ route('password.update') }}" class="pe-form" id="update-password">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input id="current_password" name="current_password" type="password" autocomplete="current-password">
                @error('current_password', 'updatePassword') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password">Password Baru</label>
                <input id="password" name="password" type="password" autocomplete="new-password">
                @error('password', 'updatePassword') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Konfirmasi Password Baru</label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                @error('password_confirmation', 'updatePassword') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="pe-form-actions">
                <button type="submit" class="btn-save">🔐 Ganti Password</button>
                @if (session('status') === 'password-updated')
                    <span class="save-success">✅ Password berhasil diperbarui!</span>
                @endif
            </div>
        </form>
    </div>

    {{-- Delete Account --}}
    <div class="profile-edit-card profile-danger-card">
        <div class="profile-edit-card-header">
            <span class="pe-icon">⚠️</span>
            <div>
                <h3 style="color:#c0392b;">Hapus Akun</h3>
                <p>Setelah akun dihapus, semua data akan hilang secara permanen.</p>
            </div>
        </div>

        <button id="btnShowDeleteForm" class="btn-danger-delete" onclick="document.getElementById('deleteAccountForm').style.display='block'; this.style.display='none';">
            🗑️ Hapus Akun Saya
        </button>

        <div id="deleteAccountForm" style="display:none; margin-top:16px; padding:20px; background:#fff5f5; border-radius:12px; border:1px solid #f5c6cb;">
            <p style="color:#721c24; font-weight:600; margin-bottom:14px;">⚠️ Apakah kamu yakin ingin menghapus akun? Tindakan ini tidak dapat dibatalkan.</p>
            <form method="post" action="{{ route('profile.destroy') }}" class="pe-form">
                @csrf
                @method('delete')
                <div class="form-group">
                    <label for="password_delete" style="color:#721c24;">Masukkan password untuk konfirmasi</label>
                    <input id="password_delete" name="password" type="password" placeholder="Password kamu" required>
                    @error('password', 'userDeletion') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="pe-form-actions">
                    <button type="submit" class="btn-danger-delete">🗑️ Ya, Hapus Akun</button>
                    <button type="button" class="btn-cancel" onclick="document.getElementById('deleteAccountForm').style.display='none'; document.getElementById('btnShowDeleteForm').style.display='inline-block';">Batal</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* ===== PROFILE EDIT PAGE ===== */
.profile-edit-container {
    max-width: 700px;
    margin: 0 auto;
    padding: 30px 20px 60px;
    display: flex;
    flex-direction: column;
    gap: 24px;
}
.profile-edit-header {
    text-align: center;
    padding: 10px 0;
}
.back-link {
    display: inline-block;
    color: #8B6248;
    text-decoration: none;
    font-size: 14px;
    margin-bottom: 12px;
    transition: color 0.2s;
}
.back-link:hover {
    color: #A0522D;
}
.profile-edit-header h2 {
    margin: 8px 0 4px;
}
.profile-edit-header p {
    font-size: 14px;
}
.profile-edit-card {
    background: white;
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.06);
}
.profile-danger-card {
    border: 2px solid #f5c6cb;
}
.profile-edit-card-header {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    margin-bottom: 24px;
    padding-bottom: 16px;
    border-bottom: 2px solid #F5EFE6;
}
.pe-icon {
    font-size: 26px;
    flex-shrink: 0;
}
.profile-edit-card-header h3 {
    font-size: 17px;
    margin: 0 0 4px;
    color: #4A3728;
}
.profile-edit-card-header p {
    font-size: 13px;
    color: #8B6248;
    margin: 0;
}
.pe-form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}
.pe-form-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-top: 4px;
    flex-wrap: wrap;
}
.save-success {
    color: #27ae60;
    font-size: 14px;
    font-weight: 600;
    animation: fadeIn 0.5s;
}
.btn-danger-delete {
    background: #e74c3c;
    color: white;
    border: none;
    padding: 10px 22px;
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s;
}
.btn-danger-delete:hover {
    background: #c0392b;
    transform: translateY(-1px);
}

/* Dark Mode */
.dark .profile-edit-card {
    background: #2d2d44;
}
.dark .profile-edit-card-header {
    border-bottom-color: #444;
}
.dark .profile-edit-card-header h3 { color: #f0f0f0; }
</style>
@endpush

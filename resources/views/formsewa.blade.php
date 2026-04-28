@extends('layouts.app')

@section('title', 'LensRent - Form Penyewaan')
@section('description', 'Isi data dengan lengkap untuk menyewa kamera')
@section('active_sewa', 'active')

@section('content')
<header class="hero-small">
    <div class="hero-content">
        <h1>Form Penyewaan Kamera</h1>
        <p>Isi data dengan lengkap untuk menyewa kamera</p>
    </div>
</header>

<div class="container">
    <!-- Sidebar Informasi -->
    <aside class="sidebar">
        <div class="widget">
            <h3>ℹ️ Informasi Penting</h3>
            <p>✅ Pastikan data yang diisi sudah benar</p>
            <p>✅ Minimal sewa 1 hari</p>
            <p>✅ DP 50% untuk sewa >3 hari</p>
            <p>✅ Asuransi kerusakan tersedia</p>
            <p>✅ Denda keterlambatan Rp50.000/hari</p>
        </div>
        <div class="widget">
            <h3>💳 Metode Pembayaran</h3>
            <p>🏦 Transfer Bank (BCA/Mandiri/BRI)</p>
            <p>💳 Kartu Kredit</p>
            <p>📱 E-Wallet (OVO/GoPay/Dana)</p>
        </div>
        <div class="widget">
            <h3>📞 Butuh Bantuan?</h3>
            <p>Hubungi CS kami:</p>
            <p>📞 (021) 1234-5678</p>
            <p>💬 WhatsApp: 0823-3855-6742</p>
        </div>
    </aside>

    <!-- Form dan Riwayat -->
    <div class="main-content">
        <div class="form-card">
            <h2>📝 Form Penyewaan</h2>
            <form id="formSewa">
                <fieldset>
                    <legend>Data Penyewa</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label>ID Penyewaan *</label>
                            <input type="number" id="id" placeholder="Contoh: 1001" required>
                            <small class="error-msg" id="errorId"></small>
                        </div>
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" id="nama" placeholder="Nama lengkap" required>
                            <small class="error-msg" id="errorNama"></small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>No. Telepon *</label>
                            <input type="tel" id="telepon" placeholder="081234567890" required>
                            <small class="error-msg" id="errorTelepon"></small>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="email" placeholder="nama@email.com">
                            <small class="error-msg" id="errorEmail"></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" id="alamat" placeholder="Alamat lengkap">
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Data Kamera</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Kode Kamera *</label>
                            <input type="text" id="kode" placeholder="Contoh: K001" required>
                            <small class="error-msg" id="errorKode"></small>
                        </div>
                        <div class="form-group">
                            <label>Pilih Kamera</label>
                            <select id="kameraSelect">
                                <option value="">-- Pilih Kamera --</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Jumlah Unit *</label>
                            <input type="number" id="jumlah" min="1" required>
                            <small class="error-msg" id="errorJumlah"></small>
                        </div>
                        <div class="form-group">
                            <label>Metode Pembayaran *</label>
                            <select id="pembayaran" required>
                                <option value="">-- Pilih --</option>
                                <option>Transfer Bank</option>
                                <option>Cash</option>
                                <option>E-Wallet</option>
                            </select>
                            <small class="error-msg" id="errorPembayaran"></small>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Periode Sewa</legend>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Tanggal Sewa *</label>
                            <input type="date" id="tanggal_sewa" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Kembali *</label>
                            <input type="date" id="tanggal_kembali" required>
                        </div>
                    </div>
                </fieldset>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea id="catatan" rows="3" placeholder="Catatan tambahan (opsional)"></textarea>
                </div>

                <div class="preview-total" id="previewTotal">
                    <strong>💰 Estimasi Total: —</strong>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">✅ Simpan Penyewaan</button>
                    <button type="reset" class="btn-cancel">🗑️ Reset Form</button>
                </div>
            </form>
        </div>

        <div class="riwayat-card">
            <h3>📜 Riwayat Penyewaan</h3>
            <div id="riwayatSewa">
                <p style="color:#999; text-align:center">Belum ada riwayat penyewaan.</p>
            </div>
        </div>
    </div>
</div>
@endsection

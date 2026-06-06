@extends('layouts.app')
@section('title', 'Sewa Kamera')
@section('content')
<div class="container" style="margin-top:100px;">
    <div class="form-card">
        <h2>Form Sewa Kamera</h2>
        <form action="{{ route('sewa.store') }}" method="POST" id="formSewa">
            @csrf
            <div class="form-group">
                <label>ID Penyewaan *</label>
                <input type="text" name="id_penyewaan" value="{{ old('id_penyewaan') }}" required>
                @error('id_penyewaan') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Nama Penyewa *</label>
                <input type="text" name="nama_penyewa" value="{{ auth()->user()->name }}" required>
                @error('nama_penyewa') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>No Telepon *</label>
                <input type="text" name="telepon" value="{{ old('telepon') }}" required>
                @error('telepon') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}">
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat">{{ old('alamat') }}</textarea>
            </div>
            <div class="form-group">
                <label>Kamera</label>
                <select name="kamera_id" required>
                    <option value="">-- Pilih Kamera --</option>
                    @foreach ($kameras as $k)
                        <option value="{{ $k->id }}" {{ old('kamera_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }} ({{ $k->kode }}) - Stok: {{ $k->jumlah }} - Rp {{ number_format($k->harga) }}/hari</option>
                    @endforeach
                </select>
                @error('kamera_id') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jumlah Unit</label>
                    <input type="number" name="jumlah_unit" min="1" value="{{ old('jumlah_unit',1) }}" required>
                    @error('jumlah_unit') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <select name="metode_pembayaran" required>
                        <option value="">-- Pilih --</option>
                        <option value="Transfer Bank">Transfer Bank</option>
                        <option value="Cash">Cash</option>
                        <option value="E-Wallet">E-Wallet</option>
                    </select>
                    @error('metode_pembayaran') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Sewa</label>
                    <input type="date" name="tanggal_sewa" value="{{ old('tanggal_sewa') }}" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan">{{ old('catatan') }}</textarea>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn-save">Sewa</button>
                <a href="{{ route('sewa.index') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script>
    document.getElementById('formSewa').addEventListener('submit', function(e) {
        let id = document.querySelector('[name="id_penyewaan"]').value.trim();
        let nama = document.querySelector('[name="nama_penyewa"]').value.trim();
        let tel = document.querySelector('[name="telepon"]').value.trim();
        let tglSewa = document.querySelector('[name="tanggal_sewa"]').value;
        let tglKembali = document.querySelector('[name="tanggal_kembali"]').value;
        let errors = [];
        if (id === '') errors.push('ID wajib diisi');
        if (nama === '') errors.push('Nama wajib diisi');
        if (!/^[0-9]{10,13}$/.test(tel)) errors.push('No telepon harus 10-13 digit');
        if (tglSewa === '' || tglKembali === '') errors.push('Tanggal wajib diisi');
        if (new Date(tglKembali) <= new Date(tglSewa)) errors.push('Tanggal kembali harus setelah tanggal sewa');
        if (errors.length) {
            e.preventDefault();
            alert(errors.join('\n'));
        }
    });
</script>
@endpush

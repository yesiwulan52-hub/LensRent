<div class="form-group">
    <label>Kode Kamera *</label>
    <input type="text" name="kode" value="{{ old('kode', $kamera->kode ?? '') }}" required>
    @error('kode') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
    <label>Nama Kamera *</label>
    <input type="text" name="nama" value="{{ old('nama', $kamera->nama ?? '') }}" required>
    @error('nama') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
    <label>Kategori</label>
    <select name="kategori" required>
        <option value="Mirrorless" {{ (old('kategori', $kamera->kategori ?? '') == 'Mirrorless') ? 'selected' : '' }}>Mirrorless</option>
        <option value="DSLR" {{ (old('kategori', $kamera->kategori ?? '') == 'DSLR') ? 'selected' : '' }}>DSLR</option>
    </select>
</div>
<div class="form-group">
    <label>Jumlah Stok</label>
    <input type="number" name="jumlah" min="0" value="{{ old('jumlah', $kamera->jumlah ?? 0) }}" required>
    @error('jumlah') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
    <label>Harga per Hari (Rp)</label>
    <input type="number" name="harga" min="1000" value="{{ old('harga', $kamera->harga ?? '') }}" required>
    @error('harga') <span class="error-msg">{{ $message }}</span> @enderror
</div>
<div class="form-group">
    <label>Foto Kamera</label>
    <input type="file" name="foto" accept="image/*">
    @if(isset($kamera) && $kamera->foto)
        <div><img src="{{ asset($kamera->foto) }}" width="100"></div>
    @endif
    @error('foto') <span class="error-msg">{{ $message }}</span> @enderror
</div>

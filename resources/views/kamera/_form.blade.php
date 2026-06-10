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
    @if(isset($kamera) && $kamera->foto)
        <div class="foto-preview-current">
            <p style="font-size:13px; color:#8B6248; margin-bottom:8px;">📷 Foto saat ini:</p>
            <img src="{{ asset($kamera->foto) }}" alt="Foto {{ $kamera->nama }}" class="foto-preview-img">
            <p style="font-size:12px; color:#8B6248; margin-top:6px;">Upload foto baru untuk mengganti gambar ini</p>
        </div>
    @endif
    <div class="foto-upload-area" id="fotoUploadArea">
        <input type="file" name="foto" accept="image/*" id="fotoInput" style="display:none;">
        <div class="foto-upload-placeholder" id="fotoPlaceholder" onclick="document.getElementById('fotoInput').click()">
            <span style="font-size:36px;">📷</span>
            <p>Klik untuk pilih foto atau drag & drop</p>
            <small>JPG, JPEG, PNG — Maks 2MB</small>
        </div>
        <div id="fotoPreviewNew" style="display:none;">
            <img id="fotoPreviewImg" src="" alt="Preview" class="foto-preview-img">
            <button type="button" class="foto-remove-btn" onclick="removeFotoPreview()">✕ Hapus Pilihan</button>
        </div>
    </div>
    @error('foto') <span class="error-msg">{{ $message }}</span> @enderror
</div>

<script>
    const fotoInput = document.getElementById('fotoInput');
    const fotoPlaceholder = document.getElementById('fotoPlaceholder');
    const fotoPreviewNew = document.getElementById('fotoPreviewNew');
    const fotoPreviewImg = document.getElementById('fotoPreviewImg');
    const fotoUploadArea = document.getElementById('fotoUploadArea');

    fotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                fotoPreviewImg.src = e.target.result;
                fotoPlaceholder.style.display = 'none';
                fotoPreviewNew.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Drag & drop
    fotoUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    fotoUploadArea.addEventListener('dragleave', function() {
        this.classList.remove('dragover');
    });
    fotoUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            fotoInput.files = e.dataTransfer.files;
            const reader = new FileReader();
            reader.onload = function(ev) {
                fotoPreviewImg.src = ev.target.result;
                fotoPlaceholder.style.display = 'none';
                fotoPreviewNew.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    function removeFotoPreview() {
        fotoInput.value = '';
        fotoPreviewImg.src = '';
        fotoPreviewNew.style.display = 'none';
        fotoPlaceholder.style.display = 'flex';
    }
</script>

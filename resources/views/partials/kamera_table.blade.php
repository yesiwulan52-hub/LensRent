<div class="table-container">
    <table class="table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kameras as $k)
            <tr>
                <td>
                    @if($k->foto)
                        <img src="{{ asset($k->foto) }}" alt="{{ $k->nama }}" class="kamera-thumb" onclick="showFotoModal('{{ asset($k->foto) }}', '{{ $k->nama }}')">
                    @else
                        <div class="kamera-thumb-placeholder">📷</div>
                    @endif
                </td>
                <td>{{ $k->kode }}</td>
                <td><a href="{{ route('kamera.show', $k->id) }}">{{ $k->nama }}</a></td>
                <td>{{ $k->kategori }}</td>
                <td class="{{ $k->jumlah < 3 ? 'stok-menipis' : '' }}">{{ $k->jumlah }}</td>
                <td>Rp {{ number_format($k->harga, 0, ',', '.') }}</td>
                <td>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <button class="btn-toggle-status {{ $k->status === 'available' ? 'status-available' : 'status-unavailable' }}" data-id="{{ $k->id }}" data-status="{{ $k->status }}">
                                {{ $k->status === 'available' ? '✅ Tersedia' : '❌ Tidak Tersedia' }}
                            </button>
                        @else
                            <span class="status-badge {{ $k->status === 'available' ? 'status-available' : 'status-unavailable' }}">
                                {{ $k->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                            </span>
                        @endif
                    @else
                        <span class="status-badge {{ $k->status === 'available' ? 'status-available' : 'status-unavailable' }}">
                            {{ $k->status === 'available' ? 'Tersedia' : 'Tidak Tersedia' }}
                        </span>
                    @endauth
                </td>
                <td>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('kamera.edit', $k->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('kamera.destroy', $k->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-hapus" onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    @else
                        <span class="text-muted">Login untuk aksi</span>
                    @endauth
                </td>
            </tr>
            @empty
            <tr><td colspan="8">Belum ada kamera</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $kameras->links() }}

<!-- Modal Preview Foto -->
<div id="fotoModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; justify-content:center; align-items:center;" onclick="closeFotoModal()">
    <div style="position:relative; max-width:600px; width:90%; text-align:center;" onclick="event.stopPropagation()">
        <img id="fotoModalImg" src="" alt="" style="width:100%; border-radius:12px; box-shadow:0 20px 60px rgba(0,0,0,0.5);">
        <p id="fotoModalNama" style="color:white; margin-top:12px; font-weight:600; font-size:18px;"></p>
        <button onclick="closeFotoModal()" style="position:absolute; top:-15px; right:-15px; background:#fff; border:none; border-radius:50%; width:36px; height:36px; font-size:20px; cursor:pointer; box-shadow:0 2px 10px rgba(0,0,0,0.3);">✕</button>
    </div>
</div>
<script>
function showFotoModal(src, nama) {
    document.getElementById('fotoModalImg').src = src;
    document.getElementById('fotoModalNama').textContent = nama;
    document.getElementById('fotoModal').style.display = 'flex';
}
function closeFotoModal() {
    document.getElementById('fotoModal').style.display = 'none';
}
</script>

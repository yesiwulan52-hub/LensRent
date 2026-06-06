<div class="table-container">
    <table class="table">
        <thead>
            <tr>
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
            <tr><td colspan="7">Belum ada kamera</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $kameras->links() }}

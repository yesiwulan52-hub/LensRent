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
                    <button class="btn-toggle-status" data-id="{{ $k->id }}" data-status="{{ $k->status }}">
                        {{ $k->status === 'available' ? '✅ Tersedia' : '❌ Tidak Tersedia' }}
                    </button>
                </td>
                <td>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('kamera.edit', $k->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('kamera.destroy', $k->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-hapus">Hapus</button>
                            </form>
                        @endif
                    @endauth
                    <a href="{{ route('kamera.show', $k->id) }}" class="btn-detail">Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="7">Belum ada kamera</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $kameras->links() }}

<script>
    document.querySelectorAll('.btn-toggle-status').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            fetch(`/kamera/${id}/toggle-status`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    this.innerText = data.status === 'available' ? '✅ Tersedia' : '❌ Tidak Tersedia';
                    this.dataset.status = data.status;
                }
            });
        });
    });
</script>

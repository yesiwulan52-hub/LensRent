@extends('layouts.app')

@section('title', 'Penyewaan Saya')

@section('content')
<div class="container" style="margin-top: 100px;">
    <div class="riwayat-card">
        <div class="section-header">
            <h2>📜 Penyewaan Saya</h2>
            @auth
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('sewa.create') }}" class="btn-primary">+ Sewa Kamera Baru</a>
                @endif
            @endauth
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Sewa</th>
                        <th>Kamera</th>
                        <th>Jumlah</th>
                        <th>Tanggal Sewa</th>
                        <th>Tanggal Kembali</th>
                        <th>Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sewas as $sewa)
                    <tr>
                        <td>{{ $sewa->id_penyewaan }}</td>
                        <td>{{ $sewa->kamera->nama ?? '-' }}</td>
                        <td>{{ $sewa->jumlah_unit }}</td>
                        <td>{{ \Carbon\Carbon::parse($sewa->tanggal_sewa)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($sewa->tanggal_kembali)->format('d/m/Y') }}</td>
                        <td>Rp {{ number_format($sewa->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('sewa.destroy', $sewa->id) }}" method="POST" onsubmit="return confirm('Batalkan sewa?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-hapus-sewa">Batal</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="7" class="text-center">😞 Belum ada penyewaan. Klik tombol "Sewa Kamera Baru" untuk mulai menyewa.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Riwayat Penyewaan')
@section('content')
<div class="container" style="margin-top:85px;">
    <div class="riwayat-card">
        <div class="section-header">
            <h2>{{ auth()->user()->role === 'admin' ? 'Semua Penyewaan' : 'Penyewaan Saya' }}</h2>
            @if(auth()->user()->role === 'customer')
                <a href="{{ route('sewa.create') }}" class="btn-primary">+ Sewa Kamera</a>
            @endif
        </div>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr><th>ID Sewa</th><th>Penyewa</th><th>Kamera</th><th>Jumlah</th><th>Tgl Sewa</th><th>Tgl Kembali</th><th>Total</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                    @forelse ($sewas as $s)
                    <tr>
                        <td>{{ $s->id_penyewaan }}</td>
                        <td>{{ $s->nama_penyewa }}</td>
                        <td>{{ $s->kamera->nama }}</td>
                        <td>{{ $s->jumlah_unit }}</td>
                        <td>{{ date('d/m/Y', strtotime($s->tanggal_sewa)) }}</td>
                        <td>{{ date('d/m/Y', strtotime($s->tanggal_kembali)) }}</td>
                        <td>Rp {{ number_format($s->total_harga, 0, ',', '.') }}</td>
                        <td>
                            @if(auth()->user()->role === 'customer' || auth()->user()->role === 'admin')
                                <form action="{{ route('sewa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Batalkan sewa?')">
                                    @csrf @method('DELETE')
                                    <button class="btn-hapus-sewa">Batal</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8">Belum ada penyewaan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

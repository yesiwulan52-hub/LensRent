@extends('layouts.app')

@section('title', 'Data Kamera')

@section('content')
<div class="container">
    <div class="section-header">
        <h2>📋 Daftar Kamera</h2>
        @auth
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('kamera.create') }}" class="btn-primary">+ Tambah Kamera</a>
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
                    <th>Kode</th><th>Nama</th><th>Kategori</th><th>Stok</th><th>Harga</th><th>Foto</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kameras as $k)   {{-- <-- LOOPING DENGAN VARIABEL $k --}}
                <tr>
                    <td>{{ $k->kode }}</td>
                    <td>{{ $k->nama }}</td>
                    <td>{{ $k->kategori }}</td>
                    <td class="{{ $k->jumlah < 3 ? 'stok-menipis' : '' }}">{{ $k->jumlah }}</td>
                    <td>Rp {{ number_format($k->harga, 0, ',', '.') }}</td>
                    <td>
                        @if($k->foto)
                            <img src="{{ asset($k->foto) }}" width="50" height="50" style="object-fit:cover;">
                        @else
                            -
                        @endif
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
                                <span>-</span>
                            @endif
                        @else
                            <span>Login untuk aksi</span>
                        @endauth
                    </td>
                </tr>
                @empty
                    <tr><td colspan="7" class="text-center">Belum ada data kamera</td><td
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $kameras->links() }}
</div>
@endsection

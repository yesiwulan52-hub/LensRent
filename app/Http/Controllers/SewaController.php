<?php

namespace App\Http\Controllers;

use App\Models\Sewa;
use App\Models\Kamera;
use Illuminate\Http\Request;

class SewaController extends Controller
{
    // Menampilkan daftar penyewaan
    public function index()
    {
        if (auth()->user()->role === 'admin') {
            $sewas = Sewa::with('kamera')->latest()->get();
        } else {
            $sewas = Sewa::where('user_id', auth()->id())->with('kamera')->latest()->get();
        }
        return view('sewa.index', compact('sewas'));
    }

    public function create()
    {
        // if (auth()->user()->role !== 'customer') {
        //     abort(403, 'Hanya customer yang bisa menyewa kamera.');
        // }
        $kameras = Kamera::where('jumlah', '>', 0)->get();
        return view('sewa.create', compact('kameras'));
    }

    // Menyimpan penyewaan (hanya customer)
    public function store(Request $request)
    {
        // if (auth()->user()->role !== 'customer') {
        //     abort(403);
        // }

        $validated = $request->validate([
            'id_penyewaan'  => 'required|unique:sewas',
            'nama_penyewa'  => 'required|min:3',
            'telepon'       => 'required|regex:/^[0-9]{10,13}$/',
            'email'         => 'nullable|email',
            'alamat'        => 'nullable',
            'kamera_id'     => 'required|exists:kameras,id',
            'jumlah_unit'   => 'required|integer|min:1',
            'tanggal_sewa'  => 'required|date',
            'tanggal_kembali'=> 'required|date|after:tanggal_sewa',
            'metode_pembayaran' => 'required',
            'catatan'       => 'nullable',
        ]);

        $kamera = Kamera::findOrFail($request->kamera_id);
        $hari = max(1, (strtotime($request->tanggal_kembali) - strtotime($request->tanggal_sewa)) / 86400);
        $total = $kamera->harga * $request->jumlah_unit * $hari;

        if ($request->jumlah_unit > $kamera->jumlah) {
            return back()->withErrors(['jumlah_unit' => 'Stok tidak mencukupi!']);
        }

        // Kurangi stok
        $kamera->decrement('jumlah', $request->jumlah_unit);

        $validated['total_harga'] = $total;
        $validated['user_id'] = auth()->id();

        Sewa::create($validated);

        return redirect()->route('sewa.index')->with('success', 'Penyewaan berhasil!');
    }

    // Membatalkan penyewaan (hanya customer, dan hanya miliknya)
    public function destroy(Sewa $sewa)
    {
        if (auth()->user()->role !== 'admin' || $sewa->user_id !== auth()->id()) {
            abort(403, 'Tidak diizinkan.');
        }

        // Kembalikan stok
        $sewa->kamera->increment('jumlah', $sewa->jumlah_unit);
        $sewa->delete();

        return redirect()->route('sewa.index')->with('success', 'Penyewaan dibatalkan!');
    }
}

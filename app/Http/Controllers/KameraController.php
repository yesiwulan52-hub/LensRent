<?php

namespace App\Http\Controllers;

use App\Models\Kamera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KameraController extends Controller
{
    public function index()
    {
        $kameras = Kamera::latest()->paginate(10);
        return view('kamera.index', compact('kameras'));
    }

    public function create()
    {
        return view('kamera.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:kameras|max:10',
            'nama' => 'required|min:3|max:100',
            'kategori' => 'required|in:DSLR,Mirrorless',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|integer|min:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('kamera_fotos', 'public');
            $validated['foto'] = '/storage/' . $path;
        }

        Kamera::create($validated);
        return redirect()->route('kamera.index')->with('success', 'Kamera ditambahkan!');
    }

    public function edit(Kamera $kamera)
    {
        return view('kamera.edit', compact('kamera'));
    }

    public function update(Request $request, Kamera $kamera)
    {
        $validated = $request->validate([
            'kode' => 'required|max:10|unique:kameras,kode,' . $kamera->id,
            'nama' => 'required|min:3|max:100',
            'kategori' => 'required|in:DSLR,Mirrorless',
            'jumlah' => 'required|integer|min:0',
            'harga' => 'required|integer|min:1000',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($kamera->foto && Storage::disk('public')->exists(str_replace('/storage/', '', $kamera->foto))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $kamera->foto));
            }
            $path = $request->file('foto')->store('kamera_fotos', 'public');
            $validated['foto'] = '/storage/' . $path;
        }

        $kamera->update($validated);
        return redirect()->route('kamera.index')->with('success', 'Kamera diupdate!');
    }

    public function destroy(Kamera $kamera)
    {
        if ($kamera->foto && Storage::disk('public')->exists(str_replace('/storage/', '', $kamera->foto))) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $kamera->foto));
        }
        $kamera->delete();
        return redirect()->route('kamera.index')->with('success', 'Kamera dihapus!');
    }
}

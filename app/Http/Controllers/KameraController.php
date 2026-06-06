<?php

namespace App\Http\Controllers;

use App\Models\Kamera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KameraController extends Controller
{
    // app/Http/Controllers/KameraController.php

    public function index(Request $request)
    {
        $query = Kamera::query();

        // Jika ada fitur pencarian
        if ($request->has('search') && $request->ajax()) {
            $search = $request->search;
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('kode', 'like', "%{$search}%");
            $kameras = $query->paginate(10);
            return view('partials.kamera_table', compact('kameras'))->render();
        }

        $kameras = $query->latest()->paginate(10);
        return view('kamera.index', compact('kameras'));
    }

    public function show(Kamera $kamera)
    {
        return view('kamera.show', compact('kamera'));
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
        $validated['status'] = 'available';
        Kamera::create($validated);
        return redirect()->route('kamera.index')->with('success', 'Kamera ditambahkan!');
    }

    public function search(Request $request)
    {
        $keyword = $request->q;
        $kameras = Kamera::where('nama', 'like', "%{$keyword}%")
                        ->orWhere('kode', 'like', "%{$keyword}%")
                        ->paginate(10);
        return view('partials.kamera_table', compact('kameras'))->render();
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

    // AJAX toggle status
    public function toggleStatus(Kamera $kamera)
    {
        $kamera->status = $kamera->status === 'available' ? 'unavailable' : 'available';
        $kamera->save();
        return response()->json(['success' => true, 'status' => $kamera->status]);
    }
}

<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class PreferencesController extends Controller
{
    public function index()
    {
        return view('preferences');
    }
    public function store(Request $request)
    {
        $theme = $request->input('theme');
        $fontSize = $request->input('font_size');
        cookie()->queue(cookie()->forever('theme', $theme));
        cookie()->queue(cookie()->forever('font_size', $fontSize));
        return response()->json(['success' => true]);
    }
}

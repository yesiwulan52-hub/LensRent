@extends('layouts.app')
@section('title', 'Preferensi')
@section('content')
<div class="container mx-auto p-4" style="margin-top: 100px;">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 max-w-md mx-auto">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Pengaturan Preferensi</h2>
        <form id="pref-form">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Tema</label>
                <select name="theme" id="theme-select" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                    <option value="system">System</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 mb-2">Ukuran Font</label>
                <select name="font_size" id="font-size-select" class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white">
                    <option value="small">Kecil</option>
                    <option value="medium">Sedang</option>
                    <option value="large">Besar</option>
                </select>
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">Simpan Preferensi</button>
        </form>
    </div>
</div>
<script>
    function getCookieValue(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
        return null;
    }
    const currentTheme = getCookieValue('theme');
    const currentFont = getCookieValue('font_size');
    if (currentTheme) document.getElementById('theme-select').value = currentTheme;
    if (currentFont) document.getElementById('font-size-select').value = currentFont;

    document.getElementById('pref-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(e.target);
        const res = await fetch('{{ route("preferences.store") }}', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value },
            body: formData
        });
        const data = await res.json();
        if (data.success) {
            alert('Preferensi disimpan. Halaman akan dimuat ulang.');
            location.reload();
        } else {
            alert('Gagal menyimpan.');
        }
    });
</script>
@endsection

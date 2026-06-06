<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'LensRent')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Prevent FOUC for dark mode -->
    <script>
        (function() {
            const theme = document.cookie.split('; ').find(row => row.startsWith('theme='));
            let isDark = false;
            if (theme) {
                isDark = theme.split('=')[1] === 'dark';
            } else {
                isDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
            if (isDark) document.documentElement.classList.add('dark');
        })();
    </script>
    @stack('styles')
</head>
<body>
    @include('partials.navbar')
    <main> @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @yield('content')
        {{ $slot ?? '' }}
    </main>
    
    @include('partials.footer')
    <script src="{{ asset('js/script.js') }}"></script>
    @stack('scripts')
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'RoSys') }} – Florist</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/homepage.css', 'resources/css/auth.css'])
</head>
<body class="auth-body">

    {{-- Navbar --}}
    <header class="nav">
      <div class="container">
        <a href="{{ url('/') }}" class="brand">
            RoSys <small>Florist · Est. 2026</small>
        </a>

        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/flowers') }}">Flowers</a></li>
            <li><a href="{{ url('/customise') }}">Customise</a></li>
            <li><a href="{{ url('/orders') }}">Orders</a></li>
        </ul>

        <div class="nav-actions">
            @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
            @else
                <a href="{{ route('login') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/>
                    </svg>
                    Sign in
                </a>
            @endauth

            <a href="{{ url('/cart') }}" aria-label="Cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 8h14l-1 12H6L5 8z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>
                </svg>
            </a>
        </div>
      </div>
    </header>

    <main class="container auth-page">
        {{ $slot }}
    </main>

    <footer class="auth-footer"></footer>
</body>
</html>
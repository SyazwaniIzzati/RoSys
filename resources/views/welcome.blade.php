<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'RoSys') }} – Florist</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Page styles -->
    @vite('resources/css/homepage.css')
</head>

<body>

    {{-- Navbar --}}
    <header class="nav">
        <div class="container">
            <a href="{{ url('/') }}" class="brand">
                RoSys <small>Florist · Est. 2026</small>
            </a>

            <div class="nav-actions">
                @if (Route::has('login'))
                @auth
                <a href="{{ url('/dashboard') }}">Dashboard</a>
                @else
                <a href="{{ route('login') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 21c0-4 4-6 8-6s8 2 8 6" />
                    </svg>
                    Sign in
                </a>
                @endauth
                @endif
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <main class="container hero">
        <section class="hero-text">
            <span class="eyebrow">A quiet florist · Est. 2026</span>

            <h1>
                Bouquets made
                <em>just for you.</em>
            </h1>

            <p class="lead">
                Fresh seasonal blooms, hand-tied in our atelier. Choose your flowers,
                colours and style — we'll arrange the rest with quiet romance.
            </p>
        </section>

        <aside class="hero-media">
            {{-- Change to your own image: public/images/homepagephoto.jpg --}}
            <img src="{{ asset('images/homepagephoto.jpg') }}" alt="Pink peony and cream ranunculus bouquet with eucalyptus">

            <div class="bloom-card">
                <span>Today's bloom</span>
                <strong>Coral Charm Peony</strong>
            </div>
        </aside>
    </main>
    </main>

    {{-- Footer --}}
    <footer class="site-footer">
        <div class="container">
            <span class="footer-brand">
                RoSys <small>© {{ date('Y') }} · All rights reserved</small>
            </span>

            <ul class="footer-links">
                <li><a href="#">Contact</a></li>
                <li><a href="#">Privacy</a></li>
                <li><a href="#">Terms</a></li>
            </ul>
        </div>
    </footer>

</body>

</html>

</body>

</html>
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

        <ul class="nav-links">
            <li><a href="{{ url('/') }}" class="active">Home</a></li>
            <li><a href="{{ url('/flowers') }}">Flowers</a></li>
            <li><a href="{{ url('/customise') }}">Customise</a></li>
            <li><a href="{{ url('/orders') }}">Orders</a></li>
        </ul>

        <div class="nav-actions">
            @if (Route::has('login'))
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
            @endif

            <a href="{{ url('/cart') }}" aria-label="Cart">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 8h14l-1 12H6L5 8z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>
                </svg>
            </a>
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

            <div class="btn-row">
                <a href="{{ url('/customise') }}" class="btn btn-primary">Customise a bouquet &rarr;</a>
                <a href="{{ url('/flowers') }}" class="btn btn-ghost">Shop flowers</a>
            </div>

            <dl class="stats">
                <div class="stat">
                    <dt>Stems</dt>
                    <dd>60+</dd>
                </div>
                <div class="stat">
                    <dt>Cities</dt>
                    <dd>3</dd>
                </div>
                <div class="stat">
                    <dt>Same-day</dt>
                    <dd>by 2pm</dd>
                </div>
            </dl>
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

</body>
</html>
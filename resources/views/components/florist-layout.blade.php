<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'RoSys') }} – Florist</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/homepage.css', 'resources/css/auth.css', 'resources/js/app.js', 'resources/css/dashboard.css', 'resources/css/profile.css',])
    @stack('styles')
</head>

<body class="auth-body">

    {{-- Navbar --}}
    <header class="nav">
        <div class="container">
            <a href="{{ url('/') }}" class="brand">
                RoSys <small>Florist · Est. 2026</small>
            </a>

            <ul class="nav-links">
                <li><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li><a href="{{ url('/flowers') }}">Flowers</a></li>
                <li><a href="{{ url('/customise') }}">Customise</a></li>
                <li><a href="{{ url('/orders') }}">Orders</a></li>
            </ul>

            <div class="nav-actions">

                @auth
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button type="button" class="user-dropdown-trigger">
                            <span>{{ Auth::user()->name }}</span>

                            <svg
                                class="user-dropdown-icon"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true">
                                <path
                                    fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link
                                :href="route('logout')"
                                onclick="event.preventDefault();
                    this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>

                    </x-slot>

                </x-dropdown>
                @else

                <a href="{{ route('login') }}">
                    <svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 21c0-4 4-6 8-6s8 2 8 6" />
                    </svg>
                    Sign in
                </a>

                @endauth



                <a href="{{ route('cart.index') }}"
                    class="cart-icon-link"
                    aria-label="Cart, {{ $cartCount ?? 0 }} items">

                    <svg viewBox="0 0 24 24" fill="none"
                        stroke="currentColor"
                        stroke-width="1.5"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true">
                        <path d="M5 8h14l-1 12H6L5 8z" />
                        <path d="M9 8V6a3 3 0 0 1 6 0v2" />
                    </svg>

                    @if (($cartCount ?? 0) > 0)
                    <span class="cart-count-badge">
                        {{ $cartCount }}
                    </span>
                    @endif
                </a>


            </div>
        </div>
    </header>

    <main class="container auth-page">
        {{ $slot }}
    </main>

    <x-site-footer />
    @stack('scripts')
</body>

</html>
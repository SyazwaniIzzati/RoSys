@php
    $user = auth()->user();
    $initials = collect(preg_split('/\s+/', trim($user->name)))
        ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))->take(2)->join('');

    $nav = [
        ['Dashboard',      'admin.dashboard',  '<rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>'],
        ['Orders',         'admin.orders',     '<path d="M5 8h14l-1 12H6L5 8z"/><path d="M9 8V6a3 3 0 0 1 6 0v2"/>'],
        ['Proof Approval', 'admin.proofs',     '<rect x="3" y="3" width="18" height="18" rx="3"/><path d="m8 12 3 3 5-6"/>'],
        ['QR Payments',    'admin.payments',   '<rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><path d="M14 14h3v3h-3zM20 14v1M14 20h1M18 20h3v-3"/>'],
        ['Flowers',        'admin.flowers',    '<ellipse cx="12" cy="6" rx="8" ry="3"/><path d="M4 6v6c0 1.7 3.6 3 8 3s8-1.3 8-3V6"/><path d="M4 12v6c0 1.7 3.6 3 8 3s8-1.3 8-3v-6"/>'],
        ['Categories',     'admin.categories', '<path d="M4 6h16M4 12h10M4 18h16"/>'],
        ['Stock',          'admin.stock',      '<path d="M3 8l9-5 9 5v8l-9 5-9-5V8z"/><path d="M3 8l9 5 9-5M12 13v8"/>'],
        ['Users',          'admin.users',      '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c0-3.5 3-5.5 6.5-5.5s6.5 2 6.5 5.5"/><path d="M16 4.5a3.5 3.5 0 0 1 0 7M18 15c2 .6 3.5 2.2 3.5 5"/>'],
        ['Settings',       'admin.settings',   '<circle cx="12" cy="12" r="3"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3M4.9 4.9l2.1 2.1M17 17l2.1 2.1M19.1 4.9L17 7M7 17l-2.1 2.1"/>'],
    ];

    $logoutIcon = '<path d="M15 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3"/><path d="M10 8l-4 4 4 4M6 12h10"/>';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Dashboard' }} – RoSys Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300&family=Jost:wght@300;400;500&display=swap" rel="stylesheet">

    @vite(['resources/css/admin.css', 'resources/js/app.js', 'resources/css/flowers.css',])
</head>
<body class="admin-body">

    {{-- Top bar --}}
    <header class="admin-top">
        <a href="{{ Route::has('admin.dashboard') ? route('admin.dashboard') : url('/admin') }}" class="brand">RoSys <small>Admin</small></a>

        <form class="search" role="search" onsubmit="return false">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
            <input type="search" placeholder="Search orders, customers, flowers..." aria-label="Search">
        </form>

        <div class="top-actions">
            <button type="button" class="icon-btn has-dot" aria-label="Notifications">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M6 16V11a6 6 0 0 1 12 0v5l1.5 2h-15L6 16z"/><path d="M10 21h4"/></svg>
            </button>

            <div class="user-chip">
                <span class="avatar">{{ $initials }}</span>
                <span class="who">
                    <strong>{{ $user->name }}</strong>
                    <small>Administrator</small>
                </span>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="pill-btn">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $logoutIcon !!}</svg>
                    Logout
                </button>
            </form>
        </div>
    </header>

    <div class="admin-shell">
        {{-- Sidebar --}}
        <aside class="admin-side">
            <p class="side-label">Navigation</p>

            <nav>
                @foreach ($nav as [$label, $routeName, $icon])
                    @php $active = request()->routeIs($routeName); @endphp
                    <a href="{{ Route::has($routeName) ? route($routeName) : '#' }}"
                       class="side-link {{ $active ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $icon !!}</svg>
                        {{ $label }}
                        @if ($active)
                            <svg class="chev" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 6 6 6-6 6"/></svg>
                        @endif
                    </a>
                @endforeach
            </nav>

            <form method="POST" action="{{ route('logout') }}" class="side-logout">
                @csrf
                <button type="submit" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">{!! $logoutIcon !!}</svg>
                    Logout
                </button>
            </form>
        </aside>

        {{-- Page content --}}
        <main class="admin-main">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
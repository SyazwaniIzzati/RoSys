<x-admin-layout title="Dashboard Overview">
    <span class="eyebrow">RoSys · Administration</span>

    <h1 class="page-title">Dashboard Overview</h1>
    <p class="page-lead">
        Manage customer orders, flower inventory, proof approval and payments — all from one
        calm, considered workspace.
    </p>

    @php
        $stats = $stats ?? [];
        $cards = [
            ['Total orders',       ($stats['total'] ?? 0),      'All-time'],
            ['Pending orders',     ($stats['pending'] ?? 0),    'Awaiting review'],
            ['Processing orders',  ($stats['processing'] ?? 0), 'In workshop'],
            ['Ready for delivery', ($stats['ready'] ?? 0),      'Awaiting courier'],
            ['Delivered orders',   ($stats['delivered'] ?? 0),  'Fulfilled'],
            ['Total customers',    ($stats['customers'] ?? 0),  'Registered'],
        ];
    @endphp

    <section class="stat-grid">
        @foreach ($cards as [$label, $value, $caption])
            <article class="stat-card">
                <span class="stat-label">{{ $label }}</span>
                <strong class="stat-value">{{ number_format($value) }}</strong>
                <span class="stat-caption">{{ $caption }}</span>
            </article>
        @endforeach
    </section>
</x-admin-layout>
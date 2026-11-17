<x-florist-layout>
    @push('styles')
    @vite('resources/css/customer-flowers.css')
    @endpush

    <div id="rf">

        @if (session('success'))
        <div class="flash flash-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="flash flash-error">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
        <div class="flash flash-error">{{ $errors->first() }}</div>
        @endif

        <div class="catalog-wrap">


            {{-- Left Sidebar Menu --}}
            <aside class="sidebar">
                <div class="sidebar-card">

                    <p class="side-title">Categories</p>

                    <nav class="side-nav" aria-label="Flower categories">

                        {{-- All Flowers --}}
                        <a href="{{ url('/flowers') }}"
                            class="side-link {{ $activeCategory ? '' : 'is-active' }}">

                            <svg viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true">
                                <rect x="3" y="3" width="7" height="7" rx="1.5" />
                                <rect x="14" y="3" width="7" height="7" rx="1.5" />
                                <rect x="3" y="14" width="7" height="7" rx="1.5" />
                                <rect x="14" y="14" width="7" height="7" rx="1.5" />
                            </svg>

                            <span class="side-link-text">All Flowers</span>

                            @if(isset($totalFlowersCount))
                            <span class="cat-num">{{ $totalFlowersCount }}</span>
                            @endif

                            @if(!$activeCategory)
                            <svg class="side-chevron"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="m9 6 6 6-6 6" />
                            </svg>
                            @endif
                        </a>

                        {{-- Flower Categories --}}
                        @foreach ($categories as $cat)

                        @php
                        $isActive = $activeCategory
                        && $activeCategory->category_id == $cat->category_id;
                        @endphp

                        <a href="{{ route('flowers.category', $cat->category_id) }}"
                            class="side-link {{ $isActive ? 'is-active' : '' }}">

                            <svg viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M4 6h16M4 12h10M4 18h16" />
                            </svg>

                            <span class="side-link-text">
                                {{ $cat->category_name }}
                            </span>

                            @if(isset($cat->flowers_count))
                            <span class="cat-num">{{ $cat->flowers_count }}</span>
                            @endif

                            @if($isActive)
                            <svg class="side-chevron"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.5"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="m9 6 6 6-6 6" />
                            </svg>
                            @endif

                        </a>
                        @endforeach

                    </nav>
                </div>

                {{-- Custom Bouquet Promo --}}
                <div class="promo-box">
                    <h4>Custom Bouquet</h4>
                    <p>Compose a bouquet stem by stem, arranged by our florists.</p>
                    <a href="{{ url('/customise') }}">
                        Start customising &rarr;
                    </a>
                </div>
            </aside>

            {{-- Right Main Area --}}
            <div class="main-area">

                {{-- Toolbar --}}
                <div class="toolbar">
                    <span class="count">
                        Showing <strong>{{ $flowers->firstItem() ?? 0 }}–{{ $flowers->lastItem() ?? 0 }}</strong>
                        of <strong>{{ $flowers->total() }}</strong> items
                    </span>

                    <form method="GET" class="sort">
                        <label for="sort">Sort by</label>
                        <select id="sort" name="sort" onchange="this.form.submit()">
                            <option value="latest" @selected($sort==='latest' )>Latest</option>
                            <option value="price_low" @selected($sort==='price_low' )>Price: low to high</option>
                            <option value="price_high" @selected($sort==='price_high' )>Price: high to low</option>
                            <option value="name" @selected($sort==='name' )>Name A–Z</option>
                        </select>
                    </form>
                </div>

                {{-- Products Grid --}}
                @if ($flowers->isEmpty())
                <p class="empty">No flowers found in this category yet.</p>
                @else
                <div class="flower-grid">
                    @foreach ($flowers as $flower)
                    @php
                    $minStems = max(1, (int) ($flower->min_quantity ?? 1));
                    $stock = (int) $flower->stock_quantity;
                    $canBunch = $flower->price_per_bunch !== null && (int) $flower->bunch_quantity > 0;
                    $available = (bool) $flower->availability && $stock >= $minStems;
                    $badge = ! $available ? ['out', 'Out of stock'] : ($stock <= 20 ? ['low', 'Limited stock' ] : ['', 'In stock' ]);
                        @endphp

                        <article class="flower-card"
                        data-flower
                        data-stem-price="{{ $flower->price_per_stem }}"
                        data-bunch-price="{{ $canBunch ? $flower->price_per_bunch : 0 }}"
                        data-bunch-qty="{{ $canBunch ? (int) $flower->bunch_quantity : 0 }}"
                        data-stock="{{ $stock }}"
                        data-min="{{ $minStems }}">

                        <div class="flower-media">
                            @if ($flower->image)
                            <img src="{{ asset('storage/' . $flower->image) }}" alt="{{ $flower->flower_name }}" loading="lazy">
                            @else
                            <div class="flower-noimg">No image</div>
                            @endif
                            <span class="badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                        </div>

                        <div class="flower-body">
                            <div>
                                <h3 class="flower-name">
                                    {{ $flower->flower_name }}
                                </h3>
                                <p class="flower-min">Min. {{ $minStems }} {{ $minStems === 1 ? 'stem' : 'stems' }}</p>
                            </div>

                            <div class="prices">
                                <div><span>Per stem</span><strong>RM{{ number_format($flower->price_per_stem, 2) }}</strong></div>
                                @if ($canBunch)
                                <div><span>Per bunch ({{ (int) $flower->bunch_quantity }} stems)</span><strong>RM{{ number_format($flower->price_per_bunch, 2) }}</strong></div>
                                @endif
                            </div>

                            <form method="POST" action="{{ route('cart.add') }}" class="add-form" style="display:contents">
                                @csrf
                                <input type="hidden" name="flower_id" value="{{ $flower->flower_id }}">
                                <input type="hidden" name="item_type" class="f-type" value="stem">
                                <input type="hidden" name="quantity" class="f-qty" value="{{ $minStems }}">

                                <div class="mode" role="group" aria-label="Buy as">
                                    <button type="button" class="m-stem is-active" @disabled(! $available)>Stems</button>
                                    <button type="button" class="m-bunch" @disabled(! $available || ! $canBunch)>Bunch</button>
                                </div>

                                <div class="stepper">
                                    <button type="button" class="step-btn s-minus" aria-label="Decrease" @disabled(! $available)>&minus;</button>
                                    <div class="qty">
                                        <b class="q-num">{{ $minStems }}</b> <span class="q-unit">stems</span>
                                        <small class="q-note"></small>
                                    </div>
                                    <button type="button" class="step-btn s-plus" aria-label="Increase" @disabled(! $available)>+</button>
                                </div>

                                <div class="total"><span>Total</span><strong class="t-price">RM{{ number_format($minStems * $flower->price_per_stem, 2) }}</strong></div>

                                <button type="submit" class="add-btn" @disabled(! $available)>
                                    {{ $available ? '+ Add to Cart' : 'Unavailable' }}
                                </button>
                            </form>
                        </div>
                        </article>
                        @endforeach
                </div>

                @if ($flowers->hasPages())
                <nav class="pagination-wrap" aria-label="Flower pages">
                    <span class="pagination-info">Page {{ $flowers->currentPage() }} of {{ $flowers->lastPage() }}</span>

                    @if ($flowers->onFirstPage())
                    <span class="pagination-btn is-disabled" aria-disabled="true">Previous</span>
                    @else
                    <a class="pagination-btn" href="{{ $flowers->appends(request()->query())->previousPageUrl() }}">Previous</a>
                    @endif

                    @if ($flowers->hasMorePages())
                    <a class="pagination-btn next" href="{{ $flowers->appends(request()->query())->nextPageUrl() }}">Next page &rarr;</a>
                    @else
                    <span class="pagination-btn next is-disabled" aria-disabled="true">Next page &rarr;</span>
                    @endif
                </nav>
                @endif
                @endif

            </div>
        </div>

    </div>

    <script>
        (function() {
            document.querySelectorAll('#rf [data-flower]').forEach(function(card) {
                var stemPrice = parseFloat(card.dataset.stemPrice) || 0;
                var bunchPrice = parseFloat(card.dataset.bunchPrice) || 0;
                var bunchQty = parseInt(card.dataset.bunchQty, 10) || 0;
                var stock = parseInt(card.dataset.stock, 10) || 0;
                var minStems = parseInt(card.dataset.min, 10) || 1;

                var mode = 'stem';
                var stems = minStems;

                var $ = function(s) {
                    return card.querySelector(s);
                };
                var bStem = $('.m-stem'),
                    bBunch = $('.m-bunch');
                var minus = $('.s-minus'),
                    plus = $('.s-plus');
                var num = $('.q-num'),
                    unit = $('.q-unit'),
                    note = $('.q-note'),
                    price = $('.t-price');
                var fType = $('.f-type'),
                    fQty = $('.f-qty');

                function step() {
                    return mode === 'bunch' ? bunchQty : 1;
                }

                function lowest() {
                    return mode === 'bunch' ? Math.max(bunchQty, Math.ceil(minStems / bunchQty) * bunchQty) : minStems;
                }

                function highest() {
                    return mode === 'bunch' ? Math.floor(stock / bunchQty) * bunchQty : stock;
                }

                function render() {
                    var bunches = bunchQty ? stems / bunchQty : 0;
                    num.textContent = stems;
                    unit.textContent = stems === 1 ? 'stem' : 'stems';
                    note.textContent = mode === 'bunch' ? '= ' + bunches + (bunches === 1 ? ' bunch' : ' bunches') : '';

                    var total = mode === 'bunch' ? bunches * bunchPrice : stems * stemPrice;
                    price.textContent = 'RM' + total.toFixed(2);

                    fType.value = mode;
                    fQty.value = mode === 'bunch' ? bunches : stems;

                    minus.disabled = stems - step() < lowest();
                    plus.disabled = stems + step() > highest();
                    bStem.classList.toggle('is-active', mode === 'stem');
                    bBunch.classList.toggle('is-active', mode === 'bunch');
                }

                function setMode(m) {
                    mode = m;
                    stems = lowest();
                    render();
                }

                bStem.addEventListener('click', function() {
                    setMode('stem');
                });
                bBunch.addEventListener('click', function() {
                    if (!bBunch.disabled) setMode('bunch');
                });
                minus.addEventListener('click', function() {
                    if (stems - step() >= lowest()) {
                        stems -= step();
                        render();
                    }
                });
                plus.addEventListener('click', function() {
                    if (stems + step() <= highest()) {
                        stems += step();
                        render();
                    }
                });

                render();
            });
        })();
    </script>

</x-florist-layout>
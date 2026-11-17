<x-florist-layout>

<style>
#rf{--ink:#2a1d1a;--muted:#7a6a65;--line:#eadfd9;--soft:#f6ece6;--dark:#3b2a24;--dark-hover:#241914;--radius:16px;--gap:20px;
--body:'Jost',system-ui,sans-serif;--display:'Cormorant Garamond',Georgia,serif;
display:block;width:100%;max-width:none;margin:-48px 0 0;padding:0 10px 36px 0;box-sizing:border-box;font-family:var(--body);color:var(--ink)}
#rf *{box-sizing:border-box}
#rf a{text-decoration:none;color:inherit}
#rf h1,#rf h2,#rf h3,#rf p{margin:0}
#rf button,#rf select{font-family:inherit}

/* flash */
#rf .flash{margin:0 0 16px;padding:12px 16px;border-radius:12px;font-size:.95rem}
#rf .flash-success{background:#e8f3ea;color:#25552f}
#rf .flash-error{background:#fbe9e9;color:#8a2a2a}

/* Layout utama: Sidebar betul-betul merapat ke tepi kiri */
#rf .catalog-wrap{display:grid;grid-template-columns:210px minmax(0,1fr);gap:18px;align-items:start;width:100%}

/* Sidebar ikut scroll bersama seluruh halaman */
#rf .sidebar{position:static;align-self:start;display:flex;flex-direction:column;gap:12px;flex-shrink:0;max-height:none;overflow:visible}
#rf .sidebar-card{background:#fff;border:1px solid var(--line);border-top-right-radius:var(--radius);border-bottom-right-radius:var(--radius);border-top-left-radius:0;border-bottom-left-radius:0;border-left:0;padding:18px 14px 18px 20px;box-shadow:2px 0 8px rgba(42,29,26,0.02)}
#rf .side-title{font-size:.72rem;letter-spacing:.14em;text-transform:uppercase;color:var(--muted);padding:0 8px 10px;margin-bottom:4px;font-weight:500;border-bottom:1px solid var(--line)}
#rf .side-nav{display:flex;flex-direction:column;gap:3px}
#rf .side-link{display:flex;justify-content:space-between;align-items:center;padding:9px 10px;border-radius:8px;font-size:.9rem;color:var(--muted);transition:background .2s,color .2s,font-weight .2s}
#rf .side-link:hover{background:var(--soft);color:var(--ink)}
#rf .side-link.is-active{background:var(--dark);color:#fff;font-weight:500}
#rf .side-link .cat-num{font-size:.8rem;opacity:.7}

/* Promo box in sidebar */
#rf .promo-box{background:#fff;border:1px solid var(--line);border-top-right-radius:var(--radius);border-bottom-right-radius:var(--radius);border-top-left-radius:0;border-bottom-left-radius:0;border-left:0;padding:18px 16px 18px 20px;box-shadow:2px 0 8px rgba(42,29,26,0.02)}
#rf .promo-box h4{font-family:var(--display);font-size:1.15rem;font-weight:500;margin-bottom:6px;color:var(--ink)}
#rf .promo-box p{font-size:.82rem;line-height:1.45;color:var(--muted);margin-bottom:12px}
#rf .promo-box a{font-size:.84rem;font-weight:500;color:var(--ink);display:inline-flex;align-items:center;gap:4px}
#rf .promo-box a:hover{text-decoration:underline}

/* Main Area & Toolbar */
#rf .main-area{min-width:0;width:100%;padding:0 8px 0 0}
#rf .toolbar{display:flex;justify-content:space-between;align-items:center;gap:12px;margin:0 0 12px}
#rf .toolbar .count{color:var(--muted);font-size:.92rem}
#rf .toolbar .count strong{color:var(--ink);font-weight:500}
#rf .sort{display:flex;align-items:center;gap:8px;font-size:.9rem;color:var(--muted)}
#rf .sort select{border:1px solid var(--line);background:#fff;border-radius:999px;padding:8px 16px;color:var(--ink);cursor:pointer}

/* Grid Responsif Profesional */
#rf .flower-grid{display:grid;grid-template-columns:repeat(5,minmax(0,1fr));gap:16px}
#rf .flower-card{background:#fff;border:1px solid var(--line);border-radius:14px;overflow:hidden;display:flex;flex-direction:column;min-width:0;transition:box-shadow .2s,transform .2s}
#rf .flower-card:hover{box-shadow:0 8px 24px rgba(42,29,26,.08);transform:translateY(-2px)}
#rf .flower-media{position:relative;height:190px;aspect-ratio:auto;background:var(--soft);overflow:hidden;flex-shrink:0}
#rf .flower-media img{width:100%;height:100%;object-fit:contain;object-position:center;display:block}
#rf .flower-noimg{height:100%;display:grid;place-items:center;color:var(--muted);font-size:.85rem}
#rf .badge{position:absolute;top:12px;left:12px;background:rgba(255,255,255,.92);border-radius:999px;padding:4px 11px;font-size:.68rem;letter-spacing:.08em;text-transform:uppercase}
#rf .badge.low{background:#fff3df;color:#8a5a12}
#rf .badge.out{background:#fbe9e9;color:#8a2a2a}
#rf .flower-body{padding:10px 10px 11px;display:flex;flex-direction:column;gap:8px;flex:1}
#rf .flower-name{font-family:var(--display);font-size:1.08rem;font-weight:500;line-height:1.12;overflow-wrap:anywhere}
#rf .flower-name span{color:var(--muted);font-size:1.05rem}
#rf .flower-min{font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:var(--muted);margin-top:4px}
#rf .prices{border-top:1px solid var(--line);border-bottom:1px solid var(--line);padding:7px 0;display:grid;gap:4px;font-size:.82rem}
#rf .prices div{display:flex;justify-content:space-between;color:var(--muted)}
#rf .prices strong{color:var(--ink);font-weight:500}

/* Stem / Bunch Toggle */
#rf .mode{display:grid;grid-template-columns:1fr 1fr;background:var(--soft);border-radius:999px;padding:3px}
#rf .mode button{border:0;background:transparent;border-radius:999px;padding:6px 0;font-size:.8rem;cursor:pointer;color:var(--muted);transition:background .2s,color .2s}
#rf .mode button.is-active{background:#fff;color:var(--ink);box-shadow:0 1px 3px rgba(0,0,0,.08)}
#rf .mode button:disabled{opacity:.4;cursor:not-allowed}

/* Quantity Stepper */
#rf .stepper{display:flex;align-items:center;justify-content:space-between;gap:8px}
#rf .step-btn{width:28px;height:28px;flex-shrink:0;border-radius:50%;border:1px solid var(--line);background:#fff;font-size:1.05rem;line-height:1;cursor:pointer;display:grid;place-items:center;transition:border-color .2s,background .2s}
#rf .step-btn:hover:not(:disabled){border-color:var(--dark);background:var(--soft)}
#rf .step-btn:disabled{opacity:.35;cursor:not-allowed}
#rf .qty{text-align:center;flex:1}
#rf .qty b{font-size:1.05rem;font-weight:500}
#rf .qty small{display:block;color:var(--muted);font-size:.76rem;margin-top:1px;min-height:1.1em}
#rf .total{display:flex;justify-content:space-between;font-size:.9rem}
#rf .total strong{font-weight:500}

#rf .add-btn{margin-top:auto;border:0;background:var(--dark);color:#fff;border-radius:999px;padding:8px 6px;font-size:.82rem;cursor:pointer;transition:background .2s}
#rf .add-btn:hover:not(:disabled){background:var(--dark-hover)}
#rf .add-btn:disabled{background:#cfc3bd;cursor:not-allowed}

#rf .empty{padding:60px 0;text-align:center;color:var(--muted)}

/* Pagination - di bahagian bawah sebelah kanan */
#rf .pagination-wrap{display:flex;justify-content:flex-end;align-items:center;gap:8px;margin:24px 0 0;padding:12px 0 0}
#rf .pagination-info{font-size:.82rem;color:var(--muted);margin-right:6px}
#rf .pagination-btn{display:inline-flex;align-items:center;justify-content:center;min-height:38px;padding:8px 16px;border:1px solid var(--line);border-radius:999px;background:#fff;color:var(--ink);font-size:.85rem;transition:background .2s,border-color .2s}
#rf .pagination-btn:hover:not(.is-disabled){background:var(--soft);border-color:var(--dark)}
#rf .pagination-btn.is-disabled{opacity:.45;pointer-events:none;background:#f8f5f3}
#rf .pagination-btn.next{background:var(--dark);border-color:var(--dark);color:#fff}
#rf .pagination-btn.next:hover:not(.is-disabled){background:var(--dark-hover)}

/* Responsive layout */
@media (max-width: 1400px){
    #rf .flower-grid{grid-template-columns:repeat(4,minmax(0,1fr))}
}
@media (max-width: 1100px){
    #rf .catalog-wrap{grid-template-columns:190px minmax(0,1fr);gap:14px}
    #rf .flower-grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:14px}
}
@media (max-width: 960px){
    #rf{margin-top:-28px;padding:0 16px 32px}
    #rf .catalog-wrap{grid-template-columns:1fr;gap:18px}
    #rf .sidebar{position:static;max-height:none;overflow:visible}
    #rf .sidebar-card{border:1px solid var(--line);border-radius:var(--radius);padding:14px 16px}
    #rf .side-title{border-bottom:none;padding-bottom:6px;margin-bottom:4px}
    #rf .side-nav{flex-direction:row;overflow-x:auto;padding-bottom:4px;scrollbar-width:none}
    #rf .side-nav::-webkit-scrollbar{display:none}
    #rf .side-link{flex:0 0 auto;border:1px solid var(--line);border-radius:999px;padding:8px 14px;gap:8px}
    #rf .side-link.is-active{border-color:var(--dark);background:var(--dark);color:#fff}
    #rf .promo-box{display:none}
    #rf .main-area{padding:0}
    #rf .flower-grid{grid-template-columns:repeat(3,minmax(0,1fr))}
    #rf .flower-media{height:170px}
}
@media (max-width: 640px){
    #rf{margin-top:-18px;padding:0 12px 28px}
    #rf .flower-grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:12px}
    #rf .flower-body{padding:9px;gap:8px}
    #rf .flower-name{font-size:1.05rem}
    #rf .toolbar{align-items:flex-start;flex-wrap:wrap;margin-bottom:14px}
    #rf .sort select{max-width:155px;padding:8px 10px}
    #rf .prices{font-size:.76rem}
    #rf .flower-media{height:145px}
    #rf .stepper{gap:4px}
    #rf .step-btn{width:29px;height:29px}
}
@media (max-width: 380px){
    #rf .flower-grid{grid-template-columns:1fr}
}
</style>

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
                <nav class="side-nav" aria-label="Categories">
                    <a href="{{ url('/flowers') }}" class="side-link {{ $activeCategory ? '' : 'is-active' }}">
                        <span>All Flowers</span>
                        @if(isset($totalFlowersCount))
                            <span class="cat-num">{{ $totalFlowersCount }}</span>
                        @endif
                    </a>

                    @foreach ($categories as $cat)
                        <a href="{{ route('flowers.category', $cat->category_id) }}"
                           class="side-link {{ $activeCategory && $activeCategory->category_id == $cat->category_id ? 'is-active' : '' }}">
                            <span>{{ $cat->category_name }}</span>
                            @if(isset($cat->flowers_count))
                                <span class="cat-num">{{ $cat->flowers_count }}</span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>

            <div class="promo-box">
                <h4>Custom Bouquet</h4>
                <p>Compose a bouquet stem by stem, arranged by our florists.</p>
                <a href="{{ url('/customise') }}">Start customising &rarr;</a>
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
                        <option value="latest"     @selected($sort === 'latest')>Latest</option>
                        <option value="price_low"  @selected($sort === 'price_low')>Price: low to high</option>
                        <option value="price_high" @selected($sort === 'price_high')>Price: high to low</option>
                        <option value="name"       @selected($sort === 'name')>Name A–Z</option>
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
                            $minStems  = max(1, (int) ($flower->min_quantity ?? 1));
                            $stock     = (int) $flower->stock_quantity;
                            $canBunch  = $flower->price_per_bunch !== null && (int) $flower->bunch_quantity > 0;
                            $available = (bool) $flower->availability && $stock >= $minStems;
                            $badge     = ! $available ? ['out', 'Out of stock'] : ($stock <= 20 ? ['low', 'Limited stock'] : ['', 'In stock']);
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
(function () {
    document.querySelectorAll('#rf [data-flower]').forEach(function (card) {
        var stemPrice = parseFloat(card.dataset.stemPrice) || 0;
        var bunchPrice = parseFloat(card.dataset.bunchPrice) || 0;
        var bunchQty = parseInt(card.dataset.bunchQty, 10) || 0;
        var stock = parseInt(card.dataset.stock, 10) || 0;
        var minStems = parseInt(card.dataset.min, 10) || 1;

        var mode = 'stem';
        var stems = minStems;

        var $ = function (s) { return card.querySelector(s); };
        var bStem = $('.m-stem'), bBunch = $('.m-bunch');
        var minus = $('.s-minus'), plus = $('.s-plus');
        var num = $('.q-num'), unit = $('.q-unit'), note = $('.q-note'), price = $('.t-price');
        var fType = $('.f-type'), fQty = $('.f-qty');

        function step()    { return mode === 'bunch' ? bunchQty : 1; }
        function lowest()  { return mode === 'bunch' ? Math.max(bunchQty, Math.ceil(minStems / bunchQty) * bunchQty) : minStems; }
        function highest() { return mode === 'bunch' ? Math.floor(stock / bunchQty) * bunchQty : stock; }

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

        bStem.addEventListener('click', function () { setMode('stem'); });
        bBunch.addEventListener('click', function () { if (!bBunch.disabled) setMode('bunch'); });
        minus.addEventListener('click', function () { if (stems - step() >= lowest()) { stems -= step(); render(); } });
        plus.addEventListener('click', function () { if (stems + step() <= highest()) { stems += step(); render(); } });

        render();
    });
})();
</script>

</x-florist-layout>
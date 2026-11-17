<x-florist-layout>

<style>
#rh{--ink:#1d1517;--muted:#6f5f65;--blush:#f8e6e9;--radius:14px;--gap:24px;--cols:7;
--body:'Jost',system-ui,sans-serif;
display:block;width:100%;max-width:1440px;margin:0 auto;padding:24px 20px 56px;box-sizing:border-box;font-family:var(--body);color:var(--ink)}
#rh *{box-sizing:border-box}
#rh a{text-decoration:none;color:inherit}
#rh h1,#rh h2,#rh h3,#rh p{margin:0}
#rh button{font-family:inherit}

/* ---------- 1. HERO SLIDER (arrows outside, caption below) ---------- */
#rh .hero-ad{display:grid;grid-template-columns:auto 1fr auto;align-items:center;column-gap:18px}
#rh .hero-ad-viewport{overflow:hidden;border-radius:6px;min-width:0}
#rh .hero-ad-track{display:flex;transition:transform .4s cubic-bezier(.65,0,.35,1)}
#rh .hero-ad-slide{flex:0 0 100%;min-width:100%;display:block}
#rh .hero-ad-slide img{display:block;width:100%;aspect-ratio:3/1;object-fit:cover}
#rh .hero-ad-slide h1,#rh .hero-ad-slide h2{font-size:clamp(1.3rem,2.4vw,1.9rem);font-weight:400;margin-top:16px}
#rh .hero-ad-arrow{background:none;border:0;padding:6px;cursor:pointer;color:var(--ink);display:grid;place-items:center;transition:transform .2s,color .2s;align-self:start;margin-top:clamp(40px,9vw,120px)}
#rh .hero-ad-arrow svg{width:clamp(22px,3.4vw,40px);height:clamp(22px,3.4vw,40px)}
#rh .hero-ad-prev:hover{transform:translateX(-3px)}
#rh .hero-ad-next:hover{transform:translateX(3px)}
#rh .hero-ad-dots{grid-column:2;display:flex;justify-content:center;gap:8px;margin-top:6px}
#rh .hero-ad-dot{width:8px;height:8px;border:0;padding:0;border-radius:99px;background:rgba(29,21,23,.25);cursor:pointer;transition:width .25s,background .25s}
#rh .hero-ad-dot.is-active{width:26px;background:var(--ink)}

/* ---------- 2. CATEGORIES (4 cards + MORE) ---------- */
#rh .category-section{margin:44px auto 0;max-width:1200px}
#rh .category-row{display:flex;align-items:center;gap:var(--gap)}
#rh .category-scroll{flex:1;min-width:0;display:flex;flex-wrap:nowrap;gap:var(--gap);overflow-x:auto;scroll-snap-type:x mandatory;scrollbar-width:none;scroll-behavior:smooth}
#rh .category-scroll::-webkit-scrollbar{display:none}
#rh .category-card{position:relative;flex:0 0 calc((100% - (var(--cols) - 1) * var(--gap)) / var(--cols));aspect-ratio:1/1;border-radius:var(--radius);overflow:hidden;scroll-snap-align:start;background:var(--blush);display:block}
#rh .category-card-image-wrapper{position:absolute;inset:0}
#rh .category-card-image{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
#rh .category-card:hover .category-card-image{transform:scale(1.06)}
#rh .category-image-placeholder{height:100%;display:grid;place-items:center;font-size:.8rem;color:var(--muted)}
#rh .category-card::after{content:"";position:absolute;inset:0;background:linear-gradient(0deg,rgba(29,21,23,.55),rgba(29,21,23,.08) 60%)}
#rh .category-card-content{position:absolute;left:0;right:0;bottom:0;z-index:1;padding:14px;text-align:center}
#rh .category-card-content h3{color:#fff;font-size:1rem;font-weight:500;letter-spacing:.08em;text-transform:uppercase}
#rh .category-more{flex:0 0 auto;display:flex;align-items:center;gap:10px;background:none;border:0;cursor:pointer;color:var(--ink);font-size:.8rem;letter-spacing:.06em;text-transform:uppercase;padding:4px;position:relative;top:70px}
#rh .category-more svg{width:16px;height:16px;transition:transform .2s}
#rh .category-more:hover svg{transform:translateX(4px)}
#rh .empty-categories{color:var(--muted)}

/* ---------- 3. ADVERTISEMENT CARDS ---------- */
#rh .mini-ad-section{margin:44px auto 0;max-width:1200px}
#rh .mini-ad-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:var(--gap)}
#rh .mini-ad-card{position:relative;aspect-ratio:2.3/1;border-radius:var(--radius);overflow:hidden;display:block}
#rh .mini-ad-card img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s}
#rh .mini-ad-card:hover img{transform:scale(1.05)}
#rh .mini-ad-content{position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:6px;text-align:center;padding:20px;color:#fff;background:rgba(29,21,23,.38)}
#rh .mini-ad-content h3{font-size:clamp(1.1rem,2.2vw,1.6rem);font-weight:500;letter-spacing:.06em;text-transform:uppercase}
#rh .mini-ad-content p{font-size:.95rem;max-width:36ch}

/* ---------- resets: cancel any old rules from other css files ---------- */
#rh .category-scroll{display:flex!important;grid-template-columns:none!important}
#rh .category-card{border:0!important;box-shadow:none!important;padding:0!important;margin:0!important;max-width:none!important;height:auto!important;display:block!important;background:var(--blush)!important}
#rh .category-card-image-wrapper{position:absolute!important;inset:0!important;width:100%!important;height:100%!important;aspect-ratio:auto!important;border-radius:0!important;outline:0!important;overflow:hidden!important}
#rh .category-card-image{width:100%!important;height:100%!important;max-width:none!important;object-fit:cover!important}
#rh .category-card-content{position:absolute!important;left:0;right:0;bottom:0;background:transparent!important;padding:14px!important;text-align:center!important}
#rh .category-card-content h3{color:#fff!important;text-align:center!important;margin:0!important}
#rh .hero-ad-slide img{max-width:none;height:auto}
#rh .mini-ad-card img{max-width:none}
</style>

<div id="rh">

    {{-- 1. HERO ADVERTISEMENT SLIDER --}}
    <section class="hero-ad" aria-label="Flower promotions">

        <button type="button" class="hero-ad-arrow hero-ad-prev" id="heroAdPrev" aria-label="Previous advertisement">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 4 7 12l8 8"/></svg>
        </button>

        <div class="hero-ad-viewport">
            <div class="hero-ad-track" id="heroAdTrack">

                <a href="#flower-categories" class="hero-ad-slide">
                    <img src="{{ asset('images/homepagephoto.jpg') }}" alt="Welcome to RoSys">
                    <h1>Welcome to RoSys</h1>
                </a>

                <a href="#flower-categories" class="hero-ad-slide">
                    <img src="{{ asset('images/homepagephoto.jpg') }}" alt="Flowers for every special moment">
                    <h2>Flowers for every special moment</h2>
                </a>

                <a href="#flower-categories" class="hero-ad-slide">
                    <img src="{{ asset('images/homepagephoto.jpg') }}" alt="Fresh flowers made with love">
                    <h2>Fresh flowers, made with love</h2>
                </a>

            </div>
        </div>

        <button type="button" class="hero-ad-arrow hero-ad-next" id="heroAdNext" aria-label="Next advertisement">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 4 8 8-8 8"/></svg>
        </button>

        <div class="hero-ad-dots" id="heroAdDots"></div>
    </section>


    {{-- 2. CATEGORY ROW --}}
    <section class="category-section" id="flower-categories">
        <div class="category-row">

            <div class="category-scroll" id="categoryScroll">
                @forelse ($categories as $category)
                    <a href="{{ route('flowers.category', $category->category_id) }}" class="category-card">
                        <div class="category-card-image-wrapper">
                            @if ($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}"
                                     alt="{{ $category->category_name }}"
                                     class="category-card-image" loading="lazy">
                            @else
                                <div class="category-image-placeholder"><span>No image</span></div>
                            @endif
                        </div>
                        <div class="category-card-content">
                            <h3>{{ $category->category_name }}</h3>
                        </div>
                    </a>
                @empty
                    <p class="empty-categories">No flower categories are available yet.</p>
                @endforelse
            </div>

            <button type="button" class="category-more" id="categoryMore" aria-label="Show more categories">
                <span>More</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 4 8 8-8 8"/></svg>
            </button>

        </div>
    </section>


    {{-- 3. ADVERTISEMENT CARDS --}}
    <section class="mini-ad-section">
        <div class="mini-ad-grid">

            <a href="#flower-categories" class="mini-ad-card">
                <img src="{{ asset('images/homepagephoto.jpg') }}" alt="Flowers for every occasion" loading="lazy">
                <div class="mini-ad-content">
                    <h3>Flowers for every occasion</h3>
                    <p>Find the perfect flowers for your loved ones.</p>
                </div>
            </a>

            <a href="#flower-categories" class="mini-ad-card">
                <img src="{{ asset('images/homepagephoto.jpg') }}" alt="Find your perfect bloom" loading="lazy">
                <div class="mini-ad-content">
                    <h3>Find your perfect bloom</h3>
                    <p>Discover colours and flowers you will love.</p>
                </div>
            </a>

        </div>
    </section>

</div>

<script>
(function () {
    // ----- hero slider -----
    var track = document.getElementById('heroAdTrack');
    if (track) {
        var prev = document.getElementById('heroAdPrev');
        var next = document.getElementById('heroAdNext');
        var dotsBox = document.getElementById('heroAdDots');
        var hero = track.closest('.hero-ad');
        var total = track.children.length;
        var index = 0, timer = null, dots = [];

        var goTo = function (i) {
            index = (i + total) % total;
            track.style.transform = 'translateX(-' + (index * 100) + '%)';
            dots.forEach(function (d, n) { d.classList.toggle('is-active', n === index); });
        };
        var stop = function () { clearInterval(timer); };
        var start = function () { stop(); if (total > 1) timer = setInterval(function () { goTo(index + 1); }, 3000); };

        for (var i = 0; i < total; i++) {
            (function (n) {
                var dot = document.createElement('button');
                dot.type = 'button';
                dot.className = 'hero-ad-dot';
                dot.setAttribute('aria-label', 'Go to slide ' + (n + 1));
                dot.addEventListener('click', function () { goTo(n); start(); });
                dotsBox.appendChild(dot);
                dots.push(dot);
            })(i);
        }

        prev.addEventListener('click', function () { goTo(index - 1); start(); });
        next.addEventListener('click', function () { goTo(index + 1); start(); });
        hero.addEventListener('mouseenter', stop);
        hero.addEventListener('mouseleave', start);

        var sx = 0;
        hero.addEventListener('touchstart', function (e) { sx = e.touches[0].clientX; stop(); }, { passive: true });
        hero.addEventListener('touchend', function (e) {
            var d = e.changedTouches[0].clientX - sx;
            if (Math.abs(d) > 50) goTo(index + (d < 0 ? 1 : -1));
            start();
        });

        goTo(0);
        start();
    }

    // ----- category "More" button scrolls the row -----
    var sc = document.getElementById('categoryScroll');
    var more = document.getElementById('categoryMore');
    if (sc && more) {
        var toggleMore = function () {
            more.style.visibility = sc.scrollWidth > sc.clientWidth + 4 ? 'visible' : 'hidden';
        };
        more.addEventListener('click', function () {
            var atEnd = sc.scrollLeft + sc.clientWidth >= sc.scrollWidth - 4;
            sc.scrollTo({ left: atEnd ? 0 : sc.scrollLeft + sc.clientWidth, behavior: 'smooth' });
        });
        window.addEventListener('resize', toggleMore);
        toggleMore();
    }
})();
</script>

</x-florist-layout>
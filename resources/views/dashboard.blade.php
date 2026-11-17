<x-florist-layout>
@push('styles')
    @vite('resources/css/customer-dashboard.css')
@endpush
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
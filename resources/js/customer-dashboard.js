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
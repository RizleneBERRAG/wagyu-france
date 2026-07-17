(function () {
    'use strict';

    var progress = document.querySelector('[data-scroll-progress]');
    var track = document.querySelector('.wf-scroll-progress');
    var header = document.querySelector('[data-site-header]');
    var ticking = false;

    function update() {
        var doc = document.documentElement;
        var max = doc.scrollHeight - window.innerHeight;
        var y = window.scrollY || doc.scrollTop;

        if (track && header) {
            track.style.top = Math.max(0, header.getBoundingClientRect().bottom) + 'px';
        }

        if (progress) {
            var ratio = max > 0 ? Math.min(1, Math.max(0, y / max)) : 0;
            progress.style.transform = 'scaleY(' + ratio + ')';
        }

        ticking = false;
    }

    function requestUpdate() {
        if (!ticking) {
            ticking = true;
            window.requestAnimationFrame(update);
        }
    }

    window.addEventListener('scroll', requestUpdate, { passive: true });
    window.addEventListener('resize', requestUpdate, { passive: true });
    update();
})();
(function () {
    'use strict';

    var cibles = document.querySelectorAll('[data-reveal]');
    if (!cibles.length) { return; }

    if (!('IntersectionObserver' in window)) {
        cibles.forEach(function (el) { el.classList.add('is-revealed'); });
        return;
    }

    var obs = new IntersectionObserver(function (entrees) {
        entrees.forEach(function (e) {
            if (e.isIntersecting) {
                e.target.classList.add('is-revealed');
                obs.unobserve(e.target);
            }
        });
    }, { threshold: 0.3 });

    cibles.forEach(function (el) { obs.observe(el); });
})();
(function () {
    'use strict';

    var cartes = document.querySelectorAll('[data-open-card]');
    if (!cartes.length) { return; }

    function revelerAuScroll(el) {
        if (!('IntersectionObserver' in window)) {
            el.classList.add('is-revealed');
            return;
        }
        var obs = new IntersectionObserver(function (entrees) {
            entrees.forEach(function (e) {
                if (e.isIntersecting) {
                    e.target.classList.add('is-revealed');
                    obs.unobserve(e.target);
                }
            });
        }, { threshold: 0.3 });
        obs.observe(el);
    }

    cartes.forEach(function (carte) {
        var cover = carte.querySelector('.shop-duo-cover');
        if (cover && cover.offsetWidth > 0) {
            cover.addEventListener('click', function () {
                carte.classList.add('is-revealed');
            }, { once: true });
        } else {
            revelerAuScroll(carte);
        }
    });
})();

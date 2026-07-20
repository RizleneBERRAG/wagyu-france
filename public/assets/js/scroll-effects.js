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
    }, { threshold: 0, rootMargin: '0px 0px -12% 0px' });

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
        }, { threshold: 0, rootMargin: '0px 0px -12% 0px' });

        obs.observe(el);
    }

    cartes.forEach(function (carte) {
        var cover = carte.querySelector('.shop-duo-cover');

        if (cover && cover.offsetWidth > 0) {
            cover.addEventListener('click', function () {
                carte.classList.add('is-revealed');
            }, { once: true });

            if (window.matchMedia) {
                var mq = window.matchMedia('(max-width: 980px)');
                var bascule = function (e) {
                    if (e.matches && !carte.classList.contains('is-revealed')) {
                        revelerAuScroll(carte);
                    }
                };

                if (mq.addEventListener) { mq.addEventListener('change', bascule); }
                else if (mq.addListener) { mq.addListener(bascule); }
            }
        } else {
            revelerAuScroll(carte);
        }
    });
})();

(function () {
    'use strict';

    var nav = document.querySelector('[data-section-nav]');
    if (!nav) { return; }

    var header = document.querySelector('[data-site-header]');
    var rail = nav.firstElementChild;
    var links = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));
    var sections = links
        .map(function (link) {
            return document.getElementById(link.getAttribute('href').slice(1));
        })
        .filter(Boolean);

    if (!sections.length) { return; }

    var ticking = false;
    var activeId = '';

    function topOf(element) {
        return element.getBoundingClientRect().top + (window.scrollY || window.pageYOffset || 0);
    }

    function updateActiveLink(section) {
        if (!section || activeId === section.id) { return; }

        activeId = section.id;
        var activeLink = null;

        links.forEach(function (link) {
            var active = link.getAttribute('href') === '#' + activeId;
            link.classList.toggle('is-active', active);

            if (active) {
                link.setAttribute('aria-current', 'true');
                activeLink = link;
            } else {
                link.removeAttribute('aria-current');
            }
        });

        if (window.innerWidth < 1760 && rail && activeLink) {
            var targetLeft = activeLink.offsetLeft - ((rail.clientWidth - activeLink.offsetWidth) / 2);

            if (typeof rail.scrollTo === 'function') {
                rail.scrollTo({
                    left: Math.max(0, targetLeft),
                    behavior: 'smooth'
                });
            } else {
                rail.scrollLeft = Math.max(0, targetLeft);
            }
        }
    }

    function updateNavigation() {
        var viewportY = window.scrollY || window.pageYOffset || 0;
        var headerBottom = header
            ? Math.max(0, Math.round(header.getBoundingClientRect().bottom))
            : 0;
        var wideRail = window.innerWidth >= 1760;
        var navHeight = wideRail ? 0 : Math.round(nav.getBoundingClientRect().height);
        var activationOffset = Math.max(
            headerBottom + navHeight + 36,
            Math.round(window.innerHeight * 0.36)
        );
        var activationY = viewportY + activationOffset;
        var current = sections[0];

        document.documentElement.style.setProperty(
            '--wf-section-nav-top',
            headerBottom + 'px'
        );

        sections.forEach(function (section) {
            if (topOf(section) <= activationY) {
                current = section;
            }

            section.style.scrollMarginTop = (headerBottom + navHeight + 24) + 'px';
        });

        var firstTop = topOf(sections[0]);
        var lastSection = sections[sections.length - 1];
        var lastBottom = topOf(lastSection) + lastSection.offsetHeight;
        var inContent = activationY >= firstTop && activationY <= lastBottom;

        nav.classList.toggle('is-in-content', inContent);
        updateActiveLink(current);
        ticking = false;
    }

    function requestNavigationUpdate() {
        if (!ticking) {
            ticking = true;
            window.requestAnimationFrame(updateNavigation);
        }
    }

    links.forEach(function (link) {
        link.addEventListener('click', function () {
            window.setTimeout(requestNavigationUpdate, 80);
        });
    });

    window.addEventListener('scroll', requestNavigationUpdate, { passive: true });
    window.addEventListener('resize', requestNavigationUpdate, { passive: true });
    window.addEventListener('load', requestNavigationUpdate);

    updateNavigation();
})();

(function () {
    'use strict';

    var livre = document.querySelector('[data-book]');
    if (!livre) { return; }

    var feuilles = Array.prototype.slice.call(livre.querySelectorAll('.story-leaf'));
    if (!feuilles.length) { return; }

    livre.addEventListener('click', function () {
        var courante = -1;

        for (var i = 0; i < feuilles.length; i++) {
            if (!feuilles[i].classList.contains('is-turned')) {
                courante = i;
                break;
            }
        }

        if (courante >= 0 && courante < feuilles.length - 1) {
            feuilles[courante].classList.add('is-turned');
        } else {
            feuilles.forEach(function (f) {
                f.classList.remove('is-turned');
            });
        }
    });
})();

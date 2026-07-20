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

    var liens = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));
    var sections = liens
        .map(function (a) { return document.getElementById(a.getAttribute('href').slice(1)); })
        .filter(Boolean);
    if (!sections.length) { return; }

    var premiereSection = sections[0];
    var visibiliteTicking = false;

    function activer(id) {
        liens.forEach(function (a) {
            a.classList.toggle('is-active', a.getAttribute('href') === '#' + id);
        });
    }

    function actualiserVisibiliteDebut() {
        var ligneActivation = Math.min(window.innerHeight * 0.46, 440);
        var avantPremierChapitre = premiereSection.getBoundingClientRect().top > ligneActivation;

        nav.classList.toggle('is-before-content', avantPremierChapitre);

        if (avantPremierChapitre) {
            nav.style.setProperty('opacity', '0', 'important');
            nav.style.setProperty('visibility', 'hidden', 'important');
            nav.style.setProperty('pointer-events', 'none', 'important');
        } else {
            nav.style.removeProperty('opacity');
            nav.style.removeProperty('visibility');
            nav.style.removeProperty('pointer-events');
        }

        visibiliteTicking = false;
    }

    function demanderVisibiliteDebut() {
        if (!visibiliteTicking) {
            visibiliteTicking = true;
            window.requestAnimationFrame(actualiserVisibiliteDebut);
        }
    }

    window.addEventListener('scroll', demanderVisibiliteDebut, { passive: true });
    window.addEventListener('resize', demanderVisibiliteDebut, { passive: true });
    actualiserVisibiliteDebut();

    if (!('IntersectionObserver' in window)) {
        activer(premiereSection.id);
        return;
    }

    var obs = new IntersectionObserver(function (entrees) {
        entrees.forEach(function (e) {
            if (e.isIntersecting) { activer(e.target.id); }
        });
    }, { rootMargin: '-35% 0px -55% 0px' });

    sections.forEach(function (s) { obs.observe(s); });
})();
(function () {
    'use strict';

    var nav = document.querySelector('[data-section-nav]');
    var fin = document.querySelector('[data-nav-end]') || document.querySelector('.wagyu-origin');
    if (!nav || !fin || !('IntersectionObserver' in window)) { return; }

    var obs = new IntersectionObserver(function (entrees) {
        nav.classList.toggle('is-hidden', entrees[0].isIntersecting);
    }, { rootMargin: '0px 0px -18% 0px' });

    obs.observe(fin);
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
            if (!feuilles[i].classList.contains('is-turned')) { courante = i; break; }
        }

        if (courante >= 0 && courante < feuilles.length - 1) {
            feuilles[courante].classList.add('is-turned');
        } else {
            feuilles.forEach(function (f) { f.classList.remove('is-turned'); });
        }
    });
})();
(function () {
    'use strict';

    var nav = document.querySelector('[data-section-nav]');
    if (!nav) { return; }

    var links = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]'));
    var contentShells = document.querySelectorAll(
        '.wagyu-page [data-section-nav] ~ section:not([data-nav-end]) > .wagyu-shell,' +
        '.histoire-page [data-section-nav] ~ section:not([data-nav-end]) > .story-shell,' +
        '.blog-page [data-section-nav] ~ section:not([data-nav-end]) > .journal-shell,' +
        '.professionnels-page [data-section-nav] ~ section:not([data-nav-end]) > .pro-shell,' +
        '.decoupe-page [data-section-nav] ~ section:not([data-nav-end]) > .cut-shell,' +
        '.tracabilite-page [data-section-nav] ~ section:not([data-nav-end]) > .trace-shell'
    );

    function setImportant(element, property, value) {
        element.style.setProperty(property, value, 'important');
    }

    function clearProperty(element, property) {
        element.style.removeProperty(property);
    }

    function updateCompactRail() {
        var compact = window.innerWidth >= 1500 && window.innerWidth <= 1899;

        if (compact) {
            setImportant(nav, 'left', '18px');
            setImportant(nav, 'width', '76px');
            setImportant(nav, 'max-width', '76px');

            links.forEach(function (link) {
                setImportant(link, 'gap', '9px');
                setImportant(link, 'width', '64px');
                setImportant(link, 'overflow', 'hidden');
                setImportant(link, 'white-space', 'nowrap');
                setImportant(link, 'font-size', '0');

                var number = link.querySelector('span');
                if (number) { setImportant(number, 'font-size', '13.5px'); }
            });

            contentShells.forEach(function (shell) {
                setImportant(shell, 'padding-left', '0');
            });
        } else {
            ['left', 'width', 'max-width'].forEach(function (property) {
                clearProperty(nav, property);
            });

            links.forEach(function (link) {
                ['gap', 'width', 'overflow', 'white-space', 'font-size'].forEach(function (property) {
                    clearProperty(link, property);
                });

                var number = link.querySelector('span');
                if (number) { clearProperty(number, 'font-size'); }
            });

            contentShells.forEach(function (shell) {
                clearProperty(shell, 'padding-left');
            });
        }
    }

    window.addEventListener('resize', updateCompactRail, { passive: true });
    updateCompactRail();
})();

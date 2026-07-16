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

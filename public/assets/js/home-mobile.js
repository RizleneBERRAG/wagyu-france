document.addEventListener('DOMContentLoaded', () => {
    const mobileQuery = window.matchMedia('(max-width: 760px)');

    const carouselSelectors = [
        '.home-private-proof',
        '.home-private-cards',
        '.home-product-grid',
        '.home-pro-steps',
        '.home-pro-feature-grid',
        '.home-pro-metrics'
    ];

    const carousels = [];

    function getScrollTarget(carousel, target) {
        return target.offsetLeft - carousel.offsetLeft;
    }

    function createDots(carousel, items) {
        let dots = carousel.nextElementSibling;

        if (!dots || !dots.classList.contains('mobile-carousel-dots')) {
            dots = document.createElement('div');
            dots.className = 'mobile-carousel-dots';
            carousel.insertAdjacentElement('afterend', dots);
        }

        dots.innerHTML = '';

        items.forEach((_, index) => {
            const button = document.createElement('button');
            button.type = 'button';

            if (index === 0) {
                button.classList.add('is-active');
            }

            button.addEventListener('click', () => {
                const target = items[index];

                carousel.scrollTo({
                    left: getScrollTarget(carousel, target),
                    behavior: 'smooth'
                });
            });

            dots.appendChild(button);
        });

        return dots;
    }

    function updateDots(carousel, items, dots) {
        if (!dots) return;

        const scrollLeft = carousel.scrollLeft;

        let activeIndex = 0;
        let closestDistance = Infinity;

        items.forEach((item, index) => {
            const distance = Math.abs(getScrollTarget(carousel, item) - scrollLeft);

            if (distance < closestDistance) {
                closestDistance = distance;
                activeIndex = index;
            }
        });

        dots.querySelectorAll('button').forEach((button, index) => {
            button.classList.toggle('is-active', index === activeIndex);
        });
    }

    function setupCarousel(carousel) {
        if (carousel.dataset.mobileCarouselReady === 'true') return;

        const items = Array.from(carousel.children).filter((child) => {
            return child.tagName.toLowerCase() === 'article';
        });

        if (items.length <= 1) return;

        const dots = createDots(carousel, items);

        const state = {
            carousel,
            items,
            dots,
            timer: null,
            isTouched: false
        };

        carousel.addEventListener('scroll', () => {
            updateDots(carousel, items, dots);
        }, { passive: true });

        carousel.addEventListener('touchstart', () => {
            state.isTouched = true;
        }, { passive: true });

        carousel.addEventListener('touchend', () => {
            setTimeout(() => {
                state.isTouched = false;
            }, 2400);
        }, { passive: true });

        carousel.dataset.mobileCarouselReady = 'true';
        carousels.push(state);
    }

    function getActiveIndex(carousel, items) {
        const scrollLeft = carousel.scrollLeft;

        let activeIndex = 0;
        let closestDistance = Infinity;

        items.forEach((item, index) => {
            const distance = Math.abs(getScrollTarget(carousel, item) - scrollLeft);

            if (distance < closestDistance) {
                closestDistance = distance;
                activeIndex = index;
            }
        });

        return activeIndex;
    }

    function startAutoSlide(state) {
        if (state.timer) return;

        state.timer = setInterval(() => {
            if (!mobileQuery.matches) return;
            if (state.isTouched) return;

            const currentIndex = getActiveIndex(state.carousel, state.items);
            const nextIndex = currentIndex >= state.items.length - 1 ? 0 : currentIndex + 1;
            const target = state.items[nextIndex];

            state.carousel.scrollTo({
                left: getScrollTarget(state.carousel, target),
                behavior: 'smooth'
            });
        }, 3600);
    }

    function stopAutoSlide(state) {
        if (!state.timer) return;

        clearInterval(state.timer);
        state.timer = null;
    }

    function initMobileCarousels() {
        carouselSelectors.forEach((selector) => {
            document.querySelectorAll(selector).forEach(setupCarousel);
        });

        carousels.forEach((state) => {
            if (mobileQuery.matches) {
                startAutoSlide(state);
            } else {
                stopAutoSlide(state);
            }
        });
    }

    initMobileCarousels();

    window.addEventListener('resize', () => {
        initMobileCarousels();
    });
});

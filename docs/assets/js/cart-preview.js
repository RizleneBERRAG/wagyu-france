const cartDrawer = document.querySelector('[data-cart-drawer]');
const cartOpen = document.querySelector('[data-cart-open]');
const cartClose = document.querySelector('[data-cart-close]');

if (cartDrawer && cartOpen && cartClose) {
    cartOpen.addEventListener('click', () => {
        cartDrawer.classList.add('is-open');
    });

    cartClose.addEventListener('click', () => {
        cartDrawer.classList.remove('is-open');
    });

    cartDrawer.addEventListener('click', (event) => {
        if (event.target === cartDrawer) {
            cartDrawer.classList.remove('is-open');
        }
    });
}

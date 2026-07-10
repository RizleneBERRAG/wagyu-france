document.addEventListener('DOMContentLoaded', () => {
    const productCards = document.querySelectorAll('.shop-product-card');
    const filterButtons = document.querySelectorAll('[data-filter]');

    const cartOpenButtons = document.querySelectorAll('[data-shop-cart-open]');
    const cartCloseButtons = document.querySelectorAll('[data-shop-cart-close]');
    const cartOverlay = document.querySelector('[data-shop-cart-overlay]');
    const cartDrawer = document.querySelector('[data-shop-cart-drawer]');
    const cartItems = document.querySelector('[data-shop-cart-items]');
    const cartEmpty = document.querySelector('[data-shop-cart-empty]');
    const cartTotal = document.querySelector('[data-shop-cart-total]');
    const cartCounters = document.querySelectorAll('[data-shop-cart-count]');
    const cartClear = document.querySelector('[data-shop-cart-clear]');
    const checkoutButton = document.querySelector('[data-shop-checkout]');
    const checkoutForm = document.querySelector('[data-shop-checkout-form]');
    const checkoutBack = document.querySelector('[data-shop-checkout-back]');
    const confirmation = document.querySelector('[data-shop-confirmation]');
    const confirmationSummary = document.querySelector('[data-shop-confirmation-summary]');

    const catalogue = {};

    productCards.forEach((card) => {
        const input = card.querySelector('[data-product-qty]');
        const id = card.dataset.productId;

        catalogue[id] = {
            name: card.dataset.name,
            price: Number(card.dataset.price) || 0,
            stock: Number(card.dataset.stock) || 0,
            min: Number(input?.min) || 1,
            max: Number(input?.max) || Math.max(1, Number(card.dataset.stock) || 1)
        };
    });

    let shopCart = {};

    try {
        shopCart = JSON.parse(sessionStorage.getItem('wf-shop-cart') || '{}');
    } catch {
        shopCart = {};
    }

    Object.entries(shopCart).forEach(([id, item]) => {
        const product = catalogue[id];

        if (!product || product.stock < product.min) {
            delete shopCart[id];
            return;
        }

        item.name = product.name;
        item.price = product.price;
        item.quantity = Math.min(product.max, Math.max(product.min, Number(item.quantity) || product.min));
        item.stock = product.stock;
        item.min = product.min;
        item.max = product.max;
    });

    function saveCart() {
        sessionStorage.setItem('wf-shop-cart', JSON.stringify(shopCart));
    }

    function formatPrice(value) {
        return `${Math.round(value).toLocaleString('fr-FR')} €`;
    }

    function formatQuantity(value) {
        return Number(value).toLocaleString('fr-FR', { maximumFractionDigits: 1 });
    }

    function escapeHtml(value) {
        const element = document.createElement('div');
        element.textContent = String(value ?? '');
        return element.innerHTML;
    }

    function getCartCount() {
        return Object.values(shopCart).reduce((total, item) => total + Number(item.quantity || 0), 0);
    }

    function getCartTotal(cart = shopCart) {
        return Object.values(cart).reduce((total, item) => {
            return total + (Number(item.price || 0) * Number(item.quantity || 0));
        }, 0);
    }

    function hideCheckoutStates() {
        checkoutForm?.classList.add('is-hidden');
        confirmation?.classList.add('is-hidden');
        cartDrawer?.classList.remove('is-checkout', 'is-confirmed');
    }

    function openCart() {
        if (!cartDrawer || !cartOverlay) return;
        cartDrawer.classList.add('is-open');
        cartOverlay.classList.add('is-open');
        cartDrawer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('shop-cart-open');
    }

    function closeCart() {
        if (!cartDrawer || !cartOverlay) return;
        cartDrawer.classList.remove('is-open');
        cartOverlay.classList.remove('is-open');
        cartDrawer.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('shop-cart-open');
        setTimeout(hideCheckoutStates, 280);
    }

    function renderCart() {
        if (!cartItems || !cartTotal || !cartEmpty) return;

        const entries = Object.entries(shopCart);
        cartItems.innerHTML = '';
        cartEmpty.classList.toggle('is-hidden', entries.length > 0);

        entries.forEach(([id, item]) => {
            const article = document.createElement('article');
            article.className = 'shop-cart-item';
            article.innerHTML = `
                <div class="shop-cart-item-top">
                    <div>
                        <h3>${escapeHtml(item.name)}</h3>
                        <small>${formatPrice(item.price)} / kg · ${formatQuantity(item.stock)} kg disponibles</small>
                    </div>
                    <button class="shop-cart-remove" type="button" data-remove="${escapeHtml(id)}" aria-label="Retirer ${escapeHtml(item.name)}">×</button>
                </div>
                <div class="shop-cart-item-bottom">
                    <div class="shop-cart-qty">
                        <button type="button" data-minus="${escapeHtml(id)}">−</button>
                        <span>${formatQuantity(item.quantity)} kg</span>
                        <button type="button" data-plus="${escapeHtml(id)}">+</button>
                    </div>
                    <strong class="shop-cart-line-total">${formatPrice(item.price * item.quantity)}</strong>
                </div>
            `;
            cartItems.appendChild(article);
        });

        cartTotal.textContent = formatPrice(getCartTotal());
        cartCounters.forEach((counter) => counter.textContent = formatQuantity(getCartCount()));
        saveCart();
    }

    function addProduct(card) {
        const id = card.dataset.productId;
        const product = catalogue[id];
        const input = card.querySelector('[data-product-qty]');
        const button = card.querySelector('[data-add-product]');

        if (!product || !input || button?.disabled) return;

        const requested = Math.min(product.max, Math.max(product.min, Number(input.value) || product.min));
        const current = Number(shopCart[id]?.quantity || 0);
        const quantity = Math.min(product.max, current + requested);

        shopCart[id] = { ...product, quantity };

        if (button) {
            button.textContent = quantity >= product.max ? 'Stock atteint' : 'Ajouté';
            setTimeout(() => {
                button.textContent = 'Ajouter';
            }, 1200);
        }

        hideCheckoutStates();
        renderCart();
        openCart();
    }

    function updateCartItem(id, delta) {
        const item = shopCart[id];
        if (!item) return;

        const next = Number(item.quantity) + delta;

        if (next < item.min) {
            delete shopCart[id];
        } else {
            item.quantity = Math.min(item.max, next);
        }

        hideCheckoutStates();
        renderCart();
    }

    function showCheckout() {
        if (Object.keys(shopCart).length === 0) return openCart();
        if (!checkoutForm || !cartDrawer) return;

        cartDrawer.classList.add('is-checkout');
        cartDrawer.classList.remove('is-confirmed');
        checkoutForm.classList.remove('is-hidden');
        confirmation?.classList.add('is-hidden');
        checkoutForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function buildConfirmation(formData, cartSnapshot, totalSnapshot, reference) {
        if (!confirmationSummary) return;

        const items = Object.values(cartSnapshot)
            .map((item) => `${escapeHtml(item.name)} — ${formatQuantity(item.quantity)} kg`)
            .join('<br>');

        confirmationSummary.innerHTML = `
            <strong>Référence :</strong> ${escapeHtml(reference)}<br>
            <strong>Contact :</strong> ${escapeHtml(formData.get('fullname'))}<br>
            <strong>Email :</strong> ${escapeHtml(formData.get('email'))}<br>
            <strong>Téléphone :</strong> ${escapeHtml(formData.get('phone'))}<br>
            <strong>Ville :</strong> ${escapeHtml(formData.get('city'))}<br>
            <strong>Total estimatif :</strong> ${formatPrice(totalSnapshot)}<br><br>
            <strong>Pièces demandées :</strong><br>${items}
        `;
    }

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;
            filterButtons.forEach((item) => item.classList.toggle('is-active', item === button));

            productCards.forEach((card) => {
                const categories = card.dataset.category || '';
                card.classList.toggle('is-hidden', filter !== 'all' && !categories.split(' ').includes(filter));
            });
        });
    });

    productCards.forEach((card) => {
        const minus = card.querySelector('[data-product-minus]');
        const plus = card.querySelector('[data-product-plus]');
        const input = card.querySelector('[data-product-qty]');
        const addButton = card.querySelector('[data-add-product]');

        minus?.addEventListener('click', () => {
            const minimum = Number(input.min) || 1;
            input.value = String(Math.max(minimum, (Number(input.value) || minimum) - 1));
        });

        plus?.addEventListener('click', () => {
            const maximum = Number(input.max) || 999;
            input.value = String(Math.min(maximum, (Number(input.value) || 0) + 1));
        });

        input?.addEventListener('change', () => {
            const minimum = Number(input.min) || 1;
            const maximum = Number(input.max) || 999;
            input.value = String(Math.min(maximum, Math.max(minimum, Number(input.value) || minimum)));
        });

        addButton?.addEventListener('click', () => addProduct(card));
    });

    cartOpenButtons.forEach((button) => button.addEventListener('click', openCart));
    cartCloseButtons.forEach((button) => button.addEventListener('click', closeCart));
    cartOverlay?.addEventListener('click', closeCart);

    cartItems?.addEventListener('click', (event) => {
        const minus = event.target.closest('[data-minus]');
        const plus = event.target.closest('[data-plus]');
        const remove = event.target.closest('[data-remove]');

        if (minus) updateCartItem(minus.dataset.minus, -1);
        if (plus) updateCartItem(plus.dataset.plus, 1);
        if (remove) {
            delete shopCart[remove.dataset.remove];
            hideCheckoutStates();
            renderCart();
        }
    });

    cartClear?.addEventListener('click', () => {
        shopCart = {};
        hideCheckoutStates();
        renderCart();
    });

    checkoutButton?.addEventListener('click', showCheckout);
    checkoutBack?.addEventListener('click', () => {
        checkoutForm?.classList.add('is-hidden');
        cartDrawer?.classList.remove('is-checkout');
    });

    checkoutForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!checkoutForm.checkValidity()) return checkoutForm.reportValidity();

        const submitButton = checkoutForm.querySelector('.shop-checkout-submit');
        const formData = new FormData(checkoutForm);
        const cartSnapshot = JSON.parse(JSON.stringify(shopCart));
        const totalSnapshot = getCartTotal(cartSnapshot);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        const payload = {
            _token: csrfToken,
            fullname: formData.get('fullname'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            city: formData.get('city'),
            message: formData.get('message'),
            cart: Object.entries(cartSnapshot).map(([key, item]) => ({ key, quantity: item.quantity }))
        };

        try {
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Envoi en cours...';
            }

            const response = await fetch(checkoutForm.dataset.orderUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            if (!response.ok) throw data;

            buildConfirmation(formData, cartSnapshot, totalSnapshot, data.reference || '');
            shopCart = {};
            renderCart();
            checkoutForm.reset();
            checkoutForm.classList.add('is-hidden');
            cartDrawer?.classList.remove('is-checkout');
            cartDrawer?.classList.add('is-confirmed');
            confirmation?.classList.remove('is-hidden');
            confirmation?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (error) {
            const firstError = error?.errors ? Object.values(error.errors).flat()[0] : null;
            alert(firstError || error?.message || 'Impossible d’envoyer la demande pour le moment.');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Valider ma demande';
            }
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeCart();
    });

    renderCart();
});

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

    let shopCart = JSON.parse(sessionStorage.getItem('wf-shop-cart') || '{}');

    function saveCart() {
        sessionStorage.setItem('wf-shop-cart', JSON.stringify(shopCart));
    }

    function formatPrice(value) {
        return `${Math.round(value).toLocaleString('fr-FR')} €`;
    }

    function escapeHtml(value) {
        const element = document.createElement('div');
        element.textContent = String(value ?? '');
        return element.innerHTML;
    }

    function getCartCount() {
        return Object.values(shopCart).reduce((total, item) => total + item.quantity, 0);
    }

    function getCartTotal(cart = shopCart) {
        return Object.values(cart).reduce((total, item) => {
            return total + (item.price * item.quantity);
        }, 0);
    }

    function hideCheckoutStates() {
        if (checkoutForm) checkoutForm.classList.add('is-hidden');
        if (confirmation) confirmation.classList.add('is-hidden');
        if (cartDrawer) {
            cartDrawer.classList.remove('is-checkout');
            cartDrawer.classList.remove('is-confirmed');
        }
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

        setTimeout(() => {
            hideCheckoutStates();
        }, 280);
    }

    function renderCart() {
        if (!cartItems || !cartTotal || !cartEmpty) return;

        const entries = Object.entries(shopCart);
        cartItems.innerHTML = '';

        cartEmpty.classList.toggle('is-hidden', entries.length > 0);

        entries.forEach(([id, item]) => {
            const lineTotal = item.price * item.quantity;
            const safeName = escapeHtml(item.name);
            const safeId = escapeHtml(id);

            const article = document.createElement('article');
            article.className = 'shop-cart-item';

            article.innerHTML = `
                <div class="shop-cart-item-top">
                    <div>
                        <h3>${safeName}</h3>
                        <small>${item.price} €/kg</small>
                    </div>

                    <button class="shop-cart-remove" type="button" data-remove="${safeId}" aria-label="Retirer ${safeName}">
                        ×
                    </button>
                </div>

                <div class="shop-cart-item-bottom">
                    <div class="shop-cart-qty">
                        <button type="button" data-minus="${safeId}">-</button>
                        <span>${item.quantity}</span>
                        <button type="button" data-plus="${safeId}">+</button>
                    </div>

                    <strong class="shop-cart-line-total">${formatPrice(lineTotal)}</strong>
                </div>
            `;

            cartItems.appendChild(article);
        });

        cartTotal.textContent = formatPrice(getCartTotal());

        cartCounters.forEach((counter) => {
            counter.textContent = getCartCount();
        });

        saveCart();
    }

    function addProduct(card) {
        const id = card.dataset.productId;
        const name = card.dataset.name;
        const price = Number(card.dataset.price) || 0;
        const qtyInput = card.querySelector('[data-product-qty]');
        const quantity = Math.max(1, Number(qtyInput?.value) || 1);

        if (!shopCart[id]) {
            shopCart[id] = {
                name,
                price,
                quantity: 0
            };
        }

        shopCart[id].quantity += quantity;

        const button = card.querySelector('[data-add-product]');
        if (button) {
            button.textContent = 'Ajouté';
            setTimeout(() => {
                button.textContent = 'Ajouter';
            }, 1200);
        }

        hideCheckoutStates();
        renderCart();
        openCart();
    }

    function updateCartItem(id, delta) {
        if (!shopCart[id]) return;

        shopCart[id].quantity += delta;

        if (shopCart[id].quantity <= 0) {
            delete shopCart[id];
        }

        hideCheckoutStates();
        renderCart();
    }

    function removeCartItem(id) {
        delete shopCart[id];
        hideCheckoutStates();
        renderCart();
    }

    function showCheckout() {
        if (getCartCount() === 0) {
            openCart();
            return;
        }

        if (!checkoutForm || !cartDrawer) return;

        cartDrawer.classList.add('is-checkout');
        cartDrawer.classList.remove('is-confirmed');
        checkoutForm.classList.remove('is-hidden');

        if (confirmation) {
            confirmation.classList.add('is-hidden');
        }

        checkoutForm.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }

    function buildConfirmation(formData, cartSnapshot, totalSnapshot) {
        if (!confirmationSummary) return;

        const items = Object.values(cartSnapshot)
            .map((item) => {
                return `${escapeHtml(item.name)} — ${item.quantity} kg`;
            })
            .join('<br>');

        confirmationSummary.innerHTML = `
            <strong>Contact :</strong> ${escapeHtml(formData.get('fullname'))}<br>
            <strong>Email :</strong> ${escapeHtml(formData.get('email'))}<br>
            <strong>Téléphone :</strong> ${escapeHtml(formData.get('phone'))}<br>
            <strong>Ville :</strong> ${escapeHtml(formData.get('city'))}<br>
            <strong>Total estimatif :</strong> ${formatPrice(totalSnapshot)}<br><br>
            <strong>Pièces demandées :</strong><br>
            ${items}
        `;
    }

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            const filter = button.dataset.filter;

            filterButtons.forEach((item) => {
                item.classList.toggle('is-active', item === button);
            });

            productCards.forEach((card) => {
                const categories = card.dataset.category || '';
                const shouldShow = filter === 'all' || categories.includes(filter);

                card.classList.toggle('is-hidden', !shouldShow);
            });
        });
    });

    productCards.forEach((card) => {
        const minus = card.querySelector('[data-product-minus]');
        const plus = card.querySelector('[data-product-plus]');
        const input = card.querySelector('[data-product-qty]');
        const addButton = card.querySelector('[data-add-product]');

        if (minus && input) {
            minus.addEventListener('click', () => {
                const currentValue = Number(input.value) || 1;
                input.value = Math.max(1, currentValue - 1);
            });
        }

        if (plus && input) {
            plus.addEventListener('click', () => {
                const currentValue = Number(input.value) || 1;
                input.value = currentValue + 1;
            });
        }

        if (addButton) {
            addButton.addEventListener('click', () => {
                addProduct(card);
            });
        }
    });

    cartOpenButtons.forEach((button) => {
        button.addEventListener('click', openCart);
    });

    cartCloseButtons.forEach((button) => {
        button.addEventListener('click', closeCart);
    });

    if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCart);
    }

    if (cartItems) {
        cartItems.addEventListener('click', (event) => {
            const minus = event.target.closest('[data-minus]');
            const plus = event.target.closest('[data-plus]');
            const remove = event.target.closest('[data-remove]');

            if (minus) {
                updateCartItem(minus.dataset.minus, -1);
            }

            if (plus) {
                updateCartItem(plus.dataset.plus, 1);
            }

            if (remove) {
                removeCartItem(remove.dataset.remove);
            }
        });
    }

    if (cartClear) {
        cartClear.addEventListener('click', () => {
            shopCart = {};
            hideCheckoutStates();
            renderCart();
        });
    }

    if (checkoutButton) {
        checkoutButton.addEventListener('click', showCheckout);
    }

    if (checkoutBack) {
        checkoutBack.addEventListener('click', () => {
            if (checkoutForm) checkoutForm.classList.add('is-hidden');
            if (cartDrawer) cartDrawer.classList.remove('is-checkout');
        });
    }

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (!checkoutForm.checkValidity()) {
                checkoutForm.reportValidity();
                return;
            }

            const submitButton = checkoutForm.querySelector('.shop-checkout-submit');
            const formData = new FormData(checkoutForm);
            const cartSnapshot = structuredClone(shopCart);
            const totalSnapshot = getCartTotal(cartSnapshot);

            const cartPayload = Object.entries(shopCart).map(([key, item]) => {
                return {
                    key: key,
                    quantity: item.quantity
                };
            });

            const csrfToken =
                document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                checkoutForm.querySelector('input[name="_token"]')?.value ||
                '';

            const payload = {
                _token: csrfToken,
                fullname: formData.get('fullname'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                city: formData.get('city'),
                message: formData.get('message'),
                cart: cartPayload
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

                if (!response.ok) {
                    throw data;
                }

                buildConfirmation(formData, cartSnapshot, totalSnapshot);

                if (confirmationSummary && data.reference) {
                    confirmationSummary.insertAdjacentHTML(
                        'afterbegin',
                        `<strong>Référence :</strong> ${escapeHtml(data.reference)}<br>`
                    );
                }

                shopCart = {};
                renderCart();
                checkoutForm.reset();
                checkoutForm.classList.add('is-hidden');

                if (cartDrawer) {
                    cartDrawer.classList.remove('is-checkout');
                    cartDrawer.classList.add('is-confirmed');
                }

                if (confirmation) {
                    confirmation.classList.remove('is-hidden');
                    confirmation.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            } catch (error) {
                let message = 'Impossible d’envoyer la demande pour le moment.';

                if (error?.message) {
                    message = error.message;
                }

                alert(message);
            } finally {
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.textContent = 'Valider ma demande';
                }
            }
        });
    }

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeCart();
        }
    });

    renderCart();
});
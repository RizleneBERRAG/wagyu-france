const RESERVE_STAGE = { width: 1000, height: 520 };

const RESERVE_GEOMETRY = {
    paleron: {
        dot: { x: 280, y: 240 }, label: { x: 90, y: 245 }, hit: { x: 280, y: 240, w: 180, h: 120 },
        frame: { x: 252, y: 238, w: 210, h: 130, rotate: -10, radius: '48% 52% 46% 54% / 50% 46% 54% 50%' }
    },
    entrecote: {
        dot: { x: 470, y: 150 }, label: { x: 500, y: 40 }, hit: { x: 470, y: 150, w: 240, h: 110 },
        frame: { x: 515, y: 185, w: 300, h: 92, rotate: 2, radius: '46% 54% 50% 50% / 58% 50% 50% 42%' }
    },
    fauxfilet: {
        dot: { x: 665, y: 160 }, label: { x: 700, y: 65 }, hit: { x: 665, y: 160, w: 210, h: 110 },
        frame: { x: 690, y: 190, w: 250, h: 100, rotate: -2, radius: '44% 56% 48% 52% / 58% 50% 50% 42%' }
    },
    rumsteak: {
        dot: { x: 830, y: 225 }, label: { x: 970, y: 235 }, hit: { x: 830, y: 225, w: 160, h: 130 },
        frame: { x: 820, y: 235, w: 160, h: 140, rotate: 10, radius: '44% 56% 52% 48% / 50% 48% 52% 50%' }
    },
    filet: {
        dot: { x: 610, y: 340 }, label: { x: 735, y: 345 }, hit: { x: 610, y: 340, w: 240, h: 100 },
        frame: { x: 600, y: 335, w: 230, h: 86, rotate: -8, radius: '52% 48% 54% 46% / 58% 46% 54% 42%' }
    },
    macreuse: {
        dot: { x: 335, y: 335 }, label: { x: 275, y: 495 }, hit: { x: 335, y: 335, w: 180, h: 135 },
        frame: { x: 355, y: 355, w: 200, h: 145, rotate: -20, radius: '48% 52% 50% 50% / 42% 58% 42% 58%' }
    },
    jarret: {
        dot: { x: 820, y: 445 }, label: { x: 940, y: 485 }, hit: { x: 820, y: 445, w: 150, h: 150 },
        frame: { x: 835, y: 438, w: 110, h: 175, rotate: 8, radius: '46% 54% 48% 52% / 36% 36% 64% 64%' }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const dataElement = document.getElementById('reserve-cuts-data');
    let reserveData = {};

    try {
        reserveData = JSON.parse(dataElement?.textContent || '{}');
    } catch (error) {
        console.error('Données de réserve invalides', error);
    }

    const cuts = Object.fromEntries(
        Object.entries(reserveData).map(([key, cut]) => [key, { ...cut, ...(RESERVE_GEOMETRY[key] || {}) }])
    );

    const cutKeys = Object.keys(cuts);
    if (cutKeys.length === 0) return;

    const animalStage = document.querySelector('[data-animal-stage]');
    const animalArea = document.querySelector('.luxury-animal-area');
    const allCutElements = document.querySelectorAll('[data-cut]');
    const interactiveCutElements = document.querySelectorAll('.cut-hit, .cut-tag');

    const cutName = document.querySelector('[data-cut-name]');
    const cutDescription = document.querySelector('[data-cut-description]');
    const cutPrice = document.querySelector('[data-cut-price]');
    const cutStock = document.querySelector('[data-cut-stock]');
    const cutReserved = document.querySelector('[data-cut-reserved]');
    const cutMin = document.querySelector('[data-cut-min]');
    const cutPercentLabel = document.querySelector('[data-cut-percent-label]');
    const cutPercentBar = document.querySelector('[data-cut-percent-bar]');

    const quantityInput = document.querySelector('[data-quantity-input]');
    const quantityMinus = document.querySelector('[data-quantity-minus]');
    const quantityPlus = document.querySelector('[data-quantity-plus]');
    const reserveButton = document.querySelector('[data-reserve-button]');
    const reserveFeedback = document.querySelector('[data-reserve-feedback]');

    const cartDrawer = document.querySelector('[data-cart-drawer]');
    const cartOverlay = document.querySelector('[data-cart-overlay]');
    const cartOpenButtons = document.querySelectorAll('[data-cart-open]');
    const cartCloseButtons = document.querySelectorAll('[data-cart-close]');
    const cartItemsContainer = document.querySelector('[data-cart-items]');
    const cartEmpty = document.querySelector('[data-cart-empty]');
    const cartTotal = document.querySelector('[data-cart-total]');
    const cartCounters = document.querySelectorAll('[data-cart-count]');
    const cartClearButton = document.querySelector('[data-cart-clear]');
    const cartSubmitButton = document.querySelector('[data-cart-submit]');

    const checkoutForm = document.querySelector('[data-checkout-form]');
    const checkoutBackButton = document.querySelector('[data-checkout-back]');
    const cartConfirmation = document.querySelector('[data-cart-confirmation]');
    const confirmationSummary = document.querySelector('[data-confirmation-summary]');

    const bovinReference = checkoutForm?.dataset.bovinReference || 'reserve';
    const storageKey = `wf-pro-cart-${bovinReference}`;
    let selectedCut = cutKeys[0];
    let proCart = {};

    try {
        proCart = JSON.parse(sessionStorage.getItem(storageKey) || '{}');
    } catch {
        proCart = {};
    }

    Object.keys(proCart).forEach((key) => {
        if (!cuts[key]) delete proCart[key];
    });

    const formatPrice = (value) => `${Math.round(value).toLocaleString('fr-FR')} €`;
    const formatQuantity = (value) => Number(value).toLocaleString('fr-FR', { maximumFractionDigits: 1 });

    function escapeHtml(value) {
        const element = document.createElement('div');
        element.textContent = String(value ?? '');
        return element.innerHTML;
    }

    function saveCart() {
        sessionStorage.setItem(storageKey, JSON.stringify(proCart));
    }

    function getScale() {
        if (!animalStage) return { x: 1, y: 1 };
        const rect = animalStage.getBoundingClientRect();
        return { x: rect.width / RESERVE_STAGE.width, y: rect.height / RESERVE_STAGE.height };
    }

    function placeCutElements() {
        if (!animalStage) return;
        const scale = getScale();

        Object.entries(cuts).forEach(([key, cut]) => {
            if (!cut.dot || !cut.label || !cut.hit || !cut.frame) return;

            const tag = animalStage.querySelector(`.cut-tag[data-cut="${key}"]`);
            const dot = animalStage.querySelector(`.cut-dot[data-cut="${key}"]`);
            const line = animalStage.querySelector(`.cut-line[data-cut="${key}"]`);
            const hit = animalStage.querySelector(`.cut-hit[data-cut="${key}"]`);
            const frame = animalStage.querySelector(`.cut-frame[data-cut="${key}"]`);

            const dotX = cut.dot.x * scale.x;
            const dotY = cut.dot.y * scale.y;
            const labelX = cut.label.x * scale.x;
            const labelY = cut.label.y * scale.y;

            if (tag) {
                tag.style.left = `${labelX}px`;
                tag.style.top = `${labelY}px`;
            }

            if (dot) {
                dot.style.left = `${dotX}px`;
                dot.style.top = `${dotY}px`;
            }

            if (hit) {
                hit.style.left = `${cut.hit.x * scale.x}px`;
                hit.style.top = `${cut.hit.y * scale.y}px`;
                hit.style.width = `${cut.hit.w * scale.x}px`;
                hit.style.height = `${cut.hit.h * scale.y}px`;
            }

            if (frame) {
                frame.style.left = `${cut.frame.x * scale.x}px`;
                frame.style.top = `${cut.frame.y * scale.y}px`;
                frame.style.width = `${cut.frame.w * scale.x}px`;
                frame.style.height = `${cut.frame.h * scale.y}px`;
                frame.style.transform = `translate(-50%, -50%) rotate(${cut.frame.rotate}deg)`;
                frame.style.setProperty('--frame-radius', cut.frame.radius);
            }

            if (line) {
                const dx = labelX - dotX;
                const dy = labelY - dotY;
                const distance = Math.sqrt((dx * dx) + (dy * dy));
                const angle = Math.atan2(dy, dx) * 180 / Math.PI;
                line.style.left = `${dotX}px`;
                line.style.top = `${dotY}px`;
                line.style.width = `${Math.max(distance - 84, 20)}px`;
                line.style.transform = `rotate(${angle}deg)`;
            }
        });

        animalStage.classList.add('is-positioned');
    }

    function updateCut(cutKey) {
        const cut = cuts[cutKey];
        if (!cut) return;

        selectedCut = cutKey;
        allCutElements.forEach((element) => {
            const active = element.dataset.cut === cutKey;
            element.classList.toggle('active', active);
            if (element.tagName === 'BUTTON') element.setAttribute('aria-pressed', active ? 'true' : 'false');
        });

        if (animalArea) animalArea.dataset.selectedCut = cutKey;
        if (cutName) cutName.textContent = cut.name;
        if (cutDescription) cutDescription.textContent = cut.description || '';
        if (cutPrice) cutPrice.textContent = cut.price;
        if (cutStock) cutStock.textContent = cut.stock;
        if (cutReserved) cutReserved.textContent = cut.reserved;
        if (cutMin) cutMin.textContent = cut.min;
        if (cutPercentLabel) cutPercentLabel.textContent = cut.reserved;
        if (cutPercentBar) cutPercentBar.style.width = `${cut.percent}%`;

        if (quantityInput) {
            const minimum = Math.max(0.1, Number(cut.minValue) || 1);
            const maximum = Math.max(minimum, Number(cut.stockValue) || minimum);
            quantityInput.min = String(minimum);
            quantityInput.max = String(maximum);
            quantityInput.step = '0.1';
            quantityInput.value = String(minimum);
        }

        if (reserveFeedback) reserveFeedback.textContent = '';
    }

    function getCartCount() {
        return Object.values(proCart).reduce((total, item) => total + Number(item.quantity || 0), 0);
    }

    function getCartTotal(cart = proCart) {
        return Object.entries(cart).reduce((total, [key, item]) => {
            return total + ((Number(cuts[key]?.priceValue) || 0) * Number(item.quantity || 0));
        }, 0);
    }

    function hideCheckout() {
        checkoutForm?.classList.add('is-hidden');
        cartConfirmation?.classList.add('is-hidden');
        cartDrawer?.classList.remove('is-confirmed', 'is-checkout');
    }

    function openCart() {
        if (!cartDrawer || !cartOverlay) return;
        cartDrawer.classList.add('is-open');
        cartOverlay.classList.add('is-open');
        cartDrawer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('pro-cart-open');
    }

    function closeCart() {
        if (!cartDrawer || !cartOverlay) return;
        cartDrawer.classList.remove('is-open');
        cartOverlay.classList.remove('is-open');
        cartDrawer.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('pro-cart-open');
        setTimeout(hideCheckout, 250);
    }

    function renderCart() {
        if (!cartItemsContainer || !cartEmpty || !cartTotal) return;
        const entries = Object.entries(proCart);
        cartItemsContainer.innerHTML = '';
        cartEmpty.classList.toggle('is-hidden', entries.length > 0);

        entries.forEach(([key, item]) => {
            const cut = cuts[key];
            if (!cut) return;

            const article = document.createElement('article');
            article.className = 'pro-cart-item';
            article.innerHTML = `
                <div class="pro-cart-item-head">
                    <div><h3>${escapeHtml(cut.name)}</h3><small>${escapeHtml(cut.price)}</small></div>
                    <button type="button" data-cart-remove="${escapeHtml(key)}" aria-label="Retirer">×</button>
                </div>
                <div class="pro-cart-item-bottom">
                    <div class="pro-cart-item-qty">
                        <button type="button" data-cart-minus="${escapeHtml(key)}">−</button>
                        <span>${formatQuantity(item.quantity)} kg</span>
                        <button type="button" data-cart-plus="${escapeHtml(key)}">+</button>
                    </div>
                    <strong>${formatPrice(Number(cut.priceValue) * Number(item.quantity))}</strong>
                </div>
            `;
            cartItemsContainer.appendChild(article);
        });

        cartTotal.textContent = formatPrice(getCartTotal());
        cartCounters.forEach((counter) => counter.textContent = formatQuantity(getCartCount()));
        saveCart();
    }

    function addSelectedCut() {
        const cut = cuts[selectedCut];
        if (!cut || !quantityInput) return;

        const minimum = Math.max(0.1, Number(cut.minValue) || 1);
        const maximum = Math.max(minimum, Number(cut.stockValue) || minimum);
        const quantity = Math.min(maximum, Math.max(minimum, Number(quantityInput.value) || minimum));
        const current = Number(proCart[selectedCut]?.quantity || 0);
        const next = Math.min(maximum, current + quantity);

        proCart[selectedCut] = { quantity: next };
        if (reserveFeedback) {
            reserveFeedback.textContent = next >= maximum
                ? `${cut.name} ajouté — volume indicatif maximal atteint.`
                : `${cut.name} ajouté à votre sélection.`;
        }

        hideCheckout();
        renderCart();
        openCart();
    }

    function updateCartItem(key, delta) {
        const cut = cuts[key];
        if (!cut || !proCart[key]) return;

        const minimum = Math.max(0.1, Number(cut.minValue) || 1);
        const maximum = Math.max(minimum, Number(cut.stockValue) || minimum);
        const next = Number(proCart[key].quantity) + delta;

        if (next < minimum) {
            delete proCart[key];
        } else {
            proCart[key].quantity = Math.min(maximum, next);
        }

        hideCheckout();
        renderCart();
    }

    function showCheckout() {
        if (Object.keys(proCart).length === 0) return openCart();
        if (!checkoutForm || !cartDrawer) return;
        cartDrawer.classList.add('is-checkout');
        checkoutForm.classList.remove('is-hidden');
        cartConfirmation?.classList.add('is-hidden');
        checkoutForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function buildConfirmation(formData, snapshot, reference, total) {
        if (!confirmationSummary) return;
        const items = Object.entries(snapshot)
            .map(([key, item]) => `${escapeHtml(cuts[key]?.name || key)} — ${formatQuantity(item.quantity)} kg`)
            .join('<br>');

        confirmationSummary.innerHTML = `
            <strong>Référence :</strong> ${escapeHtml(reference)}<br>
            <strong>Établissement :</strong> ${escapeHtml(formData.get('company'))}<br>
            <strong>Contact :</strong> ${escapeHtml(formData.get('fullname'))}<br>
            <strong>Total estimatif :</strong> ${formatPrice(total)} HT<br><br>
            <strong>Pièces demandées :</strong><br>${items}
        `;
    }

    interactiveCutElements.forEach((element) => {
        element.addEventListener('click', () => updateCut(element.dataset.cut));
    });

    quantityMinus?.addEventListener('click', () => {
        const minimum = Number(quantityInput.min) || 1;
        quantityInput.value = String(Math.max(minimum, (Number(quantityInput.value) || minimum) - 1));
    });

    quantityPlus?.addEventListener('click', () => {
        const maximum = Number(quantityInput.max) || 999;
        quantityInput.value = String(Math.min(maximum, (Number(quantityInput.value) || 0) + 1));
    });

    reserveButton?.addEventListener('click', addSelectedCut);
    cartOpenButtons.forEach((button) => button.addEventListener('click', openCart));
    cartCloseButtons.forEach((button) => button.addEventListener('click', closeCart));
    cartOverlay?.addEventListener('click', closeCart);
    cartSubmitButton?.addEventListener('click', showCheckout);
    checkoutBackButton?.addEventListener('click', () => {
        checkoutForm?.classList.add('is-hidden');
        cartDrawer?.classList.remove('is-checkout');
    });

    cartClearButton?.addEventListener('click', () => {
        proCart = {};
        hideCheckout();
        renderCart();
    });

    cartItemsContainer?.addEventListener('click', (event) => {
        const minus = event.target.closest('[data-cart-minus]');
        const plus = event.target.closest('[data-cart-plus]');
        const remove = event.target.closest('[data-cart-remove]');
        if (minus) updateCartItem(minus.dataset.cartMinus, -1);
        if (plus) updateCartItem(plus.dataset.cartPlus, 1);
        if (remove) {
            delete proCart[remove.dataset.cartRemove];
            hideCheckout();
            renderCart();
        }
    });

    checkoutForm?.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (!checkoutForm.checkValidity()) return checkoutForm.reportValidity();

        const submitButton = checkoutForm.querySelector('.checkout-submit-button');
        const formData = new FormData(checkoutForm);
        const snapshot = JSON.parse(JSON.stringify(proCart));
        const totalSnapshot = getCartTotal(snapshot);
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';

        const payload = {
            _token: csrfToken,
            bovin_reference: bovinReference,
            company: formData.get('company'),
            fullname: formData.get('fullname'),
            email: formData.get('email'),
            phone: formData.get('phone'),
            professional_type: formData.get('professional_type'),
            city: formData.get('city'),
            message: formData.get('message'),
            cart: Object.entries(snapshot).map(([key, item]) => ({ key, quantity: item.quantity }))
        };

        try {
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = 'Transmission en cours...';
            }

            const response = await fetch(checkoutForm.dataset.requestUrl, {
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

            buildConfirmation(formData, snapshot, data.reference || '', totalSnapshot);
            proCart = {};
            renderCart();
            checkoutForm.reset();
            checkoutForm.classList.add('is-hidden');
            cartDrawer?.classList.remove('is-checkout');
            cartDrawer?.classList.add('is-confirmed');
            cartConfirmation?.classList.remove('is-hidden');
            cartConfirmation?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        } catch (error) {
            alert(error?.message || 'Impossible de transmettre la demande pour le moment.');
        } finally {
            if (submitButton) {
                submitButton.disabled = false;
                submitButton.textContent = 'Transmettre ma demande';
            }
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') closeCart();
    });

    window.addEventListener('resize', placeCutElements);
    placeCutElements();
    updateCut(selectedCut);
    renderCart();
});

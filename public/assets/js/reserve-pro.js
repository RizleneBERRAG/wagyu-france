const STAGE = {
    width: 1000,
    height: 520
};

const cuts = {
    paleron: {
        name: 'Paleron Wagyu',
        description: 'Pièce de l’épaule, riche et savoureuse, idéale pour cuisson lente, effiloché premium ou carte bistronomique.',
        price: '143 €/kg',
        priceValue: 143,
        stock: '5,8 kg',
        reserved: '33%',
        min: '2 kg',
        percent: 33,
        dot: { x: 280, y: 240 },
        label: { x: 90, y: 245 },
        hit: { x: 280, y: 240, w: 180, h: 120 },
        frame: {
            x: 252,
            y: 238,
            w: 210,
            h: 130,
            rotate: -10,
            radius: '48% 52% 46% 54% / 50% 46% 54% 50%'
        }
    },
    entrecote: {
        name: 'Entrecôte Wagyu',
        description: 'Pièce emblématique située sur la partie haute du dos, persillage intense, parfaite pour les restaurants premium.',
        price: '174 €/kg',
        priceValue: 174,
        stock: '8,5 kg',
        reserved: '74%',
        min: '2 kg',
        percent: 74,
        dot: { x: 470, y: 150 },
        label: { x: 500, y: 40 },
        hit: { x: 470, y: 150, w: 240, h: 110 },
        frame: {
            x: 515,
            y: 185,
            w: 300,
            h: 92,
            rotate: 2,
            radius: '46% 54% 50% 50% / 58% 50% 50% 42%'
        }
    },
    fauxfilet: {
        name: 'Faux-filet Wagyu',
        description: 'Zone dorsale arrière, équilibre idéal entre tendreté, puissance aromatique et rendement professionnel.',
        price: '174 €/kg',
        priceValue: 174,
        stock: '7,1 kg',
        reserved: '58%',
        min: '2 kg',
        percent: 58,
        dot: { x: 665, y: 160 },
        label: { x: 700, y: 65 },
        hit: { x: 665, y: 160, w: 210, h: 110 },
        frame: {
            x: 690,
            y: 190,
            w: 250,
            h: 100,
            rotate: -2,
            radius: '44% 56% 48% 52% / 58% 50% 50% 42%'
        }
    },
    rumsteak: {
        name: 'Rumsteak Wagyu',
        description: 'Pièce arrière de caractère, régulière et élégante, adaptée aux menus dégustation et découpes précises.',
        price: '137 €/kg',
        priceValue: 137,
        stock: '6,4 kg',
        reserved: '49%',
        min: '2 kg',
        percent: 49,
        dot: { x: 830, y: 225 },
        label: { x: 970, y: 235 },
        hit: { x: 830, y: 225, w: 160, h: 130 },
        frame: {
            x: 820,
            y: 235,
            w: 160,
            h: 140,
            rotate: 10,
            radius: '44% 56% 52% 48% / 50% 48% 52% 50%'
        }
    },
    filet: {
        name: 'Filet Wagyu',
        description: 'Pièce noble et fondante, située sous la zone lombaire, idéale pour une carte gastronomique.',
        price: '198 €/kg',
        priceValue: 198,
        stock: '4,2 kg',
        reserved: '61%',
        min: '1 kg',
        percent: 61,
        dot: { x: 610, y: 340 },
        label: { x: 735, y: 345 },
        hit: { x: 610, y: 340, w: 240, h: 100 },
        frame: {
            x: 600,
            y: 335,
            w: 230,
            h: 86,
            rotate: -8,
            radius: '52% 48% 54% 46% / 58% 46% 54% 42%'
        }
    },
    macreuse: {
        name: 'Macreuse Wagyu',
        description: 'Morceau de l’avant, intéressant pour les chefs qui souhaitent valoriser des pièces moins classiques.',
        price: '119 €/kg',
        priceValue: 119,
        stock: '5,2 kg',
        reserved: '28%',
        min: '2 kg',
        percent: 28,
        dot: { x: 335, y: 335 },
        label: { x: 275, y: 495 },
        hit: { x: 335, y: 335, w: 180, h: 135 },
        frame: {
            x: 355,
            y: 355,
            w: 200,
            h: 145,
            rotate: -20,
            radius: '48% 52% 50% 50% / 42% 58% 42% 58%'
        }
    },
    jarret: {
        name: 'Jarret Wagyu',
        description: 'Pièce basse de la patte, parfaite pour jus, bouillons, plats mijotés et préparations gastronomiques longues.',
        price: '92 €/kg',
        priceValue: 92,
        stock: '4,9 kg',
        reserved: '22%',
        min: '2 kg',
        percent: 22,
        dot: { x: 820, y: 445 },
        label: { x: 940, y: 485 },
        hit: { x: 820, y: 445, w: 150, h: 150 },
        frame: {
            x: 835,
            y: 438,
            w: 110,
            h: 175,
            rotate: 8,
            radius: '46% 54% 48% 52% / 36% 36% 64% 64%'
        }
    }
};

document.addEventListener('DOMContentLoaded', () => {
    const animalStage = document.querySelector('[data-animal-stage]') || document.querySelector('.animal-stage');
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

    let selectedCut = 'paleron';
    let proCart = {};

    function getScale() {
        if (!animalStage) {
            return { x: 1, y: 1 };
        }

        const rect = animalStage.getBoundingClientRect();

        return {
            x: rect.width / STAGE.width,
            y: rect.height / STAGE.height
        };
    }

    function placeCutElements() {
        if (!animalStage) return;

        const scale = getScale();

        Object.entries(cuts).forEach(([key, cut]) => {
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
                const labelGap = 84;
                const lineWidth = Math.max(distance - labelGap, 20);

                line.style.left = `${dotX}px`;
                line.style.top = `${dotY}px`;
                line.style.width = `${lineWidth}px`;
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
            const isActive = element.dataset.cut === cutKey;
            element.classList.toggle('active', isActive);

            if (element.tagName === 'BUTTON') {
                element.setAttribute('aria-pressed', isActive ? 'true' : 'false');
            }
        });

        if (animalArea) {
            animalArea.dataset.selectedCut = cutKey;
        }

        if (cutName) cutName.textContent = cut.name;
        if (cutDescription) cutDescription.textContent = cut.description;
        if (cutPrice) cutPrice.textContent = cut.price;
        if (cutStock) cutStock.textContent = cut.stock;
        if (cutReserved) cutReserved.textContent = cut.reserved;
        if (cutMin) cutMin.textContent = cut.min;
        if (cutPercentLabel) cutPercentLabel.textContent = cut.reserved;
        if (cutPercentBar) cutPercentBar.style.width = `${cut.percent}%`;
        if (quantityInput) quantityInput.value = 1;
        if (reserveFeedback) reserveFeedback.textContent = '';
    }

    function formatPrice(value) {
        return `${Math.round(value).toLocaleString('fr-FR')} €`;
    }

    function getCartCount() {
        return Object.values(proCart).reduce((total, item) => total + item.quantity, 0);
    }

    function getCartTotal() {
        return Object.entries(proCart).reduce((total, [key, item]) => {
            return total + (cuts[key].priceValue * item.quantity);
        }, 0);
    }

    function hideCheckout() {
        if (checkoutForm) checkoutForm.classList.add('is-hidden');
        if (cartConfirmation) cartConfirmation.classList.add('is-hidden');
        if (cartDrawer) cartDrawer.classList.remove('is-confirmed');
    }

    function openCart() {
        if (!cartDrawer || !cartOverlay) return;

        cartDrawer.classList.add('is-open');
        cartOverlay.classList.add('is-open');
        cartDrawer.setAttribute('aria-hidden', 'false');
        document.body.classList.add('cart-open');
    }

    function closeCart() {
        if (!cartDrawer || !cartOverlay) return;

        cartDrawer.classList.remove('is-open');
        cartOverlay.classList.remove('is-open');
        cartDrawer.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('cart-open');

        setTimeout(() => {
            hideCheckout();
        }, 280);
    }

    function renderCart() {
        if (!cartItemsContainer || !cartTotal || !cartEmpty) return;

        const entries = Object.entries(proCart);
        cartItemsContainer.innerHTML = '';

        cartEmpty.classList.toggle('is-hidden', entries.length > 0);

        entries.forEach(([key, item]) => {
            const cut = cuts[key];
            const lineTotal = cut.priceValue * item.quantity;

            const article = document.createElement('article');
            article.className = 'pro-cart-item';

            article.innerHTML = `
                <div class="pro-cart-item-top">
                    <div>
                        <h3>${cut.name}</h3>
                        <small>${cut.price} · ${cut.min} min.</small>
                    </div>

                    <button class="cart-remove" type="button" data-cart-remove="${key}" aria-label="Retirer ${cut.name}">
                        ×
                    </button>
                </div>

                <div class="pro-cart-item-bottom">
                    <div class="cart-qty">
                        <button type="button" data-cart-minus="${key}">-</button>
                        <span>${item.quantity}</span>
                        <button type="button" data-cart-plus="${key}">+</button>
                    </div>

                    <strong class="cart-line-total">${formatPrice(lineTotal)} HT</strong>
                </div>
            `;

            cartItemsContainer.appendChild(article);
        });

        cartTotal.textContent = `${formatPrice(getCartTotal())} HT`;

        cartCounters.forEach((counter) => {
            counter.textContent = getCartCount();
        });
    }

    function addToCart(cutKey, quantity) {
        const normalizedQuantity = Math.max(1, Number(quantity) || 1);

        if (!proCart[cutKey]) {
            proCart[cutKey] = { quantity: 0 };
        }

        proCart[cutKey].quantity += normalizedQuantity;

        hideCheckout();
        renderCart();
        openCart();
    }

    function updateCartQuantity(cutKey, delta) {
        if (!proCart[cutKey]) return;

        proCart[cutKey].quantity += delta;

        if (proCart[cutKey].quantity <= 0) {
            delete proCart[cutKey];
        }

        hideCheckout();
        renderCart();
    }

    function removeCartItem(cutKey) {
        delete proCart[cutKey];
        hideCheckout();
        renderCart();
    }

    function showCheckoutForm() {
        if (getCartCount() === 0) {
            openCart();
            return;
        }

        if (cartConfirmation) cartConfirmation.classList.add('is-hidden');

        if (checkoutForm) {
            checkoutForm.classList.remove('is-hidden');
            checkoutForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function buildConfirmation(formData, savedData = null, cartSnapshot = null, totalSnapshot = null) {
        const cartToDisplay = cartSnapshot || proCart;
        const totalToDisplay = totalSnapshot ?? getCartTotal();

        const items = Object.entries(cartToDisplay)
            .map(([key, item]) => {
                const cut = cuts[key];
                return `${cut.name} — ${item.quantity} kg`;
            })
            .join('<br>');

        if (!confirmationSummary) return;

        const referenceLine = savedData?.reference
            ? `<strong>Référence :</strong> ${savedData.reference}<br>`
            : '';

        confirmationSummary.innerHTML = `
        ${referenceLine}
        <strong>Contact :</strong> ${formData.get('fullname')}<br>
        <strong>Société :</strong> ${formData.get('company')}<br>
        <strong>Email :</strong> ${formData.get('email')}<br>
        <strong>Téléphone :</strong> ${formData.get('phone')}<br>
        <strong>Type :</strong> ${formData.get('professional_type')}<br>
        <strong>Total estimatif :</strong> ${formatPrice(totalToDisplay)} HT<br><br>
        <strong>Pièces demandées :</strong><br>
        ${items}
    `;
    }

    interactiveCutElements.forEach((element) => {
        element.addEventListener('click', () => {
            updateCut(element.dataset.cut);
        });

        element.addEventListener('mouseenter', () => {
            const cutKey = element.dataset.cut;

            document.querySelectorAll(`[data-cut="${cutKey}"]`).forEach((relatedElement) => {
                relatedElement.classList.add('is-hovered');
            });
        });

        element.addEventListener('mouseleave', () => {
            const cutKey = element.dataset.cut;

            document.querySelectorAll(`[data-cut="${cutKey}"]`).forEach((relatedElement) => {
                relatedElement.classList.remove('is-hovered');
            });
        });
    });

    if (quantityMinus && quantityPlus && quantityInput) {
        quantityMinus.addEventListener('click', () => {
            const currentValue = Number(quantityInput.value) || 1;
            quantityInput.value = Math.max(1, currentValue - 1);
        });

        quantityPlus.addEventListener('click', () => {
            const currentValue = Number(quantityInput.value) || 1;
            quantityInput.value = currentValue + 1;
        });
    }

    if (reserveButton && reserveFeedback) {
        reserveButton.addEventListener('click', () => {
            const cut = cuts[selectedCut];
            const quantity = Number(quantityInput.value) || 1;

            addToCart(selectedCut, quantity);

            reserveFeedback.textContent = `${quantity} kg de ${cut.name} ajouté au panier pro.`;
            reserveButton.textContent = 'Ajouté au panier';

            setTimeout(() => {
                reserveButton.textContent = 'Ajouter à ma pré-réservation';
            }, 1600);
        });
    }

    cartOpenButtons.forEach((button) => {
        button.addEventListener('click', openCart);
    });

    cartCloseButtons.forEach((button) => {
        button.addEventListener('click', closeCart);
    });

    if (cartOverlay) {
        cartOverlay.addEventListener('click', closeCart);
    }

    if (cartItemsContainer) {
        cartItemsContainer.addEventListener('click', (event) => {
            const minusButton = event.target.closest('[data-cart-minus]');
            const plusButton = event.target.closest('[data-cart-plus]');
            const removeButton = event.target.closest('[data-cart-remove]');

            if (minusButton) {
                updateCartQuantity(minusButton.dataset.cartMinus, -1);
            }

            if (plusButton) {
                updateCartQuantity(plusButton.dataset.cartPlus, 1);
            }

            if (removeButton) {
                removeCartItem(removeButton.dataset.cartRemove);
            }
        });
    }

    if (cartClearButton) {
        cartClearButton.addEventListener('click', () => {
            proCart = {};
            hideCheckout();
            renderCart();
        });
    }

    if (cartSubmitButton) {
        cartSubmitButton.addEventListener('click', showCheckoutForm);
    }

    if (checkoutBackButton) {
        checkoutBackButton.addEventListener('click', () => {
            if (checkoutForm) checkoutForm.classList.add('is-hidden');
        });
    }

    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async (event) => {
            event.preventDefault();

            if (!checkoutForm.checkValidity()) {
                checkoutForm.reportValidity();
                return;
            }

            const submitButton = checkoutForm.querySelector('.checkout-submit-button');
            const formData = new FormData(checkoutForm);

            const cartPayload = Object.entries(proCart).map(([key, item]) => {
                return {
                    key: key,
                    quantity: item.quantity
                };
            });

            const payload = {
                bovin_reference: 'WF-2026-01',
                company: formData.get('company'),
                fullname: formData.get('fullname'),
                email: formData.get('email'),
                phone: formData.get('phone'),
                professional_type: formData.get('professional_type'),
                city: formData.get('city'),
                message: formData.get('message'),
                cart: cartPayload
            };

            try {
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.textContent = 'Envoi en cours...';
                }

                const csrfToken =
                    document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    checkoutForm.querySelector('input[name="_token"]')?.value ||
                    '';

                payload._token = csrfToken;

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

                if (!response.ok) {
                    throw data;
                }

                const cartSnapshot = structuredClone(proCart);
                const totalSnapshot = getCartTotal();

                buildConfirmation(formData, data, cartSnapshot, totalSnapshot);

                proCart = {};
                renderCart();

                checkoutForm.reset();
                checkoutForm.classList.add('is-hidden');

                if (cartDrawer) {
                    cartDrawer.classList.add('is-confirmed');
                }

                if (cartConfirmation) {
                    cartConfirmation.classList.remove('is-hidden');
                    cartConfirmation.scrollIntoView({ behavior: 'smooth', block: 'start' });
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
                    submitButton.textContent = 'Envoyer ma demande pro';
                }
            }
        });
    }

    window.addEventListener('resize', placeCutElements);

    if ('ResizeObserver' in window && animalStage) {
        const observer = new ResizeObserver(() => {
            placeCutElements();
        });

        observer.observe(animalStage);
    }

    placeCutElements();
    updateCut(selectedCut);
    renderCart();
});

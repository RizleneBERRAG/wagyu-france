document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('[data-contact-form]');
    const confirmation = document.querySelector('[data-contact-confirmation]');
    const reference = document.querySelector('[data-contact-reference]');
    const resetButton = document.querySelector('[data-contact-reset]');
    const errorsBox = document.querySelector('[data-contact-errors]');
    const profileLinks = document.querySelectorAll('[data-contact-profile]');

    if (!form || !confirmation) return;

    const submitButton = form.querySelector('.contact-submit-button');
    const submitLabel = submitButton?.querySelector('span');
    const subjectSelect = form.querySelector('select[name="subject"]');
    const companyInput = form.querySelector('input[name="company"]');
    const companyField = form.querySelector('[data-company-field]');

    const subjectByAudience = {
        particulier: 'Question boutique ou produit',
        professionnel: 'Demande professionnelle',
        partenaire: 'Collaboration ou partenariat'
    };

    function clearErrors() {
        if (!errorsBox) return;
        errorsBox.innerHTML = '';
        errorsBox.classList.add('is-hidden');
    }

    function showErrors(error) {
        if (!errorsBox) return;

        const messages = error?.errors
            ? Object.values(error.errors).flat()
            : [error?.message || 'Impossible d’envoyer votre message pour le moment.'];

        errorsBox.innerHTML = `
            <strong>Votre demande n’a pas encore été envoyée.</strong>
            <ul>${messages.map((message) => `<li>${message}</li>`).join('')}</ul>
        `;
        errorsBox.classList.remove('is-hidden');
        errorsBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function setLoading(isLoading) {
        if (!submitButton) return;

        submitButton.disabled = isLoading;
        if (submitLabel) {
            submitLabel.textContent = isLoading ? 'Transmission en cours…' : 'Transmettre ma demande';
        }
    }

    function applyAudience(audience, updateSubject = false) {
        const radio = form.querySelector(`input[name="audience"][value="${audience}"]`);
        if (radio) radio.checked = true;

        const isBusiness = audience === 'professionnel' || audience === 'partenaire';
        companyField?.classList.toggle('is-recommended', isBusiness);
        companyInput?.setAttribute(
            'placeholder',
            isBusiness
                ? 'Nom de votre établissement ou société'
                : 'Nom de votre établissement, si applicable'
        );

        if (updateSubject && subjectSelect && subjectByAudience[audience]) {
            subjectSelect.value = subjectByAudience[audience];
        }
    }

    profileLinks.forEach((link) => {
        link.addEventListener('click', () => {
            applyAudience(link.dataset.contactProfile, true);
        });
    });

    form.querySelectorAll('input[name="audience"]').forEach((radio) => {
        radio.addEventListener('change', () => {
            applyAudience(radio.value, false);
        });
    });

    form.addEventListener('input', clearErrors);

    form.addEventListener('submit', async (event) => {
        event.preventDefault();
        clearErrors();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);
        const payload = Object.fromEntries(formData.entries());
        const csrfToken =
            document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
            form.querySelector('input[name="_token"]')?.value ||
            '';

        try {
            setLoading(true);

            const response = await fetch(form.dataset.requestUrl, {
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

            if (reference) {
                reference.textContent = data.reference || 'WF-CONTACT';
            }

            form.classList.add('is-hidden');
            confirmation.classList.remove('is-hidden');
            confirmation.scrollIntoView({ behavior: 'smooth', block: 'center' });
        } catch (error) {
            showErrors(error);
        } finally {
            setLoading(false);
        }
    });

    resetButton?.addEventListener('click', () => {
        confirmation.classList.add('is-hidden');
        form.reset();
        clearErrors();
        applyAudience('particulier', false);
        form.classList.remove('is-hidden');
        form.scrollIntoView({ behavior: 'smooth', block: 'start' });
    });

    applyAudience(form.querySelector('input[name="audience"]:checked')?.value || 'particulier');
});

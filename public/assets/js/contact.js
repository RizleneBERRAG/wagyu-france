document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('[data-contact-form]');
    const confirmation = document.querySelector('[data-contact-confirmation]');
    const resetButton = document.querySelector('[data-contact-reset]');

    if (!form || !confirmation) return;

    form.addEventListener('submit', (event) => {
        event.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        form.classList.add('is-hidden');
        confirmation.classList.remove('is-hidden');

        confirmation.scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });
    });

    if (resetButton) {
        resetButton.addEventListener('click', () => {
            confirmation.classList.add('is-hidden');
            form.reset();
            form.classList.remove('is-hidden');

            form.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        });
    }
});

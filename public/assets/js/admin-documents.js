document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('[data-commercial-form]');
    const totalOutput = document.querySelector('[data-commercial-total]');

    if (!form || !totalOutput) {
        return;
    }

    const formatter = new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
    const suffix = totalOutput.textContent.includes('TTC') ? ' TTC' : ' HT';

    function numberValue(input) {
        const value = Number.parseFloat(input?.value ?? '0');
        return Number.isFinite(value) ? value : 0;
    }

    function recalculate() {
        let total = 0;

        form.querySelectorAll('[data-commercial-line]').forEach((line) => {
            const quantity = numberValue(line.querySelector('[data-line-quantity]'));
            const price = numberValue(line.querySelector('[data-line-price]'));
            const lineTotal = Math.round((quantity * price + Number.EPSILON) * 100) / 100;
            const output = line.querySelector('[data-line-total]');

            total += lineTotal;

            if (output) {
                output.textContent = `${formatter.format(lineTotal)} €`;
            }
        });

        total += numberValue(form.querySelector('[data-additional-amount]'));
        total = Math.round((total + Number.EPSILON) * 100) / 100;
        totalOutput.textContent = `${formatter.format(total)} €${suffix}`;
    }

    form.addEventListener('input', (event) => {
        if (
            event.target.matches('[data-line-quantity]') ||
            event.target.matches('[data-line-price]') ||
            event.target.matches('[data-additional-amount]')
        ) {
            recalculate();
        }
    });

    recalculate();
});

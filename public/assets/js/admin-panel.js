document.addEventListener('DOMContentLoaded', () => {
    const sidebar = document.querySelector('[data-admin-sidebar]');
    const backdrop = document.querySelector('[data-admin-backdrop]');
    const openButton = document.querySelector('[data-admin-open]');
    const closeButton = document.querySelector('[data-admin-close]');

    if (!sidebar || !backdrop) return;

    const open = () => {
        sidebar.classList.add('is-open');
        backdrop.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    };

    const close = () => {
        sidebar.classList.remove('is-open');
        backdrop.classList.remove('is-open');
        document.body.style.overflow = '';
    };

    openButton?.addEventListener('click', open);
    closeButton?.addEventListener('click', close);
    backdrop.addEventListener('click', close);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') close();
    });
});

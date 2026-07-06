const themeToggle = document.querySelector('[data-theme-toggle]');

function applyTheme(theme) {
    const isLight = theme === 'light';

    document.body.classList.toggle('theme-light', isLight);
    localStorage.setItem('wagyu-theme', isLight ? 'light' : 'dark');
}

const savedTheme = localStorage.getItem('wagyu-theme');

if (savedTheme === 'light') {
    applyTheme('light');
} else {
    applyTheme('dark');
}

if (themeToggle) {
    themeToggle.addEventListener('click', () => {
        const nextTheme = document.body.classList.contains('theme-light') ? 'dark' : 'light';
        applyTheme(nextTheme);
    });
}

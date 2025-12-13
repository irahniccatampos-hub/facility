const body = document.getElementById('app-body');
const toggle = document.getElementById('theme-toggle');

const savedTheme = (typeof localStorage !== 'undefined' && localStorage.getItem('theme')) || 'dark';

if (body) {
    body.classList.remove('light', 'dark');
    body.classList.add(savedTheme);
}

toggle?.addEventListener('click', () => {
    if (!body) return;
    const isDark = body.classList.contains('dark');
    body.classList.remove(isDark ? 'dark' : 'light');
    body.classList.add(isDark ? 'light' : 'dark');
    if (typeof localStorage !== 'undefined') {
        localStorage.setItem('theme', isDark ? 'light' : 'dark');
    }
});

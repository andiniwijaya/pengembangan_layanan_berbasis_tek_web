/**
 * Modul Navbar WijayCart.
 * Sticky shadow saat scroll dan toggle dark mode.
 *
 * Guest: default light, preferensi disimpan di localStorage.
 * User login: users.dark_mode di database sebagai satu-satunya sumber kebenaran.
 */

export function initNavbarScroll() {
    const navbar = document.getElementById('main-navbar');
    if (!navbar) return;

    window.addEventListener('scroll', () => {
        navbar.classList.toggle('navbar-scrolled', window.scrollY > 10);
    });
}

export function initDarkMode() {
    const toggle = document.getElementById('dark-mode-toggle');
    const html = document.documentElement;
    const isAuthenticated = html.dataset.auth === 'true';

    if (isAuthenticated) {
        localStorage.removeItem('theme');
        applyTheme(html.dataset.theme === 'dark');
    } else {
        const savedTheme = localStorage.getItem('theme');
        applyTheme(savedTheme === 'dark');
    }

    toggle?.addEventListener('click', () => {
        const isDark = !html.classList.contains('dark');
        applyTheme(isDark);

        if (isAuthenticated) {
            fetch('/theme/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                },
                body: JSON.stringify({ dark_mode: isDark }),
            }).catch(() => {});
        } else {
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        window.initLucideIcons?.();
    });
}

function applyTheme(isDark) {
    const html = document.documentElement;
    html.classList.toggle('dark', isDark);
    html.dataset.theme = isDark ? 'dark' : 'light';
}

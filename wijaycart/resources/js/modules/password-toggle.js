/**
 * Toggle visibility password pada login, register, dan profil.
 */

export function initPasswordToggle() {
    document.querySelectorAll('[data-password-toggle]').forEach((wrapper) => {
        const input = wrapper.querySelector('input[type="password"], input[type="text"]');
        const btn = wrapper.querySelector('[data-password-toggle-btn]');
        const showIcon = wrapper.querySelector('.password-icon-show');
        const hideIcon = wrapper.querySelector('.password-icon-hide');

        if (!input || !btn) {
            return;
        }

        btn.addEventListener('click', () => {
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            showIcon?.classList.toggle('hidden', isHidden);
            hideIcon?.classList.toggle('hidden', !isHidden);
            btn.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
    });
}

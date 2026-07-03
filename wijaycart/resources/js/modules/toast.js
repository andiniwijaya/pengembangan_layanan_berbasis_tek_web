/**
 * Modul Toast Notification WijayCart.
 * Menampilkan notifikasi modern untuk sukses, error, warning, dan info.
 * Dipanggil dari app.js dan modul lain (cart, wishlist, dll).
 */

const TOAST_ICONS = {
    success: 'check-circle',
    error: 'alert-circle',
    warning: 'alert-triangle',
    info: 'info',
};

const TOAST_COLORS = {
    success: 'border-success/30 bg-success/10 text-success',
    error: 'border-danger/30 bg-danger/10 text-danger',
    warning: 'border-primary/50 bg-primary/20 text-accent',
    info: 'border-accent/30 bg-secondary text-accent',
};

let toastContainer = null;

function getContainer() {
    if (!toastContainer) {
        toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'fixed right-4 top-20 z-[100] flex max-w-sm flex-col gap-2';
            toastContainer.setAttribute('aria-live', 'polite');
            document.body.appendChild(toastContainer);
        }
    }
    return toastContainer;
}

/**
 * Tampilkan toast notification.
 * @param {string} message - Pesan yang ditampilkan
 * @param {'success'|'error'|'warning'|'info'} type - Tipe notifikasi
 * @param {number} duration - Durasi tampil dalam ms
 */
export function showToast(message, type = 'success', duration = 4000) {
    const container = getContainer();
    const toast = document.createElement('div');
    toast.className = `animate-slide-up flex items-start gap-3 rounded-xl border px-4 py-3 shadow-lg backdrop-blur-sm dark:bg-dark-card ${TOAST_COLORS[type] || TOAST_COLORS.info}`;
    toast.innerHTML = `
        <i data-lucide="${TOAST_ICONS[type] || 'info'}" class="mt-0.5 h-5 w-5 shrink-0"></i>
        <p class="flex-1 text-sm font-medium text-text dark:text-dark-text">${message}</p>
        <button type="button" class="toast-close shrink-0 rounded-lg p-1 opacity-60 hover:opacity-100" aria-label="Tutup">
            <i data-lucide="x" class="h-4 w-4"></i>
        </button>
    `;

    container.appendChild(toast);

    if (window.initLucideIcons) {
        window.initLucideIcons();
    }

    const close = () => {
        toast.classList.add('opacity-0', 'translate-x-4', 'transition-all', 'duration-300');
        setTimeout(() => toast.remove(), 300);
    };

    toast.querySelector('.toast-close')?.addEventListener('click', close);
    setTimeout(close, duration);
}

/** Tampilkan toast dari flash message session yang disimpan di meta tag. */
export function initSessionToasts() {
    document.querySelectorAll('[data-flash-toast]').forEach((el) => {
        showToast(el.dataset.flashToast, el.dataset.flashType || 'success');
        el.remove();
    });
}

window.showToast = showToast;

/**
 * Modal notifikasi terpusat WijayCart.
 * Digunakan untuk sukses, error, warning, dan info — dengan ikon di tengah layar.
 */

const ALERT_CONFIG = {
    success: {
        icon: 'circle-check',
        title: 'Berhasil',
        iconWrap: 'bg-success/15',
        iconColor: 'text-success',
        button: 'bg-success text-white hover:opacity-90',
    },
    error: {
        icon: 'circle-x',
        title: 'Gagal',
        iconWrap: 'bg-danger/15',
        iconColor: 'text-danger',
        button: 'bg-danger text-white hover:opacity-90',
    },
    warning: {
        icon: 'alert-triangle',
        title: 'Perhatian',
        iconWrap: 'bg-primary/30',
        iconColor: 'text-accent dark:text-primary',
        button: 'bg-accent text-white hover:opacity-90 dark:bg-primary dark:text-accent',
    },
    info: {
        icon: 'info',
        title: 'Informasi',
        iconWrap: 'bg-secondary',
        iconColor: 'text-accent dark:text-primary',
        button: 'bg-accent text-white hover:opacity-90 dark:bg-primary dark:text-accent',
    },
};

function createAlertModal() {
    const overlay = document.createElement('div');
    overlay.id = 'alert-modal-overlay';
    overlay.className = 'fixed inset-0 z-[120] hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm';
    overlay.innerHTML = `
        <div class="w-full max-w-sm animate-slide-up rounded-2xl border border-border bg-card p-8 text-center shadow-2xl dark:border-dark-border dark:bg-dark-card" role="alertdialog" aria-modal="true" aria-labelledby="alert-modal-title" aria-describedby="alert-modal-message">
            <div id="alert-modal-icon-wrap" class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full">
                <i id="alert-modal-icon" data-lucide="circle-check" class="h-8 w-8" aria-hidden="true"></i>
            </div>
            <h3 id="alert-modal-title" class="mb-2 text-lg font-bold text-text dark:text-dark-text">Berhasil</h3>
            <p id="alert-modal-message" class="mb-6 text-sm leading-relaxed text-text/70 dark:text-dark-muted"></p>
            <button type="button" id="alert-modal-ok" class="inline-flex w-full items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold transition-all">OK</button>
        </div>
    `;
    document.body.appendChild(overlay);
    return overlay;
}

function getAlertModal() {
    return document.getElementById('alert-modal-overlay') || createAlertModal();
}

let alertQueue = [];
let alertVisible = false;

function processAlertQueue() {
    if (alertVisible || alertQueue.length === 0) return;

    const { message, type, title, onClose } = alertQueue.shift();
    alertVisible = true;

    const modal = getAlertModal();
    const config = ALERT_CONFIG[type] || ALERT_CONFIG.info;

    const iconWrap = modal.querySelector('#alert-modal-icon-wrap');
    const icon = modal.querySelector('#alert-modal-icon');
    const titleEl = modal.querySelector('#alert-modal-title');
    const messageEl = modal.querySelector('#alert-modal-message');
    const okBtn = modal.querySelector('#alert-modal-ok');

    iconWrap.className = `mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full ${config.iconWrap}`;
    icon.className = `h-8 w-8 ${config.iconColor}`;
    icon.setAttribute('data-lucide', config.icon);
    titleEl.textContent = title || config.title;
    messageEl.textContent = message;
    okBtn.className = `inline-flex w-full items-center justify-center rounded-xl px-5 py-3 text-sm font-semibold transition-all ${config.button}`;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (window.initLucideIcons) {
        window.initLucideIcons();
    }

    const close = () => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        okBtn.removeEventListener('click', close);
        modal.removeEventListener('click', handleOverlay);
        document.removeEventListener('keydown', handleEscape);
        alertVisible = false;
        onClose?.();
        processAlertQueue();
    };

    const handleOverlay = (ev) => {
        if (ev.target === modal) close();
    };

    const handleEscape = (ev) => {
        if (ev.key === 'Escape') close();
    };

    okBtn.addEventListener('click', close);
    modal.addEventListener('click', handleOverlay);
    document.addEventListener('keydown', handleEscape);
    okBtn.focus();
}

/**
 * Tampilkan modal notifikasi terpusat.
 * @param {string} message
 * @param {'success'|'error'|'warning'|'info'} type
 * @param {string|null} title
 * @param {Function|null} onClose
 */
export function showAlertModal(message, type = 'success', title = null, onClose = null) {
    alertQueue.push({ message, type, title, onClose });
    processAlertQueue();
}

/** Tampilkan modal dari flash session atau elemen data-flash-modal. */
export function initSessionAlerts() {
    document.querySelectorAll('[data-flash-modal]').forEach((el) => {
        const message = el.dataset.flashModal;
        const type = el.dataset.flashType || 'success';
        const title = el.dataset.flashTitle || null;
        showAlertModal(message, type, title);
        el.remove();
    });
}

window.showAlertModal = showAlertModal;

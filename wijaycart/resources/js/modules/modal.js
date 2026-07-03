/**
 * Modul Modal Konfirmasi WijayCart.
 * Digunakan untuk konfirmasi delete, logout, dan aksi penting lainnya.
 * Trigger via atribut data-confirm pada form atau button.
 */

let activeModal = null;

function createModal() {
    const overlay = document.createElement('div');
    overlay.id = 'confirm-modal-overlay';
    overlay.className = 'fixed inset-0 z-[110] hidden items-center justify-center bg-black/50 p-4 backdrop-blur-sm';
    overlay.innerHTML = `
        <div class="w-full max-w-md animate-slide-up rounded-2xl border border-border bg-card p-6 shadow-2xl dark:border-dark-border dark:bg-dark-card" role="dialog" aria-modal="true">
            <div class="mb-4 flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-danger/15">
                    <i data-lucide="alert-triangle" class="h-5 w-5 text-danger"></i>
                </div>
                <h3 class="text-lg font-semibold text-text dark:text-dark-text" id="confirm-modal-title">Konfirmasi</h3>
            </div>
            <p class="mb-6 text-sm text-text/70 dark:text-dark-muted" id="confirm-modal-message">Apakah Anda yakin?</p>
            <div class="flex justify-end gap-3">
                <button type="button" id="confirm-modal-cancel" class="btn-secondary py-2.5 px-5 text-sm">Batal</button>
                <button type="button" id="confirm-modal-confirm" class="inline-flex items-center justify-center gap-2 rounded-xl bg-danger px-5 py-2.5 text-sm font-semibold text-white transition-all hover:opacity-90">Ya, Lanjutkan</button>
            </div>
        </div>
    `;
    document.body.appendChild(overlay);
    return overlay;
}

function getModal() {
    return document.getElementById('confirm-modal-overlay') || createModal();
}

function closeModal() {
    const modal = getModal();
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    activeModal = null;
}

/**
 * Inisialisasi modal konfirmasi pada elemen dengan data-confirm.
 */
export function initConfirmModals() {
    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('[data-confirm-form]');
        if (!trigger) return;

        e.preventDefault();
        const formId = trigger.dataset.confirmForm;
        const form = formId ? document.getElementById(formId) : null;
        if (!form) return;

        const message = trigger.dataset.confirm || 'Apakah Anda yakin ingin melanjutkan?';
        const title = trigger.dataset.confirmTitle || 'Konfirmasi';
        showConfirmModal(message, title, () => form.submit());
    });

    document.addEventListener('submit', (e) => {
        const form = e.target.closest('[data-confirm]');
        if (!form || form.dataset.confirmed === 'true') return;

        e.preventDefault();
        const message = form.dataset.confirm || 'Apakah Anda yakin ingin melanjutkan?';
        const title = form.dataset.confirmTitle || 'Konfirmasi';
        showConfirmModal(message, title, () => {
            form.dataset.confirmed = 'true';
            form.requestSubmit();
        });
    });
}

export function showConfirmModal(message, title = 'Konfirmasi', onConfirm) {
    const modal = getModal();
    modal.querySelector('#confirm-modal-title').textContent = title;
    modal.querySelector('#confirm-modal-message').textContent = message;

    modal.classList.remove('hidden');
    modal.classList.add('flex');

    if (window.initLucideIcons) {
        window.initLucideIcons();
    }

    const confirmBtn = modal.querySelector('#confirm-modal-confirm');
    const cancelBtn = modal.querySelector('#confirm-modal-cancel');

    const handleConfirm = () => {
        closeModal();
        confirmBtn.removeEventListener('click', handleConfirm);
        cancelBtn.removeEventListener('click', handleCancel);
        modal.removeEventListener('click', handleOverlay);
        onConfirm?.();
    };

    const handleCancel = () => {
        closeModal();
        confirmBtn.removeEventListener('click', handleConfirm);
        cancelBtn.removeEventListener('click', handleCancel);
        modal.removeEventListener('click', handleOverlay);
    };

    const handleOverlay = (ev) => {
        if (ev.target === modal) handleCancel();
    };

    confirmBtn.addEventListener('click', handleConfirm);
    cancelBtn.addEventListener('click', handleCancel);
    modal.addEventListener('click', handleOverlay);
    activeModal = modal;
}

window.showConfirmModal = showConfirmModal;

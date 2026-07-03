/**
 * Modul Preview Bukti Pembayaran WijayCart.
 * Preview gambar bukti pembayaran sebelum upload.
 */

const ALLOWED_TYPES = ['image/jpeg', 'image/png'];
const MAX_SIZE = 2 * 1024 * 1024;

export function initPaymentProofPreview() {
    document.querySelectorAll('[data-payment-proof-preview]').forEach((input) => {
        input.addEventListener('change', (e) => {
            const targetId = input.dataset.paymentProofPreview;
            const preview = document.getElementById(targetId);
            const file = e.target.files?.[0];
            if (!preview || !file) return;

            if (!ALLOWED_TYPES.includes(file.type)) {
                window.showToast?.('Format harus JPG, JPEG, atau PNG.', 'error');
                input.value = '';
                return;
            }

            if (file.size > MAX_SIZE) {
                window.showToast?.('Ukuran file maksimal 2 MB.', 'error');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = (ev) => {
                preview.src = ev.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    });
}

/**
 * Modul Preview Avatar WijayCart.
 * Preview gambar avatar sebelum upload di halaman profil.
 */

const ALLOWED_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
const MAX_SIZE = 2 * 1024 * 1024;

export function initAvatarPreview() {
    document.querySelectorAll('[data-avatar-preview]').forEach((input) => {
        input.addEventListener('change', (e) => {
            const targetId = input.dataset.avatarPreview;
            const preview = document.getElementById(targetId);
            const file = e.target.files?.[0];
            if (!preview || !file) return;

            if (!ALLOWED_TYPES.includes(file.type)) {
                window.showToast?.('Format harus JPEG, PNG, atau WebP.', 'error');
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
                preview.alt = 'Preview avatar';
            };
            reader.readAsDataURL(file);
        });
    });
}

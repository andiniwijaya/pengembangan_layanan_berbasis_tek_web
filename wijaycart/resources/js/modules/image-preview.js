/**
 * Modul Preview Upload Gambar WijayCart.
 * Menampilkan preview gambar sebelum upload di form admin produk/kategori.
 */

export function initImagePreview() {
    document.querySelectorAll('[data-image-preview]').forEach((input) => {
        input.addEventListener('change', (e) => {
            const targetId = input.dataset.imagePreview;
            const preview = document.getElementById(targetId);
            if (!preview) return;

            preview.innerHTML = '';
            const files = Array.from(e.target.files);

            files.forEach((file) => {
                if (!file.type.startsWith('image/')) return;
                if (file.size > 2 * 1024 * 1024) {
                    window.showToast?.(`File ${file.name} melebihi 2MB.`, 'error');
                    return;
                }

                const reader = new FileReader();
                reader.onload = (ev) => {
                    const img = document.createElement('img');
                    img.src = ev.target.result;
                    img.className = 'h-24 w-24 rounded-xl object-cover border border-border dark:border-dark-border';
                    img.alt = 'Preview upload';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        });
    });
}

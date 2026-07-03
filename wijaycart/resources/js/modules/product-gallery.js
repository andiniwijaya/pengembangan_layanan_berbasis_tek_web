/**
 * Modul Gallery Produk WijayCart.
 * Mengganti foto utama saat thumbnail gallery diklik di halaman detail produk.
 */

export function initProductGallery() {
    const gallery = document.getElementById('product-gallery');
    if (!gallery) return;

    const mainImage = document.getElementById('product-main-image');
    const thumbs = gallery.querySelectorAll('[data-gallery-thumb]');

    thumbs.forEach((thumb) => {
        thumb.addEventListener('click', () => {
            const src = thumb.dataset.galleryThumb;
            if (mainImage && src) {
                mainImage.src = src;
                mainImage.classList.add('scale-105');
                setTimeout(() => mainImage.classList.remove('scale-105'), 200);
            }

            thumbs.forEach((t) => t.classList.remove('ring-2', 'ring-primary'));
            thumb.classList.add('ring-2', 'ring-primary');
        });
    });
}

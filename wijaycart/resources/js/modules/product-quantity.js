/**
 * Modul kontrol jumlah pembelian di halaman detail produk.
 */

export function initProductQuantity() {
    const input = document.getElementById('quantity');
    const minusBtn = document.getElementById('qty-minus');
    const plusBtn = document.getElementById('qty-plus');

    if (!input) return;

    minusBtn?.addEventListener('click', () => {
        if (parseInt(input.value, 10) > 1) {
            input.value = parseInt(input.value, 10) - 1;
        }
    });

    plusBtn?.addEventListener('click', () => {
        const max = parseInt(input.max, 10);
        if (parseInt(input.value, 10) < max) {
            input.value = parseInt(input.value, 10) + 1;
        }
    });
}

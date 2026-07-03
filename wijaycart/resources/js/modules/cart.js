/**
 * Modul Keranjang Belanja WijayCart.
 * Menangani update quantity, hapus item, dan tambah produk via AJAX tanpa reload halaman.
 */

import { showToast } from './toast.js';

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.content;
}

function formatRupiah(num) {
    return 'Rp ' + Number(num).toLocaleString('id-ID');
}

function setLoading(button, loading) {
    if (!button) return;
    button.disabled = loading;
    button.classList.toggle('opacity-50', loading);
}

/**
 * Update tampilan ringkasan keranjang setelah response AJAX.
 */
function updateCartSummary(data) {
    const subtotalEl = document.getElementById('cart-subtotal');
    const totalEl = document.getElementById('cart-total');
    const countEl = document.getElementById('cart-item-count');
    const navbarCount = document.getElementById('navbar-cart-count');

    if (subtotalEl) subtotalEl.textContent = data.subtotal_formatted;
    if (totalEl) totalEl.textContent = data.total_formatted;
    if (countEl) countEl.textContent = data.item_count;
    if (navbarCount) {
        navbarCount.textContent = data.item_count;
        navbarCount.classList.toggle('hidden', data.item_count === 0);
    }
}

/**
 * Update baris item keranjang setelah perubahan quantity.
 */
function updateCartRow(item) {
    const row = document.querySelector(`[data-cart-item="${item.id}"]`);
    if (!row) return;

    const subtotalEl = row.querySelector('[data-item-subtotal]');
    const qtyInput = row.querySelector('[data-qty-input]');
    if (subtotalEl) subtotalEl.textContent = item.subtotal_formatted;
    if (qtyInput) qtyInput.value = item.quantity;
}

/** Hapus baris item dari DOM jika keranjang kosong reload tampilan empty state. */
function removeCartRow(itemId, data) {
    const row = document.querySelector(`[data-cart-item="${itemId}"]`);
    row?.remove();

    if (data.items.length === 0) {
        window.location.reload();
    }
}

async function cartRequest(url, method, body = null) {
    const options = {
        method,
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
    };

    if (body) {
        options.headers['Content-Type'] = 'application/json';
        options.body = JSON.stringify(body);
    }

    const response = await fetch(url, options);
    const data = await response.json();

    if (!response.ok) {
        throw new Error(data.message || 'Terjadi kesalahan.');
    }

    return data;
}

/**
 * Inisialisasi interaksi keranjang pada halaman cart.index.
 */
export function initCartPage() {
    const cartPage = document.getElementById('cart-page');
    if (!cartPage) return;

    cartPage.addEventListener('click', async (e) => {
        const minusBtn = e.target.closest('[data-qty-minus]');
        const plusBtn = e.target.closest('[data-qty-plus]');
        const deleteBtn = e.target.closest('[data-cart-delete]');

        if (minusBtn || plusBtn) {
            e.preventDefault();
            const row = (minusBtn || plusBtn).closest('[data-cart-item]');
            const itemId = row.dataset.cartItem;
            const input = row.querySelector('[data-qty-input]');
            const max = parseInt(input.max, 10);
            let qty = parseInt(input.value, 10);

            qty = minusBtn ? Math.max(1, qty - 1) : Math.min(max, qty + 1);
            if (qty === parseInt(input.value, 10)) return;

            const btn = minusBtn || plusBtn;
            setLoading(btn, true);

            try {
                const data = await cartRequest(`/cart/${itemId}`, 'PUT', { quantity: qty });
                const item = data.cart.items.find((i) => String(i.id) === String(itemId));
                updateCartRow(item);
                updateCartSummary(data.cart);
                showToast(data.message, 'success');
            } catch (err) {
                showToast(err.message, 'error');
            } finally {
                setLoading(btn, false);
            }
        }

        if (deleteBtn) {
            e.preventDefault();
            const row = deleteBtn.closest('[data-cart-item]');
            const itemId = row.dataset.cartItem;

            window.showConfirmModal(
                'Produk akan dihapus dari keranjang.',
                'Hapus dari Keranjang?',
                async () => {
                    setLoading(deleteBtn, true);
                    try {
                        const data = await cartRequest(`/cart/${itemId}`, 'DELETE');
                        removeCartRow(itemId, data.cart);
                        updateCartSummary(data.cart);
                        showToast(data.message, 'success');
                    } catch (err) {
                        showToast(err.message, 'error');
                    } finally {
                        setLoading(deleteBtn, false);
                    }
                }
            );
        }
    });

    cartPage.addEventListener('change', async (e) => {
        const input = e.target.closest('[data-qty-input]');
        if (!input) return;

        const row = input.closest('[data-cart-item]');
        const itemId = row.dataset.cartItem;
        const qty = parseInt(input.value, 10);

        try {
            const data = await cartRequest(`/cart/${itemId}`, 'PUT', { quantity: qty });
            const item = data.cart.items.find((i) => String(i.id) === String(itemId));
            updateCartRow(item);
            updateCartSummary(data.cart);
            showToast(data.message, 'success');
        } catch (err) {
            showToast(err.message, 'error');
        }
    });
}

/**
 * Tambah produk ke keranjang via AJAX (katalog & detail produk).
 */
export function initAddToCartButtons() {
    document.addEventListener('submit', async (e) => {
        const form = e.target.closest('[data-add-to-cart]');
        if (!form || form.dataset.ajax !== 'true') return;

        e.preventDefault();
        const btn = form.querySelector('[type="submit"]');
        setLoading(btn, true);

        const formData = new FormData(form);
        const payload = {
            product_id: formData.get('product_id'),
            quantity: parseInt(formData.get('quantity') || '1', 10),
        };

        try {
            const response = await fetch('/cart', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(payload),
            });
            const data = await response.json();

            if (!response.ok) throw new Error(data.message);

            const navbarCount = document.getElementById('navbar-cart-count');
            if (navbarCount && data.cart) {
                navbarCount.textContent = data.cart.item_count;
                navbarCount.classList.remove('hidden');
            }

            showToast(data.message, 'success');
        } catch (err) {
            showToast(err.message || 'Gagal menambahkan ke keranjang.', 'error');
        } finally {
            setLoading(btn, false);
        }
    });
}

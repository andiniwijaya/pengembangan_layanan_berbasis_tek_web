/**
 * Notifikasi WijayCart — menampilkan modal terpusat dengan ikon.
 * showToast tetap diekspor agar modul lain (cart, preview, dll.) tidak perlu diubah.
 */

import { showAlertModal, initSessionAlerts } from './alert-modal.js';

/**
 * Tampilkan notifikasi (modal terpusat).
 * @param {string} message
 * @param {'success'|'error'|'warning'|'info'} type
 */
export function showToast(message, type = 'success') {
    showAlertModal(message, type);
}

/** Alias untuk kompatibilitas — membaca elemen flash dari partial. */
export function initSessionToasts() {
    initSessionAlerts();
}

window.showToast = showToast;

/**
 * Entry point JavaScript WijayCart.
 * Mengimpor semua modul UI dan menginisialisasi saat DOM siap.
 */

import 'flowbite';
import { createIcons, icons } from 'lucide';

import { showToast, initSessionToasts } from './modules/toast.js';
import { initConfirmModals } from './modules/modal.js';
import { initCartPage, initAddToCartButtons } from './modules/cart.js';
import { initProductGallery } from './modules/product-gallery.js';
import { initImagePreview } from './modules/image-preview.js';
import { initBarcodeActions } from './modules/barcode.js';
import { initNavbarScroll, initDarkMode } from './modules/navbar.js';
import { initDashboardChart } from './modules/dashboard-charts.js';
import { initReportsCharts } from './modules/reports-charts.js';
import { initProductQuantity } from './modules/product-quantity.js';
import { initHeroCarousel } from './modules/hero-carousel.js';
import { initAvatarPreview } from './modules/avatar-preview.js';
import { initPaymentProofPreview } from './modules/payment-proof-preview.js';
import { initPasswordToggle } from './modules/password-toggle.js';
import { initTooltips } from './modules/tooltips.js';
import { initAdminSidebar } from './modules/admin-sidebar.js';

/** Render ulang icon Lucide setelah perubahan DOM dinamis. */
function initLucideIcons() {
    createIcons({ icons });
}

window.initLucideIcons = initLucideIcons;
window.showToast = showToast;

document.addEventListener('DOMContentLoaded', () => {
    initLucideIcons();
    initNavbarScroll();
    initDarkMode();
    initSessionToasts();
    initConfirmModals();
    initCartPage();
    initAddToCartButtons();
    initProductGallery();
    initImagePreview();
    initBarcodeActions();
    initProductQuantity();
    initReportsCharts();
    initDashboardChart();
    initHeroCarousel();
    initAvatarPreview();
    initPaymentProofPreview();
    initPasswordToggle();
    initTooltips();
    initAdminSidebar();
});

document.addEventListener('htmx:afterSwap', initLucideIcons);

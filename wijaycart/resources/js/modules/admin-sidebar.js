/**
 * Toggle sidebar admin — mobile overlay & collapse desktop.
 */

const STORAGE_KEY = 'wijaycart-admin-sidebar';

export function initAdminSidebar() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-sidebar-overlay');
    const mainWrap = document.querySelector('.admin-main-wrap');
    const toggleButtons = document.querySelectorAll('[data-admin-sidebar-toggle]');
    const closeButtons = document.querySelectorAll('[data-admin-sidebar-close]');

    if (!sidebar) {
        return;
    }

    const isDesktop = () => window.innerWidth >= 1024;

    const isSidebarOpen = () => {
        if (isDesktop()) {
            return !sidebar.classList.contains('is-collapsed');
        }

        return sidebar.classList.contains('is-open');
    };

    const syncToggleIcons = () => {
        const open = isSidebarOpen();
        const iconName = open ? 'panel-left-close' : 'panel-left-open';

        document.querySelectorAll('[data-admin-sidebar-toggle-icon]').forEach((icon) => {
            icon.setAttribute('data-lucide', iconName);
        });

        window.initLucideIcons?.();
    };

    const close = () => {
        if (isDesktop()) {
            sidebar.classList.add('is-collapsed');
            mainWrap?.classList.add('is-sidebar-collapsed');
            localStorage.setItem(STORAGE_KEY, 'collapsed');
        } else {
            sidebar.classList.remove('is-open');
            overlay?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        syncToggleIcons();
    };

    const open = () => {
        if (isDesktop()) {
            sidebar.classList.remove('is-collapsed');
            mainWrap?.classList.remove('is-sidebar-collapsed');
            localStorage.setItem(STORAGE_KEY, 'open');
        } else {
            sidebar.classList.add('is-open');
            overlay?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        syncToggleIcons();
    };

    const toggle = () => {
        if (isSidebarOpen()) {
            close();
        } else {
            open();
        }
    };

    toggleButtons.forEach((btn) => btn.addEventListener('click', toggle));
    closeButtons.forEach((btn) => btn.addEventListener('click', close));
    overlay?.addEventListener('click', close);

    window.addEventListener('resize', () => {
        if (isDesktop()) {
            overlay?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            sidebar.classList.remove('is-open');
        } else {
            sidebar.classList.remove('is-collapsed');
            mainWrap?.classList.remove('is-sidebar-collapsed');
        }

        syncToggleIcons();
    });

    if (isDesktop() && localStorage.getItem(STORAGE_KEY) === 'collapsed') {
        sidebar.classList.add('is-collapsed');
        mainWrap?.classList.add('is-sidebar-collapsed');
    }

    syncToggleIcons();
}

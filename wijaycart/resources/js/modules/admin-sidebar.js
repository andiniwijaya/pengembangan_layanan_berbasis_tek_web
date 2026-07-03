/**
 * Overlay dan toggle sidebar admin di mobile.
 */

export function initAdminSidebar() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-sidebar-overlay');
    const toggleButtons = document.querySelectorAll('[data-admin-sidebar-toggle]');

    if (!sidebar) {
        return;
    }

    const close = () => {
        sidebar.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    };

    const open = () => {
        sidebar.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    };

    toggleButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            if (sidebar.classList.contains('-translate-x-full')) {
                open();
            } else {
                close();
            }
        });
    });

    overlay?.addEventListener('click', close);

    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            sidebar.classList.remove('-translate-x-full');
            overlay?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });
}

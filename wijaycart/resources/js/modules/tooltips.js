/**
 * Inisialisasi Flowbite tooltips untuk icon dan tombol aksi.
 */

import { Tooltip } from 'flowbite';

export function initTooltips() {
    document.querySelectorAll('[data-tooltip-target]').forEach((trigger) => {
        const targetId = trigger.getAttribute('data-tooltip-target');
        const target = document.getElementById(targetId?.replace('#', '') ?? '');

        if (!target) {
            return;
        }

        new Tooltip(target, trigger, {
            placement: trigger.getAttribute('data-tooltip-placement') || 'top',
            triggerType: 'hover',
        });
    });
}

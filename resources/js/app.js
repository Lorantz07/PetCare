import './bootstrap';
import { createIcons } from 'lucide';
import { icons } from './icons';
import { initUI } from './ui';
import { initTables } from './table';
import { initCharts } from './charts';
import { initBookingWizard } from './booking';

const renderIcons = () => {
    createIcons({
        icons,
        attrs: {
            'stroke-width': 1.8,
            'aria-hidden': 'true',
            focusable: 'false',
        },
    });
};

window.refreshIcons = renderIcons;

document.addEventListener('DOMContentLoaded', () => {
    renderIcons();
    initUI();
    initTables();
    initCharts();
    initBookingWizard();
});

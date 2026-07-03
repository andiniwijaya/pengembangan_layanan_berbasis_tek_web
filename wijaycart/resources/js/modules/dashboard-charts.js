/**
 * Modul Chart.js untuk dashboard admin.
 * Chart.js di-load secara lazy agar bundle storefront lebih ringan.
 */

async function loadChart() {
    if (window.Chart) {
        return window.Chart;
    }

    const { default: Chart } = await import('chart.js/auto');
    window.Chart = Chart;

    return Chart;
}

function chartOptions(isDark) {
    const gridColor = isDark ? 'rgba(61, 53, 44, 0.5)' : 'rgba(232, 227, 213, 0.5)';
    const textColor = isDark ? '#A89888' : '#4A3A2A';

    return {
        responsive: true,
        plugins: {
            legend: { display: false },
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: gridColor },
                ticks: { color: textColor },
            },
            x: {
                grid: { display: false },
                ticks: { color: textColor },
            },
        },
    };
}

export async function initDashboardChart() {
    const Chart = await loadChart();
    const isDark = document.documentElement.classList.contains('dark');

    const salesDataEl = document.getElementById('dashboard-chart-data');
    const salesCtx = document.getElementById('salesChart');
    if (salesDataEl && salesCtx) {
        const labels = JSON.parse(salesDataEl.dataset.labels || '[]');
        const revenue = JSON.parse(salesDataEl.dataset.revenue || '[]');

        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: revenue,
                    borderColor: '#8B5E3C',
                    backgroundColor: 'rgba(246, 215, 118, 0.25)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 3,
                }],
            },
            options: chartOptions(isDark),
        });
    }

    const topDataEl = document.getElementById('dashboard-top-products-data');
    const topCtx = document.getElementById('topProductsChart');
    if (topDataEl && topCtx) {
        const labels = JSON.parse(topDataEl.dataset.labels || '[]');
        const sold = JSON.parse(topDataEl.dataset.sold || '[]');

        new Chart(topCtx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Terjual',
                    data: sold,
                    backgroundColor: 'rgba(139, 94, 60, 0.75)',
                    borderRadius: 8,
                }],
            },
            options: {
                ...chartOptions(isDark),
                indexAxis: 'y',
            },
        });
    }
}

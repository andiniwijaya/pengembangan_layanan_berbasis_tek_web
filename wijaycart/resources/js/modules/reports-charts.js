/**
 * Modul Chart.js untuk halaman laporan admin.
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

export async function initReportsCharts() {
    const dataEl = document.getElementById('report-chart-data');
    if (!dataEl) return;

    const Chart = await loadChart();
    const monthlySales = JSON.parse(dataEl.dataset.monthly || '[]');
    const statusBreakdown = JSON.parse(dataEl.dataset.status || '[]');
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

    const monthlyCtx = document.getElementById('monthlyChart');
    if (monthlyCtx) {
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: monthlySales.map((s) => `${months[s.month - 1]} ${s.year}`),
                datasets: [{
                    label: 'Pendapatan',
                    data: monthlySales.map((s) => s.revenue),
                    backgroundColor: 'rgba(246, 215, 118, 0.85)',
                    borderColor: '#8B5E3C',
                    borderWidth: 1,
                    borderRadius: 8,
                }],
            },
            options: { responsive: true, plugins: { legend: { display: false } } },
        });
    }

    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusBreakdown.map((s) => s.status),
                datasets: [{
                    data: statusBreakdown.map((s) => s.count),
                    backgroundColor: ['#F6D776', '#8B5E3C', '#7FB77E', '#D97777', '#E8E3D5'],
                }],
            },
            options: { responsive: true },
        });
    }
}

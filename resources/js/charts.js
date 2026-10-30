import { Chart, registerables } from 'chart.js';

Chart.register(...registerables);

const FONT_FAMILY = "'Plus Jakarta Sans Variable', 'Plus Jakarta Sans', sans-serif";

Chart.defaults.font.family = FONT_FAMILY;
Chart.defaults.color = '#64748b';

const palette = {
    primary: {
        border: '#0F9B81',
        fill: (ctx) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(15, 155, 129, 0.28)');
            gradient.addColorStop(1, 'rgba(15, 155, 129, 0.01)');
            return gradient;
        },
    },
    accent: {
        border: '#F59E0B',
        fill: (ctx) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(245, 158, 11, 0.22)');
            gradient.addColorStop(1, 'rgba(245, 158, 11, 0.01)');
            return gradient;
        },
    },
    sky: {
        border: '#38BDF8',
        fill: (ctx) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(56, 189, 248, 0.2)');
            gradient.addColorStop(1, 'rgba(56, 189, 248, 0.01)');
            return gradient;
        },
    },
    violet: {
        border: '#8B5CF6',
        fill: (ctx) => {
            const gradient = ctx.createLinearGradient(0, 0, 0, 280);
            gradient.addColorStop(0, 'rgba(139, 92, 246, 0.2)');
            gradient.addColorStop(1, 'rgba(139, 92, 246, 0.01)');
            return gradient;
        },
    },
};

const tooltipOptions = {
    backgroundColor: 'rgba(15, 23, 42, 0.94)',
    titleColor: '#f8fafc',
    bodyColor: '#e2e8f0',
    padding: 12,
    cornerRadius: 10,
    displayColors: false,
    titleFont: { family: FONT_FAMILY, size: 11, weight: '700' },
    bodyFont: { family: FONT_FAMILY, size: 11, weight: '600' },
};

function buildDataset(dataset, canvas) {
    const variant = dataset.variant || 'primary';
    const colors = palette[variant] || palette.primary;
    const ctx = canvas.getContext('2d');
    const type = dataset.type || 'line';
    const isLine = type === 'line';

    return {
        label: dataset.label,
        data: dataset.data,
        borderColor: colors.border,
        backgroundColor: dataset.fill === false ? colors.border : colors.fill(ctx),
        borderWidth: isLine ? 2.4 : 0,
        borderRadius: isLine ? 0 : 8,
        borderSkipped: false,
        fill: isLine && dataset.fill !== false,
        tension: 0.42,
        pointRadius: 0,
        pointHoverRadius: 4,
        pointHoverBackgroundColor: '#fff',
        pointHoverBorderColor: colors.border,
        pointHoverBorderWidth: 2,
        barThickness: dataset.barThickness || 'flex',
        maxBarThickness: 28,
    };
}

function buildOptions(config, hasLegend) {
    const isCircular = config.type === 'doughnut' || config.type === 'pie';

    if (isCircular) {
        return {
            responsive: true,
            maintainAspectRatio: false,
            cutout: config.cutout || '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    ...tooltipOptions,
                    callbacks: {
                        label: (context) => ` ${context.label}: ${context.parsed}%`,
                    },
                },
            },
        };
    }

    return {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: {
                display: hasLegend,
                position: 'bottom',
                align: 'start',
                labels: {
                    usePointStyle: true,
                    pointStyle: 'circle',
                    boxWidth: 6,
                    boxHeight: 6,
                    padding: 16,
                    color: '#64748b',
                    font: { family: FONT_FAMILY, size: 10, weight: '700' },
                },
            },
            tooltip: {
                ...tooltipOptions,
                callbacks: config.currency
                    ? { label: (context) => ` ${context.dataset.label}: Rp ${Number(context.parsed.y).toLocaleString('id-ID')}` }
                    : {},
            },
        },
        scales: {
            x: {
                grid: { display: false },
                border: { display: false },
                ticks: {
                    color: '#94a3b8',
                    font: { family: FONT_FAMILY, size: 10, weight: '600' },
                    maxRotation: 0,
                },
            },
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(226, 232, 240, 0.7)' },
                border: { display: false },
                ticks: {
                    color: '#94a3b8',
                    font: { family: FONT_FAMILY, size: 10, weight: '600' },
                    maxTicksLimit: 5,
                    callback: (value) => (config.tickSuffix ? `${value}${config.tickSuffix}` : value),
                },
            },
        },
    };
}

function buildChart(canvas, config) {
    const isDoughnut = config.type === 'doughnut' || config.type === 'pie';

    if (isDoughnut) {
        return new Chart(canvas, {
            type: config.type,
            data: {
                labels: config.labels,
                datasets: [
                    {
                        data: config.data,
                        backgroundColor: config.colors || ['#0F9B81', '#38BDF8', '#F59E0B', '#A7F3D0'],
                        borderWidth: 0,
                        hoverOffset: 6,
                    },
                ],
            },
            options: buildOptions(config, false),
        });
    }

    return new Chart(canvas, {
        type: config.type || 'line',
        data: {
            labels: config.labels,
            datasets: (config.datasets || []).map((dataset) => buildDataset(dataset, canvas)),
        },
        options: buildOptions(config, config.legend !== false && (config.datasets || []).length > 1),
    });
}

function readConfig(canvas) {
    const id = canvas.dataset.chart;
    const source = document.querySelector(`script[data-chart-config="${id}"]`);

    if (!source) {
        return null;
    }

    try {
        return JSON.parse(source.textContent);
    } catch (error) {
        console.warn(`Chart config ${id} tidak valid.`, error);
        return null;
    }
}

function applyRange(chart, range) {
    if (!range) return;

    chart.data.labels = range.labels;
    chart.data.datasets = (range.datasets || []).map((dataset) => buildDataset(dataset, chart.canvas));
    chart.update();
}

export function initCharts() {
    document.querySelectorAll('canvas[data-chart]').forEach((canvas) => {
        if (canvas.dataset.chartInitialized === 'true') return;

        const config = readConfig(canvas);
        if (!config) return;

        canvas.dataset.chartInitialized = 'true';

        if (config.ranges) {
            const initialRange = config.defaultRange || Object.keys(config.ranges)[0];
            const initial = config.ranges[initialRange];
            const merged = {
                ...config,
                labels: initial.labels,
                datasets: initial.datasets,
            };

            const chart = buildChart(canvas, merged);

            const card = canvas.closest('[data-chart-card]') || canvas.closest('.panel') || document;
            card.querySelectorAll('[data-chart-range]').forEach((button) => {
                button.classList.toggle('is-active', button.dataset.chartRange === initialRange);
                button.addEventListener('click', () => {
                    card.querySelectorAll('[data-chart-range]').forEach((item) => item.classList.remove('is-active'));
                    button.classList.add('is-active');
                    applyRange(chart, config.ranges[button.dataset.chartRange]);
                });
            });

            return;
        }

        buildChart(canvas, config);
    });
}

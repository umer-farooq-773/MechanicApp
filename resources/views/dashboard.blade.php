{{-- dashboard.blade.php --}}
@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', "Here's what's happening with your workshop today.")

@section('content')
<div class="animate-in">

    <!-- ========== DATE FILTER ========== -->
    <div class="dash-filter-bar">
        <div class="range-buttons" id="rangeButtons">
            <button type="button" data-range="today">Today</button>
            <button type="button" data-range="week">This Week</button>
            <button type="button" class="active" data-range="month">This Month</button>
            <button type="button" data-range="year">This Year</button>
            <button type="button" data-range="custom">Custom</button>
        </div>
        <div class="custom-range" id="customRangeInputs" style="display:none;">
            <input type="date" id="filterFrom">
            <span>to</span>
            <input type="date" id="filterTo">
            <button type="button" id="applyCustomRange">Apply</button>
        </div>
        <div class="range-label" id="rangeLabel"></div>
    </div>

    <!-- ========== STATS GRID (all values filled by JS from /dashboard/data) ========== -->
    <div class="stats-grid">
        <div class="stat-card animate-in" data-stat="revenue">
            <div class="stat-icon blue"><i class="bi bi-currency-dollar"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Revenue</div>
            <div class="stat-trend"></div>
        </div>

        <div class="stat-card animate-in" data-stat="orders">
            <div class="stat-icon green"><i class="bi bi-cart-fill"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Job Orders</div>
            <div class="stat-trend"></div>
        </div>

        <div class="stat-card animate-in" data-stat="unique_vehicles">
            <div class="stat-icon purple"><i class="bi bi-car-front-fill"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Vehicles Serviced</div>
            <div class="stat-trend"></div>
        </div>

        <div class="stat-card animate-in" data-stat="vehicle_models">
            <div class="stat-icon orange"><i class="bi bi-tags-fill"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Vehicle Models</div>
        </div>

        <div class="stat-card animate-in" data-stat="services">
            <div class="stat-icon yellow"><i class="bi bi-tools"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Services Rendered</div>
            <div class="stat-trend"></div>
        </div>

        <div class="stat-card animate-in" data-stat="submitted">
            <div class="stat-icon teal"><i class="bi bi-check-circle-fill"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Submitted Orders</div>
        </div>

        <div class="stat-card animate-in" data-stat="draft">
            <div class="stat-icon red"><i class="bi bi-file-earmark-text-fill"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Draft Orders</div>
        </div>

        <div class="stat-card animate-in" data-stat="customers">
            <div class="stat-icon pink"><i class="bi bi-people-fill"></i></div>
            <div class="stat-value">—</div>
            <div class="stat-label">Customers Served</div>
            <div class="stat-trend"></div>
        </div>
    </div>

    <!-- Charts Grid -->
    <div class="charts-grid">
        <div class="chart-card animate-in">
            <div class="chart-header">
                <h3>Revenue Overview</h3>
                <div class="chart-actions">
                    <button class="active" data-period="daily">Daily</button>
                    <button data-period="weekly">Weekly</button>
                    <button data-period="monthly">Monthly</button>
                    <button data-period="yearly">Yearly</button>
                </div>
            </div>
            <div class="chart-wrapper">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="chart-card animate-in">
            <div class="chart-header">
                <h3>Vehicle Model Distribution</h3>
            </div>
            <div class="chart-wrapper">
                <canvas id="vehicleChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Activity Grid -->
    <div class="activity-grid">
        <!-- Recent Job Orders -->
        <div class="activity-card animate-in">
            <div class="activity-header">
                <h3>Recent Job Orders</h3>
                <a href="{{ route('vehicle-entries.index') }}" class="view-all">View All →</a>
            </div>
            <div class="activity-list" id="recentOrdersList">
                <div class="activity-empty">Loading…</div>
            </div>
        </div>

        <!-- Draft Job Orders -->
        <div class="activity-card animate-in">
            <div class="activity-header">
                <h3>Draft Job Orders</h3>
                <a href="{{ route('vehicle-entries.index') }}" class="view-all">View All →</a>
            </div>
            <div class="activity-list" id="draftOrdersList">
                <div class="activity-empty">Loading…</div>
            </div>
        </div>
    </div>
</div>

<style>
    .dash-filter-bar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 18px;
    }

    .range-buttons {
        display: inline-flex;
        background: #eef2f7;
        border-radius: 8px;
        padding: 3px;
        gap: 2px;
    }

    .range-buttons button {
        border: none;
        background: transparent;
        padding: 7px 14px;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-radius: 6px;
        cursor: pointer;
    }

    .range-buttons button.active {
        background: #ffffff;
        color: #0E2038;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
    }

    .custom-range {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        color: #475569;
    }

    .custom-range input[type="date"] {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 6px 8px;
        font-size: 12px;
    }

    .custom-range button {
        border: none;
        background: #0E2038;
        color: #fff;
        padding: 7px 14px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
    }

    .range-label {
        margin-left: auto;
        font-size: 12px;
        color: #94a3b8;
        font-weight: 600;
    }

    .stat-trend.up { color: #16a34a; }
    .stat-trend.down { color: #dc2626; }
    .stat-trend:empty { display: none; }

    .activity-empty {
        padding: 20px 4px;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
    }

    .status-pill {
        font-size: 9px;
        font-weight: 700;
        text-transform: uppercase;
        padding: 2px 8px;
        border-radius: 10px;
        margin-left: 6px;
    }

    .status-pill.submitted {
        background: #dcfce7;
        color: #166534;
    }

    .status-pill.draft {
        background: #fef9c3;
        color: #854d0e;
    }
</style>
@endsection

@push('scripts')
<script>
(function () {
    'use strict';

    const DATA_URL = "{{ route('dashboard.data') }}";
    const CHART_URL = "{{ route('dashboard.chart') }}";

    // ---------- Revenue trend chart ----------
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Revenue',
                data: [],
                borderColor: '#2D5F96',
                backgroundColor: 'rgba(45, 95, 150, 0.08)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#2D5F96',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(14, 32, 56, 0.9)',
                    titleFont: { weight: '600' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: false,
                    callbacks: {
                        label: (context) => '$' + context.parsed.y.toLocaleString(undefined, { maximumFractionDigits: 2 }),
                    }
                }
            },
            scales: {
                x: { grid: { display: false }, ticks: { font: { size: 11 } } },
                y: {
                    grid: { color: 'rgba(0,0,0,0.04)', drawBorder: false },
                    ticks: {
                        font: { size: 11 },
                        callback: (value) => '$' + value.toLocaleString(),
                    }
                }
            },
            interaction: { intersect: false, mode: 'index' }
        }
    });

    async function loadChart(period) {
        try {
            const res = await fetch(CHART_URL + '?period=' + encodeURIComponent(period));
            const data = await res.json();
            revenueChart.data.labels = data.labels;
            revenueChart.data.datasets[0].data = data.values;
            revenueChart.update();
        } catch (err) {
            console.error('Failed to load revenue chart', err);
        }
    }

    document.querySelectorAll('.chart-actions button').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.chart-actions button').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            loadChart(this.dataset.period);
        });
    });

    // ---------- Vehicle model distribution ----------
    const vehicleCtx = document.getElementById('vehicleChart').getContext('2d');
    const vehicleChart = new Chart(vehicleCtx, {
        type: 'doughnut',
        data: {
            labels: [],
            datasets: [{
                data: [],
                backgroundColor: ['#2D5F96', '#5AA7E0', '#7DBCEA', '#A8D4F2', '#D3E9F8', '#B8C4D0'],
                borderColor: '#fff',
                borderWidth: 3,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { padding: 16, usePointStyle: true, pointStyle: 'circle', font: { size: 12, weight: '500' } }
                },
                tooltip: {
                    backgroundColor: 'rgba(14, 32, 56, 0.9)',
                    titleFont: { weight: '600' },
                    bodyFont: { size: 13 },
                    padding: 12,
                    cornerRadius: 8,
                    callbacks: {
                        label: (context) => {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const pct = total ? ((context.parsed / total) * 100).toFixed(1) : '0.0';
                            return context.label + ': ' + pct + '%';
                        }
                    }
                }
            },
            cutout: '65%'
        }
    });

    // ---------- Stat cards + panels ----------
    function fmtMoney(n) {
        return '$' + Number(n).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function renderStat(key, block) {
        const card = document.querySelector('.stat-card[data-stat="' + key + '"]');
        if (!card) return;

        const valueEl = card.querySelector('.stat-value');
        const trendEl = card.querySelector('.stat-trend');

        valueEl.textContent = key === 'revenue' ? fmtMoney(block.value) : Number(block.value).toLocaleString();

        if (trendEl && block.change !== undefined) {
            trendEl.className = 'stat-trend ' + block.direction;
            const icon = block.direction === 'up' ? 'bi-arrow-up' : 'bi-arrow-down';
            trendEl.innerHTML = '<i class="bi ' + icon + '"></i> ' + block.change + '%';
        }
    }

    function renderOrderList(containerId, orders, showStatus) {
        const container = document.getElementById(containerId);
        if (!orders.length) {
            container.innerHTML = '<div class="activity-empty">No orders in this range.</div>';
            return;
        }

        container.innerHTML = orders.map(o => `
            <div class="activity-item">
                <div class="item-icon blue"><i class="bi bi-wrench"></i></div>
                <div class="item-content">
                    <div class="item-title">${o.job_order} — ${escapeHtml(o.title)}
                        ${showStatus ? '<span class="status-pill ' + o.status + '">' + o.status + '</span>' : ''}
                    </div>
                    <div class="item-sub">${escapeHtml(o.sub)}</div>
                </div>
                <span class="item-time">${o.time}</span>
            </div>
        `).join('');
    }

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str ?? '';
        return div.innerHTML;
    }

    async function loadDashboardData(params) {
        try {
            const res = await fetch(DATA_URL + '?' + new URLSearchParams(params).toString());
            const data = await res.json();

            Object.entries(data.stats).forEach(([key, block]) => renderStat(key, block));

            vehicleChart.data.labels = data.vehicle_distribution.labels;
            vehicleChart.data.datasets[0].data = data.vehicle_distribution.values;
            vehicleChart.update();

            renderOrderList('recentOrdersList', data.recent_orders, true);
            renderOrderList('draftOrdersList', data.draft_orders, false);

            document.getElementById('rangeLabel').textContent = data.range.from === data.range.to
                ? data.range.from
                : data.range.from + ' → ' + data.range.to;
        } catch (err) {
            console.error('Failed to load dashboard data', err);
        }
    }

    // ---------- Date filter ----------
    const rangeButtons = document.getElementById('rangeButtons');
    const customInputs = document.getElementById('customRangeInputs');

    rangeButtons.addEventListener('click', function (e) {
        const btn = e.target.closest('button[data-range]');
        if (!btn) return;

        rangeButtons.querySelectorAll('button').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        if (btn.dataset.range === 'custom') {
            customInputs.style.display = 'inline-flex';
            return; // wait for Apply
        }

        customInputs.style.display = 'none';
        loadDashboardData({ range: btn.dataset.range });
    });

    document.getElementById('applyCustomRange').addEventListener('click', function () {
        const from = document.getElementById('filterFrom').value;
        const to = document.getElementById('filterTo').value;
        if (!from || !to) return;
        loadDashboardData({ range: 'custom', from, to });
    });

    // ---------- Initial load ----------
    loadDashboardData({ range: 'month' });
    loadChart('daily');
})();
</script>
@endpush

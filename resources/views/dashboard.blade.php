{{-- dashboard.blade.php --}}
@extends('layouts.app')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Welcome back, John! Here\'s what\'s happening with your workshop today.')

@section('content')
<div class="animate-in">
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card animate-in">
            <div class="stat-icon blue"><i class="fas fa-dollar-sign"></i></div>
            <div class="stat-value">$12,430</div>
            <div class="stat-label">Today's Revenue</div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 12.5%</div>
        </div>

        <div class="stat-card animate-in">
            <div class="stat-icon green"><i class="fas fa-shopping-cart"></i></div>
            <div class="stat-value">48</div>
            <div class="stat-label">Total Sales Today</div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 8.2%</div>
        </div>

        <div class="stat-card animate-in">
            <div class="stat-icon purple"><i class="fas fa-car"></i></div>
            <div class="stat-value">156</div>
            <div class="stat-label">Total Vehicles</div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 5.3%</div>
        </div>

        <div class="stat-card animate-in">
            <div class="stat-icon orange"><i class="fas fa-tags"></i></div>
            <div class="stat-value">12</div>
            <div class="stat-label">Vehicle Types</div>
            <div class="stat-trend down"><i class="fas fa-arrow-down"></i> 1.2%</div>
        </div>

        <div class="stat-card animate-in">
            <div class="stat-icon yellow"><i class="fas fa-tools"></i></div>
            <div class="stat-value">23</div>
            <div class="stat-label">Active Jobs</div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 3.8%</div>
        </div>

        <div class="stat-card animate-in">
            <div class="stat-icon teal"><i class="fas fa-check-circle"></i></div>
            <div class="stat-value">187</div>
            <div class="stat-label">Completed Jobs</div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 9.1%</div>
        </div>

        <div class="stat-card animate-in">
            <div class="stat-icon red"><i class="fas fa-clock"></i></div>
            <div class="stat-value">8</div>
            <div class="stat-label">Pending Services</div>
            <div class="stat-trend down"><i class="fas fa-arrow-down"></i> 2.4%</div>
        </div>

        <div class="stat-card animate-in">
            <div class="stat-icon pink"><i class="fas fa-users"></i></div>
            <div class="stat-value">342</div>
            <div class="stat-label">Total Customers</div>
            <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 6.7%</div>
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
                </div>
            </div>
            <div class="chart-wrapper">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <div class="chart-card animate-in">
            <div class="chart-header">
                <h3>Vehicle Type Distribution</h3>
            </div>
            <div class="chart-wrapper">
                <canvas id="vehicleChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Activity Grid -->
    <div class="activity-grid">
        <!-- Recent Repairs -->
        <div class="activity-card animate-in">
            <div class="activity-header">
                <h3>Recent Repairs</h3>
                <span class="view-all">View All →</span>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="item-icon green"><i class="fas fa-wrench"></i></div>
                    <div class="item-content">
                        <div class="item-title">Engine Oil Change</div>
                        <div class="item-sub">Toyota Camry • $120</div>
                    </div>
                    <span class="item-time">2 min ago</span>
                </div>
                <div class="activity-item">
                    <div class="item-icon yellow"><i class="fas fa-wrench"></i></div>
                    <div class="item-content">
                        <div class="item-title">Brake Pad Replacement</div>
                        <div class="item-sub">Honda Accord • $250</div>
                    </div>
                    <span class="item-time">15 min ago</span>
                </div>
                <div class="activity-item">
                    <div class="item-icon red"><i class="fas fa-wrench"></i></div>
                    <div class="item-content">
                        <div class="item-title">Transmission Service</div>
                        <div class="item-sub">Ford Mustang • $450</div>
                    </div>
                    <span class="item-time">1 hour ago</span>
                </div>
                <div class="activity-item">
                    <div class="item-icon blue"><i class="fas fa-wrench"></i></div>
                    <div class="item-content">
                        <div class="item-title">Tire Rotation</div>
                        <div class="item-sub">BMW X5 • $80</div>
                    </div>
                    <span class="item-time">2 hours ago</span>
                </div>
            </div>
        </div>

        <!-- Upcoming Services -->
        <div class="activity-card animate-in">
            <div class="activity-header">
                <h3>Upcoming Services</h3>
                <span class="view-all">View All →</span>
            </div>
            <div class="activity-list">
                <div class="activity-item">
                    <div class="item-icon yellow"><i class="fas fa-calendar"></i></div>
                    <div class="item-content">
                        <div class="item-title">Oil Change & Filter</div>
                        <div class="item-sub">Toyota Camry • Tomorrow 10:00 AM</div>
                    </div>
                    <span class="item-time">1 day</span>
                </div>
                <div class="activity-item">
                    <div class="item-icon red"><i class="fas fa-calendar"></i></div>
                    <div class="item-content">
                        <div class="item-title">Engine Diagnostic</div>
                        <div class="item-sub">BMW X5 • Tomorrow 2:00 PM</div>
                    </div>
                    <span class="item-time">1 day</span>
                </div>
                <div class="activity-item">
                    <div class="item-icon blue"><i class="fas fa-calendar"></i></div>
                    <div class="item-content">
                        <div class="item-title">Tire Replacement</div>
                        <div class="item-sub">Honda Accord • Dec 20, 10:30 AM</div>
                    </div>
                    <span class="item-time">3 days</span>
                </div>
                <div class="activity-item">
                    <div class="item-icon green"><i class="fas fa-calendar"></i></div>
                    <div class="item-content">
                        <div class="item-title">Brake Inspection</div>
                        <div class="item-sub">Ford Mustang • Dec 21, 9:00 AM</div>
                    </div>
                    <span class="item-time">4 days</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== Revenue Chart =====
        const ctx1 = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Revenue',
                    data: [3200, 2800, 4100, 3800, 5200, 4800, 6300],
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(14, 32, 56, 0.9)',
                        titleFont: { weight: '600' },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 11 }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(0,0,0,0.04)',
                            drawBorder: false
                        },
                        ticks: {
                            font: { size: 11 },
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // ===== Vehicle Type Distribution Chart =====
        const ctx2 = document.getElementById('vehicleChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ['Sedan', 'SUV', 'Truck', 'Sports', 'Electric'],
                datasets: [{
                    data: [45, 38, 22, 28, 15],
                    backgroundColor: ['#2D5F96', '#5AA7E0', '#7DBCEA', '#A8D4F2', '#D3E9F8'],
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
                        labels: {
                            padding: 16,
                            usePointStyle: true,
                            pointStyle: 'circle',
                            font: { size: 12, weight: '500' }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(14, 32, 56, 0.9)',
                        titleFont: { weight: '600' },
                        bodyFont: { size: 13 },
                        padding: 12,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + percentage + '%';
                            }
                        }
                    }
                },
                cutout: '65%'
            }
        });

        // ===== Chart Period Toggle =====
        document.querySelectorAll('.chart-actions button').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.chart-actions button').forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const period = this.dataset.period;
                let newData;
                switch(period) {
                    case 'weekly':
                        newData = [2800, 3200, 4100, 3800, 5200, 4800, 6300];
                        break;
                    case 'monthly':
                        newData = [12500, 13800, 14200, 15800, 17200, 16500, 18900];
                        break;
                    default:
                        newData = [3200, 2800, 4100, 3800, 5200, 4800, 6300];
                }
                revenueChart.data.datasets[0].data = newData;
                revenueChart.update();
            });
        });
    });
</script>
@endpush

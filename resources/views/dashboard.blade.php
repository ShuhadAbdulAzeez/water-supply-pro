@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <p class="mb-0 text-muted">Welcome back! Here's what's happening with your business today.</p>
        </div>
        <div class="text-muted">
            <small>{{ date('l, F j, Y') }}</small>
        </div>
    </div>

    <!-- Primary Metrics -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-users fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Total Customers</div>
                            <div class="h4 mb-0">{{ number_format($data['totalCustomers']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-wine-bottle fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Active Bottles</div>
                            <div class="h4 mb-0">{{ number_format($data['activeBottles']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-truck fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Pending Deliveries</div>
                            <div class="h4 mb-0">{{ number_format($data['pendingDeliveries']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-dollar-sign fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Monthly Revenue</div>
                            <div class="h4 mb-0">AED {{ number_format($data['monthlyRevenue'], 2) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Secondary Metrics -->
    <div class="row g-3">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-truck-moving fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Available Trucks</div>
                            <div class="h4 mb-0">{{ number_format($data['availableTrucks']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-wine-bottle fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Empty Bottles</div>
                            <div class="h4 mb-0">{{ number_format($data['emptyBottles']) }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-exclamation-triangle fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Damaged Bottles</div>
                            <div class="h4 mb-0">{{ number_format($data['damagedBottles']) }}</div>
                            @if($data['damagedBottles'] > 0)
                                <small class="text-muted">Requires attention</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-light rounded p-3">
                                <i class="fas fa-file-invoice-dollar fa-lg text-muted"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="small text-muted text-uppercase fw-bold">Unpaid Bills</div>
                            <div class="h4 mb-0">{{ number_format($data['unpaidBills']) }}</div>
                            @if($data['unpaidBills'] > 0)
                                <small class="text-muted">Follow up required</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Quick Actions -->
    <div class="row mt-4 g-3">
        <!-- Revenue Chart -->
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-muted text-uppercase fw-bold">Revenue Trend (Last 7 Days)</h6>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Bottle Distribution Chart -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-muted text-uppercase fw-bold">Bottle Distribution</h6>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="bottleChart" width="250" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 text-muted text-uppercase fw-bold">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-dark w-100 py-2">
                                <i class="fas fa-plus me-2"></i>New Customer
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-dark w-100 py-2">
                                <i class="fas fa-truck me-2"></i>Schedule Delivery
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-dark w-100 py-2">
                                <i class="fas fa-clipboard-list me-2"></i>View Inventory
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" class="btn btn-outline-dark w-100 py-2">
                                <i class="fas fa-chart-bar me-2"></i>Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.text-gray-800 {
    color: #2d3436 !important;
}

.btn-outline-dark:hover {
    background-color: #2d3436;
    border-color: #2d3436;
}

.small {
    font-size: 0.75rem;
}

.h4 {
    font-weight: 600;
}
</style>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Sample data - replace with actual data from your controller
const revenueData = {
    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
    datasets: [{
        label: 'Revenue (AED)',
        data: [2400, 3200, 2800, 3600, 4200, 3800, 4500],
        borderColor: '#6c757d',
        backgroundColor: 'rgba(108, 117, 125, 0.1)',
        borderWidth: 2,
        fill: true,
        tension: 0.4
    }]
};

const bottleData = {
    labels: ['Active Bottles', 'Empty Bottles', 'Damaged Bottles'],
    datasets: [{
        data: [{{ $data['activeBottles'] }}, {{ $data['emptyBottles'] }}, {{ $data['damagedBottles'] }}],
        backgroundColor: [
            '#495057',
            '#6c757d', 
            '#adb5bd'
        ],
        borderWidth: 0
    }]
};

// Revenue Chart Configuration
const revenueConfig = {
    type: 'line',
    data: revenueData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f8f9fa'
                },
                ticks: {
                    color: '#6c757d'
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#6c757d'
                }
            }
        },
        elements: {
            point: {
                radius: 4,
                hoverRadius: 6
            }
        }
    }
};

// Bottle Distribution Chart Configuration
const bottleConfig = {
    type: 'doughnut',
    data: bottleData,
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    color: '#6c757d',
                    usePointStyle: true
                }
            }
        },
        cutout: '60%'
    }
};

// Initialize Charts
document.addEventListener('DOMContentLoaded', function() {
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const bottleCtx = document.getElementById('bottleChart').getContext('2d');
    
    new Chart(revenueCtx, revenueConfig);
    new Chart(bottleCtx, bottleConfig);
});
</script>
@endsection
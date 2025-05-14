@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-tachometer-alt me-2"></i>Dashboard Overview</h4>
                </div>
                <div class="card-body">
                    <!-- Quick Stats -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-2x text-primary mb-3"></i>
                                    <h3 class="fw-bold text-primary">{{ $data['totalCustomers'] }}</h3>
                                    <p class="text-muted mb-0">Total Customers</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-wine-bottle fa-2x text-success mb-3"></i>
                                    <h3 class="fw-bold text-success">{{ $data['activeBottles'] }}</h3>
                                    <p class="text-muted mb-0">Active Bottles</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-truck fa-2x text-info mb-3"></i>
                                    <h3 class="fw-bold text-info">{{ $data['pendingDeliveries'] }}</h3>
                                    <p class="text-muted mb-0">Pending Deliveries</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-dollar-sign fa-2x text-warning mb-3"></i>
                                    <h3 class="fw-bold text-warning">${{ number_format($data['monthlyRevenue'], 2) }}</h3>
                                    <p class="text-muted mb-0">Monthly Revenue</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Secondary Stats -->
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-truck-moving fa-2x text-secondary mb-3"></i>
                                    <h3 class="fw-bold text-secondary">{{ $data['availableTrucks'] }}</h3>
                                    <p class="text-muted mb-0">Available Trucks</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-wine-bottle fa-2x text-danger mb-3"></i>
                                    <h3 class="fw-bold text-danger">{{ $data['emptyBottles'] }}</h3>
                                    <p class="text-muted mb-0">Empty Bottles</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-3"></i>
                                    <h3 class="fw-bold text-danger">{{ $data['damagedBottles'] }}</h3>
                                    <p class="text-muted mb-0">Damaged Bottles</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card border-0 bg-light h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-invoice-dollar fa-2x text-danger mb-3"></i>
                                    <h3 class="fw-bold text-danger">{{ $data['unpaidBills'] }}</h3>
                                    <p class="text-muted mb-0">Unpaid Bills</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
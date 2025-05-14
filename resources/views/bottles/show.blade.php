@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Bottle Details</h1>
            <div>
                <a href="{{ route('bottles.edit', $bottle) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('bottles.destroy', $bottle) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this bottle?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('bottles.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Back to Bottles
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Bottle Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Bottle Number:</div>
                    <div class="col-md-8">{{ $bottle->bottle_number }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Size:</div>
                    <div class="col-md-8">{{ ucfirst($bottle->size) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $bottle->status === 'filled' ? 'success' : ($bottle->status === 'empty' ? 'warning' : 'danger') }}">
                            {{ ucfirst($bottle->status) }}
                        </span>
                    </div>
                </div>
                @if($bottle->truck)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Current Location:</div>
                        <div class="col-md-8">
                            <a href="{{ route('trucks.show', $bottle->truck) }}">
                                Truck: {{ $bottle->truck->plate_number }}
                            </a>
                        </div>
                    </div>
                @endif
                @if($bottle->customer)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Assigned To:</div>
                        <div class="col-md-8">
                            <a href="{{ route('customers.show', $bottle->customer) }}">
                                Customer: {{ $bottle->customer->name }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Bottle History</h5>
            </div>
            <div class="card-body">
                @if($bottle->bills->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Bill Number</th>
                                    <th>Customer</th>
                                    <th>Staff</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bottle->bills->take(5) as $bill)
                                    <tr>
                                        <td>{{ $bill->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $bill->bill_number }}</td>
                                        <td>{{ $bill->customer->name }}</td>
                                        <td>{{ $bill->staff->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $bill->bottles_delivered > 0 ? 'success' : 'warning' }}">
                                                {{ $bill->bottles_delivered > 0 ? 'Delivered' : 'Collected' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No history found.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($bottle->status === 'filled')
                        <form action="{{ route('bottles.mark-empty', $bottle) }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-tint-slash"></i> Mark as Empty
                            </button>
                        </form>
                    @endif
                    @if($bottle->status === 'empty')
                        <form action="{{ route('bottles.mark-filled', $bottle) }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-tint"></i> Mark as Filled
                            </button>
                        </form>
                    @endif
                    @if($bottle->status !== 'damaged')
                        <form action="{{ route('bottles.mark-damaged', $bottle) }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-exclamation-triangle"></i> Mark as Damaged
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h6>Total Deliveries</h6>
                        <h3>{{ $bottle->bills->where('bottles_delivered', '>', 0)->count() }}</h3>
                    </div>
                    <div class="col-6 mb-3">
                        <h6>Total Collections</h6>
                        <h3>{{ $bottle->bills->where('empty_bottles_collected', '>', 0)->count() }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Last Delivery</h6>
                        <h3>{{ $bottle->last_filled ? $bottle->last_filled->format('Y-m-d') : 'Never' }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Last Collection</h6>
                        <h3>{{ $bottle->last_returned ? $bottle->last_returned->format('Y-m-d') : 'Never' }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
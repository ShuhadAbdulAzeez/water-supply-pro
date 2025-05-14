@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Staff Details</h1>
            <div>
                <a href="{{ route('staff.edit', $staff) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('staff.destroy', $staff) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this staff member?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('staff.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Back to Staff
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Staff Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Name:</div>
                    <div class="col-md-8">{{ $staff->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Email:</div>
                    <div class="col-md-8">{{ $staff->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Phone:</div>
                    <div class="col-md-8">{{ $staff->phone }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Role:</div>
                    <div class="col-md-8">{{ ucfirst($staff->role) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $staff->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($staff->status) }}
                        </span>
                    </div>
                </div>
                @if($staff->truck)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Assigned Truck:</div>
                        <div class="col-md-8">
                            <a href="{{ route('trucks.show', $staff->truck) }}">
                                {{ $staff->truck->plate_number }} ({{ $staff->truck->model }})
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Bills</h5>
            </div>
            <div class="card-body">
                @if($staff->bills->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bill Number</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staff->bills->take(5) as $bill)
                                    <tr>
                                        <td>{{ $bill->bill_number }}</td>
                                        <td>{{ $bill->customer->name }}</td>
                                        <td>${{ number_format($bill->amount, 2) }}</td>
                                        <td>{{ $bill->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <span class="badge bg-{{ $bill->payment_status === 'paid' ? 'success' : 'warning' }}">
                                                {{ ucfirst($bill->payment_status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No bills found.</p>
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
                    <a href="{{ route('bills.create', ['staff_id' => $staff->id]) }}" class="btn btn-primary">
                        <i class="fas fa-file-invoice"></i> Create Bill
                    </a>
                    @if(!$staff->truck)
                        <a href="{{ route('trucks.index') }}" class="btn btn-success">
                            <i class="fas fa-truck"></i> Assign Truck
                        </a>
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
                        <h6>Total Bills</h6>
                        <h3>{{ $staff->bills->count() }}</h3>
                    </div>
                    <div class="col-6 mb-3">
                        <h6>Total Amount</h6>
                        <h3>${{ number_format($staff->bills->sum('amount'), 2) }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Paid Bills</h6>
                        <h3>{{ $staff->bills->where('payment_status', 'paid')->count() }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Pending Bills</h6>
                        <h3>{{ $staff->bills->where('payment_status', 'pending')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Customer Details</h1>
            <div>
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this customer?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('customers.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Back to Customers
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Customer Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Name:</div>
                    <div class="col-md-8">{{ $customer->name }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Email:</div>
                    <div class="col-md-8">{{ $customer->email }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Phone:</div>
                    <div class="col-md-8">{{ $customer->phone }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Address:</div>
                    <div class="col-md-8">{{ $customer->address }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Type:</div>
                    <div class="col-md-8">{{ ucfirst($customer->type) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Credit Limit:</div>
                    <div class="col-md-8">${{ number_format($customer->credit_limit, 2) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $customer->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($customer->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Bills</h5>
            </div>
            <div class="card-body">
                @if($customer->bills->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Bill Number</th>
                                    <th>Staff</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customer->bills->take(5) as $bill)
                                    <tr>
                                        <td>{{ $bill->bill_number }}</td>
                                        <td>{{ $bill->staff->name }}</td>
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
                    <a href="{{ route('bills.create', ['customer_id' => $customer->id]) }}" class="btn btn-primary">
                        <i class="fas fa-file-invoice"></i> Create Bill
                    </a>
                    <a href="{{ route('bottles.index', ['customer_id' => $customer->id]) }}" class="btn btn-success">
                        <i class="fas fa-wine-bottle"></i> View Bottles
                    </a>
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
                        <h3>{{ $customer->bills->count() }}</h3>
                    </div>
                    <div class="col-6 mb-3">
                        <h6>Total Amount</h6>
                        <h3>${{ number_format($customer->bills->sum('amount'), 2) }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Paid Bills</h6>
                        <h3>{{ $customer->bills->where('payment_status', 'paid')->count() }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Pending Bills</h6>
                        <h3>{{ $customer->bills->where('payment_status', 'pending')->count() }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
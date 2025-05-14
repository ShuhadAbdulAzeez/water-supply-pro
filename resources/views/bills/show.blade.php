@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Bill Details</h1>
            <div>
                <a href="{{ route('bills.print', $bill) }}" class="btn btn-primary" target="_blank">
                    <i class="fas fa-print"></i> Print Bill
                </a>
                <a href="{{ route('bills.edit', $bill) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('bills.destroy', $bill) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this bill?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('bills.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Bills
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Bill Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Customer Information</h6>
                        <p>
                            <strong>Name:</strong> {{ $bill->customer->name }}<br>
                            <strong>Phone:</strong> {{ $bill->customer->phone }}<br>
                            <strong>Email:</strong> {{ $bill->customer->email }}<br>
                            <strong>Address:</strong> {{ $bill->customer->address }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Bill Details</h6>
                        <p>
                            <strong>Bill Number:</strong> {{ $bill->bill_number }}<br>
                            <strong>Date:</strong> {{ $bill->created_at->format('Y-m-d') }}<br>
                            <strong>Payment Status:</strong> 
                            <span class="badge bg-{{ $bill->payment_status === 'paid' ? 'success' : ($bill->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($bill->payment_status) }}
                            </span><br>
                            <strong>Payment Method:</strong> {{ ucfirst($bill->payment_method) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Delivery Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Staff Information</h6>
                        <p>
                            <strong>Name:</strong> {{ $bill->staff->name }}<br>
                            <strong>Role:</strong> {{ $bill->staff->role }}<br>
                            <strong>Phone:</strong> {{ $bill->staff->phone }}
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6>Truck Information</h6>
                        <p>
                            <strong>Plate Number:</strong> {{ $bill->truck->plate_number }}<br>
                            <strong>Model:</strong> {{ $bill->truck->model }}<br>
                            <strong>Capacity:</strong> {{ $bill->truck->capacity }} bottles
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Billing Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Water Bottles Delivered</td>
                                <td>{{ $bill->bottles_delivered }}</td>
                                <td>AED {{ number_format($bill->amount / $bill->bottles_delivered, 2) }}</td>
                                <td>AED {{ number_format($bill->amount, 2) }}</td>
                            </tr>
                            @if($bill->empty_bottles_collected > 0)
                            <tr>
                                <td>Empty Bottles Collected</td>
                                <td>{{ $bill->empty_bottles_collected }}</td>
                                <td>AED 0.00</td>
                                <td>AED 0.00</td>
                            </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total Amount:</th>
                                <th>AED {{ number_format($bill->amount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                @if($bill->notes)
                <div class="mt-4">
                    <h6>Notes</h6>
                    <p class="mb-0">{{ $bill->notes }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('bills.print', $bill) }}" class="btn btn-primary" target="_blank">
                        <i class="fas fa-print"></i> Print Bill
                    </a>
                    <a href="{{ route('bills.edit', $bill) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Bill
                    </a>
                    @if($bill->payment_status === 'pending')
                    <form action="{{ route('bills.update', $bill) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="customer_id" value="{{ $bill->customer_id }}">
                        <input type="hidden" name="staff_id" value="{{ $bill->staff_id }}">
                        <input type="hidden" name="truck_id" value="{{ $bill->truck_id }}">
                        <input type="hidden" name="bottles_delivered" value="{{ $bill->bottles_delivered }}">
                        <input type="hidden" name="empty_bottles_collected" value="{{ $bill->empty_bottles_collected }}">
                        <input type="hidden" name="amount" value="{{ $bill->amount }}">
                        <input type="hidden" name="payment_method" value="{{ $bill->payment_method }}">
                        <input type="hidden" name="payment_status" value="paid">
                        <input type="hidden" name="notes" value="{{ $bill->notes }}">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Mark as Paid
                        </button>
                    </form>
                    @endif
                    <a href="{{ route('customers.show', $bill->customer) }}" class="btn btn-info">
                        <i class="fas fa-user"></i> View Customer
                    </a>
                    <a href="{{ route('trucks.show', $bill->truck) }}" class="btn btn-info">
                        <i class="fas fa-truck"></i> View Truck
                    </a>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Information</h5>
            </div>
            <div class="card-body">
                <p>
                    <strong>Payment Method:</strong> {{ ucfirst($bill->payment_method) }}<br>
                    <strong>Payment Status:</strong> 
                    <span class="badge bg-{{ $bill->payment_status === 'paid' ? 'success' : ($bill->payment_status === 'pending' ? 'warning' : 'danger') }}">
                        {{ ucfirst($bill->payment_status) }}
                    </span><br>
                    @if($bill->payment_status === 'pending')
                        <strong>Due Date:</strong> {{ $bill->created_at->addDays(30)->format('Y-m-d') }}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>
@endsection 
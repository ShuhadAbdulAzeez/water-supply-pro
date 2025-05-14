@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Edit Bill</h1>
            <a href="{{ route('bills.show', $bill) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Bill Details
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('bills.update', $bill->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="customer_id" class="form-label">Customer</label>
                            <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                <option value="">Select Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ old('customer_id', $bill->customer_id) == $customer->id ? 'selected' : '' }}>
                                        {{ $customer->name }} ({{ $customer->phone }})
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="staff_id" class="form-label">Staff Member</label>
                            <select name="staff_id" id="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required>
                                <option value="">Select Staff</option>
                                @foreach($staff as $member)
                                    <option value="{{ $member->id }}" {{ old('staff_id', $bill->staff_id) == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} ({{ $member->role }})
                                    </option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="truck_id" class="form-label">Truck</label>
                            <select name="truck_id" id="truck_id" class="form-select @error('truck_id') is-invalid @enderror" required>
                                <option value="">Select Truck</option>
                                @foreach($trucks as $truck)
                                    <option value="{{ $truck->id }}" {{ old('truck_id', $bill->truck_id) == $truck->id ? 'selected' : '' }}>
                                        {{ $truck->plate_number }} ({{ $truck->model }})
                                    </option>
                                @endforeach
                            </select>
                            @error('truck_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="">Select Payment Method</option>
                                <option value="cash" {{ old('payment_method', $bill->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="card" {{ old('payment_method', $bill->payment_method) == 'card' ? 'selected' : '' }}>Card</option>
                                <option value="credit" {{ old('payment_method', $bill->payment_method) == 'credit' ? 'selected' : '' }}>Credit</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bottles_delivered" class="form-label">Bottles Delivered</label>
                            <input type="number" name="bottles_delivered" id="bottles_delivered" class="form-control @error('bottles_delivered') is-invalid @enderror" value="{{ old('bottles_delivered', $bill->bottles_delivered) }}" required min="1">
                            @error('bottles_delivered')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="empty_bottles_collected" class="form-label">Empty Bottles Collected</label>
                            <input type="number" name="empty_bottles_collected" id="empty_bottles_collected" class="form-control @error('empty_bottles_collected') is-invalid @enderror" value="{{ old('empty_bottles_collected', $bill->empty_bottles_collected) }}" required min="0">
                            @error('empty_bottles_collected')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="amount" class="form-label">Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">AED</span>
                                <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount', $bill->amount) }}" required min="0" step="0.01">
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="payment_status" class="form-label">Payment Status</label>
                            <select name="payment_status" id="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                                <option value="">Select Payment Status</option>
                                <option value="pending" {{ old('payment_status', $bill->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('payment_status', $bill->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ old('payment_status', $bill->payment_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" rows="3">{{ old('notes', $bill->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Update Bill</button>
                        <a href="{{ route('bills.show', $bill) }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Quick Tips</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-primary"></i>
                        Make sure to verify all changes before updating the bill.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-primary"></i>
                        Updating bottle counts will affect inventory records.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-primary"></i>
                        Changing payment status may affect customer credit.
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-info-circle text-primary"></i>
                        Print the updated bill after making changes.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bottlesDelivered = document.getElementById('bottles_delivered');
        const amount = document.getElementById('amount');
        const pricePerBottle = 5; // Price per bottle in AED

        bottlesDelivered.addEventListener('input', function() {
            const bottles = parseInt(this.value) || 0;
            amount.value = (bottles * pricePerBottle).toFixed(2);
        });
    });
</script>
@endpush
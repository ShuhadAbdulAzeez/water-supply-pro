@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Bills</h1>
            <a href="{{ route('bills.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create New Bill
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Bill Number</th>
                                <th>Customer</th>
                                <th>Staff</th>
                                <th>Amount</th>
                                <th>Payment Method</th>
                                <th>Payment Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bills as $bill)
                                <tr>
                                    <td>{{ $bill->bill_number }}</td>
                                    <td>{{ $bill->customer->name }}</td>
                                    <td>{{ $bill->staff->name }}</td>
                                    <td>{{ \App\Helpers\CurrencyHelper::format($bill->amount) }}</td>
                                    <td>{{ ucfirst($bill->payment_method) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $bill->payment_status === 'paid' ? 'success' : ($bill->payment_status === 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($bill->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $bill->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('bills.show', $bill) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('bills.print', $bill) }}" class="btn btn-sm btn-secondary" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No bills found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $bills->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
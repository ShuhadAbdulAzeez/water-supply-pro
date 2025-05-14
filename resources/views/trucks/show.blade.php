@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Truck Details</h1>
            <div>
                <a href="{{ route('trucks.edit', $truck) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('trucks.destroy', $truck) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this truck?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('trucks.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Back to Trucks
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Truck Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Plate Number:</div>
                    <div class="col-md-8">{{ $truck->plate_number }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Model:</div>
                    <div class="col-md-8">{{ $truck->model }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Capacity:</div>
                    <div class="col-md-8">{{ $truck->capacity }} bottles</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Status:</div>
                    <div class="col-md-8">
                        <span class="badge bg-{{ $truck->status === 'active' ? 'success' : ($truck->status === 'maintenance' ? 'warning' : 'danger') }}">
                            {{ ucfirst($truck->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Assigned Staff</h5>
            </div>
            <div class="card-body">
                @if($truck->staff->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Role</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($truck->staff as $staff)
                                    <tr>
                                        <td>{{ $staff->name }}</td>
                                        <td>{{ ucfirst($staff->role) }}</td>
                                        <td>{{ $staff->phone }}</td>
                                        <td>
                                            <span class="badge bg-{{ $staff->status === 'active' ? 'success' : 'danger' }}">
                                                {{ ucfirst($staff->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No staff assigned to this truck.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Inventory Records</h5>
            </div>
            <div class="card-body">
                @if($truck->inventory->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Filled</th>
                                    <th>Empty</th>
                                    <th>Damaged</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($truck->inventory->take(5) as $inventory)
                                    <tr>
                                        <td>{{ $inventory->inventory_date }}</td>
                                        <td>{{ $inventory->filled_bottles_count }}</td>
                                        <td>{{ $inventory->empty_bottles_count }}</td>
                                        <td>{{ $inventory->damaged_bottles_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No inventory records found.</p>
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
                    <a href="{{ route('inventory.create', ['truck_id' => $truck->id]) }}" class="btn btn-primary">
                        <i class="fas fa-clipboard-check"></i> Take Inventory
                    </a>
                    <a href="{{ route('staff.create', ['truck_id' => $truck->id]) }}" class="btn btn-success">
                        <i class="fas fa-user-plus"></i> Assign Staff
                    </a>
                    <a href="{{ route('bills.create', ['truck_id' => $truck->id]) }}" class="btn btn-info">
                        <i class="fas fa-file-invoice"></i> Create Bill
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
                        <h6>Total Staff</h6>
                        <h3>{{ $truck->staff->count() }}</h3>
                    </div>
                    <div class="col-6 mb-3">
                        <h6>Total Bills</h6>
                        <h3>{{ $truck->bills->count() }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Total Inventory</h6>
                        <h3>{{ $truck->inventory->count() }}</h3>
                    </div>
                    <div class="col-6">
                        <h6>Utilization</h6>
                        <h3>{{ number_format(($truck->bills->count() / 30) * 100, 1) }}%</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Inventory</h1>
            <div>
                <a href="{{ route('inventory.create') }}" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Add Inventory Record
                </a>
                <a href="{{ route('inventory.daily-report') }}" class="btn btn-info">
                    <i class="fas fa-chart-bar"></i> Daily Report
                </a>
            </div>
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
                                <th>Truck</th>
                                <th>Filled Bottles</th>
                                <th>Empty Bottles</th>
                                <th>Damaged Bottles</th>
                                <th>Total Bottles</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->truck->plate_number }}</td>
                                    <td>{{ $inventory->filled_bottles_count }}</td>
                                    <td>{{ $inventory->empty_bottles_count }}</td>
                                    <td>{{ $inventory->damaged_bottles_count }}</td>
                                    <td>{{ $inventory->filled_bottles_count + $inventory->empty_bottles_count + $inventory->damaged_bottles_count }}</td>
                                    <td>{{ $inventory->inventory_date->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('inventory.show', $inventory) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No inventory records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $inventories->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
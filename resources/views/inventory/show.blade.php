@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Inventory Details</h1>
            <div>
                <a href="{{ route('inventory.edit', $inventory) }}" class="btn btn-primary me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('inventory.destroy', $inventory) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this inventory record?')">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary ms-2">
                    <i class="fas fa-arrow-left"></i> Back to Inventory
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Inventory Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Truck:</div>
                    <div class="col-md-8">
                        <a href="{{ route('trucks.show', $inventory->truck) }}">
                            {{ $inventory->truck->plate_number }} ({{ $inventory->truck->model }})
                        </a>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Date:</div>
                    <div class="col-md-8">{{ $inventory->inventory_date->format('Y-m-d') }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Filled Bottles:</div>
                    <div class="col-md-8">{{ $inventory->filled_bottles_count }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Empty Bottles:</div>
                    <div class="col-md-8">{{ $inventory->empty_bottles_count }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Damaged Bottles:</div>
                    <div class="col-md-8">{{ $inventory->damaged_bottles_count }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 fw-bold">Total Bottles:</div>
                    <div class="col-md-8">
                        {{ $inventory->filled_bottles_count + $inventory->empty_bottles_count + $inventory->damaged_bottles_count }}
                    </div>
                </div>
                @if($inventory->notes)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Notes:</div>
                        <div class="col-md-8">{{ $inventory->notes }}</div>
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
                    <a href="{{ route('trucks.show', $inventory->truck) }}" class="btn btn-info">
                        <i class="fas fa-truck"></i> View Truck Details
                    </a>
                    <a href="{{ route('inventory.edit', $inventory) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Inventory
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
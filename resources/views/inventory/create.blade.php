@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Add New Inventory Record</h1>
            <a href="{{ route('inventory.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Inventory
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('inventory.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="truck_id">Select Truck</label>
                        <select name="truck_id" id="truck_id" class="form-control @error('truck_id') is-invalid @enderror">
                            <option value="">Select a truck...</option>
                            @foreach($trucks as $truck)
                                <option value="{{ $truck->id }}" {{ old('truck_id') == $truck->id ? 'selected' : '' }}>
                                    {{ $truck->plate_number }} - {{ $truck->model }}
                                </option>
                            @endforeach
                        </select>
                        @error('truck_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="filled_bottles_count" class="form-label">Filled Bottles Count</label>
                        <input type="number" class="form-control @error('filled_bottles_count') is-invalid @enderror" 
                               id="filled_bottles_count" name="filled_bottles_count" 
                               value="{{ old('filled_bottles_count') }}" required min="0">
                        @error('filled_bottles_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="empty_bottles_count" class="form-label">Empty Bottles Count</label>
                        <input type="number" class="form-control @error('empty_bottles_count') is-invalid @enderror" 
                               id="empty_bottles_count" name="empty_bottles_count" 
                               value="{{ old('empty_bottles_count') }}" required min="0">
                        @error('empty_bottles_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="damaged_bottles_count" class="form-label">Damaged Bottles Count</label>
                        <input type="number" class="form-control @error('damaged_bottles_count') is-invalid @enderror" 
                               id="damaged_bottles_count" name="damaged_bottles_count" 
                               value="{{ old('damaged_bottles_count') }}" required min="0">
                        @error('damaged_bottles_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inventory_date" class="form-label">Inventory Date</label>
                        <input type="date" class="form-control @error('inventory_date') is-invalid @enderror" 
                               id="inventory_date" name="inventory_date" 
                               value="{{ old('inventory_date', date('Y-m-d')) }}" required>
                        @error('inventory_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Inventory Record
                        </button>
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
                    <li><i class="fas fa-info-circle text-info"></i> Select the truck for inventory</li>
                    <li><i class="fas fa-info-circle text-info"></i> Count filled bottles carefully</li>
                    <li><i class="fas fa-info-circle text-info"></i> Count empty bottles carefully</li>
                    <li><i class="fas fa-info-circle text-info"></i> Record any damaged bottles</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
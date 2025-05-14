@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Edit Inventory Record</h1>
            <a href="{{ route('inventory.show', $inventory) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Inventory Details
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('inventory.update', $inventory) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="truck_id" class="form-label">Truck</label>
                        <select class="form-select @error('truck_id') is-invalid @enderror" 
                                id="truck_id" name="truck_id" required>
                            <option value="">Select Truck</option>
                            @foreach($trucks as $truck)
                                <option value="{{ $truck->id }}" {{ old('truck_id', $inventory->truck_id) == $truck->id ? 'selected' : '' }}>
                                    {{ $truck->plate_number }} ({{ $truck->model }})
                                </option>
                            @endforeach
                        </select>
                        @error('truck_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="inventory_date" class="form-label">Date</label>
                        <input type="date" class="form-control @error('inventory_date') is-invalid @enderror" 
                               id="inventory_date" name="inventory_date" 
                               value="{{ old('inventory_date', $inventory->inventory_date->format('Y-m-d')) }}" required>
                        @error('inventory_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="filled_bottles_count" class="form-label">Filled Bottles</label>
                        <input type="number" class="form-control @error('filled_bottles_count') is-invalid @enderror" 
                               id="filled_bottles_count" name="filled_bottles_count" 
                               value="{{ old('filled_bottles_count', $inventory->filled_bottles_count) }}" 
                               min="0" required>
                        @error('filled_bottles_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="empty_bottles_count" class="form-label">Empty Bottles</label>
                        <input type="number" class="form-control @error('empty_bottles_count') is-invalid @enderror" 
                               id="empty_bottles_count" name="empty_bottles_count" 
                               value="{{ old('empty_bottles_count', $inventory->empty_bottles_count) }}" 
                               min="0" required>
                        @error('empty_bottles_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="damaged_bottles_count" class="form-label">Damaged Bottles</label>
                        <input type="number" class="form-control @error('damaged_bottles_count') is-invalid @enderror" 
                               id="damaged_bottles_count" name="damaged_bottles_count" 
                               value="{{ old('damaged_bottles_count', $inventory->damaged_bottles_count) }}" 
                               min="0" required>
                        @error('damaged_bottles_count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                  id="notes" name="notes" rows="3">{{ old('notes', $inventory->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Inventory
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
                    <li><i class="fas fa-info-circle text-info"></i> Update bottle counts accurately</li>
                    <li><i class="fas fa-info-circle text-info"></i> Verify the inventory date</li>
                    <li><i class="fas fa-info-circle text-info"></i> Add any relevant notes</li>
                    <li><i class="fas fa-info-circle text-info"></i> Ensure truck assignment is correct</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 
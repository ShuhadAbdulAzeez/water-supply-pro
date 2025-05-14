@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Edit Bottle</h1>
            <a href="{{ route('bottles.show', $bottle) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Bottle Details
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('bottles.update', $bottle) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="bottle_number" class="form-label">Bottle Number</label>
                        <input type="text" class="form-control @error('bottle_number') is-invalid @enderror" 
                               id="bottle_number" name="bottle_number" 
                               value="{{ old('bottle_number', $bottle->bottle_number) }}" required>
                        @error('bottle_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <select class="form-select @error('size') is-invalid @enderror" 
                                id="size" name="size" required>
                            <option value="">Select Size</option>
                            <option value="small" {{ old('size', $bottle->size) == 'small' ? 'selected' : '' }}>Small</option>
                            <option value="medium" {{ old('size', $bottle->size) == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="large" {{ old('size', $bottle->size) == 'large' ? 'selected' : '' }}>Large</option>
                        </select>
                        @error('size')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="filled" {{ old('status', $bottle->status) == 'filled' ? 'selected' : '' }}>Filled</option>
                            <option value="empty" {{ old('status', $bottle->status) == 'empty' ? 'selected' : '' }}>Empty</option>
                            <option value="damaged" {{ old('status', $bottle->status) == 'damaged' ? 'selected' : '' }}>Damaged</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="truck_id" class="form-label">Current Location (Truck)</label>
                        <select class="form-select @error('truck_id') is-invalid @enderror" 
                                id="truck_id" name="truck_id">
                            <option value="">Select Truck</option>
                            @foreach($trucks as $truck)
                                <option value="{{ $truck->id }}" {{ old('truck_id', $bottle->truck_id) == $truck->id ? 'selected' : '' }}>
                                    {{ $truck->plate_number }} ({{ $truck->model }})
                                </option>
                            @endforeach
                        </select>
                        @error('truck_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="customer_id" class="form-label">Assigned Customer</label>
                        <select class="form-select @error('customer_id') is-invalid @enderror" 
                                id="customer_id" name="customer_id">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ old('customer_id', $bottle->customer_id) == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Bottle
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
                    <li><i class="fas fa-info-circle text-info"></i> Update bottle number if changed</li>
                    <li><i class="fas fa-info-circle text-info"></i> Change size if needed</li>
                    <li><i class="fas fa-info-circle text-info"></i> Update status based on current condition</li>
                    <li><i class="fas fa-info-circle text-info"></i> Assign to truck or customer if needed</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 
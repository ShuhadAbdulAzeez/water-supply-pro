@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Add New Bottle</h1>
            <a href="{{ route('bottles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Bottles
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('bottles.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="bottle_number" class="form-label">Bottle Number</label>
                        <input type="text" class="form-control @error('bottle_number') is-invalid @enderror" 
                               id="bottle_number" name="bottle_number" value="{{ old('bottle_number') }}" required>
                        @error('bottle_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="size" class="form-label">Size</label>
                        <select class="form-select @error('size') is-invalid @enderror" 
                                id="size" name="size" required>
                            <option value="">Select Size</option>
                            <option value="small" {{ old('size') == 'small' ? 'selected' : '' }}>Small</option>
                            <option value="medium" {{ old('size') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="large" {{ old('size') == 'large' ? 'selected' : '' }}>Large</option>
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
                            <option value="filled" {{ old('status') == 'filled' ? 'selected' : '' }}>Filled</option>
                            <option value="empty" {{ old('status') == 'empty' ? 'selected' : '' }}>Empty</option>
                            <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Create Bottle
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
                    <li><i class="fas fa-info-circle text-info"></i> Enter a unique bottle number</li>
                    <li><i class="fas fa-info-circle text-info"></i> Select the appropriate size</li>
                    <li><i class="fas fa-info-circle text-info"></i> Set initial status</li>
                    <li><i class="fas fa-info-circle text-info"></i> Truck and customer assignment can be done later</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 
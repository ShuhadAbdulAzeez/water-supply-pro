@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Edit Staff Member</h1>
            <a href="{{ route('staff.show', $staff) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Staff Details
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('staff.update', $staff) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" 
                               value="{{ old('name', $staff->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" 
                               value="{{ old('email', $staff->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" 
                               value="{{ old('phone', $staff->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">New Password (leave blank to keep current)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" name="role" required>
                            <option value="">Select Role</option>
                            <option value="driver" {{ old('role', $staff->role) == 'driver' ? 'selected' : '' }}>Driver</option>
                            <option value="helper" {{ old('role', $staff->role) == 'helper' ? 'selected' : '' }}>Helper</option>
                            <option value="manager" {{ old('role', $staff->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="truck_id" class="form-label">Assigned Truck</label>
                        <select class="form-select @error('truck_id') is-invalid @enderror" 
                                id="truck_id" name="truck_id">
                            <option value="">Select Truck</option>
                            @foreach($trucks as $truck)
                                <option value="{{ $truck->id }}" {{ old('truck_id', $staff->truck_id) == $truck->id ? 'selected' : '' }}>
                                    {{ $truck->plate_number }} ({{ $truck->model }})
                                </option>
                            @endforeach
                        </select>
                        @error('truck_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="active" {{ old('status', $staff->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $staff->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Staff Member
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
                    <li><i class="fas fa-info-circle text-info"></i> Update contact information if changed</li>
                    <li><i class="fas fa-info-circle text-info"></i> Change password only if needed</li>
                    <li><i class="fas fa-info-circle text-info"></i> Update role if responsibilities change</li>
                    <li><i class="fas fa-info-circle text-info"></i> Assign to a different truck if needed</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 
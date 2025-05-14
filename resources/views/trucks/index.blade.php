@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12 mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Trucks</h1>
            <a href="{{ route('trucks.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Truck
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
                                <th>Plate Number</th>
                                <th>Model</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($trucks as $truck)
                                <tr>
                                    <td>{{ $truck->plate_number }}</td>
                                    <td>{{ $truck->model }}</td>
                                    <td>{{ $truck->capacity }}</td>
                                    <td>
                                        <span class="badge bg-{{ $truck->status === 'active' ? 'success' : ($truck->status === 'maintenance' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($truck->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('trucks.show', $truck) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('trucks.edit', $truck) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('trucks.destroy', $truck) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No trucks found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $trucks->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
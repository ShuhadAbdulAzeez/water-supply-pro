@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Bottles</h1>
    <a href="{{ route('bottles.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Add New Bottle
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Bottle Number</th>
                <th>Size</th>
                <th>Status</th>
                <th>Location</th>
                <th>Last Filled</th>
                <th>Last Returned</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bottles as $bottle)
                <tr>
                    <td>{{ $bottle->bottle_number }}</td>
                    <td>{{ ucfirst($bottle->size) }}</td>
                    <td>
                        <span class="badge bg-{{ $bottle->status === 'filled' ? 'success' : ($bottle->status === 'empty' ? 'warning' : 'danger') }}">
                            {{ ucfirst($bottle->status) }}
                        </span>
                    </td>
                    <td>
                        @if($bottle->truck)
                            Truck: {{ $bottle->truck->plate_number }}
                        @elseif($bottle->customer)
                            Customer: {{ $bottle->customer->name }}
                        @else
                            Not Assigned
                        @endif
                    </td>
                    <td>{{ $bottle->last_filled_date ? $bottle->last_filled_date->format('Y-m-d') : 'Never' }}</td>
                    <td>{{ $bottle->last_returned_date ? $bottle->last_returned_date->format('Y-m-d') : 'Never' }}</td>
                    <td>
                        <a href="{{ route('bottles.show', $bottle) }}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        @if($bottle->status !== 'damaged')
                            <form action="{{ route('bottles.mark-damaged', $bottle) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Mark this bottle as damaged?')">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No bottles found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $bottles->links() }}
</div>
@endsection
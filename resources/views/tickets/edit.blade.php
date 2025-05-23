@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Edit Ticket</h2>
    </div>
    <div class="card-body">
        <form action="{{ route('tickets.update', $ticket) }}" method="POST">
            @csrf
            @method('PUT')
            
            @if(auth()->user()->isAdmin())
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assign To</label>
                    <select class="form-select" id="assigned_to" name="assigned_to">
                        <option value="">Unassigned</option>
                        @foreach($staff as $user)
                            <option value="{{ $user->id }}" {{ $ticket->assigned_to === $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ ucfirst($user->role) }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif
            
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ $ticket->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection

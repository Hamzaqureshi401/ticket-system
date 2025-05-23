@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Ticket Details</h2>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <h4>{{ $ticket->title }}</h4>
        </div>
        <div class="mb-3">
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $ticket->status === 'resolved' ? 'success' : ($ticket->status === 'in_progress' ? 'warning' : 'danger') }}">
                    {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                </span>
            </p>
            <p><strong>Priority:</strong> {{ ucfirst($ticket->priority) }}</p>
            <p><strong>Category:</strong> {{ $ticket->category }}</p>
            <p><strong>Created By:</strong> {{ $ticket->user->name }}</p>
            <p><strong>Assigned To:</strong> {{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Unassigned' }}</p>
            <p><strong>Created At:</strong> {{ $ticket->created_at->format('M d, Y H:i') }}</p>
        </div>
        <div class="mb-3">
            <h5>Description</h5>
            <p>{{ $ticket->description }}</p>
        </div>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back</a>
        @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && $ticket->assigned_to === auth()->id()))
            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-primary">Edit</a>
        @endif
    </div>
</div>
@endsection
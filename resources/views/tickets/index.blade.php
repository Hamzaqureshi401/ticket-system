@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Tickets</h2>
        @if(auth()->user()->isUser())
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">Create Ticket</a>
        @endif
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Category</th>
                    <th>Created By</th>
                    <th>Assigned To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->title }}</td>
                    <td>
                        <span class="badge bg-{{ $ticket->status === 'resolved' ? 'success' : ($ticket->status === 'in_progress' ? 'warning' : 'danger') }}">
                            {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                        </span>
                    </td>
                    <td>{{ ucfirst($ticket->priority) }}</td>
                    <td>{{ $ticket->category }}</td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ $ticket->assignedTo ? $ticket->assignedTo->name : 'Unassigned' }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-info">View</a>
                        @if(auth()->user()->isAdmin() || (auth()->user()->isStaff() && $ticket->assigned_to === auth()->id()))
                            <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-primary">Edit</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
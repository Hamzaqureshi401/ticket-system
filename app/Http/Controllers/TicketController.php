<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\TicketAssigned;
use Illuminate\Support\Facades\Notification;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $tickets = Ticket::with(['user', 'assignedTo'])->get();
        } elseif ($user->isStaff()) {
            $tickets = Ticket::where('assigned_to', $user->id)
                ->with(['user', 'assignedTo'])
                ->get();
        } else {
            $tickets = Ticket::where('user_id', $user->id)
                ->with(['user', 'assignedTo'])
                ->get();
        }

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        if (!auth()->user()->isUser()) {
            return redirect()->route('tickets.index');
        }

        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'category' => 'required|string|max:255',
        ]);

        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'category' => $request->category,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('tickets.show', $ticket);
    }

    public function show(Ticket $ticket)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && 
            !($user->isStaff() && $ticket->assigned_to === $user->id) && 
            $ticket->user_id !== $user->id) {
            return redirect()->route('tickets.index');
        }

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $user = auth()->user();

        if (!$user->isAdmin() && !($user->isStaff() && $ticket->assigned_to === $user->id)) {
            return redirect()->route('tickets.index');
        }

        $staff = User::whereIn('role', ['admin', 'staff'])->get();

        return view('tickets.edit', compact('ticket', 'staff'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $request->validate([
                'assigned_to' => 'sometimes|exists:users,id',
                'status' => 'sometimes|in:open,in_progress,resolved',
            ]);

            if ($request->has('assigned_to') && $ticket->assigned_to !== $request->assigned_to) {
                $ticket->update(['assigned_to' => $request->assigned_to]);
                
                $staff = User::find($request->assigned_to);
                Notification::send($staff, new TicketAssigned($ticket));
            }

            if ($request->has('status')) {
                $ticket->update(['status' => $request->status]);
            }
        } elseif ($user->isStaff() && $ticket->assigned_to === $user->id) {
            $request->validate([
                'status' => 'required|in:open,in_progress,resolved',
            ]);

            $ticket->update(['status' => $request->status]);
        } else {
            return redirect()->route('tickets.index');
        }

        return redirect()->route('tickets.show', $ticket);
    }
}
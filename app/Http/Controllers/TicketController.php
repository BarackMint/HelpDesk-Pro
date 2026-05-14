<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Category;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function __construct(protected TicketService $ticketService)
    {
    }

    public function index(Request $request)
    {
        $filters = $request->only(['status', 'priority', 'category_id', 'search']);
        $tickets = $this->ticketService->getTicketsForUser($filters);
        $categories = Category::all();

        return view('tickets.index', compact('tickets', 'categories', 'filters'));
    }

    public function create()
    {
        $categories = Category::all();

        return view('tickets.create', compact('categories'));
    }

    public function store(StoreTicketRequest $request)
    {
        $this->ticketService->createTicket($request->validated());

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $ticket->load(['category', 'creator', 'assignee', 'replies.author']);
        $agents = $this->ticketService->getAgents();

        return view('tickets.show', compact('ticket', 'agents'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $categories = Category::all();
        $agents = $this->ticketService->getAgents();

        return view('tickets.edit', compact('ticket', 'categories', 'agents'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->authorizeTicketAccess($ticket);

        $data = $request->validated();

        // Only admin/agent can update status and assignment
        if (auth()->user()->isEmployee()) {
            unset($data['status'], $data['assigned_to']);
        }

        $this->ticketService->updateTicket($ticket, $data);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully.');
    }

    // --- Private Helpers ---
    private function authorizeTicketAccess(Ticket $ticket): void
    {
        $user = auth()->user();

        if ($user->isEmployee() && $ticket->created_by !== $user->id) {
            abort(403, 'Unauthorized');
        }

        if ($user->isAgent() && $ticket->assigned_to !== $user->id) {
            abort(403, 'Unauthorized');
        }
    }
}
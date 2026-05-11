<?php

namespace App\Services;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class TicketService
{
    public function getTicketsForUser(array $filters = []): LengthAwarePaginator
    {
        $user = Auth::user();

        $query = Ticket::query()
            ->with(['category', 'creator', 'assignee']);

        // Scope by role
        if ($user->isEmployee()) {
            $query->where('created_by', $user->id);
        } elseif ($user->isAgent()) {
            $query->where('assigned_to', $user->id);
        }
        // Admin sees all — no scope applied

        // Filters
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // Search
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate(10);
    }

    public function createTicket(array $data): Ticket
    {
        return Ticket::create([
            'title'       => $data['title'],
            'description' => $data['description'],
            'priority'    => $data['priority'],
            'category_id' => $data['category_id'] ?? null,
            'created_by'  => Auth::id(),
            'status'      => 'open',
        ]);
    }

    public function updateTicket(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);
        return $ticket->fresh();
    }

    public function assignTicket(Ticket $ticket, int $agentId): Ticket
    {
        $ticket->update([
            'assigned_to' => $agentId,
            'status'      => 'in_progress',
        ]);

        return $ticket->fresh();
    }

    public function getAgents(): \Illuminate\Database\Eloquent\Collection
    {
        return User::where('role', 'agent')->get();
    }
}
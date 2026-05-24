<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReplyRequest;
use App\Models\Ticket;
use App\Models\TicketReply;

class TicketReplyController extends Controller
{
    public function store(StoreReplyRequest $request, Ticket $ticket)
    {
        // Block replies on closed tickets
        if ($ticket->isClosed()) {
            abort(403, 'Cannot reply to a closed ticket.');
        }

        // Create the reply
        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'body'      => $request->validated()['body'],
        ]);

        // Agent/Admin can update status when replying
        if (
            $request->filled('status') &&
            (auth()->user()->isAgent() || auth()->user()->isAdmin())
        ) {
            $ticket->update(['status' => $request->validated()['status']]);
        }

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Reply posted successfully.');
    }
}
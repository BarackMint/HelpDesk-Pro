<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Http\Request;

class TicketReplyController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        if ($ticket->isClosed()) {
            abort(403, 'Cannot reply to a closed ticket.');
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'min:3'],
        ]);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id(),
            'body'      => $validated['body'],
        ]);

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Reply posted successfully.');
    }
}
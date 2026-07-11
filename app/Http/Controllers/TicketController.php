<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Show the ticket thread to the visitor.
     */
    public function show($ticket_id)
    {
        $message = ContactMessage::with('replies')->where('ticket_id', $ticket_id)->firstOrFail();
        
        return view('portfolio.ticket', compact('message'));
    }

    /**
     * Handle visitor replying back to the ticket.
     */
    public function reply(Request $request, $ticket_id)
    {
        $message = ContactMessage::where('ticket_id', $ticket_id)->firstOrFail();

        $request->validate([
            'reply_body' => 'required|string',
        ]);

        $message->replies()->create([
            'sender_type' => 'visitor',
            'body' => $request->reply_body,
        ]);

        // Automatically mark the message as unread for the admin
        $message->update(['is_read' => false]);

        return back()->with('success', 'Balasan Anda berhasil terkirim!');
    }
}

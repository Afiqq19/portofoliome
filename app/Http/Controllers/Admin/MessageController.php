<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;

class MessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(20);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        $message->update(['is_read' => true]);
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Pesan berhasil dihapus!');
    }

    public function reply(\Illuminate\Http\Request $request, ContactMessage $message)
    {
        $request->validate([
            'reply_body' => 'required|string',
        ]);

        // Generate ticket_id for older messages that don't have one
        if (empty($message->ticket_id)) {
            $message->update(['ticket_id' => (string) \Illuminate\Support\Str::uuid()]);
        }

        // Simpan riwayat balasan ke database
        $message->replies()->create([
            'sender_type' => 'admin',
            'body' => $request->reply_body,
        ]);

        try {
            \Illuminate\Support\Facades\Mail::to($message->email)
                ->send(new \App\Mail\ReplyMessageMail($message, $request->reply_body));
            
            return back()->with('success', 'Balasan berhasil disimpan dan dikirim ke ' . $message->email . '! 🚀');
        } catch (\Exception $e) {
            return back()->with('error', 'Balasan tersimpan di sistem, TAPI gagal mengirim email: ' . $e->getMessage() . '. Pastikan setting SMTP di file .env sudah benar.');
        }
    }
}

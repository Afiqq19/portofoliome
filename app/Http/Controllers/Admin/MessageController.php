<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function reply(Request $request, ContactMessage $message)
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

    /**
     * Export all contact messages to CSV
     */
    public function export()
    {
        $fileName = 'pesan-kontak-' . date('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['No', 'ID Tiket', 'Nama Pengirim', 'Email', 'Subjek', 'Isi Pesan', 'Status Baca', 'Waktu Masuk (WIB)']);

            $no = 0;
            ContactMessage::latest()->chunk(250, function ($messages) use ($file, &$no) {
                foreach ($messages as $m) {
                    $no++;
                    $status = $m->is_read ? 'Sudah Dibaca' : 'Belum Dibaca';
                    $timeWib = $m->created_at ? $m->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s') : '-';

                    fputcsv($file, [
                        $no,
                        $m->ticket_id ?? '-',
                        $m->name,
                        $m->email,
                        $m->subject ?? '-',
                        $m->message,
                        $status,
                        $timeWib
                    ]);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }
}

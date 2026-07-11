<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReplyMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $contactMessage;
    public $replyBody;

    /**
     * Create a new message instance.
     */
    public function __construct(ContactMessage $contactMessage, string $replyBody)
    {
        $this->contactMessage = $contactMessage;
        $this->replyBody = $replyBody;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Balasan: ' . ($this->contactMessage->subject ?? 'Pesan Anda'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.reply',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}

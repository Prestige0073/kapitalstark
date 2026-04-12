<?php

namespace App\Mail;

use App\Models\ChatSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChatAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ChatSession $session,
        public string $visitorMessage
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            to:      [config('mail.from.address')],
            subject: '💬 Nouveau message chat — ' . $this->session->ip_address . ' attend une réponse',
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.chat-alert', with: [
            'session'        => $this->session,
            'visitorMessage' => $this->visitorMessage,
            'chatUrl'        => url('/admin/chat/' . $this->session->id),
        ]);
    }
}

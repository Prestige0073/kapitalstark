<?php

namespace App\Mail;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdvisorMessage extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Message $message) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: ($this->message->subject ?? 'Message de votre conseiller') . ' — KapitalStark');
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.advisor-message',
            with: [
                'userName' => $this->message->user->name,
                'subject'  => $this->message->subject ?? 'Message de votre conseiller',
                'body'     => $this->message->body,
            ]
        );
    }
}

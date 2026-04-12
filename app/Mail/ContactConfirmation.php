<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $senderName,
        public string $senderEmail,
        public string $contactSubject,
        public string $messageBody,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Votre message a bien été reçu — KapitalStark');
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.contact-confirmation',
            with: [
                'name'           => $this->senderName,
                'email'          => $this->senderEmail,
                'subject'        => $this->contactSubject,
                'contactMessage' => $this->messageBody,
            ]
        );
    }
}

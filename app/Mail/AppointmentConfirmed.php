<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentConfirmed extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Votre rendez-vous est confirmé — KapitalStark');
    }

    public function content(): Content
    {
        $channelLabels = [
            'video'   => 'Visioconférence',
            'agency'  => 'En agence',
            'phone'   => 'Téléphone',
            'chat'    => 'Messagerie en ligne',
        ];

        return new Content(
            view: 'mail.appointment-confirmed',
            with: [
                'userName' => $this->appointment->user->name,
                'date'     => \Carbon\Carbon::parse($this->appointment->date)->translatedFormat('l d F Y'),
                'time'     => $this->appointment->time,
                'subject'  => $this->appointment->subject,
                'channel'  => $channelLabels[$this->appointment->channel] ?? $this->appointment->channel,
                'advisor'  => $this->appointment->advisor,
            ]
        );
    }
}

<?php

namespace App\Mail;

use App\Models\LoanRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanRequestReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public LoanRequest $loanRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Votre demande de prêt a bien été reçue — KapitalStark');
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.loan-request-received',
            with: [
                'userName'  => $this->loanRequest->user->name,
                'loanType'  => ucwords(str_replace(['-', '_'], ' ', $this->loanRequest->loan_type)),
                'amount'    => $this->loanRequest->amount,
                'duration'  => $this->loanRequest->duration_months,
                'requestId' => $this->loanRequest->id,
            ]
        );
    }
}

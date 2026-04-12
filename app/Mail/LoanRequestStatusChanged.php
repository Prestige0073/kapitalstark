<?php

namespace App\Mail;

use App\Models\LoanRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LoanRequestStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public LoanRequest $loanRequest) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Mise à jour de votre dossier — KapitalStark');
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.loan-request-status',
            with: [
                'userName'    => $this->loanRequest->user->name,
                'loanType'    => ucwords(str_replace(['-', '_'], ' ', $this->loanRequest->loan_type)),
                'amount'      => $this->loanRequest->amount,
                'status'      => $this->loanRequest->status,
                'statusLabel' => $this->loanRequest->statusLabel(),
                'requestId'   => $this->loanRequest->id,
            ]
        );
    }
}

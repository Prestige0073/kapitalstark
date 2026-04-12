<?php

namespace App\Services;

use App\Models\Document;
use App\Models\LoanRequest;
use App\Models\Transfer;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class PdfService
{
    /**
     * Generate a loan approval / contract PDF and attach it to the user's documents.
     */
    public function generateLoanDocument(LoanRequest $loanRequest, string $status, string $locale = 'fr'): ?Document
    {
        if (!in_array($status, ['offer', 'signed', 'approved'], true)) {
            return null;
        }

        app()->setLocale($locale);

        $user = $loanRequest->user;

        $data = [
            'ref'       => 'KS-' . strtoupper(Str::random(4)) . '-' . $loanRequest->id,
            'date'      => now()->format('d/m/Y'),
            'status'    => $status,
            'locale'    => $locale,
            'user'      => $user,
            'loan'      => $loanRequest,
            'monthly'   => $this->calcMonthly($loanRequest->amount, $loanRequest->duration_months),
            'rate'      => $this->rateForType($loanRequest->loan_type),
            'schedule'  => $this->buildSchedule($loanRequest->amount, $loanRequest->duration_months, 6),
        ];

        $view     = 'pdf.loan-document';
        $filename = match ($status) {
            'offer'    => 'offre-pret',
            'approved' => 'accord-pret',
            default    => 'contrat-signe',
        } . '-' . $loanRequest->id . '-' . now()->format('Ymd') . '.pdf';

        $pdf = Pdf::loadView($view, $data)
            ->setPaper('a4', 'portrait')
            ->setOptions(['dpi' => 150, 'defaultFont' => 'DejaVu Sans', 'isHtml5ParserEnabled' => true]);

        $storedName = $this->store($pdf, $user->id, $filename);

        $label = match ($status) {
            'offer'    => 'Offre de prêt — ' . $this->loanTypeLabel($loanRequest->loan_type),
            'approved' => 'Accord de prêt — ' . $this->loanTypeLabel($loanRequest->loan_type),
            default    => 'Contrat de prêt signé — ' . $this->loanTypeLabel($loanRequest->loan_type),
        };

        return Document::create([
            'user_id'       => $user->id,
            'original_name' => $label . '.pdf',
            'stored_name'   => $storedName,
            'category'      => 'Approbation',
            'mime'          => 'application/pdf',
            'size_bytes'    => strlen($pdf->output()),
        ]);
    }

    /**
     * Generate a PDF receipt for a completed bank transfer (Transfer model).
     */
    public function generateTransferPdf(Transfer $transfer, User $user, string $locale = 'fr'): string
    {
        app()->setLocale($locale);

        $data = [
            'ref'        => 'VIR-' . strtoupper(Str::random(6)) . '-' . str_pad($transfer->id, 5, '0', STR_PAD_LEFT),
            'date'       => ($transfer->completed_at ?? $transfer->created_at)->format('d/m/Y à H:i'),
            'label'      => $transfer->label ?: 'Virement bancaire vers ' . $transfer->recipient_name,
            'amount'     => number_format($transfer->amount, 2, ',', ' ') . ' €',
            'credit'     => false,
            'locale'     => $locale,
            'user'       => $user,
            'card_last4' => '****',
            'generated'  => now()->format('d/m/Y à H:i'),
            'qrSvg'      => $this->generateQr('https://kapitalstark.fr/verify/' . $transfer->id),
        ];

        $pdf = Pdf::loadView('pdf.transfer-receipt', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions(['dpi' => 150, 'defaultFont' => 'DejaVu Sans', 'isHtml5ParserEnabled' => true]);

        return $pdf->output();
    }

    /**
     * Generate a transfer receipt PDF (on demand from card page).
     */
    public function generateTransferReceipt(User $user, array $transaction, string $locale = 'fr'): string
    {
        app()->setLocale($locale);

        $data = [
            'ref'         => 'VIR-' . strtoupper(Str::random(6)) . '-' . now()->format('YmdHis'),
            'date'        => $transaction['date'],
            'label'       => $transaction['label'],
            'amount'      => $transaction['amount'],
            'credit'      => $transaction['credit'],
            'locale'      => $locale,
            'user'        => $user,
            'card_last4'  => $transaction['card_last4'] ?? '****',
            'generated'   => now()->format('d/m/Y à H:i'),
            'qrSvg'       => $this->generateQr('https://kapitalstark.fr'),
        ];

        $pdf = Pdf::loadView('pdf.transfer-receipt', $data)
            ->setPaper('a4', 'portrait')
            ->setOptions(['dpi' => 150, 'defaultFont' => 'DejaVu Sans', 'isHtml5ParserEnabled' => true]);

        return $pdf->output();
    }

    /* ── Private helpers ─────────────────────────────────────── */

    private function generateQr(string $url): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(120, 1),
            new SvgImageBackEnd()
        );
        return (new Writer($renderer))->writeString($url);
    }

    private function store($pdf, int $userId, string $filename): string
    {
        $storedName = "documents/{$userId}/{$filename}";
        \Illuminate\Support\Facades\Storage::disk('local')->put($storedName, $pdf->output());
        return $storedName;
    }

    private function calcMonthly(int $amount, int $months, float $rate = null): float
    {
        $rate  = ($rate ?? 3.9) / 100 / 12;
        if ($rate == 0) return round($amount / $months, 2);
        return round($amount * $rate * pow(1 + $rate, $months) / (pow(1 + $rate, $months) - 1), 2);
    }

    private function rateForType(string $type): float
    {
        return match ($type) {
            'immobilier' => 3.45,
            'automobile' => 4.90,
            'entreprise' => 5.20,
            'agricole'   => 4.10,
            'microcredit'=> 6.50,
            default      => 5.90,
        };
    }

    private function loanTypeLabel(string $type): string
    {
        return match ($type) {
            'immobilier'  => 'Immobilier',
            'automobile'  => 'Automobile',
            'personnel'   => 'Personnel',
            'entreprise'  => 'Entreprise',
            'microcredit' => 'Microcrédit',
            'agricole'    => 'Agricole',
            default       => ucfirst($type),
        };
    }

    private function buildSchedule(int $amount, int $months, int $rows = 6): array
    {
        $rate    = 3.9 / 100 / 12;
        $monthly = $this->calcMonthly($amount, $months, 3.9);
        $balance = $amount;
        $rows    = min($rows, $months);
        $schedule = [];

        for ($i = 1; $i <= $rows; $i++) {
            $interest   = round($balance * $rate, 2);
            $principal  = round($monthly - $interest, 2);
            $balance    = round($balance - $principal, 2);
            $schedule[] = [
                'n'         => $i,
                'date'      => now()->addMonths($i)->format('d/m/Y'),
                'monthly'   => number_format($monthly, 2, ',', ' '),
                'principal' => number_format($principal, 2, ',', ' '),
                'interest'  => number_format($interest, 2, ',', ' '),
                'balance'   => number_format(max(0, $balance), 2, ',', ' '),
            ];
        }

        return $schedule;
    }
}

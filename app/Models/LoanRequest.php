<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LoanRequest extends Model
{
    /** Statuts considérés comme "en cours" — bloquent une nouvelle demande */
    const ACTIVE_STATUSES = [
        'pending', 'contract_sent', 'documents_submitted',
        'under_review', 'validated', 'confirmed',
    ];

    protected $fillable = [
        'user_id', 'loan_type', 'amount', 'duration_months',
        'purpose', 'income', 'charges', 'employment', 'status',
        'contract_path', 'signed_contract_path', 'admin_notes',
        'approved_amount', 'approved_at', 'confirmed_at', 'reviewed_at',
    ];

    protected $casts = [
        'reviewed_at'  => 'datetime',
        'approved_at'  => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    /* ── Relations ────────────────────────────────────────────── */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /* ── Helpers ──────────────────────────────────────────────── */

    public function isActive(): bool
    {
        return in_array($this->status, self::ACTIVE_STATUSES);
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'              => 'En attente',
            'contract_sent'        => 'Contrat à signer',
            'documents_submitted'  => 'Documents soumis',
            'under_review'         => 'Dossier en étude',
            'validated'            => 'Dossier validé',
            'confirmed'            => 'Demande confirmée',
            'approved'             => 'Prêt accordé',
            'rejected'             => 'Refusé',
            // Anciens statuts (rétrocompatibilité)
            'analysis'             => 'En analyse',
            'offer'                => 'Offre émise',
            'signed'               => 'Signé',
            default                => ucfirst($this->status),
        };
    }

    public function statusClass(): string
    {
        return match ($this->status) {
            'pending'                            => 'warning',
            'contract_sent'                      => 'info',
            'documents_submitted', 'under_review'=> 'info',
            'validated'                          => 'success',
            'confirmed'                          => 'success',
            'approved'                           => 'success',
            'rejected'                           => 'danger',
            default                              => 'muted',
        };
    }

    /** Index de l'étape courante (1-based, max 6) */
    public function stepIndex(): int
    {
        return match ($this->status) {
            'pending'              => 1,
            'contract_sent'        => 2,
            'documents_submitted'  => 3,
            'under_review'         => 3,
            'validated'            => 4,
            'confirmed'            => 5,
            'approved'             => 6,
            // Legacy
            'analysis'             => 2,
            'offer'                => 3,
            'signed'               => 5,
            default                => 1,
        };
    }
}

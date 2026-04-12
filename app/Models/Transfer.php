<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'recipient_name', 'recipient_iban', 'recipient_bic',
        'label', 'note', 'status', 'progress', 'stop_levels', 'completion_message',
        'validated_by', 'validated_at', 'completed_at',
        'started_at', 'base_progress', 'duration_seconds',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'stop_levels'  => 'array',
        'validated_at' => 'datetime',
        'completed_at' => 'datetime',
        'started_at'   => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'validated_by');
    }

    /* ── Calcul de progression en temps réel ─────────────────── */

    /**
     * Calcule la progression basée sur l'horloge uniquement.
     * Aucun sleep(), aucun job nécessaire.
     * Formule : base_progress + (elapsed / duration_seconds) × 100
     */
    public function calculateProgress(): int
    {
        if ($this->status !== 'processing' || !$this->started_at) {
            return (int) $this->progress;
        }

        $elapsed  = now()->diffInSeconds($this->started_at);
        $duration = max(1, (int) ($this->duration_seconds ?? 300));
        $base     = (int) ($this->base_progress ?? 0);
        $earned   = ($elapsed / $duration) * 100;

        return (int) min(100, $base + $earned);
    }

    /* ── Helpers ──────────────────────────────────────────────── */

    public function statusLabel(): string
    {
        return match ($this->status) {
            'pending'    => 'En attente de validation',
            'approved'   => 'Approuvé — prêt à lancer',
            'processing' => 'En cours d\'exécution',
            'paused'     => 'En attente de déblocage',
            'completed'  => 'Terminé',
            'rejected'   => 'Rejeté',
            default      => ucfirst($this->status),
        };
    }

    public function statusClass(): string
    {
        return match ($this->status) {
            'pending'    => 'warning',
            'approved'   => 'info',
            'processing' => 'info',
            'paused'     => 'warning',
            'completed'  => 'success',
            'rejected'   => 'danger',
            default      => 'muted',
        };
    }

    public function sortedStopLevels(): array
    {
        $levels = $this->stop_levels ?? [];
        usort($levels, fn ($a, $b) => $a['percentage'] <=> $b['percentage']);
        return $levels;
    }

    public function currentLevelText(): ?string
    {
        $reached = array_filter(
            $this->sortedStopLevels(),
            fn ($l) => !empty($l['reached_at'])
        );
        if (empty($reached)) return null;
        $last = end($reached);
        return $last['text'];
    }

    /**
     * Returns the currently active (reached but not yet unlocked) stop level, or null.
     */
    public function activePausedLevel(): ?array
    {
        foreach ($this->sortedStopLevels() as $level) {
            if (!empty($level['reached_at']) && empty($level['code_used_at'])) {
                return $level;
            }
        }
        return null;
    }
}

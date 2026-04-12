<?php

namespace App\Jobs;

use App\Models\Transfer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProcessTransfer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 360; // 6 min max par segment (jamais de boucle d'attente)
    public int $tries   = 1;

    public function __construct(public readonly int $transferId) {}

    public function handle(): void
    {
        $transfer = Transfer::find($this->transferId);
        if (!$transfer || !in_array($transfer->status, ['processing', 'paused'])) {
            return;
        }

        $levels       = $transfer->sortedStopLevels();
        $totalSeconds = 300; // 5 minutes au total
        $tickSeconds  = 4;
        $prevPct      = $transfer->progress;

        foreach ($levels as $i => $level) {
            $pct = (int) $level['percentage'];

            // ── Palier déjà entièrement traité (code utilisé ou pas de code) ──
            if (!empty($level['reached_at'])) {
                if (empty($level['unlock_code']) || !empty($level['code_used_at'])) {
                    $prevPct = $pct;
                    continue;
                }
                // Atteint mais pas encore débloqué → repause et EXIT
                // unlock() redispatchera un nouveau job
                $transfer->update(['status' => 'paused', 'progress' => $pct]);
                return;
            }

            // ── Animer progressivement vers ce palier ────────────────────────
            $segmentSeconds = (int) round(($pct - $prevPct) / 100 * $totalSeconds);
            $elapsed        = 0;

            while ($elapsed < $segmentSeconds) {
                $wait = min($tickSeconds, $segmentSeconds - $elapsed);
                sleep($wait);
                $elapsed += $wait;

                $transfer->refresh();
                if ($transfer->status !== 'processing') return;

                $ratio        = $elapsed / max(1, $segmentSeconds);
                $intermediate = (int) round($prevPct + ($pct - $prevPct) * $ratio);
                $transfer->update(['progress' => min($pct - 1, $intermediate)]);
            }

            // ── Palier atteint : code + pause + EXIT ─────────────────────────
            $transfer->refresh();
            if ($transfer->status !== 'processing') return;

            $unlockCode    = strtoupper(Str::random(3)) . '-' . strtoupper(Str::random(4));
            $updatedLevels = $transfer->stop_levels ?? [];
            $updatedLevels[$i]['reached_at']   = now()->toIso8601String();
            $updatedLevels[$i]['unlock_code']  = $unlockCode;
            $updatedLevels[$i]['code_used_at'] = null;

            $transfer->update([
                'progress'    => $pct,
                'stop_levels' => $updatedLevels,
                'status'      => 'paused',
            ]);

            Log::info("Transfer #{$transfer->id} — palier {$pct}% : pause.");
            return; // EXIT — unlock() redispatchera le job
        }

        // ── Segment final vers 100% ───────────────────────────────────────────
        $finalSeconds = (int) round((100 - $prevPct) / 100 * $totalSeconds);
        $elapsed      = 0;

        while ($elapsed < $finalSeconds) {
            $wait = min($tickSeconds, $finalSeconds - $elapsed);
            sleep($wait);
            $elapsed += $wait;

            $transfer->refresh();
            if ($transfer->status !== 'processing') return;

            $ratio        = $elapsed / max(1, $finalSeconds);
            $intermediate = (int) round($prevPct + (100 - $prevPct) * $ratio);
            $transfer->update(['progress' => min(99, $intermediate)]);
        }

        $transfer->refresh();
        if ($transfer->status !== 'processing') return;

        $transfer->update([
            'status'       => 'completed',
            'progress'     => 100,
            'completed_at' => now(),
        ]);

        Log::info("Transfer #{$transfer->id} — terminé à 100%");
    }

    public function failed(\Throwable $e): void
    {
        $transfer = Transfer::find($this->transferId);
        if ($transfer && in_array($transfer->status, ['processing', 'paused'])) {
            $transfer->update(['status' => 'approved']);
        }
        Log::error("ProcessTransfer #{$this->transferId} échoué : " . $e->getMessage());
    }
}

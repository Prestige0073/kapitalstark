<?php

namespace App\Console\Commands;

use App\Models\ChatSession;
use Illuminate\Console\Command;

class PruneChatSessions extends Command
{
    protected $signature   = 'chat:prune {--days=30 : Supprimer les sessions inactives depuis N jours}';
    protected $description = 'Supprime les sessions de chat public inactives depuis N jours';

    public function handle(): int
    {
        $days = (int) $this->option('days');

        $cutoff = now()->subDays($days);

        $count = ChatSession::where(function ($q) use ($cutoff) {
            // Sessions sans activité récente
            $q->where('last_seen_at', '<', $cutoff)
              ->orWhereNull('last_seen_at');
        })->count();

        if ($count === 0) {
            $this->info("Aucune session à supprimer (seuil : {$days} jours).");
            return self::SUCCESS;
        }

        ChatSession::where(function ($q) use ($cutoff) {
            $q->where('last_seen_at', '<', $cutoff)
              ->orWhereNull('last_seen_at');
        })->delete();

        $this->info("✓ {$count} session(s) chat supprimée(s) (inactives depuis > {$days} jours).");

        return self::SUCCESS;
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            // Requête la plus fréquente : tous les messages d'une session par direction
            $table->index(['session_id', 'direction'], 'chat_messages_session_direction_idx');
            // Pour compter les non-lus visiteur par session
            $table->index(['session_id', 'direction', 'read'], 'chat_messages_session_direction_read_idx');
        });

        Schema::table('chat_sessions', function (Blueprint $table) {
            // Tri par last_seen_at dans la liste admin
            $table->index('last_seen_at', 'chat_sessions_last_seen_idx');
        });
    }

    public function down(): void
    {
        Schema::table('chat_messages', function (Blueprint $table) {
            $table->dropIndex('chat_messages_session_direction_idx');
            $table->dropIndex('chat_messages_session_direction_read_idx');
        });

        Schema::table('chat_sessions', function (Blueprint $table) {
            $table->dropIndex('chat_sessions_last_seen_idx');
        });
    }
};

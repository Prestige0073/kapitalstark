<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Index composite (user_id, direction) — requête la plus fréquente du projet
        Schema::table('messages', function (Blueprint $table) {
            $table->index(['user_id', 'direction'], 'messages_user_direction_idx');
            $table->index(['user_id', 'direction', 'read'], 'messages_user_direction_read_idx');
        });

        // Index sur loan_requests.status — filtré dans presque toutes les requêtes admin
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->index('status', 'loan_requests_status_idx');
        });

        // Index sur transfers.status — filtré par l'admin et les jobs
        Schema::table('transfers', function (Blueprint $table) {
            $table->index('status', 'transfers_status_idx');
        });
    }

    public function down(): void
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('messages_user_direction_idx');
            $table->dropIndex('messages_user_direction_read_idx');
        });

        Schema::table('loan_requests', function (Blueprint $table) {
            $table->dropIndex('loan_requests_status_idx');
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dropIndex('transfers_status_idx');
        });
    }
};

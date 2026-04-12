<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->timestamp('started_at')->nullable()->after('completed_at');
            $table->unsignedSmallInteger('base_progress')->default(0)->after('started_at');
            $table->unsignedSmallInteger('duration_seconds')->default(300)->after('base_progress');
        });
    }

    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn(['started_at', 'base_progress', 'duration_seconds']);
        });
    }
};

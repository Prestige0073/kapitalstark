<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE transfers MODIFY COLUMN status ENUM('pending','approved','processing','paused','completed','rejected') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE transfers MODIFY COLUMN status ENUM('pending','approved','processing','completed','rejected') NOT NULL DEFAULT 'pending'");
    }
};

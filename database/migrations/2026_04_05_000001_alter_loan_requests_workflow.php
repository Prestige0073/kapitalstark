<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convertir le ENUM en VARCHAR pour accepter les nouveaux statuts
        DB::statement("ALTER TABLE loan_requests MODIFY COLUMN status VARCHAR(50) NOT NULL DEFAULT 'pending'");

        Schema::table('loan_requests', function (Blueprint $table) {
            $table->string('contract_path')->nullable()->after('reviewed_at');
            $table->string('signed_contract_path')->nullable()->after('contract_path');
            $table->text('admin_notes')->nullable()->after('signed_contract_path');
            $table->decimal('approved_amount', 15, 2)->nullable()->after('admin_notes');
            $table->timestamp('approved_at')->nullable()->after('approved_amount');
            $table->timestamp('confirmed_at')->nullable()->after('approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('loan_requests', function (Blueprint $table) {
            $table->dropColumn(['contract_path', 'signed_contract_path', 'admin_notes', 'approved_amount', 'approved_at', 'confirmed_at']);
        });
        DB::statement("ALTER TABLE loan_requests MODIFY COLUMN status ENUM('pending','analysis','offer','signed','rejected') NOT NULL DEFAULT 'pending'");
    }
};

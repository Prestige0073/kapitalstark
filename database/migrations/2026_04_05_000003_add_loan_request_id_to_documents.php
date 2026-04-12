<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->foreignId('loan_request_id')
                  ->nullable()
                  ->after('user_id')
                  ->constrained('loan_requests')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropForeign(['loan_request_id']);
            $table->dropColumn('loan_request_id');
        });
    }
};

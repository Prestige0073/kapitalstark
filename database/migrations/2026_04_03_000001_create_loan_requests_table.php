<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('loan_type', 50);
            $table->unsignedBigInteger('amount');
            $table->unsignedSmallInteger('duration_months');
            $table->text('purpose');
            $table->unsignedInteger('income');
            $table->unsignedInteger('charges')->default(0);
            $table->string('employment', 50);
            $table->enum('status', ['pending', 'analysis', 'offer', 'signed', 'rejected'])
                  ->default('pending');
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_requests');
    }
};

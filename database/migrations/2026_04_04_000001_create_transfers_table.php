<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Destination
            $table->decimal('amount', 12, 2);
            $table->string('recipient_name');
            $table->string('recipient_iban', 34);
            $table->string('recipient_bic', 11)->nullable();
            $table->string('label')->nullable();
            $table->text('note')->nullable();

            // Cycle de vie
            $table->enum('status', ['pending', 'processing', 'completed', 'rejected'])
                  ->default('pending');
            $table->unsignedTinyInteger('progress')->default(0); // 0–100

            // Niveaux d'arrêt (JSON) et message de fin
            $table->json('stop_levels')->nullable();        // [{percentage,text,reached_at}]
            $table->text('completion_message')->nullable();  // message 100 %

            // Validation admin
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('validated_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};

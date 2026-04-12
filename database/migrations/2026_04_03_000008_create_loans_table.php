<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('type', 50);                     // immobilier, automobile, personnel…
            $table->bigInteger('amount');                   // montant initial (€)
            $table->bigInteger('remaining');                // capital restant dû (€)
            $table->integer('monthly');                     // mensualité (€)
            $table->decimal('rate', 5, 2);                 // taux (%)
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('progress')->default(0);   // 0-100
            $table->enum('status', ['active', 'closed', 'late'])->default('active');
            $table->date('next_payment_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};

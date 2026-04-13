<?php
// Migration : table faqs — questions/réponses pour Featured Snippets Google

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->text('question');
            $table->longText('answer');
            $table->string('category', 80);    // conditions_pret, taux_interet, eligibilite, remboursement, documents_requis
            $table->string('page_slug', 120)->nullable(); // ex: prets/immobilier — null = page /faq globale
            $table->boolean('is_published')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index(['category', 'is_published', 'sort_order'], 'faqs_cat_pub_order_idx');
            $table->index(['page_slug', 'is_published'], 'faqs_slug_pub_idx');
        });
    }

    public function down(): void {
        Schema::dropIfExists('faqs');
    }
};

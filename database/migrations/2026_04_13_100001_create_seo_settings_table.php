<?php
// Migration : table seo_settings — paramètres SEO par type de page

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page_type')->unique();       // ex: home, loan_immobilier, faq, blog, contact
            $table->string('meta_title', 70)->nullable();
            $table->string('meta_description', 160)->nullable();
            $table->string('og_image')->nullable();
            $table->string('canonical_url')->nullable();
            $table->text('schema_json')->nullable();     // JSON-LD supplémentaire spécifique à la page
            $table->string('robots_directive', 60)->default('index, follow');
            $table->text('keywords')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('seo_settings');
    }
};

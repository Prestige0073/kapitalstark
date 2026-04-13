<?php
// Migration : table ad_conversions — suivi côté serveur des conversions Google Ads (RGPD compliant)

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ad_conversions', function (Blueprint $table) {
            $table->id();
            $table->string('gclid', 100)->nullable()->index();  // Google Click Identifier
            $table->string('conversion_type', 60);              // form_submit, simulator_click, phone_call, pdf_download, scroll_75, engagement_3min
            $table->string('page_url', 300);
            $table->decimal('value', 10, 2)->nullable();
            $table->string('currency', 3)->default('EUR');
            $table->string('ip_address', 45)->nullable();       // stocké anonymisé (3 derniers octets masqués)
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('utm_term', 200)->nullable();
            $table->string('utm_content', 200)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['conversion_type', 'created_at'], 'ad_conv_type_date_idx');
        });
    }

    public function down(): void {
        Schema::dropIfExists('ad_conversions');
    }
};

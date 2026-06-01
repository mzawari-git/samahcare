<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_attribution_events', function (Blueprint $table) {
            $table->id();
            $table->string('session_id')->index();
            $table->string('user_id')->nullable()->index();
            $table->string('fbp')->nullable()->index();
            $table->string('fbc')->nullable()->index();
            $table->string('external_id')->nullable()->index();
            $table->foreignId('campaign_id')->nullable()->constrained('meta_campaigns')->cascadeOnDelete();
            $table->foreignId('ad_set_id')->nullable()->constrained('meta_ad_sets')->cascadeOnDelete();
            $table->foreignId('ad_id')->nullable()->constrained('meta_ads')->cascadeOnDelete();
            $table->enum('event_type', ['view', 'click', 'landing', 'add_to_cart', 'checkout', 'purchase']);
            $table->decimal('value', 12, 2)->nullable();
            $table->string('currency', 3)->default('ILS');
            $table->string('url')->nullable();
            $table->string('referrer')->nullable();
            $table->json('utm_params')->nullable();
            $table->string('device_type')->nullable();
            $table->string('browser')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamps();
            
            $table->index(['event_type', 'created_at']);
            $table->index(['campaign_id', 'event_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_attribution_events');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_lead_conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('meta_leads')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('meta_campaigns')->cascadeOnDelete();
            $table->foreignId('booking_id')->nullable();
            $table->foreignId('order_id')->nullable();
            $table->enum('conversion_type', ['booking', 'purchase', 'signup', 'call', 'form_submit']);
            $table->decimal('value', 12, 2)->nullable();
            $table->string('currency', 3)->default('ILS');
            $table->integer('days_to_convert')->nullable();
            $table->json('touchpoints')->nullable();
            $table->enum('attribution_model', ['first_click', 'last_click', 'linear', 'time_decay'])->default('last_click');
            $table->timestamps();
            
            $table->index(['lead_id', 'conversion_type']);
            $table->index(['campaign_id', 'conversion_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_lead_conversions');
    }
};

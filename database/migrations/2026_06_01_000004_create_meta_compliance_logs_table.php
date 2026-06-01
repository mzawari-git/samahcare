<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_compliance_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_account_id')->constrained('meta_ad_accounts')->cascadeOnDelete();
            $table->foreignId('campaign_id')->nullable()->constrained('meta_campaigns')->cascadeOnDelete();
            $table->foreignId('ad_id')->nullable()->constrained('meta_ads')->cascadeOnDelete();
            $table->enum('type', ['policy_violation', 'rejection', 'warning', 'account_issue', 'delivery_issue']);
            $table->enum('severity', ['low', 'medium', 'high', 'critical']);
            $table->string('policy_name')->nullable();
            $table->text('description');
            $table->json('meta_data')->nullable();
            $table->enum('status', ['open', 'acknowledged', 'resolved', 'appealed'])->default('open');
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();
            $table->timestamps();
            
            $table->index(['ad_account_id', 'status']);
            $table->index(['severity', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_compliance_logs');
    }
};

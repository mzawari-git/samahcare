<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_automation_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_account_id')->constrained('meta_ad_accounts')->cascadeOnDelete();
            $table->string('name');
            $table->enum('type', ['auto_pause', 'budget_scale', 'bid_adjust', 'schedule', 'alert']);
            $table->json('conditions');
            $table->json('actions');
            $table->enum('status', ['active', 'paused', 'archived'])->default('active');
            $table->enum('scope', ['all_campaigns', 'specific_campaigns'])->default('all_campaigns');
            $table->json('campaign_ids')->nullable();
            $table->timestamp('last_executed_at')->nullable();
            $table->integer('execution_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_automation_rules');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_spending_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_account_id')->constrained('meta_ad_accounts')->cascadeOnDelete();
            $table->enum('scope', ['account', 'campaign', 'ad_set']);
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->decimal('daily_limit', 12, 2)->nullable();
            $table->decimal('lifetime_limit', 12, 2)->nullable();
            $table->decimal('current_spend', 12, 2)->default(0);
            $table->decimal('alert_threshold', 5, 2)->default(80);
            $table->enum('action_on_limit', ['pause', 'alert_only', 'reduce_budget'])->default('alert_only');
            $table->enum('status', ['active', 'paused', 'triggered'])->default('active');
            $table->timestamp('reset_at')->nullable();
            $table->timestamps();
            
            $table->index(['ad_account_id', 'scope', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_spending_limits');
    }
};

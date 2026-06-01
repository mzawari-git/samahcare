<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_scheduled_campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained('meta_campaigns')->cascadeOnDelete();
            $table->enum('action', ['activate', 'pause', 'budget_change', 'bid_change']);
            $table->timestamp('scheduled_at');
            $table->json('parameters')->nullable();
            $table->enum('status', ['pending', 'executed', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('executed_at')->nullable();
            $table->text('error_message')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_scheduled_campaigns');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ad_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->index();
            $table->string('type'); // health_critical, spend_anomaly, traffic_drop, auto_pause, webhook
            $table->string('severity'); // info, warning, critical
            $table->string('title');
            $table->text('body')->nullable();
            $table->json('data')->nullable();
            $table->string('campaign_id')->nullable()->index();
            $table->boolean('acknowledged')->default(false);
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('ad_auto_pause_logs', function (Blueprint $table) {
            $table->id();
            $table->string('platform')->index();
            $table->string('campaign_id')->nullable()->index();
            $table->string('campaign_name')->nullable();
            $table->string('trigger_type'); // health_score, spend_anomaly, traffic_quality, webhook
            $table->decimal('trigger_value', 8, 2)->nullable();
            $table->decimal('threshold', 8, 2)->nullable();
            $table->string('action'); // paused, resumed, attempted
            $table->boolean('success')->default(false);
            $table->text('error_message')->nullable();
            $table->json('context')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_auto_pause_logs');
        Schema::dropIfExists('ad_alerts');
    }
};

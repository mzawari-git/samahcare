<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('google_campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('campaign_id')->unique()->index();
            $table->string('customer_id')->index();
            $table->string('name');
            $table->string('status')->default('PAUSED');
            $table->string('advertising_channel_type')->default('SEARCH');
            $table->decimal('budget_amount', 12, 2)->nullable();
            $table->string('budget_currency', 3)->default('ILS');
            $table->string('budget_period')->default('DAILY');
            $table->string('bidding_strategy_type')->default('MAXIMIZE_CONVERSIONS');
            $table->decimal('target_cpa', 10, 2)->nullable();
            $table->decimal('target_roas', 5, 2)->nullable();
            $table->string('network_settings')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->json('insights')->nullable();
            $table->json('settings')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('google_ad_groups', function (Blueprint $table) {
            $table->id();
            $table->string('ad_group_id')->unique()->index();
            $table->foreignId('campaign_id')->constrained('google_campaigns')->onDelete('cascade');
            $table->string('name');
            $table->string('status')->default('PAUSED');
            $table->decimal('cpc_bid_micros', 15, 0)->nullable();
            $table->string('type')->default('SEARCH_STANDARD');
            $table->json('settings')->nullable();
            $table->json('insights')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('google_keywords', function (Blueprint $table) {
            $table->id();
            $table->string('keyword_id')->unique()->index();
            $table->foreignId('ad_group_id')->constrained('google_ad_groups')->onDelete('cascade');
            $table->string('text');
            $table->string('match_type')->default('BROAD');
            $table->string('status')->default('ENABLED');
            $table->decimal('cpc_bid_micros', 15, 0)->nullable();
            $table->decimal('quality_score', 3, 1)->nullable();
            $table->decimal('estimated_daily_clicks', 10, 2)->nullable();
            $table->decimal('estimated_daily_cost', 10, 2)->nullable();
            $table->json('insights')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('google_ads', function (Blueprint $table) {
            $table->id();
            $table->string('ad_id')->unique()->index();
            $table->foreignId('ad_group_id')->constrained('google_ad_groups')->onDelete('cascade');
            $table->string('type')->default('RESPONSIVE_SEARCH');
            $table->string('status')->default('PAUSED');
            $table->text('final_url')->nullable();
            $table->string('headline_1')->nullable();
            $table->string('headline_2')->nullable();
            $table->string('headline_3')->nullable();
            $table->string('headline_4')->nullable();
            $table->string('headline_5')->nullable();
            $table->string('headline_6')->nullable();
            $table->string('headline_7')->nullable();
            $table->string('headline_8')->nullable();
            $table->string('headline_9')->nullable();
            $table->string('headline_10')->nullable();
            $table->string('headline_11')->nullable();
            $table->string('headline_12')->nullable();
            $table->string('headline_13')->nullable();
            $table->string('headline_14')->nullable();
            $table->string('headline_15')->nullable();
            $table->string('description_1')->nullable();
            $table->string('description_2')->nullable();
            $table->string('description_3')->nullable();
            $table->string('description_4')->nullable();
            $table->string('path_1')->nullable();
            $table->string('path_2')->nullable();
            $table->json('asset_associations')->nullable();
            $table->json('insights')->nullable();
            $table->timestamp('last_synced_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('google_ads');
        Schema::dropIfExists('google_keywords');
        Schema::dropIfExists('google_ad_groups');
        Schema::dropIfExists('google_campaigns');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('custom_audiences', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('platform', 20);
            $table->string('platform_audience_id', 100)->nullable();
            $table->enum('source_type', ['lookalike', 'custom', 'website', 'engagement', 'lead_form', 'capi'])->default('custom');
            $table->string('seed_source', 100)->nullable();
            $table->integer('audience_size')->default(0);
            $table->decimal('lookalike_ratio', 3, 1)->nullable();
            $table->string('country', 10)->default('PS');
            $table->enum('status', ['draft', 'syncing', 'ready', 'error', 'fatigued'])->default('draft');
            $table->integer('fatigue_score')->default(0);
            $table->timestamp('last_synced_at')->nullable();
            $table->decimal('performance_ctr', 5, 2)->nullable();
            $table->decimal('performance_cpa', 10, 2)->nullable();
            $table->decimal('performance_roas', 5, 2)->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('audience_insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audience_id')->constrained('custom_audiences')->onDelete('cascade');
            $table->date('date');
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->decimal('ctr', 5, 2)->nullable();
            $table->decimal('spend', 10, 2)->default(0);
            $table->integer('conversions')->default(0);
            $table->decimal('cpa', 10, 2)->nullable();
            $table->decimal('roas', 5, 2)->nullable();
            $table->decimal('fatigue_indicator', 3, 1)->nullable();
            $table->unique(['audience_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audience_insights');
        Schema::dropIfExists('custom_audiences');
    }
};

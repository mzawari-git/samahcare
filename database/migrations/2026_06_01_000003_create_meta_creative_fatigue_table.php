<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_creative_fatigue', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creative_id')->constrained('meta_ad_creatives')->cascadeOnDelete();
            $table->date('date');
            $table->float('ctr')->default(0);
            $table->float('ctr_change')->default(0);
            $table->float('frequency')->default(0);
            $table->integer('impressions')->default(0);
            $table->integer('clicks')->default(0);
            $table->enum('fatigue_level', ['healthy', 'warning', 'fatigued', 'critical'])->default('healthy');
            $table->float('fatigue_score')->default(0);
            $table->json('recommendations')->nullable();
            $table->timestamps();
            
            $table->unique(['creative_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_creative_fatigue');
    }
};

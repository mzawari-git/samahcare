<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('meta_automated_reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['daily', 'weekly', 'monthly', 'custom']);
            $table->json('metrics');
            $table->json('filters')->nullable();
            $table->json('recipients');
            $table->enum('format', ['email', 'pdf', 'csv', 'excel'])->default('email');
            $table->enum('status', ['active', 'paused'])->default('active');
            $table->time('send_time')->nullable();
            $table->string('timezone')->default('Asia/Jerusalem');
            $table->timestamp('last_sent_at')->nullable();
            $table->timestamp('next_send_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meta_automated_reports');
    }
};

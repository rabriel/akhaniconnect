<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_activities', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('activity_type')->default('page_view');
            $table->string('method', 10)->nullable();
            $table->string('route_name')->nullable();
            $table->string('path')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->string('country_code', 2)->nullable();
            $table->string('country_name')->nullable();
            $table->string('browser')->nullable();
            $table->string('platform')->nullable();
            $table->string('device_type')->nullable();
            $table->unsignedSmallInteger('response_status')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('occurred_at');
            $table->timestamps();

            $table->index(['user_id', 'occurred_at']);
            $table->index(['route_name', 'occurred_at']);
            $table->index(['activity_type', 'occurred_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_activities');
    }
};

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
        Schema::create('verification_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verification_record_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('status', 20)->default('pending');
            $table->string('provider_reference')->nullable();
            $table->json('request_payload')->nullable();
            $table->longText('raw_response')->nullable();
            $table->json('processed_response')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('attempted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verification_attempts');
    }
};

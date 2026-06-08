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
        Schema::create('procurement_directors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('procurement_profile_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('id_number', 20);
            $table->string('position')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procurement_directors');
    }
};

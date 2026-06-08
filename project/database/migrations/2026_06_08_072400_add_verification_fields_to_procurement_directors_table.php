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
        Schema::table('procurement_directors', function (Blueprint $table) {
            $table->string('provider_reference')->nullable()->after('status');
            $table->json('verification_summary')->nullable()->after('provider_reference');
            $table->timestamp('verified_at')->nullable()->after('verification_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurement_directors', function (Blueprint $table) {
            $table->dropColumn(['provider_reference', 'verification_summary', 'verified_at']);
        });
    }
};

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
            $table->string('director_status', 100)->nullable()->after('provider_reference');
            $table->json('director_data')->nullable()->after('verification_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurement_directors', function (Blueprint $table) {
            $table->dropColumn([
                'director_status',
                'director_data',
            ]);
        });
    }
};

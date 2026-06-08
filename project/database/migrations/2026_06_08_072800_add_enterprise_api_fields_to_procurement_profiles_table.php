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
        Schema::table('procurement_profiles', function (Blueprint $table) {
            $table->string('enterprise_status', 100)->nullable()->after('company_phone');
            $table->string('enterprise_type', 100)->nullable()->after('enterprise_status');
            $table->text('enterprise_address')->nullable()->after('enterprise_type');
            $table->json('enterprise_data')->nullable()->after('enterprise_address');
            $table->timestamp('enterprise_synced_at')->nullable()->after('enterprise_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurement_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'enterprise_status',
                'enterprise_type',
                'enterprise_address',
                'enterprise_data',
                'enterprise_synced_at',
            ]);
        });
    }
};

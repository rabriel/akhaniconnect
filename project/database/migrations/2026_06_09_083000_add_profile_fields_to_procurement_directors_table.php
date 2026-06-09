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
            $table->string('initials', 20)->nullable()->after('full_name');
            $table->date('birth_date')->nullable()->after('initials');
            $table->string('gender', 20)->nullable()->after('birth_date');
            $table->string('title', 50)->nullable()->after('gender');
            $table->string('marital_status', 50)->nullable()->after('title');
            $table->string('privacy_status', 100)->nullable()->after('marital_status');
            $table->string('cellular_number', 30)->nullable()->after('privacy_status');
            $table->string('home_telephone', 30)->nullable()->after('cellular_number');
            $table->string('work_telephone', 30)->nullable()->after('home_telephone');
            $table->string('email_address')->nullable()->after('work_telephone');
            $table->text('residential_address')->nullable()->after('email_address');
            $table->text('postal_address')->nullable()->after('residential_address');
            $table->string('employer')->nullable()->after('postal_address');
            $table->unsignedInteger('number_of_enquiries')->nullable()->after('employer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('procurement_directors', function (Blueprint $table) {
            $table->dropColumn([
                'initials',
                'birth_date',
                'gender',
                'title',
                'marital_status',
                'privacy_status',
                'cellular_number',
                'home_telephone',
                'work_telephone',
                'email_address',
                'residential_address',
                'postal_address',
                'employer',
                'number_of_enquiries',
            ]);
        });
    }
};

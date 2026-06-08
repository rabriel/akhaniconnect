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
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->string('notice_period', 100)->nullable()->after('employment_status');
            $table->boolean('willing_to_relocate')->nullable()->after('notice_period');
            $table->string('job_industry')->nullable()->after('willing_to_relocate');
            $table->string('preferred_employment_type', 100)->nullable()->after('job_industry');
            $table->string('salary_expectation', 100)->nullable()->after('preferred_employment_type');
            $table->string('education_level', 100)->nullable()->after('salary_expectation');
            $table->text('education')->nullable()->after('education_level');
            $table->text('certifications')->nullable()->after('education');
            $table->text('experience')->nullable()->after('certifications');
            $table->text('skills')->nullable()->after('experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'notice_period',
                'willing_to_relocate',
                'job_industry',
                'preferred_employment_type',
                'salary_expectation',
                'education_level',
                'education',
                'certifications',
                'experience',
                'skills',
            ]);
        });
    }
};

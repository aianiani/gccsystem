<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change nature_of_problem from enum to text to support multiple selections (JSON array)
        DB::statement("ALTER TABLE appointments MODIFY nature_of_problem TEXT NULL");

        // Add decline_reason column
        Schema::table('appointments', function (Blueprint $table) {
            $table->text('decline_reason')->nullable()->after('reschedule_reason');
        });
    }

    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn('decline_reason');
        });

        DB::statement("ALTER TABLE appointments MODIFY nature_of_problem ENUM('Academic','Family','Personal / Emotional','Social','Psychological','Other') NULL");
    }
};

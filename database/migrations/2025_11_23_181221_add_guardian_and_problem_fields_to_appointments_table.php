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
        Schema::table('appointments', function (Blueprint $table) {
            // Guardian 1 (Required)
            $table->string('guardian1_name')->nullable()->after('notes');
            $table->string('guardian1_relationship')->nullable()->after('guardian1_name');
            $table->string('guardian1_contact')->nullable()->after('guardian1_relationship');
            
            // Guardian 2 (Optional)
            $table->string('guardian2_name')->nullable()->after('guardian1_contact');
            $table->string('guardian2_relationship')->nullable()->after('guardian2_name');
            $table->string('guardian2_contact')->nullable()->after('guardian2_relationship');
            
            // Nature of Problem
            $table->enum('nature_of_problem', ['Academic', 'Family', 'Personal / Emotional', 'Social', 'Psychological', 'Other'])->nullable()->after('guardian2_contact');
            $table->text('nature_of_problem_other')->nullable()->after('nature_of_problem');
            
            // Reference number for confirmation
            $table->string('reference_number')->unique()->nullable()->after('nature_of_problem_other');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn([
                'guardian1_name',
                'guardian1_relationship',
                'guardian1_contact',
                'guardian2_name',
                'guardian2_relationship',
                'guardian2_contact',
                'nature_of_problem',
                'nature_of_problem_other',
                'reference_number',
            ]);
        });
    }
};
